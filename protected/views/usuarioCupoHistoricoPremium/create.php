<?php
/* @var $this UsuarioCupoHistoricoPremiumController */
/* @var $model UsuarioCupoHistoricoPremium */

$this->breadcrumbs=array(
	'Usuario Cupo Historico Premia'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UsuarioCupoHistoricoPremium', 'url'=>array('index')),
	array('label'=>'Manage UsuarioCupoHistoricoPremium', 'url'=>array('admin')),
);
?>

<h1>Create UsuarioCupoHistoricoPremium</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>