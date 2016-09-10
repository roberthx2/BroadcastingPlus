<?php
/* @var $this AccesosBcpController */
/* @var $model AccesosBcp */

$this->breadcrumbs=array(
	'Accesos Bcps'=>array('index'),
	$model->id_usuario,
);

$this->menu=array(
	array('label'=>'List AccesosBcp', 'url'=>array('index')),
	array('label'=>'Create AccesosBcp', 'url'=>array('create')),
	array('label'=>'Update AccesosBcp', 'url'=>array('update', 'id'=>$model->id_usuario)),
	array('label'=>'Delete AccesosBcp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_usuario),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccesosBcp', 'url'=>array('admin')),
);
?>

<h1>View AccesosBcp #<?php echo $model->id_usuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_usuario',
		'broadcasting_premium',
		'crear_promo_premium',
		'ver_detalles_premium',
		'ver_reporte_premium',
		'generar_reporte_sms_recibidos_premium',
		'ver_sms_programados',
		'ver_mensual_sms',
		'ver_mensual_sms_por_cliente',
		'ver_mensual_sms_por_codigo',
		'ver_reporte_vigilancia',
	),
)); ?>
