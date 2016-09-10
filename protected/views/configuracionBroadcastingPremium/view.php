<?php
/* @var $this ConfiguracionBroadcastingPremiumController */
/* @var $model ConfiguracionBroadcastingPremium */

$this->breadcrumbs=array(
	'Configuracion Broadcasting Premia'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConfiguracionBroadcastingPremium', 'url'=>array('index')),
	array('label'=>'Create ConfiguracionBroadcastingPremium', 'url'=>array('create')),
	array('label'=>'Update ConfiguracionBroadcastingPremium', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConfiguracionBroadcastingPremium', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConfiguracionBroadcastingPremium', 'url'=>array('admin')),
);
?>

<h1>View ConfiguracionBroadcastingPremium #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'propiedad',
		'valor',
		'descripcion',
	),
)); ?>
