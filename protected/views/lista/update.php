<?php
/* @var $this ListaController */
/* @var $model Lista */

$this->breadcrumbs=array(
	'Listas'=>array('index'),
	$model->id_lista=>array('view','id'=>$model->id_lista),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lista', 'url'=>array('index')),
	array('label'=>'Create Lista', 'url'=>array('create')),
	array('label'=>'View Lista', 'url'=>array('view', 'id'=>$model->id_lista)),
	array('label'=>'Manage Lista', 'url'=>array('admin')),
);
?>

<h1>Update Lista <?php echo $model->id_lista; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>