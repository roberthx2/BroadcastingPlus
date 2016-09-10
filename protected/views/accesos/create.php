<?php
/* @var $this AccesosController */
/* @var $model Accesos */

$this->breadcrumbs=array(
	'Accesoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Accesos', 'url'=>array('index')),
	array('label'=>'Manage Accesos', 'url'=>array('admin')),
);
?>

<h1>Create Accesos</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>