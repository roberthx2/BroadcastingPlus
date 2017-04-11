<?php
/* @var $this ConfiguracionReservacionPorDiaController */
/* @var $model ConfiguracionReservacionPorDia */

$this->breadcrumbs=array(
	'Configuracion Reservacion Por Dias'=>array('index'),
	$model->id_dia,
);

$this->menu=array(
	array('label'=>'List ConfiguracionReservacionPorDia', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionReservacionPorDia', 'url'=>array('create')),
	array('label'=>'Update ConfiguracionReservacionPorDia', 'url'=>array('update', 'id'=>$model->id_dia)),
	array('label'=>'Delete ConfiguracionReservacionPorDia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_dia),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConfiguracionReservacionPorDia', 'url'=>array('admin')),
);
?>

<h1>View ConfiguracionReservacionPorDia #<?php echo $model->id_dia; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_dia',
		'descripcion',
		'estado',
	),
)); ?>
