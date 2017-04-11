<?php
/* @var $this ConfiguracionSmsPorDiaController */
/* @var $data ConfiguracionSmsPorDia */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_dia')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_dia), array('view', 'id'=>$data->id_dia)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />


</div>