<?php
/* @var $this PalabrasObscenasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Palabras Obscenases',
);

$this->menu=array(
	array('label'=>'Create PalabrasObscenas', 'url'=>array('create')),
	array('label'=>'Manage PalabrasObscenas', 'url'=>array('admin')),
);
?>

<h1>Palabras Obscenases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
