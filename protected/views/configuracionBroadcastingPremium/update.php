<?php
/* @var $this ConfiguracionBroadcastingPremiumController */
/* @var $model ConfiguracionBroadcastingPremium */

$this->breadcrumbs=array(
	'Configuracion Broadcasting Premia'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConfiguracionBroadcastingPremium', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionBroadcastingPremium', 'url'=>array('create')),
	array('label'=>'View ConfiguracionBroadcastingPremium', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConfiguracionBroadcastingPremium', 'url'=>array('admin')),
);
?>

<h1>Update ConfiguracionBroadcastingPremium <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>