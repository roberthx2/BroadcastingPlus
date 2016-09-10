<?php
/* @var $this PromocionesPremiumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Promociones Premia',
);

$this->menu=array(
	array('label'=>'Create PromocionesPremium', 'url'=>array('create')),
	array('label'=>'Manage PromocionesPremium', 'url'=>array('admin')),
);
?>

<h1>Promociones Premia</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
