<?php
/* @var $this ConfiguracionBroadcastingPremiumController */
/* @var $model ConfiguracionBroadcastingPremium */

$this->breadcrumbs=array(
	'Configuracion Broadcasting Premia'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConfiguracionBroadcastingPremium', 'url'=>array('index')),
	array('label'=>'Manage ConfiguracionBroadcastingPremium', 'url'=>array('admin')),
);
?>

<h1>Create ConfiguracionBroadcastingPremium</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>