<?php
/* @var $this UsuarioSmsController */
/* @var $model UsuarioSms */

$this->breadcrumbs=array(
	'Usuario Sms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UsuarioSms', 'url'=>array('index')),
	array('label'=>'Manage UsuarioSms', 'url'=>array('admin')),
);
?>

<h1>Create UsuarioSms</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>