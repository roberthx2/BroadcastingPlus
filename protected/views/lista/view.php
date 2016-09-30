<?php
/* @var $this ListaController */
/* @var $model Lista */

$this->breadcrumbs=array(
	'Listas'=>array('index'),
	$model->id_lista,
);

$this->menu=array(
	array('label'=>'List Lista', 'url'=>array('index')),
	array('label'=>'Create Lista', 'url'=>array('create')),
	array('label'=>'Update Lista', 'url'=>array('update', 'id'=>$model->id_lista)),
	array('label'=>'Delete Lista', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_lista),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lista', 'url'=>array('admin')),
);
?>

<h1>View Lista #<?php echo $model->id_lista; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_lista',
		'id_usuario',
		'nombre',
	),
)); ?>
