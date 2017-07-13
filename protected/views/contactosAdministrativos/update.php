<?php
/* @var $this ContactosAdministrativosController */
/* @var $model ContactosAdministrativos */

$this->breadcrumbs=array(
	'Contactos Administrativoses'=>array('index'),
	$model->id_contacto=>array('view','id'=>$model->id_contacto),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContactosAdministrativos', 'url'=>array('index')),
	array('label'=>'Create ContactosAdministrativos', 'url'=>array('create')),
	array('label'=>'View ContactosAdministrativos', 'url'=>array('view', 'id'=>$model->id_contacto)),
	array('label'=>'Manage ContactosAdministrativos', 'url'=>array('admin')),
);
?>

<h1>Update ContactosAdministrativos <?php echo $model->id_contacto; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>