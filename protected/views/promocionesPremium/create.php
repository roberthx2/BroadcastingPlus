<?php
/* @var $this PromocionesPremiumController */
/* @var $model PromocionesPremium */

$this->breadcrumbs=array(
	'Promociones Premia'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PromocionesPremium', 'url'=>array('index')),
	array('label'=>'Manage PromocionesPremium', 'url'=>array('admin')),
);
?>

<h1>Create PromocionesPremium</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>