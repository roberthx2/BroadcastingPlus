<?php
/* @var $this ConfiguracionSmsPorDiaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configuracion Sms Por Dias',
);

$this->menu=array(
	array('label'=>'Create ConfiguracionSmsPorDia', 'url'=>array('create')),
	array('label'=>'Manage ConfiguracionSmsPorDia', 'url'=>array('admin')),
);
?>

<h1>Configuracion Sms Por Dias</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
