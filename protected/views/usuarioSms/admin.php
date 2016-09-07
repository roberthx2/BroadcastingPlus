<?php
/* @var $this UsuarioSmsController */
/* @var $model UsuarioSms */

$this->breadcrumbs=array(
	'Usuario Sms'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UsuarioSms', 'url'=>array('index')),
	array('label'=>'Create UsuarioSms', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#usuario-sms-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Usuario Sms</h1>

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
	'id'=>'usuario-sms-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_usuario',
		'login',
		'pwd',
		'id_perfil',
		'id_cliente',
		'id_integ',
		/*
		'email_u',
		'cadena_sc',
		'creado',
		'cadena_serv',
		'acceso_masivo',
		'acceso_triviaweb',
		'cadena_promo',
		'edicion_clasificados',
		'reportes_clasificados',
		'acceso_digitelstats',
		'cadena_cintillo',
		'acceso_admin',
		'acceso_analisis',
		'ver_numero',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
