<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $model ConfiguracionOperadoraReservacion */

$this->breadcrumbs=array(
	'Configuracion Operadora Reservacions'=>array('index'),
	$model->id_operadora=>array('view','id'=>$model->id_operadora),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConfiguracionOperadoraReservacion', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionOperadoraReservacion', 'url'=>array('create')),
	array('label'=>'View ConfiguracionOperadoraReservacion', 'url'=>array('view', 'id'=>$model->id_operadora)),
	array('label'=>'Manage ConfiguracionOperadoraReservacion', 'url'=>array('admin')),
);
?>

<h1>Update ConfiguracionOperadoraReservacion <?php echo $model->id_operadora; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>