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
                'actions' => array('index','authenticate', 'form', 'getProductosAndOperadoras', 'validarDatosForm'),
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

        $sc_CFE = ControlFE::model()->find($criteria);

        $sc = array_intersect(explode(",", $sc_CFE->sc_cadena), explode(",", Yii::app()->user->getCadenaSc()));

        $criteria = new CDbCriteria();
        $criteria->select = "DISTINCT sc_id";
        $criteria->addInCondition("id_sc", $sc);
        $criteria->order = "sc_id DESC ";

        $sc = ScId::model()->findAll($criteria);

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
}

?>