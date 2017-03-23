<?php

class PromocionController extends Controller
{
	public $layout="//layouts/menuApp";

	public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

	public function accessRules() {

        return (array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('create', 'getCliente', 'reporteCreate', 'confirmarBCP', 'confirmarBCNL', 'verDetalles', 'mensajeTimeSlot', 'generarPromocionBCP', 'timeSlot2'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='promocion-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCreate()
    {
        $model = new PromocionForm;

        $listas = array();
        $dataTipo = array();

        $this->performAjaxValidation($model);

        if(isset($_POST['PromocionForm']))
        {
            $model->attributes=$_POST['PromocionForm'];
            
            if ($model->validate())
            {
                $transaction = Yii::app()->db->beginTransaction(); //Insignia_masivo
                $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

                try
                {
                    $id_proceso = Yii::app()->Procedimientos->getNumeroProceso();

                    $cupo = LoginCupo::model()->find("id_usuario = ".Yii::app()->user->id);
                    $url_confirmar = null;

                    //BCNL / CPEI
                    if ($model->tipo == 1 || $model->tipo == 2)
                    {
                        //BTL
                        if (isset($model->sc) && $model->sc != "")
                        {
                            $btl_destinatarios = BtlController::actionGetNumeros($model->sc, $model->operadoras, $model->all_operadoras, $model->fecha_inicio, $model->fecha_fin, $model->productos);

                            //En case de existir numeros obtenidos desde BTL los updateo como validos para que no se aplique ningun filtro
                            if ($btl_destinatarios != "")
                            {
                                Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $btl_destinatarios);
                                //Marco los numeros que vienen de BTL para no aplicar el filtro segun sea el caso
                                $sql = "UPDATE tmp_procesamiento SET numero_btl = 1 WHERE id_proceso = :id_proceso AND estado IS NULL";

                                $sql = Yii::app()->db_masivo_premium->createCommand($sql);
                                $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
                                $sql->execute();
                            }
                        }

                        //Guarda los numeros ingresados en el textarea en la tabla de procesamiento
                        if (isset($model->destinatarios) && $model->destinatarios != "") 
                            Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $model->destinatarios);

                        //Entra si selecciono por lo menos 1 lista
                        if (isset($model->listas) && COUNT($model->listas) > 0)
                        {
                            $listas_destinatarios = $this->actionGetNumerosListas($model->listas, $model->tipo, null);
                            //Guarda los numeros de las listas en la tabla de procesamiento
                            Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $listas_destinatarios);
                        }

                        //Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
                        Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso, 1, false);

                        //Updatea en estado 3 todos los números duplicados
                        Yii::app()->Filtros->filtrarDuplicados($id_proceso);

                        //Update en estado 4 todos los numeros exentos
                        Yii::app()->Filtros->filtrarExentos($id_proceso);

                        if (Yii::app()->Procedimientos->clienteIsHipicoLotero($model->id_cliente))
                        {
                            //Update en estado 5 todos los numeros que no tienen trafico suficiente
                            Yii::app()->Filtros->filtrarSmsXNumero($id_proceso, 1, null);
                        }

                        //Update en estado 8 todos los numeros que sobrepasen el porcentaje permitido por operadora
                        Yii::app()->Filtros->filtrarPorcentajeOperadora($id_proceso, $model->id_cliente);
                        
                        //Updatea a estado = 7 todos los numeros que sobrepasen la cantidad de cupo disponible 
                        Yii::app()->Filtros->filtrarCupo($id_proceso, $cupo->disponible);

                        //Updatea a estado = 1 todos los numeros validos 
                        Yii::app()->Filtros->filtrarAceptados($id_proceso);

                        //Cantidad de destinatarios validos
                        $total = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);

                        //En caso de existir numeros validos procedo a crear la promocion
                        if ($total > 0)
                        {
                            if ($model->tipo == 1) //BCNL
                            {
                                $estado = 1;
                                $prefijo = "BCNL";
                            }
                            else if ($model->tipo == 2) //CPEI
                            {
                                $estado = 2;
                                $prefijo = "CPEI";
                                $model->hora_inicio = date("H:i:s");
                                $hora_fin = strtotime( '+'. $model->duracion.' minute' , strtotime($model->hora_inicio));
                                $model->hora_fin = date('H:i:s' , $hora_fin);
                                
                            }

                            if ($model->all_puertos == true)
                            {
                                $sql = "SELECT puertos FROM usuario WHERE id_usuario = ".Yii::app()->user->id;
                                $puertos_tmp = Yii::app()->db->createCommand($sql)->queryRow();
                                $model->puertos = explode(",", $puertos_tmp["puertos"]);
                            }

                            $model_promocion = new Promociones;
                            $model_promocion->nombrePromo = $this->actionGetNombrePromo($model->id_cliente, $model->tipo, null, $model->nombre, $model->fecha);
                            $model_promocion->cadena_usuarios = Yii::app()->user->id;
                            $model_promocion->estado = $estado;
                            $model_promocion->contenido = $model->mensaje;
                            $model_promocion->fecha = $model->fecha;
                            $model_promocion->hora = $model->hora_inicio;
                            $model_promocion->cliente = $model->id_cliente;
                            $model_promocion->save();
                            $id_promo = $model_promocion->primaryKey;

                            $model_deadline = new DeadlineOutgoing;
                            $model_deadline->id_promo = $id_promo;
                            $model_deadline->fecha_limite = $model->fecha;
                            $model_deadline->hora_limite = $model->hora_fin;
                            $model_deadline->save();

                            $sql = "UPDATE usuario SET cadena_promo = CONCAT(cadena_promo, ',', '".$id_promo."') 
                                    WHERE id_usuario IN(".Yii::app()->Procedimientos->getUsuariosBCNLHerenciaInversa(Yii::app()->user->id).")";
                            Yii::app()->db->createCommand($sql)->execute();

                            //Puertos
                            foreach ($model->puertos as $value)
                            {
                                $puertos[] = "(".Yii::app()->user->id.", ".$id_promo.", '".$value."',".$value.")";
                            }

                            $sql = "INSERT INTO puerto_usu_promo VALUES ".implode(",", $puertos);
                            Yii::app()->db->createCommand($sql)->execute();
                            
                            //Registro los mensajes en outgoing

                            $count_puertos = count($model->puertos);
                            $sms_x_modem = $total/$count_puertos;
                            $sms_x_modem = ceil($sms_x_modem); //Redondea el valor hacia arriba Ej: 4.2 = 5
                            $limite_inferio = 0;
                            $id_usuario = Yii::app()->user->id;

                            foreach ($model->puertos as $value)
                            {
                                $sql = "INSERT INTO insignia_masivo.outgoing (id_promo, number, status, frecuency, date_loaded, time_loaded, loaded_by, date_program, time_program, content, id_cliente) SELECT :id_promo, CONCAT('0',numero), :estado, :puerto, :fecha_cargada, :hora_cargada, :id_usuario, :fecha_envio, :hora_envio, :mensaje, :id_cliente FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1 LIMIT :limite_inferio , :limite_superior";
                            
                                $sql = Yii::app()->db_masivo_premium->createCommand($sql);
                                $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_INT);
                                $sql->bindParam(":estado", $estado, PDO::PARAM_INT);
                                $sql->bindParam(":puerto", $value, PDO::PARAM_INT);
                                $sql->bindValue(":fecha_cargada", date("Y-m-d"), PDO::PARAM_STR);
                                $sql->bindValue(":hora_cargada", date("H:i:s"), PDO::PARAM_STR);
                                $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                                $sql->bindParam(":fecha_envio", $model->fecha, PDO::PARAM_STR);
                                $sql->bindParam(":hora_envio", $model->hora_inicio, PDO::PARAM_STR);
                                $sql->bindParam(":mensaje", $model->mensaje, PDO::PARAM_STR);
                                $sql->bindParam(":id_cliente", $model->id_cliente, PDO::PARAM_INT);
                                $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
                                $sql->bindParam(":limite_inferio", $limite_inferio, PDO::PARAM_INT);
                                $sql->bindParam(":limite_superior", $sms_x_modem, PDO::PARAM_INT);
                                $sql->execute();

                                $limite_inferio = $limite_inferio + $sms_x_modem;
                            }

                            $this->actionRestarCupoBCNL($id_promo, $total);

                            if ($model->tipo == 1) //BCNL
                            {
                                $url_confirmar = Yii::app()->createUrl("promocion/confirmarBCNL", array("id_promo"=>$id_promo));
                            }

                            $log = "PROMOCION ".$prefijo." CREADA | id_promo: ".$id_promo." | id_cliente: ".$model->id_cliente." | Destinatarios: ".$total;
                            Yii::app()->Procedimientos->setLog($log);
                        }
                    }

                    //BCP
                    if ($model->tipo == 3)
                    {
                        $clienteBCP = ClienteAlarmas::model()->findByPk($model->id_cliente);
                        $cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);

                        if(is_numeric($clienteBCP->sc))
                            $alfanumerico = false;
                        else
                            $alfanumerico = true; //En caso de ser alfanumerico

                        $operadorasPermitidasBCP = $this->actionGetOperadorasPermitidasBCP(Yii::app()->user->id, $model->id_cliente, $alfanumerico);

                        //BTL
                        if (isset($model->sc) && $model->sc != "")
                        {
                            $btl_destinatarios = BtlController::actionGetNumeros($model->sc, $model->operadoras, $model->all_operadoras, $model->fecha_inicio, $model->fecha_fin, $model->productos);

                            //En case de existir numeros obtenidos desde BTL los updateo como validos para que no se aplique ningun filtro
                            if ($btl_destinatarios != "")
                            {
                                Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $btl_destinatarios);
                                //Marco los numeros que vienen de BTL para no aplicar el filtro segun sea el caso
                                $sql = "UPDATE tmp_procesamiento SET numero_btl = 1 WHERE id_proceso = :id_proceso AND estado IS NULL";
                                $sql = Yii::app()->db_masivo_premium->createCommand($sql);
                                $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
                                $sql->execute();
                            }
                        }

