<?php
/* @var $this UsuarioMasivoController */
/* @var $model UsuarioMasivo */

$this->breadcrumbs=array(
	'Usuario Masivos'=>array('index'),
	$model->id_usuario,
);

$this->menu=array(
	array('label'=>'List UsuarioMasivo', 'url'=>array('index')),
	array('label'=>'Create UsuarioMasivo', 'url'=>array('create')),
	array('label'=>'Update UsuarioMasivo', 'url'=>array('update', 'id'=>$model->id_usuario)),
	array('label'=>'Delete UsuarioMasivo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_usuario),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UsuarioMasivo', 'url'=>array('admin')),
);
?>

<h1>View UsuarioMasivo #<?php echo $model->id_usuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_usuario',
		'login',
		'pwd',
		'creado',
		'cupo_sms',
		'sms_usados',
		'cadena_promo',
		'acceso_listas',
		'cadena_listas',
		'puertos',
		'fecha_creado',
		'puertos_de_respaldo',
	),
)); ?>
