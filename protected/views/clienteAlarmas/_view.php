<?php
/* @var $this ClienteAlarmasController */
/* @var $data ClienteAlarmas */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sc')); ?>:</b>
	<?php echo CHtml::encode($data->sc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuota')); ?>:</b>
	<?php echo CHtml::encode($data->cuota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('burst')); ?>:</b>
	<?php echo CHtml::encode($data->burst); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('onoff')); ?>:</b>
	<?php echo CHtml::encode($data->onoff); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('segundos')); ?>:</b>
	<?php echo CHtml::encode($data->segundos); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente_sms')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente_sms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contacto_del_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->contacto_del_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente_sc_numerico')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente_sc_numerico); ?>
	<br />

	*/ ?>

</div>