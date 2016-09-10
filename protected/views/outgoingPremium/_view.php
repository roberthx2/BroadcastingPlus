<?php
/* @var $this OutgoingPremiumController */
/* @var $data OutgoingPremium */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destinatario')); ?>:</b>
	<?php echo CHtml::encode($data->destinatario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mensaje')); ?>:</b>
	<?php echo CHtml::encode($data->mensaje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_in')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_in')); ?>:</b>
	<?php echo CHtml::encode($data->hora_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_out')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_out')); ?>:</b>
	<?php echo CHtml::encode($data->hora_out); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_evento')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_evento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('operadora')); ?>:</b>
	<?php echo CHtml::encode($data->operadora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_promo')); ?>:</b>
	<?php echo CHtml::encode($data->id_promo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_insignia_alarmas')); ?>:</b>
	<?php echo CHtml::encode($data->id_insignia_alarmas); ?>
	<br />

	*/ ?>

</div>