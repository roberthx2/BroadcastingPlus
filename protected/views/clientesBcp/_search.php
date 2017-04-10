<?php
/* @var $this ClientesBcpController */
/* @var $model ClientesBcp */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_cliente_bcp'); ?>
		<?php echo $form->textField($model,'id_cliente_bcp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_cliente_sms'); ?>
		<?php echo $form->textField($model,'id_cliente_sms'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc'); ?>
		<?php echo $form->textField($model,'sc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_operadora'); ?>
		<?php echo $form->textField($model,'id_operadora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alfanumerico'); ?>
		<?php echo $form->textField($model,'alfanumerico'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->