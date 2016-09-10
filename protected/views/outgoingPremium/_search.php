<?php
/* @var $this OutgoingPremiumController */
/* @var $model OutgoingPremium */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destinatario'); ?>
		<?php echo $form->textField($model,'destinatario',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mensaje'); ?>
		<?php echo $form->textField($model,'mensaje',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_in'); ?>
		<?php echo $form->textField($model,'fecha_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora_in'); ?>
		<?php echo $form->textField($model,'hora_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_out'); ?>
		<?php echo $form->textField($model,'fecha_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora_out'); ?>
		<?php echo $form->textField($model,'hora_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_evento'); ?>
		<?php echo $form->textField($model,'tipo_evento',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cliente'); ?>
		<?php echo $form->textField($model,'cliente',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'operadora'); ?>
		<?php echo $form->textField($model,'operadora',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_promo'); ?>
		<?php echo $form->textField($model,'id_promo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_insignia_alarmas'); ?>
		<?php echo $form->textField($model,'id_insignia_alarmas',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->