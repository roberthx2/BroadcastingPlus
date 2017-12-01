<?php

class PalabrasObscenasController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete', 'deletePalabra'),
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
	/*public function actionCreate()
	{
		$model=new PalabrasObscenas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PalabrasObscenas']))
		{
			$model->attributes=$_POST['PalabrasObscenas'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/

	public function actionCreate()
	{
		$model=new PalabrasObscenas;
		$valido = 'false';

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['PalabrasObscenas']))
		{
			$model->attributes=$_POST['PalabrasObscenas'];

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

		if(isset($_POST['PalabrasObscenas']))
		{
			$model->attributes=$_POST['PalabrasObscenas'];
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
		$dataProvider=new CActiveDataProvider('PalabrasObscenas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PalabrasObscenas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PalabrasObscenas']))
			$model->buscar=$_GET['PalabrasObscenas']["buscar"];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PalabrasObscenas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PalabrasObscenas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PalabrasObscenas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='palabras-obscenas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDeletePalabra()
	{
		$id_palabras = explode(",", $_POST['id']);

		$criteria = new CDbCriteria;
		$criteria->addInCondition("id", $id_palabras);
		$msj = PalabrasObscenas::model()->deleteAll($criteria);

		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode(array('salida' => $msj));
	}
}
