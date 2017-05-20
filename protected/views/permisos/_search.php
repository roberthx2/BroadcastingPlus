<?php
/* @var $this PermisosController */
/* @var $model Permisos */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_usuario'); ?>
		<?php echo $form->textField($model,'id_usuario',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_sistema'); ?>
		<?php echo $form->textField($model,'acceso_sistema',array('size'=>10,'maxlength'=>10)); ?>
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
		<?php echo $form->label($model,'broadcasting_cpei'); ?>
		<?php echo $form->textField($model,'broadcasting_cpei',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_promocion'); ?>
		<?php echo $form->textField($model,'modulo_promocion',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_promo_bcnl'); ?>
		<?php echo $form->textField($model,'crear_promo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_promo_bcp'); ?>
		<?php echo $form->textField($model,'crear_promo_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'detalles_promo_bcnl'); ?>
		<?php echo $form->textField($model,'detalles_promo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'detalles_promo_bcp'); ?>
		<?php echo $form->textField($model,'detalles_promo_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_listas'); ?>
		<?php echo $form->textField($model,'modulo_listas',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_listas'); ?>
		<?php echo $form->textField($model,'crear_listas',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_listas'); ?>
		<?php echo $form->textField($model,'administrar_listas',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_cupo'); ?>
		<?php echo $form->textField($model,'modulo_cupo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recargar_cupo_bcnl'); ?>
		<?php echo $form->textField($model,'recargar_cupo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recargar_cupo_bcp'); ?>
		<?php echo $form->textField($model,'recargar_cupo_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'historico_cupo_bcnl'); ?>
		<?php echo $form->textField($model,'historico_cupo_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'historico_cupo_bcp'); ?>
		<?php echo $form->textField($model,'historico_cupo_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_exentos'); ?>
		<?php echo $form->textField($model,'modulo_exentos',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'agregar_exentos'); ?>
		<?php echo $form->textField($model,'agregar_exentos',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_exentos'); ?>
		<?php echo $form->textField($model,'administrar_exentos',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_reportes'); ?>
		<?php echo $form->textField($model,'modulo_reportes',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_sms_programados_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_sms_programados_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_sms_programados_bcp'); ?>
		<?php echo $form->textField($model,'reporte_sms_programados_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_mensual_sms_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_mensual_sms_bcp'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_mensual_sms_por_cliente_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_por_cliente_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_mensual_sms_por_cliente_bcp'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_por_cliente_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_mensual_sms_por_codigo_bcp'); ?>
		<?php echo $form->textField($model,'reporte_mensual_sms_por_codigo_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_sms_recibidos_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_sms_recibidos_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_sms_recibidos_bcp'); ?>
		<?php echo $form->textField($model,'reporte_sms_recibidos_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_vigilancia_bcnl'); ?>
		<?php echo $form->textField($model,'reporte_vigilancia_bcnl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reporte_vigilancia_bcp'); ?>
		<?php echo $form->textField($model,'reporte_vigilancia_bcp',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_administracion'); ?>
		<?php echo $form->textField($model,'modulo_administracion',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_btl'); ?>
		<?php echo $form->textField($model,'modulo_btl',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo_herramientas'); ?>
		<?php echo $form->textField($model,'modulo_herramientas',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'administrar_prefijo'); ?>
		<?php echo $form->textField($model,'administrar_prefijo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->