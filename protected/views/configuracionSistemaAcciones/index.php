<?php
/* @var $this ConfiguracionSistemaAccionesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configuracion Sistema Acciones',
);

$this->menu=array(
	array('label'=>'Create ConfiguracionSistemaAcciones', 'url'=>array('create')),
	array('label'=>'Manage ConfiguracionSistemaAcciones', 'url'=>array('admin')),
);
?>

<h1>Configuracion Sistema Acciones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
