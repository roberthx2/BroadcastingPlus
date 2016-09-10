<?php
/* @var $this AccesosBcpController */
/* @var $model AccesosBcp */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accesos-bcp-form',
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
		<?php echo $form->labelEx($model,'broadcasting_premium'); ?>
		<?php echo $form->textField($model,'broadcasting_premium'); ?>
		<?php echo $form->error($model,'broadcasting_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_promo_premium'); ?>
		<?php echo $form->textField($model,'crear_promo_premium'); ?>
		<?php echo $form->error($model,'crear_promo_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_detalles_premium'); ?>
		<?php echo $form->textField($model,'ver_detalles_premium'); ?>
		<?php echo $form->error($model,'ver_detalles_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_reporte_premium'); ?>
		<?php echo $form->textField($model,'ver_reporte_premium'); ?>
		<?php echo $form->error($model,'ver_reporte_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'generar_reporte_sms_recibidos_premium'); ?>
		<?php echo $form->textField($model,'generar_reporte_sms_recibidos_premium'); ?>
		<?php echo $form->error($model,'generar_reporte_sms_recibidos_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_sms_programados'); ?>
		<?php echo $form->textField($model,'ver_sms_programados'); ?>
		<?php echo $form->error($model,'ver_sms_programados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_mensual_sms'); ?>
		<?php echo $form->textField($model,'ver_mensual_sms'); ?>
		<?php echo $form->error($model,'ver_mensual_sms'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_mensual_sms_por_cliente'); ?>
		<?php echo $form->textField($model,'ver_mensual_sms_por_cliente'); ?>
		<?php echo $form->error($model,'ver_mensual_sms_por_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_mensual_sms_por_codigo'); ?>
		<?php echo $form->textField($model,'ver_mensual_sms_por_codigo'); ?>
		<?php echo $form->error($model,'ver_mensual_sms_por_codigo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_reporte_vigilancia'); ?>
		<?php echo $form->textField($model,'ver_reporte_vigilancia'); ?>
		<?php echo $form->error($model,'ver_reporte_vigilancia'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->