<?php
/* @var $this DeadlineOutgoingPremiumController */
/* @var $model DeadlineOutgoingPremium */

$this->breadcrumbs=array(
	'Deadline Outgoing Premia'=>array('index'),
	$model->id_promo,
);

$this->menu=array(
	array('label'=>'List DeadlineOutgoingPremium', 'url'=>array('index')),
	array('label'=>'Create DeadlineOutgoingPremium', 'url'=>array('create')),
	array('label'=>'Update DeadlineOutgoingPremium', 'url'=>array('update', 'id'=>$model->id_promo)),
	array('label'=>'Delete DeadlineOutgoingPremium', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_promo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DeadlineOutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>View DeadlineOutgoingPremium #<?php echo $model->id_promo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_promo',
		'fecha_limite',
		'hora_limite',
	),
)); ?>
