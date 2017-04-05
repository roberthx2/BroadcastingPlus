<?php

class ConfiguracionSistemaAccionesController extends Controller
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
				'actions'=>array('create','update', 'admin', 'delete', 'index', 'view', 'scInSMS', 'updateSCInSMS'),
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
		$model=new ConfiguracionSistemaAcciones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ConfiguracionSistemaAcciones']))
		{
			$model->attributes=$_POST['ConfiguracionSistemaAcciones'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ConfiguracionSistemaAcciones']))
		{
			$model->attributes=$_POST['ConfiguracionSistemaAcciones'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('ConfiguracionSistemaAcciones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ConfiguracionSistemaAcciones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ConfiguracionSistemaAcciones']))
			$model->attributes=$_GET['ConfiguracionSistemaAcciones'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ConfiguracionSistemaAcciones the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ConfiguracionSistemaAcciones::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ConfiguracionSistemaAcciones $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='configuracion-sistema-acciones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionScInSMS()
	{
		$model=$this->loadModel($_GET["id"]);
		$this->renderPartial("updateSCInSMS", array("model"=>$model));
	}

	public function actionUpdateSCInSMS()
	{
		$model=new ConfiguracionSistemaAccionesForm;
		$model->scenario = "updateSCInSMS";
		$valido = 'false';

		$this->performAjaxValidation($model);

		if(isset($_POST['ConfiguracionSistemaAccionesForm']))
		{
			$model->attributes=$_POST['ConfiguracionSistemaAccionesForm'];
			//$model->id_usuario=Yii::app()->user->id;

			if ($model->validate())
            {
				if($model->save())
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
			else
			{
				header('Content-Type: application/json; charset="UTF-8"');
				echo CJSON::encode(array('salida' => $valido, 'error'=>$model->getErrors()));
			}
		}
	}
}
