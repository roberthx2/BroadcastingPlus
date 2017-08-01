<?php

class PromocionesController extends Controller
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
				'actions'=>array('create','update', 'viewInformacion', 'viewConfirmar', 'confirmarPromo','viewCancelar', 'cancelarPromo'),
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
		$objeto = $this->actionViewResumen($id);

		$this->render('view', array("model"=>$objeto["model"], 'cliente'=>$objeto["cliente"], 'estado'=>$objeto["estado"]));
	}

	public function actionViewResumen($id_promo)
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.id_promo, u.login, t.cadena_usuarios, t.nombrePromo, t.cliente, t.estado, t.fecha, t.hora, t.contenido, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id_sms) FROM outgoing WHERE id_promo = t.id_promo) AS total,
			(SELECT COUNT(id_sms) FROM outgoing WHERE id_promo = t.id_promo AND status = 3) AS enviados";
		$criteria->join = "INNER JOIN deadline_outgoing d_o ON t.id_promo = d_o.id_promo ";
		$criteria->join .= "INNER JOIN usuario u ON t.cadena_usuarios = u.id_usuario";
		$criteria->condition = "t.id_promo = :id_promo";
		$criteria->params = array(':id_promo' => $id_promo);

		$model = Promociones::model()->find($criteria);

		$sql = "SELECT Des_cliente FROM cliente WHERE id_cliente = ".$model->cliente;
		$sql = Yii::app()->db_sms->createCommand($sql)->queryRow();
		$cliente = $sql["Des_cliente"];

		$array = array(
		    "estado"=>$model->estado, 
		    "fecha"=>$model->fecha, 
		    "hora"=>$model->hora, 
		    "fecha_limite"=>$model->fecha_limite, 
		    "hora_limite"=>$model->hora_limite, 
		    "total"=>$model->total, 
		    "enviados"=>$model->enviados, 
		    "no_enviados"=>($model->total - $model->enviados)
		);

		$estado = $this->actionGetStatusPromocionRapida($array);

		return array("model"=>$model, 'cliente'=>$cliente, 'estado'=>$estado);
	}

	public function actionViewInformacion($id_promo)
	{
		$objeto = $this->actionViewResumen($id_promo);

		$this->renderPartial('viewInformacion', array("model"=>$objeto["model"], 'cliente'=>$objeto["cliente"], 'estado'=>$objeto["estado"]));
	}
	
	public function actionViewConfirmar($id_promo)
	{
		$objeto = $this->actionViewResumen($id_promo);

		$this->renderPartial('viewConfirmar', array("model"=>$objeto["model"], 'cliente'=>$objeto["cliente"], 'estado'=>$objeto["estado"]));
	}

	public function actionViewCancelar($id_promo)
	{
		$objeto = $this->actionViewResumen($id_promo);

		$this->renderPartial('viewCancelar', array("model"=>$objeto["model"], 'cliente'=>$objeto["cliente"], 'estado'=>$objeto["estado"]));
	}

	public function actionConfirmarPromo($id_promo)
    {
        $transaction = Yii::app()->db->beginTransaction();
        $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $model_promocion = Promociones::model()->findByPk($id_promo);
            $model_promocion->estado = 2;
            $model_promocion->save();

            $sql = "UPDATE outgoing SET status = 2 WHERE id_promo = :id_promo";
            $sql = Yii::app()->db->createCommand($sql);
            $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_STR);
            $sql->execute();

            $log = "PROMOCION CONFIRMADA BCNL | id_promo: ".$id_promo." | id_cliente: ".$model_promocion->cliente;
            Yii::app()->Procedimientos->setLog($log);

            $transaction->commit();
            $transaction2->commit();
        } catch (Exception $e)
            {
                $transaction->rollBack();
                $transaction2->rollBack();
            }

        $this->redirect(Yii::app()->createUrl("home/index"));
    }

	public function actionCancelarPromo($id_promo)
	{
		$transaction = Yii::app()->db->beginTransaction();
		$transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
			$model_promocion = Promociones::model()->findByPk($id_promo);
            $model_promocion->estado = 5;
            $model_promocion->save();

			//Todo lo que sea distinto de enviado
			$sql = "UPDATE outgoing SET status = 5 WHERE id_promo = ".$id_promo." AND status <> 3"; 
			Yii::app()->db->createCommand($sql)->execute();

			$log = "PROMOCION CANCELADA BCP | id_promo: ".$id_promo." | id_cliente: ".$model_promocion->cliente;
            Yii::app()->Procedimientos->setLog($log);

            Yii::app()->user->setFlash("success", "La promoción fue cancelada correctamente");
			$transaction->commit();
			$transaction2->commit();
		} catch (Exception $e)
			{
				//print_r($e);
				$error = "Ocurrio un error al procesar los datos, intente nuevamente.";
				Yii::app()->user->setFlash("danger", $error);
        		$transaction->rollBack();
        		$transaction2->rollBack();
    		}

    	$this->redirect(Yii::app()->createUrl("home/index"));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Promociones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Promociones']))
		{
			$model->attributes=$_POST['Promociones'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_promo));
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

		if(isset($_POST['Promociones']))
		{
			$model->attributes=$_POST['Promociones'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_promo));
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
		$dataProvider=new CActiveDataProvider('Promociones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Promociones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Promociones']))
			$model->attributes=$_GET['Promociones'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Promociones the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Promociones::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Promociones $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='promociones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionReporteTorta($id_promo)
	{
		$sql = "SELECT CONCAT('CASE id_operadora ',GROUP_CONCAT(condicion SEPARATOR ' '), ' END') AS condicion FROM (
				SELECT CONCAT('WHEN ', id_operadora_bcnl, ' THEN ', \" '\", descripcion, \"'\") AS condicion
				FROM operadoras_relacion
				GROUP BY id_operadora_bcnl) AS tabla";
		$cond_1 = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		$sql = "SELECT CONCAT('CASE SUBSTRING(number,2,3) ',GROUP_CONCAT(condicion SEPARATOR ' '), ' END') AS condicion FROM (
				SELECT DISTINCT CONCAT('WHEN ', \" '\", prefijo, \"'\", ' THEN ', id_operadora_bcnl) AS condicion
				FROM operadoras_relacion) AS tabla";
		$cond_2 = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		$sql = "SELECT ".$cond_1["condicion"]." AS descripcion,
				total, id_operadora FROM (
				SELECT COUNT(*) AS total, ".$cond_2["condicion"]." AS id_operadora
				FROM outgoing t 
				WHERE t.id_promo = ".$id_promo." 
				GROUP BY id_operadora
				) AS tabla";

		$sql = Yii::app()->db->createCommand($sql)->queryAll();

		$data = array();
		$bandera = 0;

		foreach ($sql as $value)
		{
			if ($bandera == 0)
			{
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]), 'sliced' => true, 'selected' => true);
          		$bandera++;
			}
          	else
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]));
		}

		return $data;
	}

	//Obtener el estado de la promocion
	public function actionGetStatusPromocion($id_promo)
	{
		$sql = "SELECT p.estado,  p.fecha, p.hora, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id_sms) FROM outgoing WHERE id_promo = p.id_promo) AS total,
			(SELECT COUNT(id_sms) FROM outgoing WHERE id_promo = p.id_promo AND status = 3) AS enviados
			FROM promociones AS p, deadline_outgoing AS d_o
			WHERE p.id_promo IN (".$id_promo.") AND p.id_promo = d_o.id_promo";

		$sql = Yii::app()->db->createCommand($sql)->queryRow();

		$objeto = array("estado"=>$sql["estado"], "fecha"=>$sql["fecha"], "hora"=>$sql["hora"], "fecha_limite"=>$sql["fecha_limite"], "hora_limite"=>$sql["hora_limite"], "total"=>$sql["total"], "enviados"=>$sql["enviados"], "no_enviados"=>($sql["total"] - $sql["enviados"]));

	    switch ($objeto["estado"])
	    {
	        case 1: 
	            //$estado = "No Confirmada";
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
	                    $estado = 4;
	                } else { 
	                    //$estado = "Enviada";
	                    $estado = 3;
	                } 
	            }

	            if ($ts_actual < $ts_inicio) {
	                //$estado = "Confirmada";
	                $estado = 2;
	            }

	            if ($ts_actual > $ts_fin) {  
	                if ($objeto["no_enviados"] > 0) {
	                    //$estado = "Incompleta";
	                    $estado = 6;
	                }
	                if($objeto["no_enviados"] == $objeto["total"]){
	                    //$estado = "No Enviada";
	                    $estado = 7;
	                }
	                if($objeto["no_enviados"] == 0){
	                    //$estado = "Enviada";
	                    $estado = 3;
	                }
	            }

	        	break;
	        case 3: 
	            //$estado = "Enviada";
	            $estado = 3;
	        	break;
	        case 4: 
	            //$estado = "En Transito";
	            $estado = 4;
	            break;
	        case 5: 
	            //$estado = "Cancelada";
	            $estado = 5;
	            
	            if($objeto["no_enviados"] == $objeto["total"]){
	                //$estado = "Cancelada";
	                $estado = 5;
	            }
	            if($objeto["no_enviados"] >= 0 && $objeto["no_enviados"] < $objeto["total"]){
	                //$estado = "Enviada y Cancelada";
	                $estado = 8;
	            }
	        break;
	        case 7: 
	            //$estado = "No enviada";
	            $estado = 7;
	        break;

	    
	    }
	    return $estado; 
	}

	public function actionGetStatusPromocionRapida($objeto)
	{
	    switch ($objeto["estado"])
	    {
	        case 1: 
	            //$estado = "No Confirmada";
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
	                    $estado = 4;
	                } else { 
	                    //$estado = "Enviada";
	                    $estado = 3;
	                } 
	            }

	            if ($ts_actual < $ts_inicio) {
	                //$estado = "Confirmada";
	                $estado = 2;
	            }

	            if ($ts_actual > $ts_fin) {  
	                if ($objeto["no_enviados"] > 0) {
	                    //$estado = "Incompleta";
	                    $estado = 6;
	                }
	                if($objeto["no_enviados"] == $objeto["total"]){
	                    //$estado = "No Enviada";
	                    $estado = 7;
	                }
	                if($objeto["no_enviados"] == 0){
	                    //$estado = "Enviada";
	                    $estado = 3;
	                }
	            }

	        	break;
	        case 3: 
	            //$estado = "Enviada";
	            $estado = 3;
	        	break;
	        case 4: 
	            //$estado = "En Transito";
	            $estado = 4;
	            break;
	        case 5: 
	            //$estado = "Cancelada";
	            $estado = 5;
	            
	            if($objeto["no_enviados"] == $objeto["total"]){
	                //$estado = "Cancelada";
	                $estado = 5;
	            }
	            if($objeto["no_enviados"] >= 0 && $objeto["no_enviados"] < $objeto["total"]){
	                //$estado = "Enviada y Cancelada";
	                $estado = 8;
	            }
	        break;
	        case 7: 
	            //$estado = "No enviada";
	            $estado = 7;
	        break;

	    
	    }
	    return $estado; 
	}
}
