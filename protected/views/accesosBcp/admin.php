<?php
/* @var $this AccesosBcpController */
/* @var $model AccesosBcp */

$this->breadcrumbs=array(
	'Accesos Bcps'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AccesosBcp', 'url'=>array('index')),
	array('label'=>'Create AccesosBcp', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accesos-bcp-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Accesos Bcps</h1>

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
	'id'=>'accesos-bcp-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_usuario',
		'broadcasting_premium',
		'crear_promo_premium',
		'ver_detalles_premium',
		'ver_reporte_premium',
		'generar_reporte_sms_recibidos_premium',
		/*
		'ver_sms_programados',
		'ver_mensual_sms',
		'ver_mensual_sms_por_cliente',
		'ver_mensual_sms_por_codigo',
		'ver_reporte_vigilancia',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
