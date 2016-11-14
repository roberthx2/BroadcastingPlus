<?php
/* @var $this PrefijoPromocionController */
/* @var $model PrefijoPromocion */

$this->breadcrumbs=array(
	'Prefijo Promocions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PrefijoPromocion', 'url'=>array('index')),
	array('label'=>'Create PrefijoPromocion', 'url'=>array('create')),
	array('label'=>'View PrefijoPromocion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PrefijoPromocion', 'url'=>array('admin')),
);
?>

<h1>Update PrefijoPromocion <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>