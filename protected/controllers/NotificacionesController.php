<?php

class NotificacionesController extends Controller
{
	public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

	public function accessRules() {

        return (array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'getNotificaciones', 'convertirValor'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    public function actionIndex()
    {
    	$model=new Notificaciones('search_usuario');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Notificaciones']))
			$model->buscar = $_GET['Notificaciones']["buscar"];
			//$model->attributes=$_GET['Lista'];
		
		$id_usuario = Yii::app()->user->id;

		$this->render('index',array('model'=>$model, 'id_usuario'=>$id_usuario));
    }

    public function actionView()
    {
    	if (isset($_GET["id_notificacion"]))
    	{
    		$id_notificacion = $_GET["id_notificacion"];
    		$model = Notificaciones::model()->findByPk($id_notificacion);
    		$model->estado = 1;
    		$model->save();

    		$this->render('view', array('model'=>$model));	
    	}
    	else
    	{
    		$this->redirect(array("index"));
    	}
    	
    }

    public function actionConvertirValor()
    {
        echo CJSON::encode(array(
            'valor' => Yii::app()->createUrl("notificaciones/view", array("id_notificacion"=>Yii::app()->request->getParam('id_notificacion')))
        ));
        Yii::app()->end();
    }

    public function actionCreate()
    {
        $model = new Notificaciones;

        if(isset($_POST['Notificaciones']))
        {
            $model->attributes=$_POST['Notificaciones'];
            
            if ($model->validate())
            {

            }
        }
        $this->render("form", array("model"=>$model));
    }

    public function actionGetNotificaciones()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $model = Notificaciones::model()->findAll("fecha BETWEEN :fecha_ini AND :fecha_fin AND id_usuario =:id_usuario AND estado = 0", array(":fecha_ini"=>date('Y-m-d' , strtotime('-1 month', strtotime(date("Y-m-d")))), ":fecha_fin"=>date("Y-m-d"), ":id_usuario"=>Yii::app()->user->id));

            if ($model)
            {
                echo CJSON::encode(array(
                    'error' => 'false',
                    'data' => $model,
                ));
                Yii::app()->end();
            }
            else
            {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'No posee cliente asociado'
                ));
                Yii::app()->end();
            }
        }

    }
}