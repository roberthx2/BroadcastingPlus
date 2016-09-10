<?php
/* @var $this AccesosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accesoses',
);

$this->menu=array(
	array('label'=>'Create Accesos', 'url'=>array('create')),
	array('label'=>'Manage Accesos', 'url'=>array('admin')),
);
?>

<h1>Accesoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
