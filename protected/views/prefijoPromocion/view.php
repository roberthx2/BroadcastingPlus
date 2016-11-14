<?php
/* @var $this PrefijoPromocionController */
/* @var $model PrefijoPromocion */

$this->breadcrumbs=array(
	'Prefijo Promocions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PrefijoPromocion', 'url'=>array('index')),
	array('label'=>'Create PrefijoPromocion', 'url'=>array('create')),
	array('label'=>'Update PrefijoPromocion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PrefijoPromocion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PrefijoPromocion', 'url'=>array('admin')),
);
?>

<h1>View PrefijoPromocion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_usuario',
		'prefijo',
	),
)); ?>