                        //Guarda los numeros ingresados en el textarea en la tabla de procesamiento
                        if (isset($model->destinatarios) && $model->destinatarios != "") 
                            Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $model->destinatarios);

                        //Entra si selecciono por lo menos 1 lista
                        if (isset($model->listas) && COUNT($model->listas) > 0)
                        {
                            $listas_destinatarios = $this->actionGetNumerosListas($model->listas, $model->tipo, $operadorasPermitidasBCP);
                            //Guarda los numeros de las listas en la tabla de procesamiento
                            Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $listas_destinatarios);
                        }

                        //Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
                        Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso, 2, $alfanumerico);

                        //Updatea en estado 3 todos los números duplicados
                        Yii::app()->Filtros->filtrarDuplicados($id_proceso);

                        //Updatea en estado 6 todos los numeros con id_operadora no permitido
                        Yii::app()->Filtros->filtrarOperadoraPermitida($id_proceso, $operadorasPermitidasBCP);

                        //Update en estado 4 todos los numeros exentos
                        Yii::app()->Filtros->filtrarExentos($id_proceso);

                        if (Yii::app()->Procedimientos->clienteIsHipicoLotero($model->id_cliente))
                        {
                            //Update en estado 5 todos los numeros que no tienen trafico suficiente
                            //Yii::app()->Filtros->filtrarSmsXNumero($id_proceso, 2, $operadorasPermitidasBCP);

                            //Update en estado 9 todos los numeros que han sido cargados del limite permitido en el dia
                            Yii::app()->Filtros->filtrarPorCargaDiaria($id_proceso, $model->fecha, $operadorasPermitidasBCP);
                        }

                        //Updatea a estado = 7 todos los numeros que sobrepasen la cantidad de cupo disponible 
                        Yii::app()->Filtros->filtrarCupo($id_proceso, $cupo->disponible);

                        //Updatea a estado = 1 todos los numeros validos 
                        Yii::app()->Filtros->filtrarAceptados($id_proceso);

                        //Total numeros validos por operadora
                        $total_x_oper = Yii::app()->Procedimientos->getNumerosValidosPorOperadoraBCP($id_proceso);
                        //Obtener la informacion de si es necesario aplicar el timeslot y/o mostrar el mensaje
                        $objeto_timeslot = $this->actionValidarReservacion($model->fecha, $model->hora_inicio, $model->hora_fin, $total_x_oper);
                    }

                    $transaction->commit();
                    $transaction2->commit();

                    if ($model->tipo == 3) //BCP
                    {
                        $_SESSION["model"] = $model;
                        if ($objeto_timeslot["timeslot"] && $objeto_timeslot["mostrarMensaje"])
                           $this->redirect(array("mensajeTimeSlot", "id_proceso"=>$id_proceso, "timeslot"=>$objeto_timeslot["timeslot"], "alfanumerico"=>$alfanumerico));
                        else $this->redirect(array("generarPromocionBCP", "id_proceso"=>$id_proceso, "timeslot"=>$objeto_timeslot["timeslot"], "alfanumerico"=>$alfanumerico));
                    }
                    else //BCNL/CPEI
                        $this->redirect(array("reporteCreate", "id_proceso"=>$id_proceso, "nombre"=>$model->nombre, "url_confirmar" => $url_confirmar, 'tipo'=>$model->tipo));

                } catch (Exception $e)
                    {
                        $error = "Ocurrio un error al procesar los datos, intente nuevamente.";
                        Yii::app()->user->setFlash("danger", $error);
                        print_r($e);
                        $transaction->rollBack();
                        $transaction2->rollBack();
                    }   
            }
        }

        if (Yii::app()->user->getPermisos()->broadcasting && Yii::app()->user->getPermisos()->crear_promo_bcnl)
            $dataTipo[1] = "BCNL";
        if (Yii::app()->user->getPermisos()->broadcasting_cpei)
            $dataTipo[2] = "CPEI";
        if (Yii::app()->user->getPermisos()->broadcasting_premium && Yii::app()->user->getPermisos()->crear_promo_bcp)
            $dataTipo[3] = "BCP";

        if (Yii::app()->user->getPermisos()->modulo_listas)
        {
            $model_lista = Lista::model()->findAll("id_usuario = ".Yii::app()->user->id);
            
            foreach ($model_lista as $value)
            {
                $listas[$value["id_lista"]] = $value["nombre"];
            }
        }

        $this->render("create", array('model'=>$model, 'dataTipo'=>$dataTipo, 'listas'=>$listas));
    }

    public function actionGenerarPromocionBCP($id_proceso, $timeslot, $alfanumerico)
    {
        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            //Cantidad de destinatarios validos
            $total_sms = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);
            $url_confirmar = null;
            $ids_promo = "";
            $model = clone $_SESSION["model"];
            $model_aux = new PromocionForm;
            $model_aux = clone $model;
            //unset($_SESSION["model"]);
            //print_r("<br><br>");

            //En caso de existir numeros validos procedo a crear la promocion
            if ($total_sms > 0)
            {
                //Total numeros validos por operadora
                $total_x_oper = Yii::app()->Procedimientos->getNumerosValidosPorOperadoraBCP($id_proceso);

                $criteria = new CDbCriteria;
                $criteria->select = "id_operadora_bcnl, GROUP_CONCAT(id_operadora_bcp) AS id_operadora_bcp";
                $criteria->group = "id_operadora_bcnl";
                $resultado = OperadorasRelacion::model()->findAll($criteria);

                foreach ($resultado as $value)
                {
                    $operadora_relacion[$value["id_operadora_bcnl"]] = $value["id_operadora_bcp"];
                }

                if ($timeslot)
                {
                    $array_promociones = $this->actionGetTimeSlotXoper($model->fecha, $model->hora_inicio, $total_x_oper);

                    if ($_SESSION["timeslot"] === $array_promociones) //Verificar si aun queda espacio
                    {
                        if(!$alfanumerico) //ShortCode numerico
                        {
                            foreach ($array_promociones as $value)
                            {
                                $i=0;
                                $j=1;
                                foreach ($value["resultado"] as $key)
                                {
                                    $model_aux->nombre = $model->nombre."_".$j."_".$value["nombre"];
                                    $model_aux->hora_inicio = $key["hora_ini"];
                                    $model_aux->hora_fin = $key["hora_fin"];
                                    
                                    $id_promo = $this->actionRegistrarPromocionBCP($id_proceso, $model_aux, $key["total"], $value["id_operadora"], $operadora_relacion[$value["id_operadora"]], $i);
                                    $ids_promo .= ",".$id_promo;
                                    $i+=$key["total"];
                                    $j++;
                                }
                            }
                        }
                        else //ShorCode Alfanumerico
                        {
                            $clienteBCP = ClienteAlarmas::model()->findByPk($model->id_cliente);

                            foreach ($array_promociones as $value)
                            {
                                $i=0;
                                $j=1;
                                foreach ($value["resultado"] as $key)
                                {
                                    if ($value["id_operadora"] == 4) //ALfanumerico Digitel
                                    {
                                        $model_aux->nombre = $model->nombre."_".$j."_".$value["nombre"]."_ALF";
                                        $model_aux->id_cliente = $clienteBCP->id;
                                    }
                                    else
                                    {
                                        $model_aux->nombre = $model->nombre."_".$j."_".$value["nombre"];
                                        $model_aux->id_cliente = $clienteBCP->id_cliente_sc_numerico;
                                    }

                                    $model_aux->hora_inicio = $key["hora_ini"];
                                    $model_aux->hora_fin = $key["hora_fin"];

                                    $id_promo = $this->actionRegistrarPromocionBCP($id_proceso, $model_aux, $key["total"], $value["id_operadora"], $operadora_relacion[$value["id_operadora"]], $i);

                                    $ids_promo .= ",".$id_promo; 
                                    $i+=$key["total"];
                                    $j++;
                                }
                            }
                        }
                    }
                    else
                    {
                        $this->redirect(array("timeSlot2"));
                    }
                }
                else
                {
                    if(!$alfanumerico)
                    {
                        foreach ($total_x_oper as $key=>$value)
                        {
                            $model_aux->nombre = $model->nombre."_".$value["nombre"];
                            $id_promo = $this->actionRegistrarPromocionBCP($id_proceso, $model_aux, $value["total"], $key, $operadora_relacion[$key], 0);
                            $ids_promo .= ",".$id_promo;
                        }
                    }
                    else
                    {
                        $clienteBCP = ClienteAlarmas::model()->findByPk($model->id_cliente);

                        foreach ($total_x_oper as $key=>$value)
                        {
                            if ($key == 4) //ALfanumerico Digitel
                            {
                                $model_aux->nombre = $model->nombre."_".$value["nombre"]."_ALF";
                                $model_aux->id_cliente = $clienteBCP->id;
                            }
                            else
                            {
                                $model_aux->nombre = $model->nombre."_".$value["nombre"];
                                $model_aux->id_cliente = $clienteBCP->id_cliente_sc_numerico;
                            }

                            $id_promo = $this->actionRegistrarPromocionBCP($id_proceso, $model_aux, $value["total"], $key, $operadora_relacion[$key], 0);

                            $ids_promo .= ",".$id_promo; 
                        }
                    }
                }

                $id_promo = trim($ids_promo, ",");
                $url_confirmar = Yii::app()->createUrl("promocion/confirmarBCP", array("id_promo"=>$id_promo));
            }

            unset($_SESSION["model"]);

            $transaction->commit();

            $this->redirect(array("reporteCreate", "id_proceso"=>$id_proceso, "nombre"=>$model->nombre, "url_confirmar" => $url_confirmar, 'tipo'=>$model->tipo));

        } catch (Exception $e)
            {
                $error = "Ocurrio un error al crear la promocion, intente nuevamente.";
                Yii::app()->user->setFlash("danger", $error);
                print_r($e);
                $transaction->rollBack();
                //$this->redirect(array("create"));
            }
    }

    private function actionRegistrarPromocionBCP($id_proceso, $model, $total_sms, $id_operadora, $id_operadoras_bcp, $limite_ini)
    {
        $clienteBCP = ClienteAlarmas::model()->findByPk($model->id_cliente);

        $sql = "SELECT id FROM evento WHERE cliente = :id_cliente";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_cliente", $model->id_cliente, PDO::PARAM_INT);
        $evento = $sql->queryRow();

        $this->actionUpdateIdAlarmas($id_proceso, $clienteBCP->descripcion, $id_operadoras_bcp);
        
        $sc_numerico = Yii::app()->Procedimientos->getScNumerico($model->id_cliente);

        $model_promocion = new PromocionesPremium;
        $model_promocion->nombrePromo = $this->actionGetNombrePromo($clienteBCP->id_cliente_sms, $model->tipo, $sc_numerico, $model->nombre, $model->fecha);
        $model_promocion->id_cliente = $model->id_cliente;
        $model_promocion->sc = $clienteBCP->sc;
        $model_promocion->estado = 0;
        $model_promocion->fecha = $model->fecha;
        $model_promocion->hora = $model->hora_inicio;
        $model_promocion->loaded_by = Yii::app()->user->id;
        $model_promocion->contenido = $model->mensaje;
        $model_promocion->fecha_cargada = date("Y-m-d");
        $model_promocion->hora_cargada = date("H:i:s");
        $model_promocion->total_sms = $total_sms;
        $model_promocion->id_operadora = $id_operadora;
        $model_promocion->save();
        $id_promo = $model_promocion->primaryKey;

        $model_deadline = new DeadlineOutgoingPremium;
        $model_deadline->id_promo = $id_promo;
        $model_deadline->fecha_limite = $model->fecha;
        $model_deadline->hora_limite = $model->hora_fin;
        $model_deadline->save();

        $model_promocion_acciones = new PromocionesPremiumAcciones;
        $model_promocion_acciones->id_promo = $id_promo;
        $model_promocion_acciones->save();

        $sql = "INSERT INTO outgoing_premium (id_promo, destinatario, mensaje, fecha_in, hora_in, tipo_evento, cliente, operadora, id_insignia_alarmas) SELECT :id_promo, SUBSTRING(numero, 4,7), :mensaje, :fecha, :hora, :evento, :id_cliente, id_operadora, id_insignia_alarmas FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1 AND id_operadora IN(".$id_operadoras_bcp.") LIMIT ".$limite_ini.",".$total_sms;
        
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_INT);
        $sql->bindParam(":mensaje", $model->mensaje, PDO::PARAM_STR);
        $sql->bindParam(":fecha", $model->fecha, PDO::PARAM_STR);
        $sql->bindParam(":hora", $model->hora_inicio, PDO::PARAM_STR);
        $sql->bindParam(":evento", $evento["id"], PDO::PARAM_INT);
        $sql->bindParam(":id_cliente", $model->id_cliente, PDO::PARAM_INT);
        $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
        $sql->execute();

        $dia_semana = date("w", strtotime($model->fecha));
        $nombre_dia = Yii::app()->Funciones->actionGetNombreDia($dia_semana);

        $historial_reservacion = HistorialReservacion::model()->COUNT("id_usuario=:id_usuario AND id_operadora=:id_operadora", array(":id_usuario"=>Yii::app()->user->id, ":id_operadora"=>$id_operadora));
        
        if ($historial_reservacion == 0)
        {
            $model_historial = new HistorialReservacion;
            $model_historial->id_usuario = Yii::app()->user->id;
            $model_historial->$nombre_dia = $model->hora_inicio;
            $model_historial->id_operadora = $id_operadora;
            $model_historial->save();
        }
        else
        {
            $model_historial = HistorialReservacion::model()->find("id_usuario=:id_usuario AND id_operadora=:id_operadora AND ".$nombre_dia.">:nombre_dia", array(":id_usuario"=>Yii::app()->user->id, ":id_operadora"=>$id_operadora, ":nombre_dia"=>$model->hora_inicio));
            
            if ($model_historial)
            {
                $model_historial->$nombre_dia = $model->hora_inicio;
                $model_historial->save();
            }
        }

        $model_cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);
        $model_cupo->disponible = $model_cupo->disponible - $total_sms;
        $model_cupo->save();

        $descripcion_historial = "PROMOCION BCP CREADA con nombre ".$model_promocion->nombrePromo." para (".$total_sms.") destinatarios";

        $model_cupo_historial = new UsuarioCupoHistoricoPremium;
        $model_cupo_historial->id_usuario = Yii::app()->user->id;
        $model_cupo_historial->id_cliente = $clienteBCP->id_cliente_sms;
        $model_cupo_historial->ejecutado_por = Yii::app()->user->id;
        $model_cupo_historial->cantidad = $total_sms;
        $model_cupo_historial->descripcion = $descripcion_historial;
        $model_cupo_historial->fecha = date("Y-m-d");
        $model_cupo_historial->hora = date("H:i:s");
        $model_cupo_historial->tipo_operacion = 3; //Consumido
        $model_cupo_historial->save();

        //Guarda todos los numeros cargados para realizar el filtrado en las proximas cargas de promociones
        $sql = "INSERT INTO tmp_numeros_cargados_por_dia (sc, numero, id_operadora, fecha) SELECT ".$sc_numerico.", numero, CASE id_operadora WHEN 6 THEN 5 ELSE id_operadora END AS id_operadora, :fecha FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1 AND id_operadora IN(".$id_operadoras_bcp.") LIMIT ".$limite_ini.",".$total_sms;
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
        $sql->bindParam(":fecha", $model->fecha, PDO::PARAM_STR);
        $sql->execute();

        //$url_confirmar = Yii::app()->createUrl("promocion/confirmarBCP", array("id_promo"=>$id_promo));

        $log = "PROMOCION BCP CREADA | id_promo: ".$id_promo." | id_cliente_sms: ".$clienteBCP->id_cliente_sms." | id_cliente_bcp: ".$model->id_cliente." | Destinatarios: ".$total_sms;
        Yii::app()->Procedimientos->setLog($log);

        return $id_promo;
    }

    public function actionGetCliente()
    {
        $tipo = Yii::app()->request->getParam('tipo');
        if (Yii::app()->request->isAjaxRequest)
        {
            if ($tipo == '') {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'Tipo de promoción invalida'
                ));
                Yii::app()->end();
            } else {   
                if ($tipo == 1) //BCNL o CPEI
                {
                    $data = Yii::app()->Procedimientos->getClientesBCNL(Yii::app()->user->id);
                    $model_cupo = LoginCupo::model()->find("id_usuario = ".Yii::app()->user->id);

                }
                else if ($tipo == 2)
                {
                    if (Yii::app()->user->id == 1) //Godadmin
                    {
                        $data = Yii::app()->Procedimientos->getClientesBCNL(Yii::app()->user->id);
                    }
                    else
                    {
                        $data = Yii::app()->Procedimientos->getClienteCPEI(Yii::app()->user->id);    
                    }
                    
                    $model_cupo = LoginCupo::model()->find("id_usuario = ".Yii::app()->user->id);
                }
                else if ($tipo == 3) //BCP
                {
                    $data = Yii::app()->Procedimientos->getClientesBCP(Yii::app()->user->id);
                    $model_cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);
                }

                $cupo = 0;
                    
                if ($model_cupo)
                {
                    $cupo = $model_cupo->disponible;
                }

                if($data) {
                    echo CJSON::encode(array(
                                            'error' => 'false',
                                            'status' => 'Clientes obtenidos correctamente',
                                            'data' => $data,
                                            'cupo' => $cupo
                                       )                                
                         );
                    Yii::app()->end();
                } else {
                    echo CJSON::encode(array(
                        'error' => 'true',
                        'status' => 'No posee cliente asociado'
                    ));
                    Yii::app()->end();
                }
            }
            
        }
        
    }

    protected function actionGetOperadorasPermitidasBCP($id_usuario, $id_cliente, $alfanumerico)
    {
        if ($alfanumerico)
        {
            $sql = "SELECT id FROM cliente WHERE id = (SELECT id_cliente_sc_numerico FROM cliente WHERE id = ".$id_cliente.") AND onoff = 1";
            $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

            if($sql)
                $id_cliente .= ",".$sql["id"];
        }

        $sql = "SELECT * FROM usuario_cliente_operadora WHERE id_usuario = :id_usuario AND id_cliente IN(".$id_cliente.")";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $sql = $sql->queryAll();

        foreach ($sql as $oper)
        {
            if ($oper["movistar"] == 1) //Movistar
            {
                $operadoras[] = 1; //0414
                $operadoras[] = 2; //0424
            }
            if ($oper["movilnet"] == 1) //Movilnet
            {
                $operadoras[] = 3; //0416
                $operadoras[] = 4; //0426
            }
            if ($oper["digitel"] == 1) //Digitel
            {
                $operadoras[] = 5; //0412
            }
            if($oper["digitel_alfanumerico"] == 1) //Digitel alfanumerico
            {
                $operadoras[] = 6; //SC alfanumerico
            }
        }

        $operadoras = implode(",",$operadoras);

        return $operadoras;
    }

    protected function actionGetNumerosListas($id_listas, $tipo, $operadorasPermitidasBCP)
    {
        if ($tipo == 1 || $tipo == 2) //BCNL / CPEI
        {
            $sql = "SELECT GROUP_CONCAT(DISTINCT numero) AS numeros FROM lista_destinatarios WHERE id_lista IN (".implode(",", $id_listas).") ";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();
        }

        else if ($tipo == 3) //BCP
        {
            $sql = "SELECT GROUP_CONCAT(DISTINCT id_operadora_bcnl) AS id_operadora FROM operadoras_relacion WHERE id_operadora_bcp IN(".$operadorasPermitidasBCP.") ";
            $operadorasPermitidas = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

            $sql = "SELECT GROUP_CONCAT(DISTINCT numero) AS numeros FROM lista_destinatarios WHERE id_lista IN (".implode(",", $id_listas).") AND id_operadora IN(".$operadorasPermitidas["id_operadora"].")";

            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();
        }

        return $sql["numeros"];   
    }

    protected function actionGetNombrePromo($id_cliente_sms, $tipo, $sc, $nombre, $fecha)
    {
        if ($tipo == 1 || $tipo == 2) //BCNL / CPEI
        {
            if ($tipo == 1)
            {
                $pref = "BCNL";
            }
            else 
            {
                $pref = "CPEI";
                $fecha = date("Y-m-d");
            }

            $criteria = new CDbCriteria;
            $criteria->select = "SUBSTRING(iniciales_cliente, 1, 4) AS iniciales_cliente";
            $criteria->compare("id_cliente", $id_cliente_sms);
            $cliente = ClienteSms::model()->find($criteria);
            $nombre_completo = preg_replace('/_{2,}/', "_", strtoupper(str_replace(" ", "_", str_replace("-", "", $fecha)."_".$pref."_".$cliente->iniciales_cliente."_".$nombre)));
        }
        else if ($tipo == 3) //BCP
        {
            $criteria = new CDbCriteria;
            $criteria->select = "SUBSTRING(iniciales_cliente, 1, 4) AS iniciales_cliente";
            $criteria->compare("id_cliente", $id_cliente_sms);
            $cliente = ClienteSms::model()->find($criteria);
            $nombre_completo = preg_replace('/_{2,}/', "_", strtoupper(str_replace(" ", "_", str_replace("-", "", $fecha)."_BCP_".$cliente->iniciales_cliente."_".$sc."_".$nombre)));
        }

        return $nombre_completo;
    }

    protected function actionUpdateIdAlarmas($id_proceso, $descripcion_cliente, $operadorasPermitidasBCP)
    {
        $sql = "SELECT id, prefijo FROM operadora WHERE id IN(".$operadorasPermitidasBCP.")";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryAll();
        
        foreach ($sql as $value)
        {
            $operadoras[] = array("id_operadora" => $value["id"], "prefijo" => $value["prefijo"]);
        }
        
        foreach ($operadoras as $value)
        {
            $sql = "UPDATE tmp_procesamiento SET id_insignia_alarmas = CONCAT('".$descripcion_cliente.$value["prefijo"]."', SUBSTRING(numero,4,7)) WHERE id_proceso = :id_proceso AND estado = 1 AND id_operadora = :id_operadora";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
            $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_STR);
            $sql->bindParam(":id_operadora", $value["id_operadora"], PDO::PARAM_STR);
            $sql->execute();
        }
    }

    public function actionConfirmarBCP()
    {
        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $id_promo = $_GET["id_promo"];

            $sql = "UPDATE promociones_premium SET estado = 2 WHERE id_promo IN(".$id_promo.")";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->execute();

            $sql = "UPDATE outgoing_premium SET status = 2 WHERE id_promo IN(".$id_promo.")";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->execute();

            $log = "PROMOCION(ES) BCP CONFIRMADA(S) | id_promo: (".$id_promo.")";
            Yii::app()->Procedimientos->setLog($log);

            $transaction->commit();
            $error = 'false';
        } catch (Exception $e)
            {
                $error = "true";
                $transaction->rollBack();
            }

        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('error' => $error));
    }

    public function actionConfirmarBCNL()
    {
        $transaction = Yii::app()->db->beginTransaction();
        $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $id_promo = $_GET["id_promo"];
            $model_promocion = Promociones::model()->findByPk($id_promo);
            $model_promocion->estado = 2;
            $model_promocion->save();

            $sql = "UPDATE outgoing SET status = 2 WHERE id_promo = :id_promo";
            $sql = Yii::app()->db->createCommand($sql);
            $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_INT);
            $sql->execute();

            $log = "PROMOCION CONFIRMADA BCNL | id_promo: ".$id_promo." | id_cliente: ".$model_promocion->cliente;
            Yii::app()->Procedimientos->setLog($log);

            $transaction->commit();
            $transaction2->commit();
            $error = 'false';
        } catch (Exception $e)
            {
                $error = "true";
                $transaction->rollBack();
                $transaction2->rollBack();
            }

        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('error' => $error));
    }

    protected function actionRestarCupoBCNL($id_promo, $cupo_consumido)
    {
        $login = Yii::app()->user->name;

        $sql = "SELECT IFNULL(MAX(id_transaccion),0)+1 AS id FROM historico_uso_cupo_usuario";
        $id_transaccion = Yii::app()->db->createCommand($sql)->queryRow();
        
        //CAMBIO DE LA FECHA DE VENCIMIENTO Y EL .OR PARA QUITAR LA COMPARACION CON NULL
        $sql = "SELECT id, fecha_vencimiento, cupo_asignado, cupo_consumido 
                FROM control_cupo_usuario 
                WHERE id_usuario = ".Yii::app()->user->id."   
                AND (DATE(fecha_vencimiento) >= '".date("Y-m-d")."')
                AND id >= (SELECT id FROM control_cupo_usuario WHERE id_usuario = ".Yii::app()->user->id." AND inicio_cupo = 1 ORDER BY id DESC LIMIT 1)
                AND cupo_consumido < cupo_asignado 
                ORDER BY fecha_asignacion ASC";

        $resultado = Yii::app()->db->createCommand($sql)->queryAll();
        $cupo_consumido_nuevo = $cupo_consumido;

        foreach ($resultado as $value)
        {
            $cupo_consumido_nuevo = $value['cupo_consumido'] + $cupo_consumido_nuevo;

            //Update la linea del cupo
            $aux = ($cupo_consumido_nuevo > $value['cupo_asignado'] ? $value['cupo_asignado'] : $cupo_consumido_nuevo);
            $model_cupo = ControlCupoUsuario::model()->findByPk($value["id"]);
            $model_cupo->cupo_consumido = $aux;
            $model_cupo->save();

            //Insertar log de transaccion en historico_uso_cupo_usuario

            $model_cupo_historial = new HistoricoUsoCupoUsuario;
            $model_cupo_historial->id_transaccion = $id_transaccion["id"];
            $model_cupo_historial->id_control_cupo_usuario = $value['id'];
            $model_cupo_historial->accion = 'USAR - El usuario '.$login.' (id='.Yii::app()->user->id.') monto promocion id='.$id_promo.' de '.$cupo_consumido.' SMS. Uso '. ($aux - $value['cupo_consumido']) .' SMS de este cupo';
            $model_cupo_historial->cupo_consumido_antes = $value['cupo_consumido'];
            $model_cupo_historial->cupo_consumido_despues = $aux;
            $model_cupo_historial->fecha = date("Y-m-d H:i:s");
            $model_cupo_historial->entidad = Yii::app()->user->id;
            $model_cupo_historial->save();

            if ($cupo_consumido_nuevo > $value['cupo_asignado'])
                $cupo_consumido_nuevo = $cupo_consumido_nuevo - $value['cupo_asignado'];
            else
                break;  //si ya no queda cupo por reintegrar ($cupo_consumido_nuevo >= 0), break
        }
    }

    public function actionReporteCreate($id_proceso, $nombre, $url_confirmar, $tipo)
    {
        $this->render("reporteCreate", array('id_proceso'=>$id_proceso, 'nombre'=>$nombre, 'url_confirmar'=>$url_confirmar, 'tipo'=>$tipo));
    }

    public function actionVerDetalles()
    {
        $this->render('verDetalles');
    }

    private function actionValidarReservacion($fecha, $hora_ini, $hora_fin, $destinatarios)
    {
        $dia_semana = date("w", strtotime($fecha));
        $objeto["timeslot"] = false;
        $objeto["mostrarMensaje"] = false;
        $hora_ini = date_create($hora_ini)->format('H:i:00');
        $hora_fin = date_create($hora_fin)->format('H:i:00');

        $dia_activo = ConfiguracionReservacionPorDia::model()->COUNT("id_dia=:id_dia AND estado = 1", array(":id_dia"=>$dia_semana));

        if ($dia_activo > 0)
        {
            $criteria = new CDbCriteria;
            $criteria->select = "propiedad, valor";
            $criteria->addInCondition("propiedad", array('intervalo_reservacion', 'hora_inicio_bcp', 'hora_fin_reservacion'));
            $resultado = ConfiguracionSistema::model()->findAll($criteria);

            foreach ($resultado as $value)
            {
                if ($value["propiedad"] == 'intervalo_reservacion')
                    $intervalo_reservacion = $value["valor"];
                else if ($value["propiedad"] == 'hora_inicio_bcp')
                    $hora_ini_reservacion = $value["valor"];
                else if ($value["propiedad"] == 'hora_fin_reservacion')
                    $hora_fin_reservacion = $value["valor"];
            }
            
            if ( (strtotime($hora_ini) >= strtotime($hora_ini_reservacion) && strtotime($hora_ini) <= strtotime($hora_fin_reservacion) ) 
                    || ( strtotime($hora_fin) >= strtotime($hora_ini_reservacion) && strtotime($hora_fin) <= strtotime($hora_fin_reservacion) ) 
                        || (strtotime($hora_ini_reservacion) >= strtotime($hora_ini) && strtotime($hora_fin_reservacion) <= strtotime($hora_fin) ) ) 
            {
                $array_promociones = $this->actionGetTimeSlotXoper($fecha, $hora_ini, $destinatarios);
                $_SESSION["timeslot"] = $array_promociones;
                $objeto["timeslot"] = true;

                if ($this->actionCheckReservacion($hora_ini, $array_promociones))
                {
                    $objeto["mostrarMensaje"] = true;
                } 
            } 
        }

        return $objeto;
    }

    private function actionGetTimeSlotXoper($fecha, $hora_ini, $objeto_oper)
    {
        $criteria = new CDbCriteria;
        $criteria->select = "propiedad, valor";
        $criteria->addInCondition("propiedad", array('intervalo_reservacion', 'hora_inicio_bcp', 'hora_fin_reservacion'));
        $resultado = ConfiguracionSistema::model()->findAll($criteria);
        
        foreach ($resultado as $value)
        {
            if ($value["propiedad"] == 'intervalo_reservacion')
                $intervalo = $value["valor"];
            else if ($value["propiedad"] == 'hora_inicio_bcp')
                $hora_ini_reservacion = $value["valor"];
            else if ($value["propiedad"] == 'hora_fin_reservacion')
                $hora_fin_reservacion = $value["valor"];
        }
        
        $timeslot_actual = $this->actionGetTimeSlot($hora_ini);
        $hora_ini = $timeslot_actual["hora_ini"];

        $hora_fin = date("H:i:00", strtotime ( +$intervalo.'minute' , strtotime ( $hora_ini ) ));
        
        $resultado_x_operadora = array();
        $i=0;
        
        foreach ($objeto_oper as $value => $key)
        {
            $resultado_x_operadora[$i]["nombre"] = $key["nombre"];
            $resultado_x_operadora[$i]["id_operadora"] = $value;
            $resultado_x_operadora[$i]["cantidad_total"] = $key["total"];
            $resultado_x_operadora[$i]["resultado"] = $this->actionGetTimeSlotXoperPrivate($fecha, $hora_ini, $hora_fin, $intervalo, $key["total"], $value, $hora_fin_reservacion, array());

            $i++;
        }
        
        return $resultado_x_operadora;
    }
    
    private function actionGetTimeSlotXoperPrivate($fecha, $hora_ini, $hora_fin, $intervalo, $total_sms, $id_operadora, $hora_fin_reservacion, $arreglo)
    {
        if ($total_sms == 0)
        {
            return $arreglo;
        }
        else
        {
            $capacidad_maxima = $this->actionGetCapacidadDisponibleTimeSlot($fecha, $hora_ini, $id_operadora, $intervalo, $hora_fin_reservacion);
            $total_sms_restante = $total_sms;
            
            if ($capacidad_maxima > 0)
            {
                if ($this->actionValidarHistorial($fecha, $hora_ini, $id_operadora))
                {
                    if (strtotime($hora_fin) > strtotime(date("H:i:00")))
                    {
                        $total_sms_restante = $total_sms - $capacidad_maxima;

                        if ($total_sms_restante >= 0)
                            $arreglo[] = array("hora_ini"=>$hora_ini, "hora_fin"=>$hora_fin, "total"=>($total_sms - $total_sms_restante));
                        else 
                        {
                            $arreglo[] = array("hora_ini"=>$hora_ini, "hora_fin"=>$hora_fin, "total"=>$total_sms);
                            $total_sms_restante = 0;
                        }
                    }
                }
            }
            else if ($capacidad_maxima === "unlimited")
            {
                $arreglo[] = array("hora_ini"=>$hora_ini, "hora_fin"=>date("H:i:00", strtotime ( '+30 minute' , strtotime ( $hora_fin ) )), "total"=>$total_sms);
                $total_sms_restante = 0;
            }
            
            $hora_ini = $hora_fin;
            $hora_fin = date("H:i:00", strtotime ( +$intervalo.'minute' , strtotime ( $hora_ini ) ));
            return $this->actionGetTimeSlotXoperPrivate($fecha, $hora_ini, $hora_fin, $intervalo, $total_sms_restante, $id_operadora, $hora_fin_reservacion, $arreglo);
        }
    }

    private function actionGetCapacidadDisponibleTimeSlot($fecha, $time_slot, $id_operadora, $intervalo, $hora_fin_reservacion)
    {
        //Hora inicio de la promo es menor que el maximo time slop
        if ( strtotime($time_slot) < strtotime($hora_fin_reservacion) )
        {
            $resumen = ResumenReservacion::model()->find("fecha=:fecha AND time_slot=:time_slot AND id_operadora=:id_operadora", array(":fecha"=>$fecha, ":time_slot"=>$time_slot, "id_operadora"=>$id_operadora));

            $total_sms = 0;

            if ($resumen)
                $total_sms = $resumen->total_sms;

            $operadora = ConfiguracionOperadoraReservacion::model()->find("id_operadora=:id_operadora", array(":id_operadora"=>$id_operadora));

            $capacidad_maxima = ($operadora->sms_x_seg * 60 * $intervalo) * ($operadora->porcentaje_permitido/100);

            $capacidad_disponible = $capacidad_maxima - $total_sms;

            if($capacidad_disponible < 0)
                return 0;
            else
                return $capacidad_disponible;
        }
        else return 'unlimited';
    }

    private function actionValidarHistorial($fecha, $time_slot, $id_operadora)
    {
        $dia_semana = date("w", strtotime($fecha));
        $nombre_dia = Yii::app()->Funciones->actionGetNombreDia($dia_semana);

        $criteria = new CDbCriteria;
        $criteria->select = $nombre_dia;
        $criteria->compare("id_usuario", Yii::app()->user->id);
        $criteria->compare("id_operadora", $id_operadora);

        $resultado = HistorialReservacion::model()->find($criteria);
        
        if ($resultado && $resultado->$nombre_dia == $time_slot)
            return false;
        else return true;
    }

    private function actionCheckReservacion($time_slot, $operadora_promociones)
    {
        foreach ($operadora_promociones as $value)
        {
            if (COUNT($value["resultado"]) > 1)
            {
                return true;
            }
            else if (COUNT($value["resultado"]) == 1 && $value["resultado"][0]["hora_ini"] != $time_slot)
            {
                return true;
            }
        }
        
        return false;
    }

    private function actionGetTimeSlot($hora_actual)
    {
        $criteria = new CDbCriteria;
        $criteria->select = "propiedad, valor";
        $criteria->addInCondition("propiedad", array('intervalo_reservacion', 'hora_inicio_bcp'));
        $resultado = ConfiguracionSistema::model()->findAll($criteria);
        
        foreach ($resultado as $value)
        {
            if ($value["propiedad"] == 'intervalo_reservacion')
                $intervalo = $value["valor"];
            else if ($value["propiedad"] == 'hora_inicio_bcp')
                $hora_ini = $value["valor"];
        }
        
        $hora_fin = date("H:i:00", strtotime ( +$intervalo.'minute' , strtotime ( $hora_ini ) ));
        return $this->actionGetTimeSlotPrivate($hora_actual, $hora_ini, $hora_fin, $intervalo);
    }
    
    private function actionGetTimeSlotPrivate($hora_actual, $hora_ini, $hora_fin, $intervalo)
    {
        if ( strtotime($hora_actual) >= strtotime($hora_ini) && strtotime($hora_actual) < strtotime($hora_fin) )
        {
            $objeto = array("hora_ini"=>$hora_ini, "hora_fin"=>$hora_fin);
            return $objeto;
        }
        else
        {
            $hora_ini = $hora_fin;
            $hora_fin = date("H:i:00", strtotime ( +$intervalo.'minute' , strtotime ( $hora_fin ) ));
            return $this->actionGetTimeSlotPrivate($hora_actual, $hora_ini, $hora_fin, $intervalo);
        
        }
    }

    public function actionMensajeTimeSlot($id_proceso, $timeslot, $alfanumerico)
    {
        $this->render("timeSlot", array("id_proceso"=>$id_proceso, "timeslot"=>$timeslot, "alfanumerico"=>$alfanumerico));
    }

    public function actionTimeSlot2()
    {
        $this->render("timeSlot2");
    }
}

?>