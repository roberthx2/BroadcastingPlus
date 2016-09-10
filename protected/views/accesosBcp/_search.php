<?php
/* @var $this AccesosBcpController */
/* @var $model AccesosBcp */
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
		<?php echo $form->label($model,'broadcasting_premium'); ?>
		<?php echo $form->textField($model,'broadcasting_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crear_promo_premium'); ?>
		<?php echo $form->textField($model,'crear_promo_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_detalles_premium'); ?>
		<?php echo $form->textField($model,'ver_detalles_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_reporte_premium'); ?>
		<?php echo $form->textField($model,'ver_reporte_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'generar_reporte_sms_recibidos_premium'); ?>
		<?php echo $form->textField($model,'generar_reporte_sms_recibidos_premium'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_sms_programados'); ?>
		<?php echo $form->textField($model,'ver_sms_programados'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_mensual_sms'); ?>
		<?php echo $form->textField($model,'ver_mensual_sms'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_mensual_sms_por_cliente'); ?>
		<?php echo $form->textField($model,'ver_mensual_sms_por_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_mensual_sms_por_codigo'); ?>
		<?php echo $form->textField($model,'ver_mensual_sms_por_codigo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_reporte_vigilancia'); ?>
		<?php echo $form->textField($model,'ver_reporte_vigilancia'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->