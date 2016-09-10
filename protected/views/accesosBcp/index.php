<?php
/* @var $this AccesosBcpController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accesos Bcps',
);

$this->menu=array(
	array('label'=>'Create AccesosBcp', 'url'=>array('create')),
	array('label'=>'Manage AccesosBcp', 'url'=>array('admin')),
);
?>

<h1>Accesos Bcps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
