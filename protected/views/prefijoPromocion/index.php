<?php
/* @var $this PrefijoPromocionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Prefijo Promocions',
);

$this->menu=array(
	array('label'=>'Create PrefijoPromocion', 'url'=>array('create')),
	array('label'=>'Manage PrefijoPromocion', 'url'=>array('admin')),
);
?>

<h1>Prefijo Promocions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
