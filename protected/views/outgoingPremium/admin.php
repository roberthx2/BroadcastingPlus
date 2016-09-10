<?php
/* @var $this OutgoingPremiumController */
/* @var $model OutgoingPremium */

$this->breadcrumbs=array(
	'Outgoing Premia'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OutgoingPremium', 'url'=>array('index')),
	array('label'=>'Create OutgoingPremium', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#outgoing-premium-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Outgoing Premia</h1>

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
	'id'=>'outgoing-premium-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'destinatario',
		'mensaje',
		'fecha_in',
		'hora_in',
		'fecha_out',
		/*
		'hora_out',
		'tipo_evento',
		'cliente',
		'operadora',
		'status',
		'id_promo',
		'id_insignia_alarmas',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
