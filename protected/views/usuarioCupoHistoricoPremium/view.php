<?php
/* @var $this UsuarioCupoHistoricoPremiumController */
/* @var $model UsuarioCupoHistoricoPremium */

$this->breadcrumbs=array(
	'Usuario Cupo Historico Premia'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UsuarioCupoHistoricoPremium', 'url'=>array('index')),
	array('label'=>'Create UsuarioCupoHistoricoPremium', 'url'=>array('create')),
	array('label'=>'Update UsuarioCupoHistoricoPremium', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UsuarioCupoHistoricoPremium', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UsuarioCupoHistoricoPremium', 'url'=>array('admin')),
);
?>

<h1>View UsuarioCupoHistoricoPremium #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_usuario',
		'id_cliente',
		'ejecutado_por',
		'cantidad',
		'descripcion',
		'fecha',
		'hora',
		'tipo_operacion',
	),
)); ?>
