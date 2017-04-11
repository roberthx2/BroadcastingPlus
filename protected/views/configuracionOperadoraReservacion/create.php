<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $model ConfiguracionOperadoraReservacion */

$this->breadcrumbs=array(
	'Configuracion Operadora Reservacions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConfiguracionOperadoraReservacion', 'url'=>array('index')),
	array('label'=>'Manage ConfiguracionOperadoraReservacion', 'url'=>array('admin')),
);
?>

<h1>Create ConfiguracionOperadoraReservacion</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>