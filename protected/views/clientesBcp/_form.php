<?php
/* @var $this ClientesBcpController */
/* @var $model ClientesBcp */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clientes-bcp-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente_bcp'); ?>
		<?php echo $form->textField($model,'id_cliente_bcp'); ?>
		<?php echo $form->error($model,'id_cliente_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente_sms'); ?>
		<?php echo $form->textField($model,'id_cliente_sms'); ?>
		<?php echo $form->error($model,'id_cliente_sms'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sc'); ?>
		<?php echo $form->textField($model,'sc'); ?>
		<?php echo $form->error($model,'sc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_operadora'); ?>
		<?php echo $form->textField($model,'id_operadora'); ?>
		<?php echo $form->error($model,'id_operadora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alfanumerico'); ?>
		<?php echo $form->textField($model,'alfanumerico'); ?>
		<?php echo $form->error($model,'alfanumerico'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->