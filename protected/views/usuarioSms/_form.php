<?php
/* @var $this UsuarioSmsController */
/* @var $model UsuarioSms */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-sms-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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
		<?php echo $form->labelEx($model,'id_perfil'); ?>
		<?php echo $form->textField($model,'id_perfil'); ?>
		<?php echo $form->error($model,'id_perfil'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente'); ?>
		<?php echo $form->textField($model,'id_cliente',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'id_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_integ'); ?>
		<?php echo $form->textField($model,'id_integ',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'id_integ'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_u'); ?>
		<?php echo $form->textField($model,'email_u',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email_u'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadena_sc'); ?>
		<?php echo $form->textArea($model,'cadena_sc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cadena_sc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creado'); ?>
		<?php echo $form->textField($model,'creado',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'creado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadena_serv'); ?>
		<?php echo $form->textArea($model,'cadena_serv',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cadena_serv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_masivo'); ?>
		<?php echo $form->textField($model,'acceso_masivo',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'acceso_masivo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_triviaweb'); ?>
		<?php echo $form->textField($model,'acceso_triviaweb',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'acceso_triviaweb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadena_promo'); ?>
		<?php echo $form->textArea($model,'cadena_promo',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cadena_promo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'edicion_clasificados'); ?>
		<?php echo $form->textField($model,'edicion_clasificados',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'edicion_clasificados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reportes_clasificados'); ?>
		<?php echo $form->textField($model,'reportes_clasificados',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reportes_clasificados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_digitelstats'); ?>
		<?php echo $form->textField($model,'acceso_digitelstats',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'acceso_digitelstats'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadena_cintillo'); ?>
		<?php echo $form->textArea($model,'cadena_cintillo',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cadena_cintillo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_admin'); ?>
		<?php echo $form->textField($model,'acceso_admin',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'acceso_admin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_analisis'); ?>
		<?php echo $form->textField($model,'acceso_analisis'); ?>
		<?php echo $form->error($model,'acceso_analisis'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_numero'); ?>
		<?php echo $form->textField($model,'ver_numero',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'ver_numero'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->