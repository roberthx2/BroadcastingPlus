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
                'actions' => array('index','authenticate', 'form'),
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
        $this->renderPartial("form", array("model"=>$model));
    }
}

?>