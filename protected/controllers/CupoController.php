<?php

class CupoController extends Controller
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
                'actions' => array('historico', 'recarga', 'getInfoCupoBcp', 'recargarCupoBcp', 'admin', 'formulario', 'update', 'usuarioVenceCupo'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    public function actionHistorico()
    {
        $this->render("historico");
    }

    public function actionRecarga()
    {
        $this->render("recarga");
    }

    public function actionAdmin()
    {
        $this->render("admin");
    }

    public function actionGetInfoCupoBcp()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            if (isset($_POST['RecargaCupoBcpForm']['id_usuario']) && $_POST['RecargaCupoBcpForm']['id_usuario'] != "")
                $id_usuario = $_POST['RecargaCupoBcpForm']['id_usuario'];
            else 
                $id_usuario = Yii::app()->user->id;

            $cupo = UsuarioCupoPremium::model()->find("id_usuario = ".$id_usuario);
            $cupo_disponible = ($cupo) ? $cupo->disponible : 0;

            $criteria = new CDbcriteria;
            $criteria->select = "id_cliente, login";
            $criteria->compare("id_usuario", $id_usuario);
            $model_usuario = UsuarioSms::model()->find($criteria);

            $criteria = new CDbcriteria;
            $criteria->select = "ejecutado_por, fecha";
            $criteria->condition = "fecha = (SELECT MAX(fecha) FROM usuario_cupo_historico_premium WHERE id_cliente = ".$model_usuario->id_cliente." AND tipo_operacion = 1) AND ";
            $criteria->condition .= "id_cliente = ".$model_usuario->id_cliente." AND ";
            $criteria->condition .= "tipo_operacion = 1";
            $criteria->order = "id DESC";
            $criteria->limit = 1;

            $historico = UsuarioCupoHistoricoPremium::model()->find($criteria);

            $ejecutado_por = "-";
            $fecha = "-";

            if ($historico)
            {
                $ejecutado_por = ($historico->ejecutado_por != 0) ? UsuarioSmsController::actionGetLogin($historico->ejecutado_por) : 'NO EXISTE';
                $fecha = $historico->fecha;
            }

            echo CJSON::encode(array(
                        'cupo_disponible'=> number_format($cupo_disponible, 0, '', '.'),
                        'login' => $model_usuario->login,
                        'ejecutado_por' => $ejecutado_por,
                        'fecha' => $fecha,
                        'maximo' => number_format($this->actionMaximoMontoBcp($id_usuario), 0, '', '.'),
                        'vence_cupo' => $this->actionUsuarioVenceCupo($id_usuario)
                    ));

            Yii::app()->end();
        }
    }

    public function actionMaximoMontoBcp($id_usuario)
    {
        $criteria = new CDbcriteria;
        $criteria->select = "id_cliente, cadena_serv";
        $criteria->compare("id_usuario", $id_usuario);
        $model_usuario = UsuarioSms::model()->find($criteria);

        $cadena_serv = Yii::app()->Funciones->limpiarCadenaQuery($model_usuario->cadena_serv);

        $criteria = new CDbcriteria;
        $criteria->select = "valor, propiedad";
        $criteria->addInCondition("propiedad", array('multiplicacion_base_bcp', 'tipo_de_consulta_para_recarga_bcp', 'cantidad_dias_consulta_bcp', 'cantidad_meses_consulta_bcp'));
        $model_conf = ConfiguracionSistema::model()->findAll($criteria);

        foreach ($model_conf as $value)
        {
            if($value["propiedad"] == 'multiplicacion_base_bcp')
                $multiplicacion_base = $value["valor"]; //numero por el que se debe multiplicar el trafico
            else if($value["propiedad"] == 'tipo_de_consulta_para_recarga_bcp')
                $tipo_consulta = $value["valor"];
            else if($value["propiedad"] == 'cantidad_dias_consulta_bcp')
                $cantidad_dias_consulta = $value["valor"];
            else if($value["propiedad"] == 'cantidad_meses_consulta_bcp')
                $cantidad_meses_consulta = $value["valor"];
        }

        //Todos los Short Codes del cliente en el Fev2.0
        $criteria = new CDbcriteria;
        $criteria->select = "GROUP_CONCAT(DISTINCT(t.id_sc)) AS id_sc";
        $criteria->join = "INNER JOIN cliente c ON t.cliente = c.id_cliente";
        $criteria->condition = "t.cliente = ".$model_usuario->id_cliente." AND ";
        $criteria->condition .= "t.id_producto IN (".$cadena_serv.") AND ";
        $criteria->condition .= "t.desc_producto NOT LIKE 'CERRADO%'";
        $model_sc = Producto::model()->find($criteria);
        $cadena_sc = Yii::app()->Funciones->limpiarCadenaQuery($model_sc->id_sc); 

        $criteria = new CDbcriteria;
        $criteria->select = "GROUP_CONCAT(DISTINCT(sc_id)) AS sc_id";
        $criteria->addInCondition("id_sc", explode(",", $cadena_sc));
        $model_sc = ScId::model()->find($criteria);
        $cadena_sc = Yii::app()->Funciones->limpiarCadenaQuery($model_sc->sc_id);
        
        //Verifico como se realizara el calculo del trafico
        if($tipo_consulta == 1)//Desde la ultima recarga efectuada
        {   
            $criteria = new CDbcriteria;
            $criteria->select = "MAX(fecha) AS fecha";
            $criteria->compare("id_cliente", $model_usuario->id_cliente);
            $criteria->compare("tipo_operacion", 1);
            $model_fecha = UsuarioCupoHistoricoPremium::model()->find($criteria);

            if ($model_fecha->fecha != "")
            {
                $cliente_nuevo = false;
                $fecha_inicial = $model_fecha->fecha;
            }
            else
            {
                $cliente_nuevo = true;
                $fecha_inicial = date('Y-m-d',strtotime(-$cantidad_meses_consulta.' month', strtotime(date('Y-m-d'))));
            }
        }
        else if($tipo_consulta == 2) //Desde hoy hacia la cantidad de dias configurado hacia atras
        {
            $fecha_inicial = date('Y-m-d',strtotime(-$cantidad_dias_consulta.' day', strtotime(date('Y-m-d'))));
        }

        $criteria = new CDbcriteria;
        $criteria->select = "GROUP_CONCAT(CONCAT(\"'\",descripcion,\"'\")) AS descripcion";
        $criteria->compare("estatus", 1);
        $model_operadora = OperadorasActivasBcp::model()->find($criteria);
        $oper_activas = Yii::app()->Funciones->limpiarCadenaQuery($model_operadora->descripcion);
        
        if ($cliente_nuevo)
        {
            //$criteria = new CDbcriteria;
            //$criteria->select = "COUNT(id_sms) AS id_sms";
            //$criteria->condition = "data_arrive BETWEEN '".$fecha_inicial."' AND '".date("Y-m-d")."' AND ";
            //$criteria->condition .= "id_producto IN (".$cadena_serv.") AND ";
            //$criteria->condition .= "sc IN (".$cadena_sc.") AND ";
            //$criteria->condition .= "desp_op IN (".$oper_activas.")";
            //$total = Smsin::model()->find($criteria);

            $sql = "SELECT COUNT(id_sms) AS id_sms FROM smsin_btl FORCE INDEX (indice_web3) 
                WHERE id_producto IN (".$cadena_serv.") AND 
                        sc IN (".$cadena_sc.") AND 
                        data_arrive BETWEEN '".$fecha_inicial."' AND '".date("Y-m-d")."' AND 
                        desp_op IN (".$oper_activas.")";
                
            $total = Yii::app()->db_sms->createCommand($sql)->queryRow();
            
            if ($tipo_consulta == 1)
                $maximo = round(($total["id_sms"] / $cantidad_meses_consulta) * $multiplicacion_base);
            else
                $maximo = $total["id_sms"] * $multiplicacion_base;
        }
        else
        {
            //No hay recargas para el dia actual
            if (strtotime($fecha_inicial) < strtotime(date("Y-m-d")) )
            {
                //$criteria = new CDbcriteria;
                //$criteria->select = "COUNT(id_sms) AS id_sms";
                //$criteria->condition = "data_arrive BETWEEN '".$fecha_inicial."' AND '".date("Y-m-d")."' AND ";
                //$criteria->condition .= "id_producto IN (".$cadena_serv.") AND ";
                //$criteria->condition .= "sc IN (".$cadena_sc.") AND ";
                //$criteria->condition .= "desp_op IN (".$oper_activas.")";
                //$total = Smsin::model()->find($criteria);

                $sql = "SELECT COUNT(id_sms) AS id_sms FROM smsin_btl FORCE INDEX (indice_web3) 
                    WHERE id_producto IN (".$cadena_serv.") AND 
                        sc IN (".$cadena_sc.") AND 
                        data_arrive BETWEEN '".$fecha_inicial."' AND '".date("Y-m-d")."' AND 
                        desp_op IN (".$oper_activas.")";
                
                $total = Yii::app()->db_sms->createCommand($sql)->queryRow();

                $maximo = $total["id_sms"] * $multiplicacion_base;
            }
            else //Existe una o más recargas para el dia actual
            {
                $criteria = new CDbcriteria;
                $criteria->select = "disponible, hora";
                $criteria->compare("id_cliente", $model_usuario->id_cliente);
                $criteria->compare("fecha", date("Y-m-d"));
                $cupo_tmp = CupoDisponibleTmp::model()->find($criteria);

                //$criteria = new CDbcriteria;
                //$criteria->select = "COUNT(id_sms) AS id_sms";
                //$criteria->condition = "data_arrive = '".date("Y-m-d")."' AND ";
                //$criteria->condition .= "time_arrive > '".$cupo_tmp->hora."' AND ";
                //$criteria->condition .= "id_producto IN (".$cadena_serv.") AND ";
                //$criteria->condition .= "sc IN (".$cadena_sc.") AND ";
                //$criteria->condition .= "desp_op IN (".$oper_activas.")";
                //$total = Smsin::model()->find($criteria);

                $sql = "SELECT COUNT(id_sms) AS id_sms FROM smsin FORCE INDEX (indice_web3) 
                    WHERE id_producto IN (".$cadena_serv.") AND 
                        sc IN (".$cadena_sc.") AND 
                        data_arrive = '".date("Y-m-d")."' AND 
                        time_arrive > '".$cupo_tmp->hora."' AND 
                        desp_op IN (".$oper_activas.")";
                
                $total = Yii::app()->db_sms->createCommand($sql)->queryRow();

                $maximo = ($total["id_sms"] * $multiplicacion_base) + $cupo_tmp->disponible;
            }
        }
        
        return $maximo;
    }

    public function actionRecargarCupoBcp()
    {
        $model=new RecargaCupoBcpForm;
        $valido = 'false';

        $this->performAjaxValidation($model);

        if(isset($_POST['RecargaCupoBcpForm']))
        {
            $model->attributes=$_POST['RecargaCupoBcpForm'];

            if ($model->validate())
            {
                $transaction = Yii::app()->db_masivo_premium->beginTransaction();
                
                try
                {
                    if (isset($_POST['RecargaCupoBcpForm']['id_usuario']) && $_POST['RecargaCupoBcpForm']['id_usuario'] !== "")
                        $id_usuario = $_POST['RecargaCupoBcpForm']['id_usuario'];
                    else 
                        $id_usuario = Yii::app()->user->id;

                    $cantidad = $model->cantidad;

                    $model_usuario = UsuarioSms::model()->find("id_usuario = ".$id_usuario);

                    $cantidad_maxima = $this->actionMaximoMontoBcp($id_usuario);

                    $vence = $this->actionUsuarioVenceCupo($id_usuario);

                    if ($vence)
                        $fecha_vencimiento = $_POST['RecargaCupoBcpForm']['fecha_vencimiento'];
                    else $fecha_vencimiento = '0000-00-00';

                    $sql = "INSERT INTO usuario_cupo_premium (id_usuario, disponible, fecha_vencimiento) VALUES (".$id_usuario.",".$cantidad.", '".$fecha_vencimiento."') "
                            . "ON DUPLICATE KEY UPDATE disponible=disponible+".$cantidad.", fecha_vencimiento='".$fecha_vencimiento."'";
                    Yii::app()->db_masivo_premium->createCommand($sql)->execute();

                    $log = 'RECARGA - El usuario '.UsuarioSmsController::actionGetLogin(Yii::app()->user->id).' (id='.Yii::app()->user->id.') recargo cupo BCP ('.$cantidad.' SMS) al usuario '.UsuarioSmsController::actionGetLogin($id_usuario).' (id='.$id_usuario.')';

                    $descripcion = 'RECARGA - recarga de cupo BCP por ('.$cantidad.' SMS)';

                    $model_historial = new UsuarioCupoHistoricoPremium;
                    $model_historial->id_usuario = $id_usuario;
                    $model_historial->id_cliente = $model_usuario->id_cliente;
                    $model_historial->ejecutado_por = Yii::app()->user->id;
                    $model_historial->cantidad = $cantidad;
                    $model_historial->descripcion = $descripcion;
                    $model_historial->fecha = date("Y-m-d");
                    $model_historial->hora = date("H:i:s");
                    $model_historial->tipo_operacion = 1;
                    $model_historial->save();

                    $disponible = $cantidad_maxima - $cantidad;
                    $disponible = ($disponible < 0) ? 0 : $disponible;

                    $sql = "INSERT INTO cupo_disponible_tmp (id_cliente, disponible, fecha, hora) VALUES (".$model_usuario->id_cliente.", ".$disponible.", '".date("Y-m-d")."', '".date("H:i:s")."') "
                            . "ON DUPLICATE KEY UPDATE disponible=".$disponible. ", fecha = '".date("Y-m-d")."', hora = '".date("H:i:s")."'";
                    Yii::app()->db_masivo_premium->createCommand($sql)->execute();

                    Yii::app()->Procedimientos->setLog($log);

                    $transaction->commit();

                    $valido = "true";
                    header('Content-Type: application/json; charset="UTF-8"');
                    echo CJSON::encode(array('salida' => $valido, 'error'=>array()));

                } catch (Exception $e) {
                    $transaction->rollBack();
                    print_r($e);
                    header('Content-Type: application/json; charset="UTF-8"');
                    echo CJSON::encode(array('salida' => $valido, 'error'=>array('cantidad'=>array('Ocurrio un error al procesar los datos'))));
                }
            }
            else
            {
                header('Content-Type: application/json; charset="UTF-8"');
                echo CJSON::encode(array('salida' => $valido, 'error'=>$model->getErrors()));
            }
        }
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='cupoBcp-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionFormulario()
    {
        $model = UsuarioCupoPremium::model()->find("id_usuario=:id_usuario", array(":id_usuario"=>$_GET["id"]));
        $this->renderPartial('formBcp', array("model"=>$model),false,true);
    }

    public function actionUpdate()
    {
        if(isset($_POST['UsuarioCupoPremium']))
        {
            $model = UsuarioCupoPremium::model()->findByPk($_POST['UsuarioCupoPremium']['id_usuario']);
            $valido = 'false';
            
            $this->performAjaxValidation($model);

            $model->attributes=$_POST['UsuarioCupoPremium'];


            if ($model->validate())
            {
                if($model->save())
                {
                    $log = "CUPO BCP - El usuario '".UsuarioSmsController::actionGetLogin(Yii::app()->user->id)."' edito cupo al usuario '".UsuarioSmsController::actionGetLogin($model->id_usuario)."'";
                    Yii::app()->Procedimientos->setLog($log);
                    
                    $valido = "true";
                    header('Content-Type: application/json; charset="UTF-8"');
                    echo CJSON::encode(array('salida' => $valido, 'error'=>array()));
                }
                else
                {
                    header('Content-Type: application/json; charset="UTF-8"');
                    echo CJSON::encode(array('salida' => $valido, 'error'=>$model->getErrors()));
                }
            }
            else
            {
                header('Content-Type: application/json; charset="UTF-8"');
                echo CJSON::encode(array('salida' => $valido, 'error'=>$model->getErrors()));
            }
        }
    }

    public function actionUsuarioVenceCupo($id_usuario)
    {
        $model_usuario = UsuarioSms::model()->findByPk($id_usuario);
        $model_contrato = ClienteTipoContrato::model()->find("id_cliente = ".$model_usuario->id_cliente);
        $vence = true;

        if($model_contrato !== null)
        {
            if ($model_contrato->id_tipo_contrato == 2) //Sin renta basica
                $vence = true;
            else if ($model_contrato->id_tipo_contrato == 1 || $model_contrato->id_tipo_contrato == 3) //Renta basica y Clasico
                $vence = false;
        }

        return $vence;
    }
}
?>
