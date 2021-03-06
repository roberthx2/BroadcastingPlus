<?php

class TmpProcesamientoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new TmpProcesamiento;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TmpProcesamiento']))
		{
			$model->attributes=$_POST['TmpProcesamiento'];
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

		if(isset($_POST['TmpProcesamiento']))
		{
			$model->attributes=$_POST['TmpProcesamiento'];
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
		$dataProvider=new CActiveDataProvider('TmpProcesamiento');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TmpProcesamiento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TmpProcesamiento']))
			$model->attributes=$_GET['TmpProcesamiento'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TmpProcesamiento the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TmpProcesamiento::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TmpProcesamiento $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tmp-procesamiento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionResumenGeneral($id_proceso, $nombre)
	{
		$objeto = array();

		$sql = "SELECT 'Total' AS descripcion, COUNT(*) AS total FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso."
				UNION
				SELECT 'Rechazado' AS descripcion, COUNT(*) AS total FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado != 1
				UNION
				SELECT descripcion, COUNT(*) AS total FROM tmp_procesamiento t 
				INNER JOIN tmp_procesamiento_estado e ON t.estado = e.id_estado
				WHERE id_proceso = ".$id_proceso."
				GROUP BY estado";

		$sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		if ($nombre != "")
		{
			$objeto[] = array('descripcion'=>'Nombre','total'=>$nombre);
		}

		$bandera = 0;
		$arr_aux = array();

		foreach ($sql as $value)
		{
			if ($bandera == 1) //Rechazado
			{
				$arr_aux = array('descripcion'=>$value["descripcion"], 'total'=>$value["total"]);
			}
			else
			{
				if ($bandera == 2 && $value["descripcion"] == "Aceptado")
				{
					$objeto[] = array('descripcion'=>$value["descripcion"], 'total'=>$value["total"]);
					$objeto[] = $arr_aux;
				}
				else if ($bandera == 2 && $value["descripcion"] != "Aceptado")
				{
					$objeto[] = $arr_aux;
					$objeto[] = array('descripcion'=>$value["descripcion"], 'total'=>$value["total"]);
				}
				else
				{
					$objeto[] = array('descripcion'=>$value["descripcion"], 'total'=>$value["total"]);
				}
			}

			$bandera++;
		}

		return $objeto;
	}

	public function actionReporteTortaBCNL($id_proceso)
	{
		$sql = "SELECT 'INVALIDOS' AS descripcion, COUNT(*) AS total, 0 AS id_operadora FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado <> 1
				UNION
				SELECT o.descripcion, COUNT(*) AS total, t.id_operadora FROM tmp_procesamiento t 
				INNER JOIN (SELECT id_operadora_bcnl, descripcion FROM operadoras_relacion GROUP BY id_operadora_bcnl) o ON t.id_operadora = o.id_operadora_bcnl 
				WHERE t.id_proceso = ".$id_proceso." AND t.estado = 1 
				GROUP BY id_operadora";

		$sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		$data = array();
		$bandera = 0;

		foreach ($sql as $value)
		{
			if ($bandera == 0)
			{
				if ($value["total"] > 0)
				{
          			$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]), 'sliced' => true, 'selected' => true);
          		}
          		
          		$bandera++;
			}
          	else
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]));
		}

		return $data;
	}

	public function actionReporteTortaBCP($id_proceso)
	{
		$sql = "SELECT descripcion, SUM(total) AS total, id_operadora FROM (
				SELECT 'INVALIDOS' AS descripcion, COUNT(*) AS total, 0 AS id_operadora FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado <> 1
				UNION
				SELECT o.descripcion, COUNT(*) AS total, t.id_operadora FROM tmp_procesamiento t 
				INNER JOIN (SELECT id_operadora_bcp, descripcion FROM operadoras_relacion) o ON t.id_operadora = o.id_operadora_bcp 
				WHERE t.id_proceso = ".$id_proceso." AND t.estado = 1 
				GROUP BY id_operadora) AS tabla 
				GROUP BY descripcion ORDER BY id_operadora";

		$sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		$data = array();
		$bandera = 0;

		foreach ($sql as $value)
		{
			if ($bandera == 0)
			{
				if ($value["total"] > 0)
				{
          			$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCP($value["id_operadora"]), 'sliced' => true, 'selected' => true);
          		}
          		
          		$bandera++;
			}
          	else
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCP($value["id_operadora"]));
		}

		return $data;
	}
}
