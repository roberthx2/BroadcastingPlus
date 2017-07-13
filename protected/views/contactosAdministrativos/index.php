<?php
/* @var $this ContactosAdministrativosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contactos Administrativoses',
);

$this->menu=array(
	array('label'=>'Create ContactosAdministrativos', 'url'=>array('create')),
	array('label'=>'Manage ContactosAdministrativos', 'url'=>array('admin')),
);
?>

<h1>Contactos Administrativoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
