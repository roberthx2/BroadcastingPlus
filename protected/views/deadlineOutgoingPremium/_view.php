<?php
/* @var $this DeadlineOutgoingPremiumController */
/* @var $data DeadlineOutgoingPremium */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_promo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_promo), array('view', 'id'=>$data->id_promo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_limite')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_limite); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_limite')); ?>:</b>
	<?php echo CHtml::encode($data->hora_limite); ?>
	<br />


</div>