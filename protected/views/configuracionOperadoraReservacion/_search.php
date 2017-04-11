<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $model ConfiguracionOperadoraReservacion */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_operadora'); ?>
		<?php echo $form->textField($model,'id_operadora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_x_seg'); ?>
		<?php echo $form->textField($model,'sms_x_seg'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'porcentaje_permitido'); ?>
		<?php echo $form->textField($model,'porcentaje_permitido'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->