<?php
/* @var $this OutgoingPremiumController */
/* @var $model OutgoingPremium */

$this->breadcrumbs=array(
	'Outgoing Premia'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OutgoingPremium', 'url'=>array('index')),
	array('label'=>'Create OutgoingPremium', 'url'=>array('create')),
	array('label'=>'View OutgoingPremium', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>Update OutgoingPremium <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>