<?php
/* @var $this DeadlineOutgoingPremiumController */
/* @var $model DeadlineOutgoingPremium */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'deadline-outgoing-premium-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_limite'); ?>
		<?php echo $form->textField($model,'fecha_limite'); ?>
		<?php echo $form->error($model,'fecha_limite'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora_limite'); ?>
		<?php echo $form->textField($model,'hora_limite'); ?>
		<?php echo $form->error($model,'hora_limite'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->