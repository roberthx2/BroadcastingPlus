<?php
/* @var $this ClienteAlarmasController */
/* @var $model ClienteAlarmas */

$this->breadcrumbs=array(
	'Cliente Alarmases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClienteAlarmas', 'url'=>array('index')),
	array('label'=>'Manage ClienteAlarmas', 'url'=>array('admin')),
);
?>

<h1>Create ClienteAlarmas</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>