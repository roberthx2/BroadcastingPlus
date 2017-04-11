<?php
/* @var $this ConfiguracionReservacionPorDiaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configuracion Reservacion Por Dias',
);

$this->menu=array(
	array('label'=>'Create ConfiguracionReservacionPorDia', 'url'=>array('create')),
	array('label'=>'Manage ConfiguracionReservacionPorDia', 'url'=>array('admin')),
);
?>

<h1>Configuracion Reservacion Por Dias</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
