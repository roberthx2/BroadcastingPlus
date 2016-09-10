<?php
/* @var $this UsuarioMasivoController */
/* @var $model UsuarioMasivo */

$this->breadcrumbs=array(
	'Usuario Masivos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UsuarioMasivo', 'url'=>array('index')),
	array('label'=>'Create UsuarioMasivo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#usuario-masivo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Usuario Masivos</h1>

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
	'id'=>'usuario-masivo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_usuario',
		'login',
		'pwd',
		'creado',
		'cupo_sms',
		'sms_usados',
		/*
		'cadena_promo',
		'acceso_listas',
		'cadena_listas',
		'puertos',
		'fecha_creado',
		'puertos_de_respaldo',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
