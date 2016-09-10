<?php
/* @var $this AccesosController */
/* @var $model Accesos */

$this->breadcrumbs=array(
	'Accesoses'=>array('index'),
	$model->id_usuario,
);

$this->menu=array(
	array('label'=>'List Accesos', 'url'=>array('index')),
	array('label'=>'Create Accesos', 'url'=>array('create')),
	array('label'=>'Update Accesos', 'url'=>array('update', 'id'=>$model->id_usuario)),
	array('label'=>'Delete Accesos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_usuario),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accesos', 'url'=>array('admin')),
);
?>

<h1>View Accesos #<?php echo $model->id_usuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_usuario',
		'acceso_conciliacion',
		'acceso_CRS',
		'crear_promo',
		'ver_detalles',
		'ver_destinatarios',
		'sms_enviados',
		'crear_lista',
		'ver_lista',
		'editar_lista',
		'editar_detalles',
		'editar_destinatarios',
		'sms_prog',
		'crear_not',
		'ver_not',
		'agregar_exen',
		'ver_exen',
		'eliminar_exen',
		'num_cruzados',
		'admin_accesos',
		'admin_puertos_usuario',
		'admin_puertos_ver',
		'admin_puertos_crear',
		'admin_puertos_editar',
		'admin_puertos_eliminar',
		'admin_cupo',
		'admin_prefijos_ver',
		'admin_prefijos_editar',
		'admin_prefijos_eliminar',
		'sms_recibidos',
		'administrar_exentos_propuestos',
		'sms_enviados_por_cliente',
		'crear_promo_personalizada',
		'admin_pruebas_modems',
		'administrar_modem_sin_saldo',
		'administrar_reasignar_puertos_por_promo',
		'administrar_reporte_vigilancia',
		'administrar_terminos_condiciones',
		'administrar_aprobar_promocion',
		'administrar_operadoras',
		'habilitar_modem_inactivos',
		'generar_reporte_sms_recibidos',
		'broadcasting',
		'broadcasting_premium',
		'crear_promo_premium',
		'ver_detalles_premium',
		'ver_reporte_premium',
		'generar_reporte_sms_recibidos_premium',
		'broadcasting_lite',
		'crear_promo_lite',
		'reactivar_promo',
		'acceso_en_suspension',
	),
)); ?>
