<?php
/* @var $this OutgoingPremiumController */
/* @var $model OutgoingPremium */

$this->breadcrumbs=array(
	'Outgoing Premia'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OutgoingPremium', 'url'=>array('index')),
	array('label'=>'Create OutgoingPremium', 'url'=>array('create')),
	array('label'=>'Update OutgoingPremium', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OutgoingPremium', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>View OutgoingPremium #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'destinatario',
		'mensaje',
		'fecha_in',
		'hora_in',
		'fecha_out',
		'hora_out',
		'tipo_evento',
		'cliente',
		'operadora',
		'status',
		'id_promo',
		'id_insignia_alarmas',
	),
)); ?>
