<?php
/* @var $this ClienteAlarmasController */
/* @var $model ClienteAlarmas */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cliente-alarmas-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sc'); ?>
		<?php echo $form->textField($model,'sc',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cuota'); ?>
		<?php echo $form->textField($model,'cuota',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'cuota'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'burst'); ?>
		<?php echo $form->textField($model,'burst',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'burst'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'onoff'); ?>
		<?php echo $form->textField($model,'onoff'); ?>
		<?php echo $form->error($model,'onoff'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'segundos'); ?>
		<?php echo $form->textField($model,'segundos'); ?>
		<?php echo $form->error($model,'segundos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente_sms'); ?>
		<?php echo $form->textField($model,'id_cliente_sms'); ?>
		<?php echo $form->error($model,'id_cliente_sms'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contacto_del_cliente'); ?>
		<?php echo $form->textField($model,'contacto_del_cliente',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'contacto_del_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente_sc_numerico'); ?>
		<?php echo $form->textField($model,'id_cliente_sc_numerico'); ?>
		<?php echo $form->error($model,'id_cliente_sc_numerico'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->