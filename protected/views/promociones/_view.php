<?php
/* @var $this PromocionesController */
/* @var $data Promociones */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_promo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_promo), array('view', 'id'=>$data->id_promo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombrePromo')); ?>:</b>
	<?php echo CHtml::encode($data->nombrePromo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cadena_usuarios')); ?>:</b>
	<?php echo CHtml::encode($data->cadena_usuarios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contenido')); ?>:</b>
	<?php echo CHtml::encode($data->contenido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora')); ?>:</b>
	<?php echo CHtml::encode($data->hora); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente')); ?>:</b>
	<?php echo CHtml::encode($data->cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verificado')); ?>:</b>
	<?php echo CHtml::encode($data->verificado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_dest_aceptados')); ?>:</b>
	<?php echo CHtml::encode($data->total_dest_aceptados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_dest_rechazados')); ?>:</b>
	<?php echo CHtml::encode($data->total_dest_rechazados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_dest_cargados')); ?>:</b>
	<?php echo CHtml::encode($data->total_dest_cargados); ?>
	<br />

	*/ ?>

</div>