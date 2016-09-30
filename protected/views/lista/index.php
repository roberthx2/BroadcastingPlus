<?php
/* @var $this ListaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Listas',
);

$this->menu=array(
	array('label'=>'Create Lista', 'url'=>array('create')),
	array('label'=>'Manage Lista', 'url'=>array('admin')),
);
?>

<h1>Listas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
