<?php
/* @var $this PalabrasObscenasController */
/* @var $data PalabrasObscenas */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('palabra')); ?>:</b>
	<?php echo CHtml::encode($data->palabra); ?>
	<br />


</div>