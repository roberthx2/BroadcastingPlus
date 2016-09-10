<?php
/* @var $this AccesosBcpController */
/* @var $model AccesosBcp */

$this->breadcrumbs=array(
	'Accesos Bcps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccesosBcp', 'url'=>array('index')),
	array('label'=>'Manage AccesosBcp', 'url'=>array('admin')),
);
?>

<h1>Create AccesosBcp</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>