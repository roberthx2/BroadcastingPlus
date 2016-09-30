<?php
/* @var $this ListaController */
/* @var $model Lista */

$this->breadcrumbs=array(
	'Listas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lista', 'url'=>array('index')),
	array('label'=>'Manage Lista', 'url'=>array('admin')),
);
?>

<h1>Create Lista</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>