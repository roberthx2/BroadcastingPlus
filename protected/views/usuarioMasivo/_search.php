<?php
/* @var $this UsuarioMasivoController */
/* @var $model UsuarioMasivo */
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
		<?php echo $form->label($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pwd'); ?>
		<?php echo $form->textField($model,'pwd',array('size'=>60,'maxlength'=>90)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creado'); ?>
		<?php echo $form->textField($model,'creado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cupo_sms'); ?>
		<?php echo $form->textField($model,'cupo_sms',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_usados'); ?>
		<?php echo $form->textField($model,'sms_usados',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadena_promo'); ?>
		<?php echo $form->textArea($model,'cadena_promo',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_listas'); ?>
		<?php echo $form->textField($model,'acceso_listas',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadena_listas'); ?>
		<?php echo $form->textArea($model,'cadena_listas',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'puertos'); ?>
		<?php echo $form->textArea($model,'puertos',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_creado'); ?>
		<?php echo $form->textField($model,'fecha_creado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'puertos_de_respaldo'); ?>
		<?php echo $form->textField($model,'puertos_de_respaldo',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->