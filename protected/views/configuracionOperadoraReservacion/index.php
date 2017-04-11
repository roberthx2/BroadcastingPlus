<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configuracion Operadora Reservacions',
);

$this->menu=array(
	array('label'=>'Create ConfiguracionOperadoraReservacion', 'url'=>array('create')),
	array('label'=>'Manage ConfiguracionOperadoraReservacion', 'url'=>array('admin')),
);
?>

<h1>Configuracion Operadora Reservacions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
