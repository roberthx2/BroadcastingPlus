<?php
/* @var $this ConfiguracionSmsPorDiaController */
/* @var $model ConfiguracionSmsPorDia */

$this->breadcrumbs=array(
	'Configuracion Sms Por Dias'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConfiguracionSmsPorDia', 'url'=>array('index')),
	array('label'=>'Manage ConfiguracionSmsPorDia', 'url'=>array('admin')),
);
?>

<h1>Create ConfiguracionSmsPorDia</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>