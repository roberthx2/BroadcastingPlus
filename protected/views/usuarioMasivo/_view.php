<?php
/* @var $this UsuarioMasivoController */
/* @var $data UsuarioMasivo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_usuario), array('view', 'id'=>$data->id_usuario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login')); ?>:</b>
	<?php echo CHtml::encode($data->login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pwd')); ?>:</b>
	<?php echo CHtml::encode($data->pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creado')); ?>:</b>
	<?php echo CHtml::encode($data->creado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cupo_sms')); ?>:</b>
	<?php echo CHtml::encode($data->cupo_sms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_usados')); ?>:</b>
	<?php echo CHtml::encode($data->sms_usados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cadena_promo')); ?>:</b>
	<?php echo CHtml::encode($data->cadena_promo); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_listas')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_listas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cadena_listas')); ?>:</b>
	<?php echo CHtml::encode($data->cadena_listas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('puertos')); ?>:</b>
	<?php echo CHtml::encode($data->puertos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_creado')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_creado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('puertos_de_respaldo')); ?>:</b>
	<?php echo CHtml::encode($data->puertos_de_respaldo); ?>
	<br />

	*/ ?>

</div>