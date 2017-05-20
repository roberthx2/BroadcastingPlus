<?php
/* @var $this UsuarioSmsController */
/* @var $model UsuarioSms */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_usuario'); ?>
		<?php echo $form->textField($model,'id_usuario'); ?>
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
		<?php echo $form->label($model,'id_perfil'); ?>
		<?php echo $form->textField($model,'id_perfil'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_cliente'); ?>
		<?php echo $form->textField($model,'id_cliente',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_integ'); ?>
		<?php echo $form->textField($model,'id_integ',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email_u'); ?>
		<?php echo $form->textField($model,'email_u',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadena_sc'); ?>
		<?php echo $form->textArea($model,'cadena_sc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creado'); ?>
		<?php echo $form->textField($model,'creado',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadena_serv'); ?>
		<?php echo $form->textArea($model,'cadena_serv',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_masivo'); ?>
		<?php echo $form->textField($model,'acceso_masivo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_triviaweb'); ?>
		<?php echo $form->textField($model,'acceso_triviaweb',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadena_promo'); ?>
		<?php echo $form->textArea($model,'cadena_promo',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'edicion_clasificados'); ?>
		<?php echo $form->textField($model,'edicion_clasificados',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reportes_clasificados'); ?>
		<?php echo $form->textField($model,'reportes_clasificados',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_digitelstats'); ?>
		<?php echo $form->textField($model,'acceso_digitelstats',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadena_cintillo'); ?>
		<?php echo $form->textArea($model,'cadena_cintillo',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_admin'); ?>
		<?php echo $form->textField($model,'acceso_admin',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acceso_analisis'); ?>
		<?php echo $form->textField($model,'acceso_analisis'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ver_numero'); ?>
		<?php echo $form->textField($model,'ver_numero',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->