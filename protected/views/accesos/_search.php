<?php
/* @var $this AccesosController */
/* @var $model Accesos */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_usuario'); ?>
		<?php echo $form->textField($model,'id_usuario',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_conciliacion'); ?>
		<?php echo $form->textField($model,'acceso_conciliacion',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_CRS'); ?>
		<?php echo $form->textField($model,'acceso_CRS',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_promo'); ?>
		<?php echo $form->textField($model,'crear_promo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_detalles'); ?>
		<?php echo $form->textField($model,'ver_detalles',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_destinatarios'); ?>
		<?php echo $form->textField($model,'ver_destinatarios',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_enviados'); ?>
		<?php echo $form->textField($model,'sms_enviados',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_lista'); ?>
		<?php echo $form->textField($model,'crear_lista',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_lista'); ?>
		<?php echo $form->textField($model,'ver_lista',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'editar_lista'); ?>
		<?php echo $form->textField($model,'editar_lista',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'editar_detalles'); ?>
		<?php echo $form->textField($model,'editar_detalles',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'editar_destinatarios'); ?>
		<?php echo $form->textField($model,'editar_destinatarios',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_prog'); ?>
		<?php echo $form->textField($model,'sms_prog',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_not'); ?>
		<?php echo $form->textField($model,'crear_not',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_not'); ?>
		<?php echo $form->textField($model,'ver_not',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'agregar_exen'); ?>
		<?php echo $form->textField($model,'agregar_exen',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_exen'); ?>
		<?php echo $form->textField($model,'ver_exen',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eliminar_exen'); ?>
		<?php echo $form->textField($model,'eliminar_exen',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'num_cruzados'); ?>
		<?php echo $form->textField($model,'num_cruzados',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_accesos'); ?>
		<?php echo $form->textField($model,'admin_accesos',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_puertos_usuario'); ?>
		<?php echo $form->textField($model,'admin_puertos_usuario',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_puertos_ver'); ?>
		<?php echo $form->textField($model,'admin_puertos_ver',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_puertos_crear'); ?>
		<?php echo $form->textField($model,'admin_puertos_crear',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_puertos_editar'); ?>
		<?php echo $form->textField($model,'admin_puertos_editar',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_puertos_eliminar'); ?>
		<?php echo $form->textField($model,'admin_puertos_eliminar',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_cupo'); ?>
		<?php echo $form->textField($model,'admin_cupo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_prefijos_ver'); ?>
		<?php echo $form->textField($model,'admin_prefijos_ver',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_prefijos_editar'); ?>
		<?php echo $form->textField($model,'admin_prefijos_editar',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_prefijos_eliminar'); ?>
		<?php echo $form->textField($model,'admin_prefijos_eliminar',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_recibidos'); ?>
		<?php echo $form->textField($model,'sms_recibidos',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_exentos_propuestos'); ?>
		<?php echo $form->textField($model,'administrar_exentos_propuestos',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_enviados_por_cliente'); ?>
		<?php echo $form->textField($model,'sms_enviados_por_cliente',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_promo_personalizada'); ?>
		<?php echo $form->textField($model,'crear_promo_personalizada',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_pruebas_modems'); ?>
		<?php echo $form->textField($model,'admin_pruebas_modems',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_modem_sin_saldo'); ?>
		<?php echo $form->textField($model,'administrar_modem_sin_saldo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_reasignar_puertos_por_promo'); ?>
		<?php echo $form->textField($model,'administrar_reasignar_puertos_por_promo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_reporte_vigilancia'); ?>
		<?php echo $form->textField($model,'administrar_reporte_vigilancia',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_terminos_condiciones'); ?>
		<?php echo $form->textField($model,'administrar_terminos_condiciones',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_aprobar_promocion'); ?>
		<?php echo $form->textField($model,'administrar_aprobar_promocion',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_operadoras'); ?>
		<?php echo $form->textField($model,'administrar_operadoras',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'habilitar_modem_inactivos'); ?>
		<?php echo $form->textField($model,'habilitar_modem_inactivos',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'generar_reporte_sms_recibidos'); ?>
		<?php echo $form->textField($model,'generar_reporte_sms_recibidos',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'broadcasting'); ?>
		<?php echo $form->textField($model,'broadcasting',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'broadcasting_premium'); ?>
		<?php echo $form->textField($model,'broadcasting_premium',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_promo_premium'); ?>
		<?php echo $form->textField($model,'crear_promo_premium',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_detalles_premium'); ?>
		<?php echo $form->textField($model,'ver_detalles_premium',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_reporte_premium'); ?>
		<?php echo $form->textField($model,'ver_reporte_premium',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'generar_reporte_sms_recibidos_premium'); ?>
		<?php echo $form->textField($model,'generar_reporte_sms_recibidos_premium',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'broadcasting_lite'); ?>
		<?php echo $form->textField($model,'broadcasting_lite',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_promo_lite'); ?>
		<?php echo $form->textField($model,'crear_promo_lite',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reactivar_promo'); ?>
		<?php echo $form->textField($model,'reactivar_promo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_en_suspension'); ?>
		<?php echo $form->textField($model,'acceso_en_suspension',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->