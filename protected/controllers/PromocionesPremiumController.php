<?php

class PromocionesPremiumController extends Controller
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
				'actions'=>array('index','view', 'indexPromociones'),
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
		$criteria=new CDbCriteria;
		$criteria->select = "t.id_promo, t.nombrePromo, t.contenido, t.fecha, t.hora, d.hora_limite, u.login AS login, (SELECT COUNT(*) FROM outgoing_premium o WHERE o.id_promo = t.id_promo) AS total";
		$criteria->join = "INNER JOIN deadline_outgoing_premium d ON t.id_promo = d.id_promo ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.loaded_by = u.id_usuario";
		$criteria->compare("t.id_promo", $id);
		$model_promocion = PromocionesPremium::model()->find($criteria);

		$model_outgoing=new OutgoingPremium('search');
		$model_outgoing->unsetAttributes();

		if(isset($_GET['OutgoingPremium']))
			$model_outgoing->buscar = $_GET['OutgoingPremium']["buscar"];

		$this->render('view',array(
			'model_promocion'=>$model_promocion, 'model_outgoing' => $model_outgoing
		));
		/*$this->render('view',array(
			'model'=>$this->loadModel($id),
		));*/
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate()
	{
		$model=new PromocionesPremium;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['PromocionesPremium']))
		{
			$model->attributes=$_POST['PromocionesPremium'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_promo));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PromocionesPremium']))
		{
			$model->attributes=$_POST['PromocionesPremium'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_promo));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	/*public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}*/

	/**
	 * Lists all models.
	 */
	/*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PromocionesPremium');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	/*public function actionAdmin()
	{
		$model=new PromocionesPremium('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PromocionesPremium']))
			$model->attributes=$_GET['PromocionesPremium'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PromocionesPremium the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PromocionesPremium::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PromocionesPremium $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='promociones-premium-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionIndexPromociones()
	{
		$model=new PromocionesPremium('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PromocionesPremium']))
			$model->attributes=$_GET['PromocionesPremium'];

		$this->render('indexPromociones',array(
			'model'=>$model,
		));
	}

	public function actionObtenerStatusDetalle($id_promo)
	{
		$sql = "SELECT p.estado,  p.fecha, p.hora, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo) AS total,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo AND status = 1) AS enviados
			FROM promociones_premium AS p, deadline_outgoing_premium AS d_o
			WHERE p.id_promo IN (".$id_promo.") AND p.id_promo = d_o.id_promo";

		$sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		$objeto = array("estado"=>$sql["estado"], "fecha"=>$sql["fecha"], "hora"=>$sql["hora"], "fecha_limite"=>$sql["fecha_limite"], "hora_limite"=>$sql["hora_limite"], "total"=>$sql["total"], "enviados"=>$sql["enviados"], "no_enviados"=>($sql["total"] - $sql["enviados"]));

	    switch ($objeto["estado"])
	    {
	        case 0: 
	            //$estado = "No Confirmada";
	            $estado = 0;
	            break;
	        case 1: 
	            //$estado = "Enviada";
	            $estado = 1;
	        break;
	        case 2:
	            //$estado = "Confirmada";
	            $estado = 2;
	            $ts_actual = time();
	            $ts_inicio = strtotime($objeto["fecha"] . " " . $objeto["hora"]);
	            $ts_fin = strtotime($objeto["fecha_limite"] . " " . $objeto["hora_limite"]);
	            
	            if (($ts_actual >= $ts_inicio) && ($ts_actual <= $ts_fin)) {
	                if ($objeto["no_enviados"] > 0) {
	                    //$estado = "En Transito";
	                    $estado = 6;
	                } else { 
	                    //$estado = "Enviada";
	                    $estado = 1;
	                } 
	            }

	            if ($ts_actual < $ts_inicio) {
	                //$estado = "Confirmada";
	                $estado = 2;
	            }

	            if ($ts_actual > $ts_fin) {  
	                if ($objeto["no_enviados"] > 0) {
	                    //$estado = "Incompleta";
	                    $estado = 3;
	                }
	                if($objeto["no_enviados"] == $objeto["total"]){
	                    //$estado = "No Enviada";
	                    $estado = 5;
	                }
	                if($objeto["no_enviados"] == 0){
	                    //$estado = "Enviada";
	                    $estado = 1;
	                }
	            }

	        break;
	        case 4: 
	            //$estado = "Cancelada";
	            $estado = 4;
	            
	            if($objeto["no_enviados"] == $objeto["total"]){
	                //$estado = "Cancelada";
	                $estado = 4;
	            }
	            if($objeto["no_enviados"] >= 0 && $objeto["no_enviados"] < $objeto["total"]){
	                //$estado = "Enviada y Cancelada";
	                $estado = 7;
	            }
	        break;
	        case 5: 
	            //$estado = "No enviada";
	            $estado = 5;
	        break;

	    
	    }

	    return $estado; 
	}

	public function actionLabelStatuPromo($estado)
	{
		$objeto = array();

		if($estado == 0)
			$objeto = array('label'=> 'No confirmada', 'clase' => 'default', 'background_color' => '');
		elseif ($estado == 1)
			$objeto = array('label'=> 'Enviada', 'clase' => 'success', 'background_color' => '');
		elseif ($estado == 2)
			$objeto = array('label'=> 'Confirmada', 'clase' => 'primary', 'background_color' => '');
		elseif ($estado == 3)
			$objeto = array('label'=> 'Incompleta', 'clase' => 'success', 'background_color' => '#FC6E51');
		elseif ($estado == 4)
			$objeto = array('label'=> 'Cancelada', 'clase' => 'danger', 'background_color' => '');
		elseif ($estado == 5)
			$objeto = array('label'=> 'No enviada', 'clase' => '', 'background_color' => '#434A54');
		elseif ($estado == 6)
			$objeto = array('label'=> 'Transito', 'clase' => 'warning', 'background_color' => '');
		elseif ($estado == 7)
			$objeto = array('label'=> 'Enviada y Cancelada', 'clase' => '', 'background_color' => '#967ADC');

		return $objeto;
	}

	public function actionObtenerStatus($status, $fecha, $hora, $fecha_limite, $hora_limite, $no_enviados, $all_sms)
	{
	    switch ($status)
	    {
	        case 0: 
	            //$estado = "No Confirmada";
	            $estado = 0;
	            break;
	        case 1: 
	            //$estado = "Enviada";
	            $estado = 1;
	        break;
	        case 2:
	            //$estado = "Confirmada";
	            $estado = 2;
	            $ts_actual = time();
	            $ts_inicio = strtotime($fecha . " " . $hora);
	            $ts_fin = strtotime($fecha_limite . " " . $hora_limite);
	            
	            if (($ts_actual >= $ts_inicio) && ($ts_actual <= $ts_fin)) {
	                if ($no_enviados > 0) {
	                    //$estado = "En Transito";
	                    $estado = 6;
	                } else { 
	                    //$estado = "Enviada";
	                    $estado = 1;
	                } 
	            }

	            if ($ts_actual < $ts_inicio) {
	                //$estado = "Confirmada";
	                $estado = 2;
	            }

	            if ($ts_actual > $ts_fin) {  
	                if ($no_enviados > 0) {
	                    //$estado = "Incompleta";
	                    $estado = 3;
	                }
	                if($no_enviados == $all_sms){
	                    //$estado = "No Enviada";
	                    $estado = 5;
	                }
	                if($no_enviados == 0){
	                    //$estado = "Enviada";
	                    $estado = 1;
	                }
	            }

	        break;
	        case 4: 
	            //$estado = "Cancelada";
	            $estado = 4;
	            
	            if($no_enviados == $all_sms){
	                //$estado = "Cancelada";
	                $estado = 4;
	            }
	            if($no_enviados >= 0 && $no_enviados < $all_sms){
	                //$estado = "Enviada y Cancelada";
	                $estado = 7;
	            }
	        break;
	        case 5: 
	            //$estado = "No enviada";
	            $estado = 5;
	        break;

	    
	    }
	    return $estado; 
	}

	public function actionReporteTorta($id_promo)
	{
		$sql = "SELECT descripcion, SUM(total) AS total, id_operadora FROM (
				SELECT o.descripcion, COUNT(*) AS total, t.operadora AS id_operadora FROM outgoing_premium t 
				INNER JOIN (SELECT id_operadora_bcp, descripcion FROM operadoras_relacion) o ON t.operadora = o.id_operadora_bcp 
				WHERE t.id_promo = ".$id_promo." 
				GROUP BY t.operadora) AS tabla 
				GROUP BY descripcion ORDER BY id_operadora";

		$sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		$data = array();
		$bandera = 0;

		foreach ($sql as $value)
		{
			if ($bandera == 0)
			{
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCP($value["id_operadora"]), 'sliced' => true, 'selected' => true);
          		$bandera++;
			}
          	else
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCP($value["id_operadora"]));
		}

		return $data;
	}
}
