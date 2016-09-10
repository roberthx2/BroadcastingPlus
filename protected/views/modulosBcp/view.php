<?php
/* @var $this ModulosBcpController */
/* @var $model ModulosBcp */

$this->breadcrumbs=array(
	'Modulos Bcps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ModulosBcp', 'url'=>array('index')),
	array('label'=>'Create ModulosBcp', 'url'=>array('create')),
	array('label'=>'Update ModulosBcp', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ModulosBcp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ModulosBcp', 'url'=>array('admin')),
);
?>

<h1>View ModulosBcp #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre_real',
		'descripcion',
	),
)); ?>
