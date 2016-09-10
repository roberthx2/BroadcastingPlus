<?php
/* @var $this ClienteAlarmasController */
/* @var $model ClienteAlarmas */

$this->breadcrumbs=array(
	'Cliente Alarmases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClienteAlarmas', 'url'=>array('index')),
	array('label'=>'Create ClienteAlarmas', 'url'=>array('create')),
	array('label'=>'Update ClienteAlarmas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClienteAlarmas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClienteAlarmas', 'url'=>array('admin')),
);
?>

<h1>View ClienteAlarmas #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
		'sc',
		'cuota',
		'burst',
		'onoff',
		'segundos',
		'id_cliente_sms',
		'contacto_del_cliente',
		'id_cliente_sc_numerico',
	),
)); ?>
