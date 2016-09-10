<?php
/* @var $this AccesosBcpController */
/* @var $data AccesosBcp */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_usuario), array('view', 'id'=>$data->id_usuario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broadcasting_premium')); ?>:</b>
	<?php echo CHtml::encode($data->broadcasting_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_promo_premium')); ?>:</b>
	<?php echo CHtml::encode($data->crear_promo_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_detalles_premium')); ?>:</b>
	<?php echo CHtml::encode($data->ver_detalles_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_reporte_premium')); ?>:</b>
	<?php echo CHtml::encode($data->ver_reporte_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('generar_reporte_sms_recibidos_premium')); ?>:</b>
	<?php echo CHtml::encode($data->generar_reporte_sms_recibidos_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_sms_programados')); ?>:</b>
	<?php echo CHtml::encode($data->ver_sms_programados); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_mensual_sms')); ?>:</b>
	<?php echo CHtml::encode($data->ver_mensual_sms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_mensual_sms_por_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->ver_mensual_sms_por_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_mensual_sms_por_codigo')); ?>:</b>
	<?php echo CHtml::encode($data->ver_mensual_sms_por_codigo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_reporte_vigilancia')); ?>:</b>
	<?php echo CHtml::encode($data->ver_reporte_vigilancia); ?>
	<br />

	*/ ?>

</div>