<?php
/* @var $this ConfiguracionBroadcastingPremiumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configuracion Broadcasting Premia',
);

$this->menu=array(
	array('label'=>'Create ConfiguracionBroadcastingPremium', 'url'=>array('create')),
	array('label'=>'Manage ConfiguracionBroadcastingPremium', 'url'=>array('admin')),
);
?>

<h1>Configuracion Broadcasting Premia</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
