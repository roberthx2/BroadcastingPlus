<?php
/* @var $this ClientesBcpController */
/* @var $data ClientesBcp */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente_sms')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente_sms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sc')); ?>:</b>
	<?php echo CHtml::encode($data->sc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_operadora')); ?>:</b>
	<?php echo CHtml::encode($data->id_operadora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alfanumerico')); ?>:</b>
	<?php echo CHtml::encode($data->alfanumerico); ?>
	<br />


</div>