<?php
/* @var $this PalabrasObscenasController */
/* @var $model PalabrasObscenas */

$this->breadcrumbs=array(
	'Palabras Obscenases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PalabrasObscenas', 'url'=>array('index')),
	array('label'=>'Create PalabrasObscenas', 'url'=>array('create')),
	array('label'=>'View PalabrasObscenas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PalabrasObscenas', 'url'=>array('admin')),
);
?>

<h1>Update PalabrasObscenas <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>