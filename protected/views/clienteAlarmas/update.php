<?php
/* @var $this ClienteAlarmasController */
/* @var $model ClienteAlarmas */

$this->breadcrumbs=array(
	'Cliente Alarmases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClienteAlarmas', 'url'=>array('index')),
	array('label'=>'Create ClienteAlarmas', 'url'=>array('create')),
	array('label'=>'View ClienteAlarmas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClienteAlarmas', 'url'=>array('admin')),
);
?>

<h1>Update ClienteAlarmas <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>