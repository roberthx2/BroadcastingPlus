<?php
/* @var $this ConfiguracionReservacionPorDiaController */
/* @var $model ConfiguracionReservacionPorDia */

$this->breadcrumbs=array(
	'Configuracion Reservacion Por Dias'=>array('index'),
	$model->id_dia=>array('view','id'=>$model->id_dia),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConfiguracionReservacionPorDia', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionReservacionPorDia', 'url'=>array('create')),
	array('label'=>'View ConfiguracionReservacionPorDia', 'url'=>array('view', 'id'=>$model->id_dia)),
	array('label'=>'Manage ConfiguracionReservacionPorDia', 'url'=>array('admin')),
);
?>

<h1>Update ConfiguracionReservacionPorDia <?php echo $model->id_dia; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>