<?php
/* @var $this UsuarioSmsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuario Sms',
);

$this->menu=array(
	array('label'=>'Create UsuarioSms', 'url'=>array('create')),
	array('label'=>'Manage UsuarioSms', 'url'=>array('admin')),
);
?>

<h1>Usuario Sms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
