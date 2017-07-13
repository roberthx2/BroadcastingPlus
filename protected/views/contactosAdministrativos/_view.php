<?php
/* @var $this ContactosAdministrativosController */
/* @var $data ContactosAdministrativos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_contacto')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_contacto), array('view', 'id'=>$data->id_contacto)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('correo')); ?>:</b>
	<?php echo CHtml::encode($data->correo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::encode($data->numero); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_operadora')); ?>:</b>
	<?php echo CHtml::encode($data->id_operadora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />


</div>