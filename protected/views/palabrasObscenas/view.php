<?php
/* @var $this PalabrasObscenasController */
/* @var $model PalabrasObscenas */

$this->breadcrumbs=array(
	'Palabras Obscenases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PalabrasObscenas', 'url'=>array('index')),
	array('label'=>'Create PalabrasObscenas', 'url'=>array('create')),
	array('label'=>'Update PalabrasObscenas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PalabrasObscenas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PalabrasObscenas', 'url'=>array('admin')),
);
?>

<h1>View PalabrasObscenas #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'palabra',
	),
)); ?>
