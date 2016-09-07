<?php
/* @var $this UsuarioSmsController */
/* @var $data UsuarioSms */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_perfil')); ?>:</b>
	<?php echo CHtml::encode($data->id_perfil); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_integ')); ?>:</b>
	<?php echo CHtml::encode($data->id_integ); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_u')); ?>:</b>
	<?php echo CHtml::encode($data->email_u); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cadena_sc')); ?>:</b>
	<?php echo CHtml::encode($data->cadena_sc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creado')); ?>:</b>
	<?php echo CHtml::encode($data->creado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cadena_serv')); ?>:</b>
	<?php echo CHtml::encode($data->cadena_serv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_masivo')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_masivo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_triviaweb')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_triviaweb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cadena_promo')); ?>:</b>
	<?php echo CHtml::encode($data->cadena_promo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edicion_clasificados')); ?>:</b>
	<?php echo CHtml::encode($data->edicion_clasificados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reportes_clasificados')); ?>:</b>
	<?php echo CHtml::encode($data->reportes_clasificados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_digitelstats')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_digitelstats); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cadena_cintillo')); ?>:</b>
	<?php echo CHtml::encode($data->cadena_cintillo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_admin')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_admin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_analisis')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_analisis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_numero')); ?>:</b>
	<?php echo CHtml::encode($data->ver_numero); ?>
	<br />

	*/ ?>

</div>