<?php
/* @var $this PromocionesPremiumController */
/* @var $model PromocionesPremium */

$this->breadcrumbs=array(
	'Promociones Premia'=>array('index'),
	$model->id_promo=>array('view','id'=>$model->id_promo),
	'Update',
);

$this->menu=array(
	array('label'=>'List PromocionesPremium', 'url'=>array('index')),
	array('label'=>'Create PromocionesPremium', 'url'=>array('create')),
	array('label'=>'View PromocionesPremium', 'url'=>array('view', 'id'=>$model->id_promo)),
	array('label'=>'Manage PromocionesPremium', 'url'=>array('admin')),
);
?>

<h1>Update PromocionesPremium <?php echo $model->id_promo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>