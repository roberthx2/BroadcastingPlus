<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $model ConfiguracionOperadoraReservacion */

$this->breadcrumbs=array(
	'Configuracion Operadora Reservacions'=>array('index'),
	$model->id_operadora,
);

$this->menu=array(
	array('label'=>'List ConfiguracionOperadoraReservacion', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionOperadoraReservacion', 'url'=>array('create')),
	array('label'=>'Update ConfiguracionOperadoraReservacion', 'url'=>array('update', 'id'=>$model->id_operadora)),
	array('label'=>'Delete ConfiguracionOperadoraReservacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_operadora),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConfiguracionOperadoraReservacion', 'url'=>array('admin')),
);
?>

<h1>View ConfiguracionOperadoraReservacion #<?php echo $model->id_operadora; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_operadora',
		'descripcion',
		'sms_x_seg',
		'porcentaje_permitido',
	),
)); ?>
