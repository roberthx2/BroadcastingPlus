<?php
/* @var $this DeadlineOutgoingPremiumController */
/* @var $model DeadlineOutgoingPremium */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_promo'); ?>
		<?php echo $form->textField($model,'id_promo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_limite'); ?>
		<?php echo $form->textField($model,'fecha_limite'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora_limite'); ?>
		<?php echo $form->textField($model,'hora_limite'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->