<?php
/* @var $this ContactosAdministrativosController */
/* @var $model ContactosAdministrativos */

$this->breadcrumbs=array(
	'Contactos Administrativoses'=>array('index'),
	$model->id_contacto,
);

$this->menu=array(
	array('label'=>'List ContactosAdministrativos', 'url'=>array('index')),
	array('label'=>'Create ContactosAdministrativos', 'url'=>array('create')),
	array('label'=>'Update ContactosAdministrativos', 'url'=>array('update', 'id'=>$model->id_contacto)),
	array('label'=>'Delete ContactosAdministrativos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_contacto),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContactosAdministrativos', 'url'=>array('admin')),
);
?>

<h1>View ContactosAdministrativos #<?php echo $model->id_contacto; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_contacto',
		'nombre',
		'correo',
		'numero',
		'id_operadora',
		'estado',
	),
)); ?>
