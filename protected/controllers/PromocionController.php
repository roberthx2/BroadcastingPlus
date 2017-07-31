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
                'actions' => array('create', 'createPersonalizada', 'getCliente', 'getScBCP', 'getScOperadorasBCP', 'reporteCreate', 'confirmarBCP', 'confirmarBCNL', 'verDetalles', 'mensajeTimeSlot', 'generarPromocionBCP', 'timeSlot2', 'generarArchivoError'),
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
        $operadoras_bcp = array();

        $this->performAjaxValidation($model);

        if(isset($_POST['PromocionForm']))
        {
            $model->attributes=$_POST['PromocionForm'];

            if (isset($_POST['operadoras_bcp']))
                $operadoras_bcp=$_POST['operadoras_bcp'];
            
            if ($model->validate())
            {
                $transaction = Yii::app()->db->beginTransaction(); //Insignia_masivo
                $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

                try
                {
                    $id_proceso = Yii::app()->Procedimientos->getNumeroProceso();

                    $cupo = LoginCupo::model()->find("id_usuario = ".Yii::app()->user->id);
                    $_SESSION["url_confirmar"] = null;

                    //BCNL / CPEI
                    if ($model->tipo == 1 || $model->tipo == 2)
                    {
                        //BTL
                        if (isset($model->sc) && $model->sc != "")
                        {
                            //En case de existir numeros obtenidos desde BTL los updateo como validos para que no se aplique ningun filtro
                            if (isset($_SESSION['numeros_btl']) && $_SESSION['numeros_btl'] != "")
                            {
                                Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $_SESSION['numeros_btl']);
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
                        Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso);

                        //Updatea en estado 3 todos los números duplicados
                        Yii::app()->Filtros->filtrarDuplicados($id_proceso);

                        //Update en estado 4 todos los numeros exentos
                        Yii::app()->Filtros->filtrarExentos($id_proceso, 1, null);

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
                                $sql_1 = "SELECT CONCAT('0',numero) AS numero FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado = 1 LIMIT ".$limite_inferio." , ".$sms_x_modem;
                                $sql_1 = Yii::app()->db_masivo_premium->createCommand($sql_1)->queryAll();

                                $array = array();

                                foreach ($sql_1 as $num)
                                {
                                    $array[] = "(".$id_promo.", '".$num["numero"]."', ".$estado.", ".$value.", '".date("Y-m-d")."', '".date("H:i:s")."', ".$id_usuario.", '".$model->fecha."', '".$model->hora_inicio."', '".$model->mensaje."', ".$model->id_cliente.")";
                                }

                                if (COUNT($array) > 0)
                                {
                                    $sql = "INSERT INTO outgoing (id_promo, number, status, frecuency, date_loaded, time_loaded, loaded_by, date_program, time_program, content, id_cliente) VALUES ".implode(",", $array);

                                    $sql = Yii::app()->db->createCommand($sql)->execute();
                                }

                                $limite_inferio = $limite_inferio + $sms_x_modem;
                            }

                            $this->actionRestarCupoBCNL($id_promo, $total);

                            if ($model->tipo == 1) //BCNL
                            {
                                $_SESSION["url_confirmar"] = Yii::app()->createUrl("promocion/confirmarBCNL", array("id_promo"=>$id_promo));
                            }
                            else if ($model->tipo == 2)
                            {
                                $_SESSION["url_confirmar"] = "CPEI";
                            }

                            $log = "PROMOCION ".$prefijo." CREADA | id_promo: ".$id_promo." | id_cliente: ".$model->id_cliente." | Destinatarios: ".$total;
                            Yii::app()->Procedimientos->setLog($log);
                        }
                    }

                    //BCP
                    if ($model->tipo == 3)
                    {
                        $cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);

                        $operadorasPermitidasBCP = $this->actionGetOperadorasPermitidasBCP($model->id_cliente, $model->sc_bcp);

                        //BTL
                        if (isset($model->sc) && $model->sc != "")
                        {
                            //En case de existir numeros obtenidos desde BTL los updateo como validos para que no se aplique ningun filtro
                            if (isset($_SESSION['numeros_btl']) && $_SESSION['numeros_btl'] != "")
                            {
                                Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $_SESSION['numeros_btl']);
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
                        Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso);

                        //Updatea en estado 11 todos los numeros con id_operadora inhabilitado
                        Yii::app()->Filtros->filtrarOperadoraHabilitada($id_proceso);

                        //Updatea en estado 3 todos los números duplicados
                        Yii::app()->Filtros->filtrarDuplicados($id_proceso);

                        //Updatea en estado 6 todos los numeros con id_operadora no permitido
                        Yii::app()->Filtros->filtrarOperadoraPermitida($id_proceso, $operadorasPermitidasBCP);

                        //Update en estado 4 todos los numeros exentos
                        Yii::app()->Filtros->filtrarExentos($id_proceso, 2, $operadorasPermitidasBCP);

                        if (Yii::app()->Procedimientos->clienteIsHipicoLotero(Yii::app()->user->modelSMS()->id_cliente))
                        {
                            //Update en estado 5 todos los numeros que no tienen trafico suficiente
                            Yii::app()->Filtros->filtrarSmsXNumero($id_proceso, 2, $operadorasPermitidasBCP);

                            //Update en estado 9 todos los numeros que han sido cargados del limite permitido en el dia
                            Yii::app()->Filtros->filtrarPorCargaDiaria($id_proceso, $model->sc_bcp, $model->fecha, $operadorasPermitidasBCP);
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
                        $_SESSION["operadoras_bcp"] = $operadoras_bcp;

                        if ($objeto_timeslot["timeslot"] && $objeto_timeslot["mostrarMensaje"])
                        {
                            $url = Yii::app()->createUrl("promocion/mensajeTimeSlot", array("id_proceso"=>$id_proceso, "timeslot"=>$objeto_timeslot["timeslot"], 'personalizada'=>'false'));
                        }
                        else
                        {
                            $url = Yii::app()->createUrl("promocion/generarPromocionBCP", array("id_proceso"=>$id_proceso, "timeslot"=>$objeto_timeslot["timeslot"], 'personalizada'=>'false'));
                        }
                    }
                    else //BCNL/CPEI
                    {
                        $url = Yii::app()->createUrl("promocion/reporteCreate", array("id_proceso"=>$id_proceso, "nombre"=>$model->nombre, 'tipo'=>$model->tipo, 'personalizada'=>'false'));
                    }

                    $this->redirect($url);

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
            $model_lista = Lista::model()->findAll("id_usuario = ".Yii::app()->user->id." AND estado = 1");
            
            foreach ($model_lista as $value)
            {
                $listas[$value["id_lista"]] = $value["nombre"];
            }
        }

        $this->render("create", array('model'=>$model, 'dataTipo'=>$dataTipo, 'listas'=>$listas, 'operadoras_bcp'=>$operadoras_bcp));
    }

    public function actionCreatePersonalizada()
    {
        $model = new PromocionPersonalizadaForm;

        $this->performAjaxValidation($model);

        $dataTipo = array();
        $operadoras_bcp = array();

        $this->performAjaxValidation($model);

        if(isset($_POST['PromocionPersonalizadaForm']))
        {
            $path_file = realpath( Yii::app( )->getBasePath( )."/files/");//ruta final del archivo

            $model->attributes=$_POST['PromocionPersonalizadaForm'];

            if (isset($_POST['operadoras_bcp']))
                $operadoras_bcp=$_POST['operadoras_bcp'];

            if ($model->validate())
            {
                $uploadedFile=CUploadedFile::getInstance($model,'archivo');

                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $path_file_full = $path_file."/".time().rand(0,9999).".".$uploadedFile->getExtensionName();  
                    $uploadedFile->saveAs($path_file_full);

                    $objeto = $this->actionAnalizarArchivo($path_file_full, $model);

                    if ($objeto["resultado"])
                    {
                        $destinatarios = $objeto["numeros"];

                        $transaction = Yii::app()->db->beginTransaction(); //Insignia_masivo
                        $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

                        try
                        {
                            $id_proceso = Yii::app()->Procedimientos->getNumeroProceso();

                            $cupo = LoginCupo::model()->find("id_usuario = ".Yii::app()->user->id);
                            $_SESSION["url_confirmar"] = null;

                            //BCNL / CPEI
                            if ($model->tipo == 1 || $model->tipo == 2)
                            {
                                Yii::app()->Procedimientos->setNumerosPersonalizadosTmpProcesamiento($id_proceso, $destinatarios);

                                //Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
                                Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso);

                                //Updatea en estado 3 todos los números duplicados
                                Yii::app()->Filtros->filtrarDuplicados($id_proceso);

                                //Update en estado 4 todos los numeros exentos
                                Yii::app()->Filtros->filtrarExentos($id_proceso, 1, null);

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
                                    $model_promocion->contenido = 'BCPLUS - Promocion de contenido personalizado';
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
                                        $sql_1 = "SELECT CONCAT('0',numero) AS numero, mensaje FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado = 1 LIMIT ".$limite_inferio." , ".$sms_x_modem;
                                        $sql_1 = Yii::app()->db_masivo_premium->createCommand($sql_1)->queryAll();

                                        $array = array();

                                        foreach ($sql_1 as $num)
                                        {
                                            $array[] = "(".$id_promo.", '".$num["numero"]."', ".$estado.", ".$value.", '".date("Y-m-d")."', '".date("H:i:s")."', ".$id_usuario.", '".$model->fecha."', '".$model->hora_inicio."', '".$num["mensaje"]."', ".$model->id_cliente.")";
                                        }

                                        if (COUNT($array) > 0)
                                        {
                                            $sql = "INSERT INTO outgoing (id_promo, number, status, frecuency, date_loaded, time_loaded, loaded_by, date_program, time_program, content, id_cliente) VALUES ".implode(",", $array);

                                            $sql = Yii::app()->db->createCommand($sql)->execute();
                                        }

                                        $limite_inferio = $limite_inferio + $sms_x_modem;
                                    }

                                    $this->actionRestarCupoBCNL($id_promo, $total);

                                    if ($model->tipo == 1) //BCNL
                                    {
                                        $_SESSION["url_confirmar"] = Yii::app()->createUrl("promocion/confirmarBCNL", array("id_promo"=>$id_promo));
                                    }
                                    else if ($model->tipo == 2)
                                    {
                                        $_SESSION["url_confirmar"] = "CPEI";
                                    }

                                    $log = "PROMOCION ".$prefijo." CREADA | id_promo: ".$id_promo." | id_cliente: ".$model->id_cliente." | Destinatarios: ".$total;
                                    Yii::app()->Procedimientos->setLog($log);
                                }
                            }

                            //BCP
                            if ($model->tipo == 3)
                            {
                                $cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);

                                $operadorasPermitidasBCP = $this->actionGetOperadorasPermitidasBCP($model->id_cliente, $model->sc_bcp);

                                //Guarda los numeros ingresados en el textarea en la tabla de procesamiento
                                Yii::app()->Procedimientos->setNumerosPersonalizadosTmpProcesamiento($id_proceso, $destinatarios);

                                //Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
                                Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso);

                                //Updatea en estado 11 todos los numeros con id_operadora inhabilitado
                                Yii::app()->Filtros->filtrarOperadoraHabilitada($id_proceso);

                                //Updatea en estado 3 todos los números duplicados
                                Yii::app()->Filtros->filtrarDuplicados($id_proceso);

                                //Updatea en estado 6 todos los numeros con id_operadora no permitido
                                Yii::app()->Filtros->filtrarOperadoraPermitida($id_proceso, $operadorasPermitidasBCP);

                                //Update en estado 4 todos los numeros exentos
                                Yii::app()->Filtros->filtrarExentos($id_proceso, 2, $operadorasPermitidasBCP);

                                if (Yii::app()->Procedimientos->clienteIsHipicoLotero(Yii::app()->user->modelSMS()->id_cliente))
                                {
                                    //Update en estado 5 todos los numeros que no tienen trafico suficiente
                                    Yii::app()->Filtros->filtrarSmsXNumero($id_proceso, 2, $operadorasPermitidasBCP);

                                    //Update en estado 9 todos los numeros que han sido cargados del limite permitido en el dia
                                    Yii::app()->Filtros->filtrarPorCargaDiaria($id_proceso, $model->sc_bcp, $model->fecha, $operadorasPermitidasBCP);
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
                                $_SESSION["operadoras_bcp"] = $operadoras_bcp;

                                if ($objeto_timeslot["timeslot"] && $objeto_timeslot["mostrarMensaje"])
                                {
                                    $url = Yii::app()->createUrl("promocion/mensajeTimeSlot", array("id_proceso"=>$id_proceso, "timeslot"=>$objeto_timeslot["timeslot"], 'personalizada'=>'true'));
                                }
                                else
                                {
                                    $url = Yii::app()->createUrl("promocion/generarPromocionBCP", array("id_proceso"=>$id_proceso, "timeslot"=>$objeto_timeslot["timeslot"], 'personalizada'=>'true'));
                                }
                            }
                            else //BCNL/CPEI
                            {
                                $url = Yii::app()->createUrl("promocion/reporteCreate", array("id_proceso"=>$id_proceso, "nombre"=>$model->nombre, 'tipo'=>$model->tipo, 'personalizada'=>'true'));
                            }

                            $this->redirect($url);

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
                else
                {
                    $error = "Ocurrio un error al cargar el archivo";
                    Yii::app()->user->setFlash("danger", $error); 
                }
            }
        }

        if (Yii::app()->user->getPermisos()->broadcasting && Yii::app()->user->getPermisos()->crear_promo_personalizada_bcnl)
        {    
            $dataTipo[1] = "BCNL";
            $dataTipo[2] = "CPEI";
        }
        if (Yii::app()->user->getPermisos()->broadcasting_premium && Yii::app()->user->getPermisos()->crear_promo_personalizada_bcp)
            $dataTipo[3] = "BCP";


        $this->render("createPersonalizada", array('model'=>$model, 'dataTipo'=>$dataTipo, 'operadoras_bcp'=>$operadoras_bcp));
    }

    public function actionAnalizarArchivo($ruta, $model_promocion)
    {
        $resultado = true;
        $array_error = array();
        $array_validos = array();
        $model = new PromocionForm;
        $model->id_cliente = $model_promocion->id_cliente;
        $model->tipo = $model_promocion->tipo;
        $model->fecha = '0000-00-00'; //Coloco una fecha por defecto para evadir el filtro de spam
        $model->sc_bcp = $model_promocion->sc_bcp;

        if (($gestor = fopen($ruta, "r")) !== FALSE)
        {
            while (($linea = fgets($gestor, 4096)) !== FALSE)
            {
                $datos = explode('#', $linea, 2);
                $linea = str_replace("\r\n", "", $linea);

                if (COUNT($datos) == 2 && is_numeric($datos[0])) //Numero y Mensaje
                {
                    $model->destinatarios = $datos[0];
                    $model->mensaje = $datos[1];
                    $model->validate();

                    $errores = $model->getErrors();

                    if ( (isset($errores["mensaje"]) && COUNT($errores["mensaje"]) > 0) || 
                            (isset($errores["destinatarios"]) && COUNT($errores["destinatarios"]) > 0) )
                    {
                        $aux = $linea;
                        $bandera = false;

                        if (isset($errores["mensaje"]) && COUNT($errores["mensaje"] > 0))
                        {
                            $bandera = true;
                            foreach ($errores["mensaje"] as $value)
                            {
                                $aux .= " ---> ".$value;
                            }
                        }

                        if (isset($errores["destinatarios"]) && COUNT($errores["destinatarios"] > 0))
                        {
                            $bandera = true;
                            foreach ($errores["destinatarios"] as $value)
                            {
                                $aux .= " ---> ".$value;
                            }
                        }

                        if ($bandera)
                            $array_error[] = $aux;
                    }
                    else
                    {
                        $array_validos[] = "(#id_proceso#, '".$model->destinatarios."', '".$model->mensaje."')";
                    }
                }
                elseif($linea != "")
                {
                    $array_error[] = $linea." ---> Cantidad de parametros invalida";
                }
            }

            if (COUNT($array_validos) == 0)
            {
                $resultado = false;
                $url = Yii::app()->createUrl("promocion/generarArchivoError");
                $error = "El archivo no contiene destinatario validos. <a href='".$url."'>Ver detalles </a>";
                Yii::app()->user->setFlash("danger", $error);
            }

            fclose($gestor);

            unlink($ruta);
        }
        else
        {
            $resultado = false;
            $error = "No se pudo abrir el archvio, intente de nuevo";
            Yii::app()->user->setFlash("danger", $error);
        }

        $_SESSION["errores"] = $array_error;

        return array("resultado"=>$resultado, "numeros"=>$array_validos);
    }

    public function actionGenerarArchivoError()
    {
        $errores = implode("\r\n", $_SESSION["errores"]);
        return Yii::app()->getRequest()->sendFile("Errores_".time().rand(0,9999).".txt", $errores);
    }

    public function actionGenerarPromocionBCP()
    {
        $id_proceso = Yii::app()->request->getParam('id_proceso');
        $timeslot = Yii::app()->request->getParam('timeslot');
        $personalizada = Yii::app()->request->getParam('personalizada');

        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            //Cantidad de destinatarios validos
            $total_sms = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);
            $_SESSION["url_confirmar"] = null;
            $ids_promo = array();
            $model = clone $_SESSION["model"];
            $model_aux = new PromocionForm;
            $model_aux = clone $model;
            $operadoras_bcp = $_SESSION["operadoras_bcp"];
            //unset($_SESSION["model"]);
            //unset($_SESSION["operadoras_bcp"]);
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
                        foreach ($array_promociones as $value)
                        {
                            $i=0;
                            $j=1;
                            
                            foreach ($value["resultado"] as $key)
                            {
                                $alfanumerico = $operadoras_bcp[$value["id_operadora"]][0];

                                if ($alfanumerico == 1) //ALfanumerico
                                {
                                    $model_aux->nombre = $model->nombre."_".$value["nombre"]."_ALF"."_".$j;
                                }
                                else
                                {
                                    $model_aux->nombre = $model->nombre."_".$value["nombre"]."_".$j;
                                }

                                $model_aux->hora_inicio = $key["hora_ini"];
                                $model_aux->hora_fin = $key["hora_fin"];

                                $model_aux->id_cliente = $this->actionGetIdClienteBCP($model->id_cliente, $model->sc_bcp, $value["id_operadora"], $alfanumerico);

                                $id_promo = $this->actionRegistrarPromocionBCP($id_proceso, $model_aux, $key["total"], $value["id_operadora"], $alfanumerico, $i, $personalizada);

                                $ids_promo[] = $id_promo; 
                                $i+=$key["total"];
                                $j++;
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
                    foreach ($total_x_oper as $key=>$value)
                    {
                        $alfanumerico = $operadoras_bcp[$key][0];

                        if ($alfanumerico == 1) //ALfanumerico
                        {
                            $model_aux->nombre = $model->nombre."_".$value["nombre"]."_ALF";
                        }
                        else
                        {
                            $model_aux->nombre = $model->nombre."_".$value["nombre"];
                        }

                        $model_aux->id_cliente = $this->actionGetIdClienteBCP($model->id_cliente, $model->sc_bcp, $key, $alfanumerico);

                        $id_promo = $this->actionRegistrarPromocionBCP($id_proceso, $model_aux, $value["total"], $key, $alfanumerico, 0, $personalizada);

                        $ids_promo[] = $id_promo; 
                    }
                }

                $id_promo = implode("##", $ids_promo);
                $_SESSION["url_confirmar"] = Yii::app()->createUrl("promocion/confirmarBCP", array("id_promo"=>$id_promo));
            }

            $transaction->commit();

            unset($_SESSION["model"]);
            unset($_SESSION["operadoras_bcp"]);
            unset($_SESSION["timeslot"]);

            $url = Yii::app()->createUrl("promocion/reporteCreate", array("id_proceso"=>$id_proceso, "nombre"=>$model->nombre, 'tipo'=>$model->tipo, 'personalizada'=>$personalizada));

            $this->redirect($url);

        } catch (Exception $e)
            {
                $error = "Ocurrio un error al crear la promocion, intente nuevamente.";
                Yii::app()->user->setFlash("danger", $error);
                //print_r($e);
                $transaction->rollBack();
                //$this->redirect(array("create"));
            }
    }

    private function actionRegistrarPromocionBCP($id_proceso, $model, $total_sms, $id_operadora, $alfanumerico, $limite_ini, $personalizada)
    {
        $clienteBCP = ClienteAlarmas::model()->findByPk($model->id_cliente);

        $sql = "SELECT id FROM evento WHERE cliente = :id_cliente";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_cliente", $model->id_cliente, PDO::PARAM_INT);
        $evento = $sql->queryRow();

        //Guarda todos los numeros cargados para realizar el filtrado en las proximas cargas de promociones
        $sql = "INSERT INTO tmp_numeros_cargados_por_dia (sc, numero, id_operadora, fecha) SELECT ".$model->sc_bcp.", numero, id_operadora, :fecha FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1 AND id_operadora IN(".$id_operadora.") LIMIT ".$limite_ini.",".$total_sms;
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
        $sql->bindParam(":fecha", $model->fecha, PDO::PARAM_STR);
        $sql->execute();

        $sql = "SELECT id_operadora_bcp, prefijo FROM operadoras_relacion 
                WHERE id_operadora_bcnl = ".$id_operadora." AND alfanumerico = ".$alfanumerico;
        $operadoras_bcp = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

        $this->actionUpdateIdAlarmas($id_proceso, $clienteBCP->descripcion, $id_operadora, $operadoras_bcp);
        
        $model_promocion = new PromocionesPremium;
        $model_promocion->nombrePromo = $this->actionGetNombrePromo($clienteBCP->id_cliente_sms, $model->tipo, $model->sc_bcp, $model->nombre, $model->fecha);
        $model_promocion->id_cliente = $model->id_cliente;
        $model_promocion->sc = $clienteBCP->sc;
        $model_promocion->estado = 0;
        $model_promocion->fecha = $model->fecha;
        $model_promocion->hora = $model->hora_inicio;
        $model_promocion->loaded_by = Yii::app()->user->id;
        $model_promocion->contenido = ($personalizada == 'false') ? $model->mensaje : 'BCPLUS - Promocion de contenido personalizado';
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

        if ($personalizada == 'false')
        {
            $sql = "INSERT INTO outgoing_premium (id_promo, destinatario, mensaje, fecha_in, hora_in, tipo_evento, cliente, operadora, id_insignia_alarmas) SELECT :id_promo, SUBSTRING(numero, 4,7), '".$model->mensaje."', :fecha, :hora, :evento, :id_cliente, CASE";
        }
        else
        {
            $sql = "INSERT INTO outgoing_premium (id_promo, destinatario, mensaje, fecha_in, hora_in, tipo_evento, cliente, operadora, id_insignia_alarmas) SELECT :id_promo, SUBSTRING(numero, 4,7), mensaje, :fecha, :hora, :evento, :id_cliente, CASE";
        }

        foreach ($operadoras_bcp as $value)
        {
            $sql .= " WHEN numero REGEXP '^".$value["prefijo"]."' THEN ".$value["id_operadora_bcp"];
        }

        $sql .= " END AS id_operadora, id_insignia_alarmas FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1 AND id_operadora = :id_operadora LIMIT ".$limite_ini.",".$total_sms;

        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_INT);
        //$sql->bindParam(":mensaje", $model->mensaje, PDO::PARAM_STR);
        $sql->bindParam(":fecha", $model->fecha, PDO::PARAM_STR);
        $sql->bindParam(":hora", $model->hora_inicio, PDO::PARAM_STR);
        $sql->bindParam(":evento", $evento["id"], PDO::PARAM_INT);
        $sql->bindParam(":id_cliente", $model->id_cliente, PDO::PARAM_INT);
        $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
        $sql->bindParam(":id_operadora", $id_operadora, PDO::PARAM_INT);
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
            $sql = "UPDATE historial_reservacion SET ".$nombre_dia." = '".$model->hora_inicio."' WHERE id_usuario = ".Yii::app()->user->id." AND id_operadora = ".$id_operadora." AND (".$nombre_dia." > '".$model->hora_inicio."' OR ".$nombre_dia." = '00:00:00')";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->execute();
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

        $log = "PROMOCION BCP CREADA | id_promo: ".$id_promo." | id_cliente_sms: ".$clienteBCP->id_cliente_sms." | id_cliente_bcp: ".$model->id_cliente." | Destinatarios: ".$total_sms;

        Yii::app()->Procedimientos->setLog($log);

        return $id_promo;
    }

    private function actionUpdateOperBCP($id_proceso, $operadoras_bcp)
    {   
        $criteria = new CDbCriteria;
        $criteria->select = "id_operadora_bcp AS id_operadora, prefijo";
        $criteria->addInCondition('id_operadora_bcp', explode(",", $operadoras_bcp));

        $operadoras = OperadorasRelacion::model()->findAll($criteria);

        foreach ($operadoras as $value)
        {
            $sql = "UPDATE tmp_procesamiento SET id_operadora = ".$value["id_operadora"]." WHERE id_proceso = :id_proceso AND estado = 1 AND numero REGEXP '^".$value["prefijo"]."'";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
            $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
            $sql->execute();
        }
    }

    private function actionGetIdClienteBCP($id_cliente_sms, $sc, $id_operadora, $alfanumerico)
    {
        if (Yii::app()->user->isAdmin())
        {
            $sql = "SELECT c.id_cliente_bcp FROM clientes_bcp c "
                    ." WHERE c.id_cliente_sms = ".$id_cliente_sms." AND c.sc = ".$sc." "
                    ." AND c.id_operadora = ".$id_operadora." AND c.alfanumerico = ".$alfanumerico;
        }
        else
        {
            $sql = "SELECT c.id_cliente_bcp FROM usuario_clientes_bcp u "
                    ." INNER JOIN clientes_bcp c ON u.id_cliente_bcp = c.id "
                    ." WHERE u.id_usuario = ".Yii::app()->user->id." AND c.id_cliente_sms = ".$id_cliente_sms." "
                    ." AND c.sc = ".$sc." AND c.id_operadora = ".$id_operadora." AND c.alfanumerico = ".$alfanumerico;
        }

        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

        $resultado = ($sql["id_cliente_bcp"] == "") ? "null" : $sql["id_cliente_bcp"];

        return $resultado;
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

    public function actionGetScBCP()
    {
        $id_cliente = Yii::app()->request->getParam('id_cliente');
        $tipo = Yii::app()->request->getParam('tipo');

        if (Yii::app()->request->isAjaxRequest)
        {
            if ($tipo == 3) //BCP
            {
                $data = Yii::app()->Procedimientos->getScClienteBCP($id_cliente);

                if($data)
                {
                    echo CJSON::encode(array(
                                            'error' => 'false',
                                            'status' => 'SC obtenidos correctamente',
                                            'data' => $data
                                       )                                
                         );
                    Yii::app()->end();
                } else {
                    echo CJSON::encode(array(
                        'error' => 'true',
                        'status' => 'No posee sc asociado'
                    ));
                    Yii::app()->end();
                }
            }
            else
            {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'No posee sc asociado'
                ));
                Yii::app()->end();
            }
        }
    }

    public function actionGetScOperadorasBCP()
    {
        $id_cliente = Yii::app()->request->getParam('id_cliente');
        $sc = Yii::app()->request->getParam('sc');
        
        if (Yii::app()->request->isAjaxRequest)
        {
            $data = Yii::app()->Procedimientos->getScOperadorasBCP($id_cliente, $sc);

            if($data)
            {
                $criteria = new CDbCriteria;
                $criteria->select = "id_operadora_bcnl, descripcion";
                $criteria->group = "id_operadora_bcnl";
                $resultado = OperadorasRelacion::model()->findAll($criteria);

                foreach ($resultado as $value)
                {
                    $operadora_relacion[$value["id_operadora_bcnl"]] = $value["descripcion"];
                }

                $resultado = "";
                $radios = "<table>";

                foreach ($data as $value)
                {
                    $resultado[$value["id_operadora"]][] = array("sc"=>$value["sc"], "alfanumerico"=>$value["alfanumerico"]);
                }

                foreach ($resultado as $id_operadora => $value)
                {
                    $radios .= "<tr><td style='padding: 3px 10px 3px 10px; color: ".Yii::app()->Funciones->getColorOperadoraBCNL($id_operadora).";'><strong>".$operadora_relacion[$id_operadora]."</strong></td><td style='padding: 3px 10px 3px 10px'>";

                    $checked = "checked";

                    foreach ($value as $key)
                    {
                        $radios .= "<input type='radio' class='operadoras_bcp_".$id_operadora."' name='operadoras_bcp[".$id_operadora."][]' ".$checked." value='".$key["alfanumerico"]."'> ".$key["sc"]." ";
                        $checked = "";
                    }

                    $radios .= "</td></tr>";
                }
                $radios .= "</table>";

                echo CJSON::encode(array(
                                        'error' => 'false',
                                        'status' => 'operadoras obtenidas correctamente',
                                        'data' => $radios
                                   )                                
                     );
                Yii::app()->end();
            } else {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => '<font color="#a94442">No posee operadoras asociadas</font>'
                ));
                Yii::app()->end();
            }
        }
    }

    protected function actionGetOperadorasPermitidasBCP($id_cliente_sms, $sc)
    {
        if (Yii::app()->user->isAdmin())
        {
            /*$sql = "SELECT GROUP_CONCAT(DISTINCT id_operadora) AS id_operadora FROM clientes_bcp cb 
                    INNER JOIN cliente c ON cb.id_cliente_bcp = c.id 
                    WHERE cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1";*/

            $sql = "SELECT GROUP_CONCAT(DISTINCT t.id_operadora) AS id_operadora FROM (
                    SELECT c.id, cb.id_operadora FROM clientes_bcp cb 
                    INNER JOIN cliente c ON cb.id_cliente_bcp = c.id 
                    WHERE cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1) AS t
                    INNER JOIN operadora_cliente oc ON t.id = oc.id_cliente AND t.id_operadora = oc.id_op";
        }
        else
        {
            /*$sql = "SELECT GROUP_CONCAT(DISTINCT id_operadora) AS id_operadora FROM usuario_clientes_bcp uc
                    INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
                    INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
                    WHERE uc.id_usuario = ".Yii::app()->user->id." AND cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1";*/

            $sql = "SELECT GROUP_CONCAT(DISTINCT t.id_operadora) AS id_operadora FROM (
                    SELECT c.id, cb.id_operadora FROM usuario_clientes_bcp uc
                    INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
                    INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
                    WHERE uc.id_usuario = ".Yii::app()->user->id." AND cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1) AS t
                    INNER JOIN operadora_cliente oc ON t.id = oc.id_cliente AND t.id_operadora = oc.id_op";
        }

        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_cliente_sms", $id_cliente_sms, PDO::PARAM_INT);
        $sql->bindParam(":sc", $sc, PDO::PARAM_INT);

        $sql = $sql->queryRow();

        $operadoras = ($sql["id_operadora"] == "") ? "0" : $sql["id_operadora"];

        return $operadoras;
    }

    protected function actionGetNumerosListas($id_listas, $tipo, $operadorasPermitidasBCP)
    {
        if ($tipo == 1 || $tipo == 2) //BCNL / CPEI
        {
            $sql = "SELECT GROUP_CONCAT(DISTINCT numero) AS numeros FROM lista_destinatarios WHERE id_lista IN (".implode(",", $id_listas).") AND estado = 1";
        }

        else if ($tipo == 3) //BCP
        {
            $sql = "SELECT GROUP_CONCAT(DISTINCT numero) AS numeros FROM lista_destinatarios WHERE id_lista IN (".implode(",", $id_listas).") AND id_operadora IN(".$operadorasPermitidasBCP.") AND estado = 1";
        }

        $sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

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

    protected function actionUpdateIdAlarmas($id_proceso, $descripcion_cliente, $id_operadora, $operadoras_bcp)
    {   
        foreach ($operadoras_bcp as $value)
        {
            $id_operadoras_bcp[$value["id_operadora_bcp"]] = array("prefijo_general"=>$value["prefijo"], "prefijo_bcp"=>"");
            $cadena_id_oper_bcp[] = $value["id_operadora_bcp"];
        }

        $sql = "SELECT id, prefijo FROM operadora WHERE id IN(".implode(",", $cadena_id_oper_bcp).")";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryAll();
        
        foreach ($sql as $value)
        {
            $id_operadoras_bcp[$value["id"]]["prefijo_bcp"] = $value["prefijo"];
        }

        foreach ($id_operadoras_bcp as $value)
        {
            $sql = "UPDATE tmp_procesamiento SET id_insignia_alarmas = CONCAT('".$descripcion_cliente.$value["prefijo_bcp"]."', SUBSTRING(numero,4,7)) WHERE id_proceso = :id_proceso AND estado = 1 AND id_operadora = :id_operadora AND numero REGEXP '^".$value["prefijo_general"]."' ";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
            $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
            $sql->bindParam(":id_operadora", $id_operadora, PDO::PARAM_INT);
            $sql->execute();
        }
    }

    public function actionConfirmarBCP()
    {
        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $id_promo = str_replace("##", ",", $_GET["id_promo"]);

            $sql = "UPDATE promociones_premium SET estado = 2 WHERE id_promo IN(".$id_promo.")";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->execute();

            $sql = "UPDATE outgoing_premium_diario SET status = 2 WHERE id_promo IN(".$id_promo.")";
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

    public function actionReporteCreate()
    {
        $id_proceso = Yii::app()->request->getParam('id_proceso');
        $nombre = Yii::app()->request->getParam('nombre');
        $url_confirmar = $_SESSION["url_confirmar"];
        //unset($_SESSION["url_confirmar"]);
        $tipo = Yii::app()->request->getParam('tipo');
        $personalizada = Yii::app()->request->getParam('personalizada');

        $this->render("reporteCreate", array('id_proceso'=>$id_proceso, 'nombre'=>$nombre, 'url_confirmar'=>$url_confirmar, 'tipo'=>$tipo, 'personalizada'=>$personalizada));
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
        
        $fecha_inicio = date_create($fecha." ".$hora_ini)->format('Y-m-d H:i:00');

        if (strtotime($fecha_inicio) < strtotime(date("Y-m-d H:i:00")))
            $hora_ini = date("H:i:00");

        $timeslot_actual = Yii::app()->Procedimientos->getTimeSlot($hora_ini);

        $hora_ini = $timeslot_actual["hora_fin"];

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
                    $fecha_limite = date_create($fecha." ".$hora_fin)->format('Y-m-d H:i:s');

                    if (strtotime($fecha_limite) > strtotime(date("Y-m-d H:i:s")))
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
                $hora_fin_aux = date("H:i:00", strtotime ( '+60 minute' , strtotime ( date("H:i:00") ) ));

                if (strtotime($hora_ini) >= strtotime($hora_fin_aux))
                {
                    $hora_fin_aux = date("H:i:00", strtotime ( '+30 minute' , strtotime ( $hora_fin ) ));
                }

                $arreglo[] = array("hora_ini"=>$hora_ini, "hora_fin"=>$hora_fin_aux, "total"=>$total_sms);

                //$arreglo[] = array("hora_ini"=>$hora_ini, "hora_fin"=>date("H:i:00", strtotime ( '+30 minute' , strtotime ( $hora_fin ) )), "total"=>$total_sms);
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

    /*public function actionGetTimeSlot($hora_actual)
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
    }*/

    public function actionMensajeTimeSlot()
    {
        $id_proceso = Yii::app()->request->getParam('id_proceso');
        $timeslot = Yii::app()->request->getParam('timeslot');
        $personalizada = Yii::app()->request->getParam('personalizada');

        $this->render("timeSlot", array("id_proceso"=>$id_proceso, "timeslot"=>$timeslot, 'personalizada'=>$personalizada));
    }

    public function actionTimeSlot2()
    {
        $this->render("timeSlot2");
    }
}

?>