<?php
/* @var $this PermisosController */
/* @var $model Permisos */

$this->breadcrumbs=array(
	'Permisoses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Permisos', 'url'=>array('index')),
	array('label'=>'Create Permisos', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#permisos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Permisoses</h1>

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
	'id'=>'permisos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_usuario',
		'acceso_sistema',
		'broadcasting',
		'broadcasting_premium',
		'broadcasting_cpei',
		'modulo_promocion',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
