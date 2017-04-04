<?php
/* @var $this ConfiguracionSistemaAccionesController */
/* @var $model ConfiguracionSistemaAcciones */

$this->breadcrumbs=array(
	'Configuracion Sistema Acciones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConfiguracionSistemaAcciones', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionSistemaAcciones', 'url'=>array('create')),
	array('label'=>'View ConfiguracionSistemaAcciones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConfiguracionSistemaAcciones', 'url'=>array('admin')),
);
?>

<h1>Update ConfiguracionSistemaAcciones <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>