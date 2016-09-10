<?php
/* @var $this DeadlineOutgoingPremiumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Deadline Outgoing Premia',
);

$this->menu=array(
	array('label'=>'Create DeadlineOutgoingPremium', 'url'=>array('create')),
	array('label'=>'Manage DeadlineOutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>Deadline Outgoing Premia</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
