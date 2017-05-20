<?php
/* @var $this PermisosController */
/* @var $model Permisos */

$this->breadcrumbs=array(
	'Permisoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Permisos', 'url'=>array('index')),
	array('label'=>'Manage Permisos', 'url'=>array('admin')),
);
?>

<h1>Create Permisos</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>