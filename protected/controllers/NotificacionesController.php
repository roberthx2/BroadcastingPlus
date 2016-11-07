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
                'actions' => array('index', 'view'),
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
}