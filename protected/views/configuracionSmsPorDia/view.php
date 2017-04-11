<?php
/* @var $this ConfiguracionSmsPorDiaController */
/* @var $model ConfiguracionSmsPorDia */

$this->breadcrumbs=array(
	'Configuracion Sms Por Dias'=>array('index'),
	$model->id_dia,
);

$this->menu=array(
	array('label'=>'List ConfiguracionSmsPorDia', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionSmsPorDia', 'url'=>array('create')),
	array('label'=>'Update ConfiguracionSmsPorDia', 'url'=>array('update', 'id'=>$model->id_dia)),
	array('label'=>'Delete ConfiguracionSmsPorDia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_dia),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConfiguracionSmsPorDia', 'url'=>array('admin')),
);
?>

<h1>View ConfiguracionSmsPorDia #<?php echo $model->id_dia; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_dia',
		'descripcion',
		'cantidad',
	),
)); ?>
