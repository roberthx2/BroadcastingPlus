<?php
/* @var $this AccesosController */
/* @var $model Accesos */

$this->breadcrumbs=array(
	'Accesoses'=>array('index'),
	$model->id_usuario=>array('view','id'=>$model->id_usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List Accesos', 'url'=>array('index')),
	array('label'=>'Create Accesos', 'url'=>array('create')),
	array('label'=>'View Accesos', 'url'=>array('view', 'id'=>$model->id_usuario)),
	array('label'=>'Manage Accesos', 'url'=>array('admin')),
);
?>

<h1>Update Accesos <?php echo $model->id_usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>