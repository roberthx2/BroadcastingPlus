<?php

class BtlController extends Controller
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
                'actions' => array('index','authenticate', 'form', 'getProductosAndOperadoras', 'validarDatosForm', 'getNumeros', 'getFechaMinSmsin', 'getNumeros2'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    /*public function actionIndex()
    {
        $this->render("index");
    }*/

    public function actionAuthenticate()
    {
        $model = new Btl;
        $valido = 'false';
        $model->scenario = "authenticate";

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Btl']))
        {
            $model->attributes=$_POST['Btl'];
            $model->id_usuario=Yii::app()->user->id;

            if ($model->validate())
            {
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
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='btl-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionForm()
    {
        $model = new Btl();
        
        $model->fecha_inicio = date('Y-m-d' , strtotime('-1 Month', strtotime(date("Y-m-d"))));
        $model->fecha_fin = date("Y-m-d");

        if(isset($_POST['sc']) && $_POST['sc'] != "")
        {
            $model->sc = Yii::app()->request->getParam('sc');
            $model->operadoras = explode(",", Yii::app()->request->getParam('operadoras'));
            $model->all_operadoras = Yii::app()->request->getParam('all_operadoras');
            $model->fecha_inicio = Yii::app()->request->getParam('fecha_inicio');
            $model->fecha_fin = Yii::app()->request->getParam('fecha_fin');
            $model->productos = Yii::app()->request->getParam('productos');
        }

        $criteria = new CDbCriteria();
        $criteria->select = "GROUP_CONCAT(sc_cadena) as sc_cadena";
        $criteria->compare("id_usuario", Yii::app()->user->id);
        $criteria->compare("access_lista", "1");

        $sc_CFE = ControlFe::model()->find($criteria);

        $sc = array_intersect(explode(",", $sc_CFE->sc_cadena), explode(",", Yii::app()->user->getCadenaSc()));

        $criteria = new CDbCriteria();
        $criteria->select = "DISTINCT sc_id";
        $criteria->addInCondition("id_sc", $sc);
        $criteria->order = "sc_id DESC ";

        $sc = ScId::model()->findAll($criteria);
        $model->tipo_busqueda = 1;

        $this->renderPartial("form", array("model"=>$model, "sc"=>$sc),false,true);
    }

    public function actionGetProductosAndOperadoras()
    {
        $sc = Yii::app()->request->getParam('sc');

        if (Yii::app()->request->isAjaxRequest)
        {
            if ($sc == '') {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'Short Code invalido'
                ));
                Yii::app()->end();
            }
            else
            {
                $criteria = new CDbCriteria();
                $criteria->select = "ver_invalido";
                $criteria->compare("id_usuario", Yii::app()->user->id);
                $criteria->addCondition("sc_id = :sc");
                $criteria->params[':sc'] = (int)$sc;
                
                $permiso = HabilitaInvalidos::model()->find($criteria);

                $data = Yii::app()->db_sms->createCommand()
                            ->select("GROUP_CONCAT(CAST(id_producto AS CHAR(6))) AS id_producto, desc_producto")
                            ->from("producto p")
                            ->join("sc_id s", "p.id_sc = s.id_sc")
                            ->where("s.sc_id = :sc", array(":sc"=>$sc))
                            ->andwhere(array("IN", "id_producto", explode(",", Yii::app()->user->getCadenaServicios())))
                            ->group("desc_producto")
                            ->order("desc_producto ASC");

                if ($permiso->ver_invalido == "Y")
                    $data = $data->union("SELECT '0', 'Comentarios Generales'");
                            
                $productos = $data->query();

                $criteria = new CDbCriteria();
                $criteria->select = "GROUP_CONCAT(id_op) AS id_op";
                $criteria->addCondition("sc_id = :sc");
                $criteria->params[':sc'] = (int)$sc;
                //Operadora de SMS
                $operadoras = ScId::model()->find($criteria);

                $criteria = new CDbCriteria();
                $criteria->select = "id_operadora_bcnl, descripcion";
                $criteria->addInCondition("id_operadora_bcnl", explode(",", $operadoras->id_op));
                $criteria->group = "id_operadora_bcnl";
                $operadoras = OperadorasRelacion::model()->findAll($criteria);

                if($productos && $operadoras) {
                    echo CJSON::encode(array(
                                            'error' => 'false',
                                            'status' => 'Productos obtenidos correctamente',
                                            'productos' => $productos,
                                            'operadoras' => $operadoras
                                       )                                
                         );
                    Yii::app()->end();
                } else {
                    echo CJSON::encode(array(
                        'error' => 'true',
                        'status' => 'No existen productos/operadoras disponibles para el Short Code seleccionado'
                    ));
                    Yii::app()->end();
                }
            }
       }
    }

    public function actionValidarDatosForm()
    {
        $model = new Btl;
        $valido = 'false';
        $model->scenario = "validateForm";

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Btl']))
        {
            $model->attributes=$_POST['Btl'];
            $model->id_usuario=Yii::app()->user->id;
            
            if ($model->validate())
            {
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
    }

    public function actionGetNumeros2($sc, $operadoras, $all_operadoras, $fecha_inicio, $fecha_fin, $productos, $tipo, $operadorasPermitidasBCP)
    {
        $numeros_btl = "";

        if ($all_operadoras == 'true')
            $operadoras_txt = OperadorasRelacion::model()->find(array("select"=>"GROUP_CONCAT(DISTINCT desp_op) AS desp_op"));
        else 
            $operadoras_txt = OperadorasRelacion::model()->find(array("select"=>"GROUP_CONCAT(DISTINCT desp_op) AS desp_op", "condition"=>"id_operadora_bcnl IN(".$operadoras.")"));

        $criteria = new CDbCriteria();
        $criteria->select = " DISTINCT origen";
        $criteria->addBetweenCondition("data_arrive", $fecha_inicio, $fecha_fin);
        $criteria->addInCondition("id_producto", explode(",", $productos));
        $criteria->compare("sc", $sc);
        $criteria->addInCondition("desp_op", explode(",", $operadoras_txt->desp_op));

        $numeros = SmsinBtl::model()->findAll($criteria);
        $numeros_array = array();

        foreach ($numeros as $value)
        {
            $aux = Yii::app()->Funciones->formatearNumero($value->origen);

            if ($aux != false)
                $numeros_array[] = $aux;
        }

        if (COUNT($numeros_array) > 0)
        {
           /* $transaction = Yii::app()->db_masivo_premium->beginTransaction();

            try
            {*/
                $id_proceso = Yii::app()->Procedimientos->getNumeroProceso();
                $numeros = implode(",", $numeros_array);
                $id_usuario = Yii::app()->user->id;

                $sql = "SELECT porcentaje_lista FROM control_fe INNER JOIN sc_id ON INSTR(sc_cadena, id_sc) 
                        WHERE id_usuario = :id_usuario AND sc_id = :sc LIMIT 1";

                $sql = Yii::app()->db_sms->createCommand($sql);
                $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                $sql->bindParam(":sc", $sc, PDO::PARAM_INT);
                $porcentaje = $sql->queryRow();

                //Guarda los numeros en la tabla de procesamiento
                Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $numeros);
                //Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
                Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso, 1, false);
                //Update en estado 4 todos los numeros exentos
                Yii::app()->Filtros->filtrarExentos($id_proceso, $tipo, $operadorasPermitidasBCP);
                //Update en estado 10 todos los numeros que sobrepasen el porcentaje permitido
                Yii::app()->Filtros->filtrarPorcentaje($id_proceso, $porcentaje["porcentaje_lista"]);
                //Updatea a estado = 1 todos los numeros validos 
                Yii::app()->Filtros->filtrarAceptados($id_proceso);

                //Cantidad de destinatarios validos
                $total = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);

                //En caso de existir numeros validos los obtengo de la tabla temporal
                //print_r($total);

                if ($total > 0)
                {
                    $sql = "SELECT numero FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1";
                    $sql = Yii::app()->db_masivo_premium->createCommand($sql);
                    $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
                    $sql = $sql->queryAll();

                    foreach ($sql as $value)
                    {
                        $numeros_btl[] = $value["numero"];
                    }

                    $numeros_btl = implode(",", $numeros_btl);
                }

                ProcesosActivos::model()->deleteByPk($id_proceso);

                /*$transaction->commit();
            }
            catch (Exception $e)
                {
                    print_r($e);
                    $transaction->rollBack();
                } */
        }

        return $numeros_btl;
    }

    public function actionGetRangoFecha($tipo_busqueda, $fecha, $fecha_inicio, $fecha_fin, $year, $anio, $mes)
    {
        $objeto = array();

        if ($tipo_busqueda == 1) //Periodo
        {
            $objeto["fecha_inicio"] = $fecha_inicio;
            $objeto["fecha_fin"] = $fecha_fin;
        }
        elseif ($tipo_busqueda == 2) //Mes
        {
            $objeto["fecha_inicio"] = $anio."-".$mes."-01";
            $objeto["fecha_fin"] = Yii::app()->Funciones->getUltimoDiaMes($anio, $mes);
        }
        elseif ($tipo_busqueda == 3) //Año
        {
            $objeto["fecha_inicio"] = $year."-01-01";
            $objeto["fecha_fin"] = $year."-12-31";
        }
        elseif ($tipo_busqueda == 4) //Día
        {
            $objeto["fecha_inicio"] = $fecha;
            $objeto["fecha_fin"] = $fecha;
        }

        return $objeto;
    }

    public function actionGetNumeros()
    {
        $sc = $_POST["Btl"]["sc"];
        $all_operadoras = $_POST["Btl"]["all_operadoras"];
        $productos = $_POST["Btl"]["productos"];

        $fechas = $this->actionGetRangoFecha($_POST["Btl"]["tipo_busqueda"], $_POST["Btl"]["fecha"], $_POST["Btl"]["fecha_inicio"], $_POST["Btl"]["fecha_fin"], $_POST["Btl"]["year"], $_POST["Btl"]["anio"], $_POST["Btl"]["mes"]);
        
        $cantidad_x_oper = array();
        $existe = 'false';
        $numeros_btl = "";
        unset($_SESSION["numeros_btl"]);

        if ($all_operadoras == 1)
            $operadoras_txt = OperadorasRelacion::model()->find(array("select"=>"GROUP_CONCAT(DISTINCT desp_op) AS desp_op"));
        else 
        {
            $operadoras = implode(",", $_POST["Btl"]["operadoras"]);
            $operadoras_txt = OperadorasRelacion::model()->find(array("select"=>"GROUP_CONCAT(DISTINCT desp_op) AS desp_op", "condition"=>"id_operadora_bcnl IN(".$operadoras.")"));
        }

        $criteria = new CDbCriteria();
        $criteria->select = "DISTINCT origen";
        $criteria->addBetweenCondition("data_arrive", $fechas["fecha_inicio"], $fechas["fecha_fin"]);
        $criteria->addInCondition("id_producto", $productos);
        $criteria->compare("sc", $sc);
        $criteria->addInCondition("desp_op", explode(",", $operadoras_txt->desp_op));

        $numeros = SmsinBtl::model()->findAll($criteria);
        $numeros_array = array();

        foreach ($numeros as $value)
        {
            $aux = Yii::app()->Funciones->formatearNumero($value->origen);

            if ($aux != false)
                $numeros_array[] = $aux;
        }

        if (COUNT($numeros_array) > 0)
        {
            $transaction = Yii::app()->db_masivo_premium->beginTransaction();

            try
            {
                $id_proceso = Yii::app()->Procedimientos->getNumeroProceso();
                $numeros = implode(",", $numeros_array);
                $id_usuario = Yii::app()->user->id;

                $sql = "SELECT porcentaje_lista FROM control_fe INNER JOIN sc_id ON INSTR(sc_cadena, id_sc) 
                        WHERE id_usuario = :id_usuario AND sc_id = :sc LIMIT 1";

                $sql = Yii::app()->db_sms->createCommand($sql);
                $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                $sql->bindParam(":sc", $sc, PDO::PARAM_INT);
                $porcentaje = $sql->queryRow();

                //Guarda los numeros en la tabla de procesamiento
                Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $numeros);
                //Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
                Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso, 1, false);
                //Update en estado 4 todos los numeros exentos
                Yii::app()->Filtros->filtrarExentos($id_proceso, 1, null);
                //Update en estado 10 todos los numeros que sobrepasen el porcentaje permitido
                Yii::app()->Filtros->filtrarPorcentaje($id_proceso, $porcentaje["porcentaje_lista"]);
                //Updatea a estado = 1 todos los numeros validos 
                Yii::app()->Filtros->filtrarAceptados($id_proceso);

                //Cantidad de destinatarios validos
                $total = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);

                if ($total > 0)
                {
                    $sql = "SELECT numero, id_operadora FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1";
                    $sql = Yii::app()->db_masivo_premium->createCommand($sql);
                    $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
                    $sql = $sql->queryAll();

                    $model_oper = OperadorasActivas::model()->findAll();

                    foreach ($model_oper as $value)
                    {
                        $array_oper[$value["id_operadora"]] = $value["descripcion"];
                    }

                    foreach ($sql as $value)
                    {
                        $numeros_btl[] = $value["numero"];

                        if (!isset($cantidad_x_oper[$value["id_operadora"]]))
                            $cantidad_x_oper[$value["id_operadora"]] = array("descripcion"=>ucfirst(strtolower($array_oper[$value["id_operadora"]])), "total"=>1);
                        else $cantidad_x_oper[$value["id_operadora"]]["total"]++;
                    }

                    $numeros_btl = implode(",", $numeros_btl);
                    $_SESSION["numeros_btl"] = $numeros_btl;
                    $existe = 'true';
                }

                ProcesosActivos::model()->deleteByPk($id_proceso);

                $transaction->commit();
            }
            catch (Exception $e)
                {
                    $transaction->rollBack();
                }
        }

        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('existe' => $existe, 'mensaje' => $cantidad_x_oper, 'numeros_btl'=>$numeros_btl));
    }

    public function actionGetFechaMinSmsin()
    {
        $criteria = new CDbCriteria;
        $criteria->select = "MIN(data_arrive) AS data_arrive";
        $model = Smsin::model()->find($criteria);

        return ($model->data_arrive) ? $model->data_arrive : date("Y-m-d");
    }
}

?>