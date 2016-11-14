<?php

class PrefijoPromocionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/menuApp';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','deletePrefijo', 'create2'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
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
		$model=new PrefijoPromocion;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['PrefijoPromocion']))
		{
			$model->attributes=$_POST['PrefijoPromocion'];
			$model->id_usuario=Yii::app()->user->id;

			if ($model->validate())
            {
				if($model->save())
				{
					header('Content-Type: application/json; charset="UTF-8"');
					echo CJSON::encode(array('salida' => 'ddd'));
				}//$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCreate2()
	{
		$model=new PrefijoPromocion;
		$valido = 'false';

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['PrefijoPromocion']))
		{
			$model->attributes=$_POST['PrefijoPromocion'];
			$model->id_usuario=Yii::app()->user->id;

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

		if(isset($_POST['PrefijoPromocion']))
		{
			$model->attributes=$_POST['PrefijoPromocion'];
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
	public function actionDeletePrefijo()
	{
		$id_prefijos = explode(",", $_POST['id']);

		$criteria = new CDbCriteria;
		$criteria->addInCondition("id", $id_prefijos);
		$msj = PrefijoPromocion::model()->deleteAll($criteria);

		//$log = "P";

		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode(array('salida' => $msj));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PrefijoPromocion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PrefijoPromocion('searchPrefijo');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PrefijoPromocion']))
			$model->buscar=$_GET['PrefijoPromocion']["buscar"];

		if(Yii::app()->user->isAdmin())
			$id_usuario = null;
		else $id_usuario = Yii::app()->user->id;

		$this->render('admin',array('model'=>$model, 'id_usuario'=>$id_usuario));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PrefijoPromocion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PrefijoPromocion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PrefijoPromocion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='prefijo-promocion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
