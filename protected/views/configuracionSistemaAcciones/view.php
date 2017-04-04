<?php
/* @var $this ConfiguracionSistemaAccionesController */
/* @var $model ConfiguracionSistemaAcciones */

$this->breadcrumbs=array(
	'Configuracion Sistema Acciones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConfiguracionSistemaAcciones', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionSistemaAcciones', 'url'=>array('create')),
	array('label'=>'Update ConfiguracionSistemaAcciones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConfiguracionSistemaAcciones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConfiguracionSistemaAcciones', 'url'=>array('admin')),
);
?>

<h1>View ConfiguracionSistemaAcciones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'propiedad',
		'action',
	),
)); ?>
