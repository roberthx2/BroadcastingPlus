<?php
/* @var $this DeadlineOutgoingPremiumController */
/* @var $model DeadlineOutgoingPremium */

$this->breadcrumbs=array(
	'Deadline Outgoing Premia'=>array('index'),
	$model->id_promo=>array('view','id'=>$model->id_promo),
	'Update',
);

$this->menu=array(
	array('label'=>'List DeadlineOutgoingPremium', 'url'=>array('index')),
	array('label'=>'Create DeadlineOutgoingPremium', 'url'=>array('create')),
	array('label'=>'View DeadlineOutgoingPremium', 'url'=>array('view', 'id'=>$model->id_promo)),
	array('label'=>'Manage DeadlineOutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>Update DeadlineOutgoingPremium <?php echo $model->id_promo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>