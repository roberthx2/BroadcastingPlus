<?php

class MensajesBroadcastingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/menuAdministracion';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','admin', 'viewDelete', 'deleteMensaje'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MensajesBroadcastingForm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MensajesBroadcastingForm']))
		{
			$model->attributes=$_POST['MensajesBroadcastingForm'];

			if($model->validate())
			{
				$transaction = Yii::app()->db->beginTransaction();

	            try
	            {
					$model_mensaje = new MensajesBroadcasting;
					$model_mensaje->mensaje = $model->mensaje;
					$model_mensaje->tipo_mensaje = $model->tipo_mensaje;
					$model_mensaje->hora_inicio = $model->hora_inicio;
					$model_mensaje->hora_fin = $model->hora_fin;

					if($model->tipo_mensaje == 1) //Periodo
				    {
				        $model_mensaje->fecha_inicio = $model->fecha_inicio;
				        $model_mensaje->fecha_fin = $model->fecha_fin;
				    }

				    $model_mensaje->save();

				    if ($model->tipo_mensaje == 3) //Personalizado
				    {
				        $array_dias = $_POST["MensajesBroadcastingForm"]["dias"];

				        $dias_semana = array(1 => "Domingo", 2 => "Lunes", 3 => "Martes", 4 => "Miercoles", 5 => "Jueves", 6 => "Viernes", 7 => "Sabado");

				        foreach ($array_dias as $casilla => $valor)
				        {
				        	$model_dia = new MensajesBroadcastingDias;
				        	$model_dia->id_mensaje = $model_mensaje->id_mensaje;
				        	$model_dia->dia_semana = $valor;
				        	$model_dia->descripcion = $dias_semana[$valor];
				        	$model_dia->save();
				        }
				    }

				    $log = "MENSAJE DE SUSPENSION: CREADO | Por el Administrador: ".UsuarioSmsController::actionGetLogin(Yii::app()->user->id);
		    		Yii::app()->Procedimientos->setLog($log);

					Yii::app()->user->setFlash("success", "Mensaje de suspensión creado");

					$transaction->commit();

					$this->redirect(array('admin'));
				} catch (Exception $e)
					{
						$error = "Ocurrio un error al procesar los datos, intente nuevamente.";
						Yii::app()->user->setFlash("danger", $error);
                		$transaction->rollBack();
            		}
			}
		}

		$this->render('form',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = new MensajesBroadcastingForm;
		$model_mensaje=$this->loadModel($id);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MensajesBroadcastingForm']))
		{
			$model->attributes=$_POST['MensajesBroadcastingForm'];

			if($model->validate())
			{
				$transaction = Yii::app()->db->beginTransaction();

	            try
	            {
					$model_mensaje->mensaje = $model->mensaje;
					$model_mensaje->tipo_mensaje = $model->tipo_mensaje;
					$model_mensaje->hora_inicio = $model->hora_inicio;
					$model_mensaje->hora_fin = $model->hora_fin;
					$model_mensaje->fecha_inicio = '0000-00-00';
					$model_mensaje->fecha_fin = '0000-00-00';

					if($model->tipo_mensaje == 1) //Periodo
				    {
				        $model_mensaje->fecha_inicio = $model->fecha_inicio;
				        $model_mensaje->fecha_fin = $model->fecha_fin;
				    }

				    $model_mensaje->save();

				    $criteria = new CDbCriteria;
					$criteria->compare("id_mensaje", $model_mensaje->id_mensaje);
					MensajesBroadcastingDias::model()->deleteAll($criteria);

				    if ($model->tipo_mensaje == 3) //Personalizado
				    {
				        $array_dias = $_POST["MensajesBroadcastingForm"]["dias"];

				        $dias_semana = array(1 => "Domingo", 2 => "Lunes", 3 => "Martes", 4 => "Miercoles", 5 => "Jueves", 6 => "Viernes", 7 => "Sabado");

				        foreach ($array_dias as $casilla => $valor)
				        {
				        	$model_dia = new MensajesBroadcastingDias;
				        	$model_dia->id_mensaje = $model_mensaje->id_mensaje;
				        	$model_dia->dia_semana = $valor;
				        	$model_dia->descripcion = $dias_semana[$valor];
				        	$model_dia->save();
				        }
				    }

				    $log = "MENSAJE DE SUSPENSION: ACTUALIZADO | Por el Administrador: ".UsuarioSmsController::actionGetLogin(Yii::app()->user->id);
		    		Yii::app()->Procedimientos->setLog($log);

					Yii::app()->user->setFlash("success", "Mensaje de suspensión actualizado");
					
					$transaction->commit();

					$this->redirect(array('admin'));
				} catch (Exception $e)
					{
						$error = "Ocurrio un error al procesar los datos, intente nuevamente.";
						Yii::app()->user->setFlash("danger", $error);
                		$transaction->rollBack();
            		}
			}
		}

		$model->id = $id;
		$model->mensaje = $model_mensaje->mensaje;
		$model->tipo_mensaje = $model_mensaje->tipo_mensaje;
		$model->hora_inicio = $model_mensaje->hora_inicio;
		$model->hora_fin = $model_mensaje->hora_fin;
		$model->fecha_inicio = $model_mensaje->fecha_inicio;
		$model->fecha_fin = $model_mensaje->fecha_fin;

		if ($model_mensaje->tipo_mensaje == 3)
		{
			$array = array();

			$dias = MensajesBroadcastingDias::model()->findall("id_mensaje=".$id);
			
			foreach ($dias as $value)
			{
				$array[] = $value["dia_semana"];
			}

			$model->dias = $array;
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MensajesBroadcasting');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MensajesBroadcasting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MensajesBroadcasting']))
			$model->buscar=$_GET['MensajesBroadcasting']['buscar'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MensajesBroadcasting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MensajesBroadcasting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MensajesBroadcasting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mensajes-broadcasting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionViewDelete($id)
	{
		$model = $this->loadModel($id);

		$this->renderPartial('viewDelete',array("model"=>$model));
	}

	public function actionDeleteMensaje($id)
	{
		$transaction = Yii::app()->db->beginTransaction();

		try
        {
			$model = $this->loadModel($id);

			$login = UsuarioSmsController::actionGetLogin(Yii::app()->user->id);
			$log = "Suspender Broadcasting (Eliminar) | Mensaje de suspensión eliminado | Ejecutado por: ".$login;

			$model->delete();
		    Yii::app()->Procedimientos->setLog($log);

		    Yii::app()->user->setFlash("success", "Mensaje de suspensión eliminado correctamente");

		    $transaction->commit();

		    if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin')); 

	   } catch (Exception $e)
			{
        		$transaction->rollBack();
        		Yii::app()->user->setFlash("danger", "Ocurrio un error al eliminar el mensaje");
        		$this->redirect(array('admin'));
    		}
	}
}
