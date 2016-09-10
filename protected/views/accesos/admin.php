<?php
/* @var $this AccesosController */
/* @var $model Accesos */

$this->breadcrumbs=array(
	'Accesoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Accesos', 'url'=>array('index')),
	array('label'=>'Create Accesos', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accesos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Accesoses</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'accesos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_usuario',
		'acceso_conciliacion',
		'acceso_CRS',
		'crear_promo',
		'ver_detalles',
		'ver_destinatarios',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
