<?php
/* @var $this AccesosController */
/* @var $model Accesos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accesos-form',
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
		<?php echo $form->textField($model,'id_usuario',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'id_usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_conciliacion'); ?>
		<?php echo $form->textField($model,'acceso_conciliacion',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'acceso_conciliacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_CRS'); ?>
		<?php echo $form->textField($model,'acceso_CRS',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'acceso_CRS'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_promo'); ?>
		<?php echo $form->textField($model,'crear_promo',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_promo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_detalles'); ?>
		<?php echo $form->textField($model,'ver_detalles',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'ver_detalles'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_destinatarios'); ?>
		<?php echo $form->textField($model,'ver_destinatarios',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'ver_destinatarios'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_enviados'); ?>
		<?php echo $form->textField($model,'sms_enviados',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'sms_enviados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_lista'); ?>
		<?php echo $form->textField($model,'crear_lista',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_lista'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_lista'); ?>
		<?php echo $form->textField($model,'ver_lista',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'ver_lista'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'editar_lista'); ?>
		<?php echo $form->textField($model,'editar_lista',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'editar_lista'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'editar_detalles'); ?>
		<?php echo $form->textField($model,'editar_detalles',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'editar_detalles'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'editar_destinatarios'); ?>
		<?php echo $form->textField($model,'editar_destinatarios',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'editar_destinatarios'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_prog'); ?>
		<?php echo $form->textField($model,'sms_prog',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'sms_prog'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_not'); ?>
		<?php echo $form->textField($model,'crear_not',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_not'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_not'); ?>
		<?php echo $form->textField($model,'ver_not',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'ver_not'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agregar_exen'); ?>
		<?php echo $form->textField($model,'agregar_exen',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'agregar_exen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_exen'); ?>
		<?php echo $form->textField($model,'ver_exen',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'ver_exen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eliminar_exen'); ?>
		<?php echo $form->textField($model,'eliminar_exen',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'eliminar_exen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_cruzados'); ?>
		<?php echo $form->textField($model,'num_cruzados',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'num_cruzados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_accesos'); ?>
		<?php echo $form->textField($model,'admin_accesos',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_accesos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_puertos_usuario'); ?>
		<?php echo $form->textField($model,'admin_puertos_usuario',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_puertos_usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_puertos_ver'); ?>
		<?php echo $form->textField($model,'admin_puertos_ver',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_puertos_ver'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_puertos_crear'); ?>
		<?php echo $form->textField($model,'admin_puertos_crear',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_puertos_crear'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_puertos_editar'); ?>
		<?php echo $form->textField($model,'admin_puertos_editar',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_puertos_editar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_puertos_eliminar'); ?>
		<?php echo $form->textField($model,'admin_puertos_eliminar',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_puertos_eliminar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_cupo'); ?>
		<?php echo $form->textField($model,'admin_cupo',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_cupo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_prefijos_ver'); ?>
		<?php echo $form->textField($model,'admin_prefijos_ver',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_prefijos_ver'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_prefijos_editar'); ?>
		<?php echo $form->textField($model,'admin_prefijos_editar',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_prefijos_editar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_prefijos_eliminar'); ?>
		<?php echo $form->textField($model,'admin_prefijos_eliminar',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_prefijos_eliminar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_recibidos'); ?>
		<?php echo $form->textField($model,'sms_recibidos',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'sms_recibidos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_exentos_propuestos'); ?>
		<?php echo $form->textField($model,'administrar_exentos_propuestos',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_exentos_propuestos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_enviados_por_cliente'); ?>
		<?php echo $form->textField($model,'sms_enviados_por_cliente',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'sms_enviados_por_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_promo_personalizada'); ?>
		<?php echo $form->textField($model,'crear_promo_personalizada',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_promo_personalizada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_pruebas_modems'); ?>
		<?php echo $form->textField($model,'admin_pruebas_modems',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'admin_pruebas_modems'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_modem_sin_saldo'); ?>
		<?php echo $form->textField($model,'administrar_modem_sin_saldo',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_modem_sin_saldo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_reasignar_puertos_por_promo'); ?>
		<?php echo $form->textField($model,'administrar_reasignar_puertos_por_promo',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_reasignar_puertos_por_promo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_reporte_vigilancia'); ?>
		<?php echo $form->textField($model,'administrar_reporte_vigilancia',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_reporte_vigilancia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_terminos_condiciones'); ?>
		<?php echo $form->textField($model,'administrar_terminos_condiciones',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_terminos_condiciones'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_aprobar_promocion'); ?>
		<?php echo $form->textField($model,'administrar_aprobar_promocion',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_aprobar_promocion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'administrar_operadoras'); ?>
		<?php echo $form->textField($model,'administrar_operadoras',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'administrar_operadoras'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'habilitar_modem_inactivos'); ?>
		<?php echo $form->textField($model,'habilitar_modem_inactivos',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'habilitar_modem_inactivos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'generar_reporte_sms_recibidos'); ?>
		<?php echo $form->textField($model,'generar_reporte_sms_recibidos',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'generar_reporte_sms_recibidos'); ?>
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
		<?php echo $form->labelEx($model,'crear_promo_premium'); ?>
		<?php echo $form->textField($model,'crear_promo_premium',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_promo_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_detalles_premium'); ?>
		<?php echo $form->textField($model,'ver_detalles_premium',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'ver_detalles_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ver_reporte_premium'); ?>
		<?php echo $form->textField($model,'ver_reporte_premium',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'ver_reporte_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'generar_reporte_sms_recibidos_premium'); ?>
		<?php echo $form->textField($model,'generar_reporte_sms_recibidos_premium',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'generar_reporte_sms_recibidos_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'broadcasting_lite'); ?>
		<?php echo $form->textField($model,'broadcasting_lite',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'broadcasting_lite'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crear_promo_lite'); ?>
		<?php echo $form->textField($model,'crear_promo_lite',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'crear_promo_lite'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reactivar_promo'); ?>
		<?php echo $form->textField($model,'reactivar_promo'); ?>
		<?php echo $form->error($model,'reactivar_promo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acceso_en_suspension'); ?>
		<?php echo $form->textField($model,'acceso_en_suspension',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'acceso_en_suspension'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->