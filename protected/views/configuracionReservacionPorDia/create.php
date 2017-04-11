<?php
/* @var $this ConfiguracionReservacionPorDiaController */
/* @var $model ConfiguracionReservacionPorDia */

$this->breadcrumbs=array(
	'Configuracion Reservacion Por Dias'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConfiguracionReservacionPorDia', 'url'=>array('index')),
	array('label'=>'Manage ConfiguracionReservacionPorDia', 'url'=>array('admin')),
);
?>

<h1>Create ConfiguracionReservacionPorDia</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>