<?php
/* @var $this UsuarioMasivoController */
/* @var $model UsuarioMasivo */

$this->breadcrumbs=array(
	'Usuario Masivos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UsuarioMasivo', 'url'=>array('index')),
	array('label'=>'Manage UsuarioMasivo', 'url'=>array('admin')),
);
?>

<h1>Create UsuarioMasivo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>