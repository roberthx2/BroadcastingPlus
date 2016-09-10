<?php
/* @var $this UsuarioMasivoController */
/* @var $model UsuarioMasivo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-masivo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_usuario'); ?>
		<?php echo $form->textField($model,'id_usuario',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'id_usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pwd'); ?>
		<?php echo $form->textField($model,'pwd',array('size'=>60,'maxlength'=>90)); ?>
		<?php echo $form->error($model,'pwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creado'); ?>
		<?php echo $form->textField($model,'creado'); ?>
		<?php echo $form->error($model,'creado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cupo_sms'); ?>
		<?php echo $form->textField($model,'cupo_sms',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'cupo_sms'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_usados'); ?>
		<?php echo $form->textField($model,'sms_usados',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'sms_usados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadena_promo'); ?>
		<?php echo $form->textArea($model,'cadena_promo',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cadena_promo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_listas'); ?>
		<?php echo $form->textField($model,'acceso_listas',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'acceso_listas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadena_listas'); ?>
		<?php echo $form->textArea($model,'cadena_listas',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cadena_listas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puertos'); ?>
		<?php echo $form->textArea($model,'puertos',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'puertos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_creado'); ?>
		<?php echo $form->textField($model,'fecha_creado'); ?>
		<?php echo $form->error($model,'fecha_creado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puertos_de_respaldo'); ?>
		<?php echo $form->textField($model,'puertos_de_respaldo',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'puertos_de_respaldo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->