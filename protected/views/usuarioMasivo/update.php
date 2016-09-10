<?php
/* @var $this UsuarioMasivoController */
/* @var $model UsuarioMasivo */

$this->breadcrumbs=array(
	'Usuario Masivos'=>array('index'),
	$model->id_usuario=>array('view','id'=>$model->id_usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List UsuarioMasivo', 'url'=>array('index')),
	array('label'=>'Create UsuarioMasivo', 'url'=>array('create')),
	array('label'=>'View UsuarioMasivo', 'url'=>array('view', 'id'=>$model->id_usuario)),
	array('label'=>'Manage UsuarioMasivo', 'url'=>array('admin')),
);
?>

<h1>Update UsuarioMasivo <?php echo $model->id_usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>