<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $model ConfiguracionOperadoraReservacion */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'configuracion-operadora-reservacion-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_operadora'); ?>
		<?php echo $form->textField($model,'id_operadora'); ?>
		<?php echo $form->error($model,'id_operadora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_x_seg'); ?>
		<?php echo $form->textField($model,'sms_x_seg'); ?>
		<?php echo $form->error($model,'sms_x_seg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'porcentaje_permitido'); ?>
		<?php echo $form->textField($model,'porcentaje_permitido'); ?>
		<?php echo $form->error($model,'porcentaje_permitido'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->