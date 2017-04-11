<?php
/* @var $this ConfiguracionSmsPorDiaController */
/* @var $model ConfiguracionSmsPorDia */

$this->breadcrumbs=array(
	'Configuracion Sms Por Dias'=>array('index'),
	$model->id_dia=>array('view','id'=>$model->id_dia),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConfiguracionSmsPorDia', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionSmsPorDia', 'url'=>array('create')),
	array('label'=>'View ConfiguracionSmsPorDia', 'url'=>array('view', 'id'=>$model->id_dia)),
	array('label'=>'Manage ConfiguracionSmsPorDia', 'url'=>array('admin')),
);
?>

<h1>Update ConfiguracionSmsPorDia <?php echo $model->id_dia; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>