<?php
/* @var $this UsuarioCupoHistoricoPremiumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuario Cupo Historico Premia',
);

$this->menu=array(
	array('label'=>'Create UsuarioCupoHistoricoPremium', 'url'=>array('create')),
	array('label'=>'Manage UsuarioCupoHistoricoPremium', 'url'=>array('admin')),
);
?>

<h1>Usuario Cupo Historico Premia</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
