<?php
/* @var $this UsuarioMasivoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuario Masivos',
);

$this->menu=array(
	array('label'=>'Create UsuarioMasivo', 'url'=>array('create')),
	array('label'=>'Manage UsuarioMasivo', 'url'=>array('admin')),
);
?>

<h1>Usuario Masivos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
