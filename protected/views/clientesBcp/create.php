<?php
/* @var $this ClientesBcpController */
/* @var $model ClientesBcp */

$this->breadcrumbs=array(
	'Clientes Bcps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClientesBcp', 'url'=>array('index')),
	array('label'=>'Manage ClientesBcp', 'url'=>array('admin')),
);
?>

<h1>Create ClientesBcp</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>