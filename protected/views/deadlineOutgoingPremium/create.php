<?php
/* @var $this DeadlineOutgoingPremiumController */
/* @var $model DeadlineOutgoingPremium */

$this->breadcrumbs=array(
	'Deadline Outgoing Premia'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DeadlineOutgoingPremium', 'url'=>array('index')),
	array('label'=>'Manage DeadlineOutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>Create DeadlineOutgoingPremium</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>