<?php
/* @var $this OutgoingPremiumController */
/* @var $model OutgoingPremium */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'outgoing-premium-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'destinatario'); ?>
		<?php echo $form->textField($model,'destinatario',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'destinatario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mensaje'); ?>
		<?php echo $form->textField($model,'mensaje',array('size'=>60,'maxlength'=>160)); ?>
		<?php echo $form->error($model,'mensaje'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_in'); ?>
		<?php echo $form->textField($model,'fecha_in'); ?>
		<?php echo $form->error($model,'fecha_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora_in'); ?>
		<?php echo $form->textField($model,'hora_in'); ?>
		<?php echo $form->error($model,'hora_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_out'); ?>
		<?php echo $form->textField($model,'fecha_out'); ?>
		<?php echo $form->error($model,'fecha_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora_out'); ?>
		<?php echo $form->textField($model,'hora_out'); ?>
		<?php echo $form->error($model,'hora_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo_evento'); ?>
		<?php echo $form->textField($model,'tipo_evento',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'tipo_evento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cliente'); ?>
		<?php echo $form->textField($model,'cliente',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'operadora'); ?>
		<?php echo $form->textField($model,'operadora',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'operadora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_promo'); ?>
		<?php echo $form->textField($model,'id_promo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'id_promo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_insignia_alarmas'); ?>
		<?php echo $form->textField($model,'id_insignia_alarmas',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'id_insignia_alarmas'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->