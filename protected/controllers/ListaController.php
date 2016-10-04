<?php

class ListaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/menuListas';

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
				'actions'=>array('create','update', 'admin', 'delete', 'reporteCrearLista'),
				'users'=>array('@'),
			),
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),*/
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
		$model=new ListaForm;
		//$model_user=new usersMasivo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ListaForm']))
		{
			$model->attributes=$_POST['ListaForm'];
			
			if ($model->validate())
			{
				$transaction = Yii::app()->db_masivo_premium->beginTransaction();

	            try
	            {
					if ($model->id_usuario == "")
						$model->id_usuario = Yii::app()->user->id;

					$id_proceso = Yii::app()->Funciones->obtenerNumeroProceso();

					$sql = "CALL split_numeros('".$model->numeros."', ',', ".$id_proceso.")";
            		Yii::app()->db_masivo_premium->createCommand($sql)->execute();

            		$sql = "INSERT INTO tmp_procesamiento (id_proceso, numero) SELECT id_proceso, numero FROM splitvalues_numeros WHERE id_proceso = ".$id_proceso;
					Yii::app()->db_masivo_premium->createCommand($sql)->execute();

					$operadoras = Yii::app()->Funciones->operadorasBCNL();

					//Updatea los id_operadora de los numeros validos
					Yii::app()->Funciones->updateOperadoraTblProcesamiento($id_proceso, $operadoras);

					$sql = "SELECT COUNT(id_proceso) AS total FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND id_operadora <> 'NULL'";
					$total = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

					if ($total["total"] > 0)
					{
						$model_lista = new Lista;
						$model_lista->id_usuario = $model->id_usuario;
						$model_lista->nombre = $model->nombre;
						$model_lista->save();
						$id_lista = $model_lista->primaryKey;

						$sql = "INSERT INTO lista_destinatarios (id_lista, numero, id_operadora) SELECT ".$id_lista.", numero, id_operadora FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND id_operadora <> 'NULL'";
						Yii::app()->db_masivo_premium->createCommand($sql)->execute();

						$transaction->commit();
						$this->redirect(array("reporteCrearLista", "id_proceso"=>$id_proceso));
					}
					else
					{
						$error = "La lista no fue creada ya que no contiene destinatarios validos";
						Yii::app()->user->setFlash("danger", $error);
						$transaction->rollBack();
						//$this->redirect(array('create'));
					}

					//Borra el id_proceso y todos los numeros en tmp_procesamiento asociados a el con el metodo de cascada
					//ProcesosActivos::model()->deleteByPk($id_proceso);           		

				} catch (Exception $e)
					{
                		$transaction->rollBack();
            		}
			}
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

		if(isset($_POST['Lista']))
		{
			$model->attributes=$_POST['Lista'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_lista));
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
		$dataProvider=new CActiveDataProvider('Lista');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Lista('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lista']))
			$model->attributes=$_GET['Lista'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lista the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Lista::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Lista $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lista-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionReporteCrearLista($id_proceso)
	{
		$model_procesamiento = TmpProcesamiento::model()->findAll($id_proceso);

		$this->render("reporteCrearLista", array("model_procesamiento"=>$model_procesamiento));
	}

}
