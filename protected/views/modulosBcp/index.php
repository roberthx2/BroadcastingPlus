<?php
/* @var $this ModulosBcpController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Modulos Bcps',
);

$this->menu=array(
	array('label'=>'Create ModulosBcp', 'url'=>array('create')),
	array('label'=>'Manage ModulosBcp', 'url'=>array('admin')),
);
?>

<h1>Modulos Bcps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
