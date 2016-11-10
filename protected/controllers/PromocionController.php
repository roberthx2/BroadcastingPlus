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
                'actions' => array('create', 'getCliente', 'reporteCreate', 'confirmarBCP', 'confirmarBCNL'),
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

                        //Update en estado 8 todos los numeros exentos
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

                            $this->actionRestarCupoBCL($id_promo, $total);

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
                        $operadorasPermitidasBCP = $this->actionGetOperadorasPermitidasBCP(Yii::app()->user->id, $model->id_cliente);
                        $clienteBCP = ClienteAlarmas::model()->findByPk($model->id_cliente);
                        $cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);

                        if(is_numeric($clienteBCP->sc))
                            $alfanumerico = false;
                        else
                            $alfanumerico = true; //En caso de ser alfanumerico

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

                        //Cantidad de destinatarios validos
                        $total = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);

                        //En caso de existir numeros validos procedo a crear la promocion
                        if ($total > 0)
                        {
                            $sql = "SELECT id FROM evento WHERE cliente = :id_cliente";
                            $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
                            $sql->bindParam(":id_cliente", $model->id_cliente, PDO::PARAM_STR);
                            $evento = $sql->queryRow();

                            $this->actionUpdateIdAlarmas($id_proceso, $clienteBCP->descripcion, $operadorasPermitidasBCP);

                            $model_promocion = new PromocionesPremium;
                            $model_promocion->nombrePromo = $this->actionGetNombrePromo($clienteBCP->id_cliente_sms, $model->tipo, $clienteBCP->sc, $model->nombre, $model->fecha);
                            $model_promocion->id_cliente = $model->id_cliente;
                            $model_promocion->estado = 0;
                            $model_promocion->fecha = $model->fecha;
                            $model_promocion->hora = $model->hora_inicio;
                            $model_promocion->loaded_by = Yii::app()->user->id;
                            $model_promocion->contenido = $model->mensaje;
                            $model_promocion->fecha_cargada = date("Y-m-d");
                            $model_promocion->hora_cargada = date("H:i:s");
                            $model_promocion->save();
                            $id_promo = $model_promocion->primaryKey;

                            $model_deadline = new DeadlineOutgoingPremium;
                            $model_deadline->id_promo = $id_promo;
                            $model_deadline->fecha_limite = $model->fecha;
                            $model_deadline->hora_limite = $model->hora_fin;
                            $model_deadline->save();

                            $sql = "INSERT INTO outgoing_premium (id_promo, destinatario, mensaje, fecha_in, hora_in, tipo_evento, cliente, operadora, id_insignia_alarmas) SELECT :id_promo, SUBSTRING(numero, 4,7), :mensaje, :fecha, :hora, :evento, :id_cliente, id_operadora, id_insignia_alarmas FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1";
                            
                            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
                            $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_STR);
                            $sql->bindParam(":mensaje", $model->mensaje, PDO::PARAM_STR);
                            $sql->bindParam(":fecha", $model->fecha, PDO::PARAM_STR);
                            $sql->bindParam(":hora", $model->hora_inicio, PDO::PARAM_STR);
                            $sql->bindParam(":evento", $evento["id"], PDO::PARAM_STR);
                            $sql->bindParam(":id_cliente", $model->id_cliente, PDO::PARAM_STR);
                            $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_STR);
                            $sql->execute();

                            $model_cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);
                            $model_cupo->disponible = $model_cupo->disponible - $total;
                            $model_cupo->save();

                            $descripcion_historial = "PROMOCION BCP CREADA con nombre ".$model_promocion->nombrePromo." para (".$total.") destinatarios";

                            $model_cupo_historial = new UsuarioCupoHistoricoPremium;
                            $model_cupo_historial->id_usuario = Yii::app()->user->id;
                            $model_cupo_historial->id_cliente = $clienteBCP->id_cliente_sms;
                            $model_cupo_historial->ejecutado_por = Yii::app()->user->id;
                            $model_cupo_historial->cantidad = $total;
                            $model_cupo_historial->descripcion = $descripcion_historial;
                            $model_cupo_historial->fecha = date("Y-m-d");
                            $model_cupo_historial->hora = date("H:i:s");
                            $model_cupo_historial->tipo_operacion = 3; //Consumido
                            $model_cupo_historial->save();

                            //Guarda todos los numeros cargados para realizar el filtrado en las proximas cargas de promociones
                            $sql = "INSERT INTO tmp_numeros_cargados_por_dia (numero, id_operadora, fecha) SELECT numero, CASE id_operadora WHEN 6 THEN 5 ELSE id_operadora END AS id_operadora, :fecha FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1";
                            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
                            $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_STR);
                            $sql->bindParam(":fecha", $model->fecha, PDO::PARAM_STR);
                            $sql->execute();

                            $url_confirmar = Yii::app()->createUrl("promocion/confirmarBCP", array("id_promo"=>$id_promo));

                            $log = "PROMOCION BCP CREADA | id_promo: ".$id_promo." | id_cliente_sms: ".$clienteBCP->id_cliente_sms." | id_cliente_bcp: ".$model->id_cliente." | Destinatarios: ".$total;
                            Yii::app()->Procedimientos->setLog($log);
                        }
                    }

                    $transaction->commit();
                    $transaction2->commit();

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

        $this->render("create", array('model' => $model, 'dataTipo' => $dataTipo, 'listas' => $listas));
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
                    $data = Yii::app()->Procedimientos->getClienteCPEI(Yii::app()->user->id);
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

    protected function actionGetOperadorasPermitidasBCP($id_usuario, $id_cliente)
    {
        $sql = "SELECT * FROM usuario_cliente_operadora WHERE id_usuario = :id_usuario AND id_cliente = :id_cliente";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_STR);
        $sql->bindParam(":id_cliente", $id_cliente, PDO::PARAM_STR);
        //print_r($sql);
        //exit;
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
            $model_promocion = PromocionesPremium::model()->findByPk($id_promo);
            $model_promocion->estado = 2;
            $model_promocion->save();

            $sql = "UPDATE outgoing_premium SET status = 2 WHERE id_promo = :id_promo";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
            $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_STR);
            $sql->execute();

            $log = "PROMOCION CONFIRMADA BCP | id_promo: ".$id_promo." | id_cliente_bcp: ".$model_promocion->id_cliente;
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

    protected function actionRestarCupoBCL($id_promo, $cupo_consumido)
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
}

?>