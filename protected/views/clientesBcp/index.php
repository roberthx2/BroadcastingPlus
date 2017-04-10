<?php
/* @var $this ClientesBcpController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Clientes Bcps',
);

$this->menu=array(
	array('label'=>'Create ClientesBcp', 'url'=>array('create')),
	array('label'=>'Manage ClientesBcp', 'url'=>array('admin')),
);
?>

<h1>Clientes Bcps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
