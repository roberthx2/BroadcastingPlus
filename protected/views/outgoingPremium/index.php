<?php
/* @var $this OutgoingPremiumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Outgoing Premia',
);

$this->menu=array(
	array('label'=>'Create OutgoingPremium', 'url'=>array('create')),
	array('label'=>'Manage OutgoingPremium', 'url'=>array('admin')),
);
?>

<h1>Outgoing Premia</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
