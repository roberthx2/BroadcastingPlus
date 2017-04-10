<?php
/* @var $this ClientesBcpController */
/* @var $model ClientesBcp */

$this->breadcrumbs=array(
	'Clientes Bcps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClientesBcp', 'url'=>array('index')),
	array('label'=>'Create ClientesBcp', 'url'=>array('create')),
	array('label'=>'View ClientesBcp', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClientesBcp', 'url'=>array('admin')),
);
?>

<h1>Update ClientesBcp <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>