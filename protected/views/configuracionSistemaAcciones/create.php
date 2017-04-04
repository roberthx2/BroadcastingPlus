<?php
/* @var $this ConfiguracionSistemaAccionesController */
/* @var $model ConfiguracionSistemaAcciones */

$this->breadcrumbs=array(
	'Configuracion Sistema Acciones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConfiguracionSistemaAcciones', 'url'=>array('index')),
	array('label'=>'Manage ConfiguracionSistemaAcciones', 'url'=>array('admin')),
);
?>

<h1>Create ConfiguracionSistemaAcciones</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>