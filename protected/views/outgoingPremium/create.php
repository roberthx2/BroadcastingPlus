<?php
/* @var $this OutgoingPremiumController */
/* @var $model OutgoingPremium */

$this->breadcrumbs=array(
	'Outgoing Premia'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OutgoingPremium', 'url'=>array('index')),
	array('label'=>'Manage OutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>Create OutgoingPremium</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>