<?php
/* @var $this ClienteAlarmasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cliente Alarmases',
);

$this->menu=array(
	array('label'=>'Create ClienteAlarmas', 'url'=>array('create')),
	array('label'=>'Manage ClienteAlarmas', 'url'=>array('admin')),
);
?>

<h1>Cliente Alarmases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
