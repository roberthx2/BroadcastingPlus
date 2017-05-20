<?php
/* @var $this PermisosController */
/* @var $model Permisos */

$this->breadcrumbs=array(
	'Permisoses'=>array('index'),
	$model->id_usuario,
);

$this->menu=array(
	array('label'=>'List Permisos', 'url'=>array('index')),
	array('label'=>'Create Permisos', 'url'=>array('create')),
	array('label'=>'Update Permisos', 'url'=>array('update', 'id'=>$model->id_usuario)),
	array('label'=>'Delete Permisos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_usuario),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Permisos', 'url'=>array('admin')),
);
?>

<h1>View Permisos #<?php echo $model->id_usuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_usuario',
		'acceso_sistema',
		'broadcasting',
		'broadcasting_premium',
		'broadcasting_cpei',
		'modulo_promocion',
		'crear_promo_bcnl',
		'crear_promo_bcp',
		'detalles_promo_bcnl',
		'detalles_promo_bcp',
		'modulo_listas',
		'crear_listas',
		'administrar_listas',
		'modulo_cupo',
		'recargar_cupo_bcnl',
		'recargar_cupo_bcp',
		'historico_cupo_bcnl',
		'historico_cupo_bcp',
		'modulo_exentos',
		'agregar_exentos',
		'administrar_exentos',
		'modulo_reportes',
		'reporte_sms_programados_bcnl',
		'reporte_sms_programados_bcp',
		'reporte_mensual_sms_bcnl',
		'reporte_mensual_sms_bcp',
		'reporte_mensual_sms_por_cliente_bcnl',
		'reporte_mensual_sms_por_cliente_bcp',
		'reporte_mensual_sms_por_codigo_bcp',
		'reporte_sms_recibidos_bcnl',
		'reporte_sms_recibidos_bcp',
		'reporte_vigilancia_bcnl',
		'reporte_vigilancia_bcp',
		'modulo_administracion',
		'modulo_btl',
		'modulo_herramientas',
		'administrar_prefijo',
	),
)); ?>
