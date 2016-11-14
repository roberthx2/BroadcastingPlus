<?php
/* @var $this PromocionesController */
/* @var $model Promociones */

$this->breadcrumbs=array(
	'Promociones'=>array('index'),
	$model->id_promo=>array('view','id'=>$model->id_promo),
	'Update',
);

$this->menu=array(
	array('label'=>'List Promociones', 'url'=>array('index')),
	array('label'=>'Create Promociones', 'url'=>array('create')),
	array('label'=>'View Promociones', 'url'=>array('view', 'id'=>$model->id_promo)),
	array('label'=>'Manage Promociones', 'url'=>array('admin')),
);
?>

<h1>Update Promociones <?php echo $model->id_promo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>