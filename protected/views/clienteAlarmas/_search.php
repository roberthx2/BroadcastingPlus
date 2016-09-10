<?php
/* @var $this ClienteAlarmasController */
/* @var $model ClienteAlarmas */
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
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc'); ?>
		<?php echo $form->textField($model,'sc',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cuota'); ?>
		<?php echo $form->textField($model,'cuota',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'burst'); ?>
		<?php echo $form->textField($model,'burst',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'onoff'); ?>
		<?php echo $form->textField($model,'onoff'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'segundos'); ?>
		<?php echo $form->textField($model,'segundos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_cliente_sms'); ?>
		<?php echo $form->textField($model,'id_cliente_sms'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contacto_del_cliente'); ?>
		<?php echo $form->textField($model,'contacto_del_cliente',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_cliente_sc_numerico'); ?>
		<?php echo $form->textField($model,'id_cliente_sc_numerico'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->