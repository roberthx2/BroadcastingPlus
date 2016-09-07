<?php
/* @var $this UsuarioSmsController */
/* @var $model UsuarioSms */

$this->breadcrumbs=array(
	'Usuario Sms'=>array('index'),
	$model->id_usuario=>array('view','id'=>$model->id_usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List UsuarioSms', 'url'=>array('index')),
	array('label'=>'Create UsuarioSms', 'url'=>array('create')),
	array('label'=>'View UsuarioSms', 'url'=>array('view', 'id'=>$model->id_usuario)),
	array('label'=>'Manage UsuarioSms', 'url'=>array('admin')),
);
?>

<h1>Update UsuarioSms <?php echo $model->id_usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>