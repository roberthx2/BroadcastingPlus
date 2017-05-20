<?php
/* @var $this PermisosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Permisoses',
);

$this->menu=array(
	array('label'=>'Create Permisos', 'url'=>array('create')),
	array('label'=>'Manage Permisos', 'url'=>array('admin')),
);
?>

<h1>Permisoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
