<?php
/* @var $this ModulosBcpController */
/* @var $model ModulosBcp */

$this->breadcrumbs=array(
	'Modulos Bcps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ModulosBcp', 'url'=>array('index')),
	array('label'=>'Manage ModulosBcp', 'url'=>array('admin')),
);
?>

<h1>Create ModulosBcp</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>