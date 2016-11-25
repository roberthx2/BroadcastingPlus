<?php
ini_set("max_execution_time",0);
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
				'actions'=>array('index','view', 'indexPromociones', 'viewConfirmar', 'confirmarPromo','viewCancelar', 'cancelarPromo', 'reporteMensualSms' , 'reporteMensualSmsPorCliente', 'reporteMensualSmsPorCodigo', 'getPromociones'),
				'users'=>array('@'),
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
		$criteria->select = "t.id_promo, t.id_cliente, t.nombrePromo, t.contenido, t.fecha, t.hora, d.hora_limite, u.login AS login, (SELECT COUNT(*) FROM outgoing_premium o WHERE o.id_promo = t.id_promo) AS total";
		$criteria->join = "INNER JOIN deadline_outgoing_premium d ON t.id_promo = d.id_promo ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.loaded_by = u.id_usuario";
		$criteria->compare("t.id_promo", $id);
		$model_promocion = PromocionesPremium::model()->find($criteria);

		$sql = "SELECT descripcion FROM cliente WHERE id = ".$model_promocion->id_cliente;
		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();
		$cliente = str_replace("@", "", $sql["descripcion"]);

		$this->render('view',array('model_promocion'=>$model_promocion, 'cliente'=>$cliente));
	}

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

	public function actionViewResumen($id_promo)
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.id_promo, u.login, t.loaded_by, t.nombrePromo, t.id_cliente, t.estado, t.fecha, t.hora, t.contenido, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo) AS total,
			(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo AND status = 1) AS enviados";
		$criteria->join = "INNER JOIN deadline_outgoing_premium d_o ON t.id_promo = d_o.id_promo ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.loaded_by = u.id_usuario";
		$criteria->condition = "t.id_promo = :id_promo";
		$criteria->params = array(':id_promo' => $id_promo);

		$model = PromocionesPremium::model()->find($criteria);

		$sql = "SELECT descripcion FROM cliente WHERE id = ".$model->id_cliente;
		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();
		$cliente = $sql["descripcion"];

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
        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $model_promocion = PromocionesPremium::model()->findByPk($id_promo);
            $model_promocion->estado = 2;
            $model_promocion->save();

            $sql = "UPDATE outgoing_premium SET status = 2 WHERE id_promo = :id_promo";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
            $sql->bindParam(":id_promo", $id_promo, PDO::PARAM_STR);
            $sql->execute();

            $log = "PROMOCION CONFIRMADA BCP | id_promo: ".$id_promo." | id_cliente_bcp: ".$model_promocion->id_cliente;
            Yii::app()->Procedimientos->setLog($log);

            $transaction->commit();
        } catch (Exception $e)
            {
                $transaction->rollBack();
            }

        $this->redirect("home/index");
    }

	public function actionCancelarPromo($id_promo)
	{
		$transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
			$model = $this->loadModel($id_promo);
			$model->estado = 4;
			$model->save();

			//Todo lo que sea distinto de enviado
			$sql = "UPDATE outgoing_premium SET status = 4 WHERE id_promo = ".$id_promo." AND status <> 1"; 
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();

			$log = "PROMOCION CANCELADA BCP | id_promo: ".$id_promo." | id_cliente_bcp: ".$model->id_cliente;
            Yii::app()->Procedimientos->setLog($log);

            Yii::app()->user->setFlash("success", "La promoción fue cancelada correctamente");
			$transaction->commit();
		} catch (Exception $e)
			{
				//print_r($e);
				$error = "Ocurrio un error al procesar los datos, intente nuevamente.";
				Yii::app()->user->setFlash("danger", $error);
        		$transaction->rollBack();
    		}

    	$this->redirect("home/index");
	}

	//Obtener el estado de la promocion
	public function actionGetStatusPromocion($id_promo)
	{
		$sql = "SELECT p.estado,  p.fecha, p.hora, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = p.id_promo) AS total,
			(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = p.id_promo AND status = 1) AS enviados
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
	        case 1: //El java coloca este estado si todos los mensajes fueron enviados (CUANDO FUNCIONA)
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

	public function actionGetStatusPromocionRapida($objeto)
	{
	    switch ($objeto["estado"])
	    {
	        case 0: 
	            //$estado = "No Confirmada";
	            $estado = 0;
	            break;
	        case 1: //El java coloca este estado si todos los mensajes fueron enviados (CUANDO FUNCIONA)
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

	public function actionGetStatusDestinatario($id_estado, $fecha, $hora, $hora_limite)
	{
		switch ($id_estado)
	    {
	    	case 0: //No confirmado
	            $estado = 0;
	            break;

	        case 1: //Enviado
	        	$estado = 1;
	        	break;

	        case 2: //Confirmado
	        	$estado = 2; //Confirmado
	            $hora_actual = time();
	            $hora_inicio = strtotime($fecha . " " . $hora);
	            $hora_fin = strtotime($fecha . " " . $hora_limite);

	            if (($hora_actual >= $hora_inicio) && ($hora_actual <= $hora_fin)) {
	            	$estado = 3; //Transito
	            }

	            if ($hora_actual < $hora_inicio) {
	                $estado = 2; //Confirmado
	            }

	            if ($hora_actual > $hora_fin) {  
	                $estado = 5; //No enviado
	            }

	            break;
	        case 3: //Transito
	        	$estado = 3;
	        	break;
	        case 4: //Cancelado
	        	$estado = 4;
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

	public function actionReporteMensualSms()
    {
        $id_cliente = $_POST['PromocionesPremium']["id_cliente"];
        $mes = $_POST['PromocionesPremium']["mes"];
        $ano = $_POST['PromocionesPremium']["ano"];
        $fecha_ini = date($ano."-".$mes."-01");
        $fecha_fin = Yii::app()->Funciones->getUltimoDiaMes($ano, $mes);

        $sql = "SELECT IFNULL(SUM(total),0) AS total, IFNULL(SUM(enviados),0) AS enviados FROM 
                (SELECT  
                    (SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo) AS total,
                    (SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo AND status = 1) AS enviados
                    FROM promociones_premium t
                    WHERE t.id_cliente = :id_cliente AND t.fecha BETWEEN :fecha_ini AND :fecha_fin
                ) AS tabla";

        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        $sql->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_STR);
        $sql->bindParam(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
        $sql = $sql->queryRow();

        $enviados = 0;
        $no_enviados = 0;

        if ($sql["total"] > 0)
        {
            $enviados = floor(($sql["enviados"] * 100) / $sql["total"]);
            $enviados = number_format($enviados, 1, '.', '.');

            $no_enviados = floor((($sql["total"] - $sql["enviados"]) * 100) / $sql["total"]);
            $no_enviados = number_format($no_enviados, 1, '.', '.');
        }

        $total = number_format($sql["total"], 0, '', '.');

        $objeto = array(
                'total' => $total,
                'enviados_title' => $enviados." %",
                'enviados_label' => number_format($sql["enviados"], 0, '', '.'),
                'no_enviados_title' => $no_enviados." %",
                'no_enviados' => number_format(($sql["total"] - $sql["enviados"]), 0, '', '.'),
                'periodo' => $fecha_ini." / ".$fecha_fin,
            );


        echo CJSON::encode(array(
            'objeto'=>$objeto,
        ));

        Yii::app()->end();
    }

    public function actionReporteMensualSmsPorCliente()
    {
        $mes = $_POST['OutgoingPremium']["mes"];
        $ano = $_POST['OutgoingPremium']["ano"];
        $fecha_ini = date($ano."-".$mes."-01");
        $fecha_fin = Yii::app()->Funciones->getUltimoDiaMes($ano, $mes);

        $sql = "SELECT GROUP_CONCAT(id_promo) AS ids FROM promociones_premium WHERE fecha BETWEEN :fecha_ini AND :fecha_fin";
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_STR);
        $sql->bindParam(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
        $sql = $sql->queryRow();

		$id_promo = $sql["ids"];

		if ($id_promo == "")
			$id_promo = "null";

		$sql = "SELECT IFNULL(SUM(total),0) AS total, IFNULL(SUM(enviados),0) AS enviados FROM  
				(SELECT  
					(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo IN(".$id_promo.") AND cliente = t.cliente) AS total, 
					(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo IN(".$id_promo.") AND cliente = t.cliente AND status = 1) AS enviados
					FROM outgoing_premium t
					WHERE t.id_promo IN(".$id_promo.")
					GROUP BY t.cliente
				) AS tabla";

        $sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

        $enviados = 0;
        $no_enviados = 0;

        if ($sql["total"] > 0)
        {
            $enviados = floor(($sql["enviados"] * 100) / $sql["total"]);
            $enviados = number_format($enviados, 1, '.', '.');

            $no_enviados = floor((($sql["total"] - $sql["enviados"]) * 100) / $sql["total"]);
            $no_enviados = number_format($no_enviados, 1, '.', '.');
        }

        $total = number_format($sql["total"], 0, '', '.');

        $objeto = array(
                'total' => $total,
                'enviados_title' => $enviados." %",
                'enviados_label' => number_format($sql["enviados"], 0, '', '.'),
                'no_enviados_title' => $no_enviados." %",
                'no_enviados' => number_format(($sql["total"] - $sql["enviados"]), 0, '', '.'),
                'periodo' => $fecha_ini." / ".$fecha_fin,
            );


        echo CJSON::encode(array(
            'objeto'=>$objeto,
        ));

        Yii::app()->end();
    }

    public function actionReporteMensualSmsPorCodigo()
    {
        $mes = $_POST['PromocionesPremium']["mes"];
        $ano = $_POST['PromocionesPremium']["ano"];
        $fecha_ini = date($ano."-".$mes."-01");
        $fecha_fin = Yii::app()->Funciones->getUltimoDiaMes($ano, $mes);

        $sql = "SELECT GROUP_CONCAT(id_promo) AS id FROM promociones_premium WHERE fecha BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'";
		$id_promo = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		$sql = "SELECT SUM(total) AS total, SUM(enviados) AS enviados FROM (
					SELECT p.sc, p.id_promo AS id,
					(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = p.id_promo) AS total, 
					(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = p.id_promo AND status = 1) AS enviados
					FROM promociones_premium p
					WHERE p.id_promo IN(".$id_promo["id"].") 
					GROUP BY p.sc, p.id_promo) AS tabla";
		
		$sql = PromocionesPremium::model()->findBySql($sql);

        $enviados = 0;
        $no_enviados = 0;

        if ($sql->total > 0)
        {
            $enviados = floor(($sql->enviados * 100) / $sql->total);
            $enviados = number_format($enviados, 1, '.', '.');

            $no_enviados = floor((($sql->total - $sql->enviados) * 100) / $sql->total);
            $no_enviados = number_format($no_enviados, 1, '.', '.');
        }

        $total = number_format($sql->total, 0, '', '.');

        $objeto = array(
                'total' => $total,
                'enviados_title' => $enviados." %",
                'enviados_label' => number_format($sql->enviados, 0, '', '.'),
                'no_enviados_title' => $no_enviados." %",
                'no_enviados' => number_format(($sql->total - $sql->enviados), 0, '', '.'),
                'periodo' => $fecha_ini." / ".$fecha_fin,
            );


        echo CJSON::encode(array(
            'objeto'=>$objeto,
        ));

        Yii::app()->end();
    }

    public function actionGetPromociones()
    {
        $id_cliente = $_POST['Smsin']["id_cliente"];
        $mes = $_POST['Smsin']["mes"];
        $fecha_ini = date("Y-".$mes."-01");
        $ano = date("Y");

        $fecha_fin = Yii::app()->Funciones->getUltimoDiaMes($ano, $mes);

        if (Yii::app()->request->isAjaxRequest)
        {
            if ($id_cliente == '') {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'Cliente invalido'
                ));
                Yii::app()->end();
            } else {   
                
                $sql = "SELECT id_promo, nombrePromo FROM promociones_premium WHERE fecha BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' AND id_cliente = ".$id_cliente." ORDER BY nombrePromo DESC";
                $data = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll($sql);
               
                if($data) {
                    echo CJSON::encode(array(
                                            'error' => 'false',
                                            'status' => 'Promociones obtenidas correctamente',
                                            'data' => $data,
                                       )                                
                         );
                    Yii::app()->end();
                } else {
                    echo CJSON::encode(array(
                        'error' => 'true',
                        'status' => 'No pexisten promociones para el mes'
                    ));
                    Yii::app()->end();
                }
            }   
        }
    }
}
