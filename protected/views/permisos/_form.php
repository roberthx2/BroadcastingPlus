<?php
/* @var $this PermisosController */
/* @var $model Permisos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'permisos-form',
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
		<?php echo $form->labelEx($model,'acceso_sistema'); ?>
		<?php echo $form->textField($model,'acceso_sistema',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'acceso_sistema'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'broadcasting'); ?>
		<?php echo $form->textField($model,'broadcasting',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'broadcasting'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'broadcasting_premium'); ?>
		<?php echo $form->textField($model,'broadcasting_premium',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'broadcasting_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'broadcasting_cpei'); ?>
		<?php echo $form->textField($model,'broadcasting_cpei',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'broadcasting_cpei'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_promocion'); ?>
		<?php echo $form->textField($model,'modulo_promocion',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_promocion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_promo_bcnl'); ?>
		<?php echo $form->textField($model,'crear_promo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_promo_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_promo_bcp'); ?>
		<?php echo $form->textField($model,'crear_promo_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_promo_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'detalles_promo_bcnl'); ?>
		<?php echo $form->textField($model,'detalles_promo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'detalles_promo_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'detalles_promo_bcp'); ?>
		<?php echo $form->textField($model,'detalles_promo_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'detalles_promo_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_listas'); ?>
		<?php echo $form->textField($model,'modulo_listas',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_listas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_listas'); ?>
		<?php echo $form->textField($model,'crear_listas',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_listas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_listas'); ?>
		<?php echo $form->textField($model,'administrar_listas',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_listas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_cupo'); ?>
		<?php echo $form->textField($model,'modulo_cupo',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_cupo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recargar_cupo_bcnl'); ?>
		<?php echo $form->textField($model,'recargar_cupo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'recargar_cupo_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recargar_cupo_bcp'); ?>
		<?php echo $form->textField($model,'recargar_cupo_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'recargar_cupo_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'historico_cupo_bcnl'); ?>
		<?php echo $form->textField($model,'historico_cupo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'historico_cupo_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'historico_cupo_bcp'); ?>
		<?php echo $form->textField($model,'historico_cupo_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'historico_cupo_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_exentos'); ?>
		<?php echo $form->textField($model,'modulo_exentos',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_exentos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agregar_exentos'); ?>
		<?php echo $form->textField($model,'agregar_exentos',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'agregar_exentos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_exentos'); ?>
		<?php echo $form->textField($model,'administrar_exentos',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_exentos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_reportes'); ?>
		<?php echo $form->textField($model,'modulo_reportes',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_reportes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_sms_programados_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_sms_programados_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_sms_programados_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_sms_programados_bcp'); ?>
		<?php echo $form->textField($model,'reporte_sms_programados_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_sms_programados_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_mensual_sms_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_mensual_sms_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_mensual_sms_bcp'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_mensual_sms_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_mensual_sms_por_cliente_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_por_cliente_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_mensual_sms_por_cliente_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_mensual_sms_por_cliente_bcp'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_por_cliente_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_mensual_sms_por_cliente_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_mensual_sms_por_codigo_bcp'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_por_codigo_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_mensual_sms_por_codigo_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_sms_recibidos_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_sms_recibidos_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_sms_recibidos_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_sms_recibidos_bcp'); ?>
		<?php echo $form->textField($model,'reporte_sms_recibidos_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_sms_recibidos_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_vigilancia_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_vigilancia_bcnl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_vigilancia_bcnl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reporte_vigilancia_bcp'); ?>
		<?php echo $form->textField($model,'reporte_vigilancia_bcp',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'reporte_vigilancia_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_administracion'); ?>
		<?php echo $form->textField($model,'modulo_administracion',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_administracion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_btl'); ?>
		<?php echo $form->textField($model,'modulo_btl',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_btl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo_herramientas'); ?>
		<?php echo $form->textField($model,'modulo_herramientas',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'modulo_herramientas'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_prefijo'); ?>
		<?php echo $form->textField($model,'administrar_prefijo',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_prefijo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->