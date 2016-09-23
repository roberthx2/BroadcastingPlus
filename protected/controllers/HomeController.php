<?php

class HomeController extends Controller
{
	public $layout="//layouts/home";

	public function actionIndex()
	{
		/*$model = new Promociones('search');
		$model->unsetAttributes();
		if(isset($_GET['PromocionesPremium']))
			$model->attributes=$_GET['PromocionesPremium'];*/

		if (Yii::app()->user->getAccesosBCP()->broadcasting_premium)
		{
			/*$sql = "SELECT GROUP_CONCAT(id_cliente) AS id_clientes FROM usuario_cliente_operadora WHERE id_usuario = ".Yii::app()->user->id;
			$id_clientes = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

			$sql = "SELECT p.id_promo, p.loaded_by, p.nombrePromo, p.id_cliente, p.estado, p.hora, p.contenido, d_o.fecha_limite, d_o.hora_limite,
				(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo) AS total,
				(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo AND status = 1) AS enviados,
				(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo AND status != 1) AS no_enviados
				FROM promociones_premium AS p, deadline_outgoing_premium AS d_o
				WHERE p.id_promo IN (SELECT id_promo FROM promociones_premium WHERE id_cliente IN(".$id_clientes["id_clientes"].")) AND p.fecha = CURDATE() AND p.id_promo = d_o.id_promo
				ORDER BY p.fecha, p.id_promo DESC";

			$modelBCP = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();*/

			$modelBCP = new PromocionesPremium('searchHome');
			$modelBCP->unsetAttributes();
			if(isset($_GET['PromocionesPremium']))
				$modelBCP->attributes=$_GET['PromocionesPremium'];
		}

		$this->render('index', array('modelBCP'=>$modelBCP));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}