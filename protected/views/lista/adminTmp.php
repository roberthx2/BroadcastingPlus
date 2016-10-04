<?php
/* @var $this TmpProcesamientoController */
/* @var $model TmpProcesamiento */

$this->breadcrumbs=array(
	'Tmp Procesamientos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TmpProcesamiento', 'url'=>array('index')),
	array('label'=>'Create TmpProcesamiento', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tmp-procesamiento-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tmp Procesamientos</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tmp-procesamiento-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'id_proceso',
		'numero',
		'id_operadora',
		'estado',
		'id_promo',
		/*
		'mensaje',
		'fecha_inicio',
		'fecha_fin',
		'hora_inicio',
		'hora_fin',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
