<?php
/* @var $this ModulosBcpController */
/* @var $model ModulosBcp */

$this->breadcrumbs=array(
	'Modulos Bcps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ModulosBcp', 'url'=>array('index')),
	array('label'=>'Create ModulosBcp', 'url'=>array('create')),
	array('label'=>'View ModulosBcp', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ModulosBcp', 'url'=>array('admin')),
);
?>

<h1>Update ModulosBcp <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>