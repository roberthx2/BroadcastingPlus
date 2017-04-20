<?php
/* @var $this UsuarioCupoHistoricoPremiumController */
/* @var $model UsuarioCupoHistoricoPremium */

$this->breadcrumbs=array(
	'Usuario Cupo Historico Premia'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UsuarioCupoHistoricoPremium', 'url'=>array('index')),
	array('label'=>'Create UsuarioCupoHistoricoPremium', 'url'=>array('create')),
	array('label'=>'View UsuarioCupoHistoricoPremium', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UsuarioCupoHistoricoPremium', 'url'=>array('admin')),
);
?>

<h1>Update UsuarioCupoHistoricoPremium <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>