<?php
/* @var $this PromocionesPremiumController */
/* @var $model PromocionesPremium */

$this->breadcrumbs=array(
	'Promociones Premia'=>array('index'),
	$model->id_promo,
);

$this->menu=array(
	array('label'=>'List PromocionesPremium', 'url'=>array('index')),
	array('label'=>'Create PromocionesPremium', 'url'=>array('create')),
	array('label'=>'Update PromocionesPremium', 'url'=>array('update', 'id'=>$model->id_promo)),
	array('label'=>'Delete PromocionesPremium', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_promo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PromocionesPremium', 'url'=>array('admin')),
);
?>

<h1>View PromocionesPremium #<?php echo $model->id_promo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_promo',
		'nombrePromo',
		'id_cliente',
		'estado',
		'fecha',
		'hora',
		'loaded_by',
		'contenido',
		'fecha_cargada',
		'hora_cargada',
		'verificada',
	),
)); ?>
