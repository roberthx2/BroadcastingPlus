<?php
/* @var $this AccesosBcpController */
/* @var $model AccesosBcp */

$this->breadcrumbs=array(
	'Accesos Bcps'=>array('index'),
	$model->id_usuario=>array('view','id'=>$model->id_usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List AccesosBcp', 'url'=>array('index')),
	array('label'=>'Create AccesosBcp', 'url'=>array('create')),
	array('label'=>'View AccesosBcp', 'url'=>array('view', 'id'=>$model->id_usuario)),
	array('label'=>'Manage AccesosBcp', 'url'=>array('admin')),
);
?>

<h1>Update AccesosBcp <?php echo $model->id_usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>