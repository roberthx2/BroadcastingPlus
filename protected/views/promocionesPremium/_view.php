<?php
/* @var $this PromocionesPremiumController */
/* @var $data PromocionesPremium */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_promo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_promo), array('view', 'id'=>$data->id_promo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombrePromo')); ?>:</b>
	<?php echo CHtml::encode($data->nombrePromo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->id_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora')); ?>:</b>
	<?php echo CHtml::encode($data->hora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loaded_by')); ?>:</b>
	<?php echo CHtml::encode($data->loaded_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('contenido')); ?>:</b>
	<?php echo CHtml::encode($data->contenido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_cargada')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_cargada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_cargada')); ?>:</b>
	<?php echo CHtml::encode($data->hora_cargada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verificada')); ?>:</b>
	<?php echo CHtml::encode($data->verificada); ?>
	<br />

	*/ ?>

</div>