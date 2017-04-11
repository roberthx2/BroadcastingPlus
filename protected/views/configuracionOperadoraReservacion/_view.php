<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $data ConfiguracionOperadoraReservacion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_operadora')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_operadora), array('view', 'id'=>$data->id_operadora)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_x_seg')); ?>:</b>
	<?php echo CHtml::encode($data->sms_x_seg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('porcentaje_permitido')); ?>:</b>
	<?php echo CHtml::encode($data->porcentaje_permitido); ?>
	<br />


</div>