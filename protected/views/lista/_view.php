<?php
/* @var $this ListaController */
/* @var $data Lista */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_lista')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_lista), array('view', 'id'=>$data->id_lista)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->id_usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />


</div>