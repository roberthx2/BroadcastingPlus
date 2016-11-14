<?php
/* @var $this PromocionesController */
/* @var $model Promociones */
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
		<?php echo $form->label($model,'nombrePromo'); ?>
		<?php echo $form->textField($model,'nombrePromo',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadena_usuarios'); ?>
		<?php echo $form->textArea($model,'cadena_usuarios',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contenido'); ?>
		<?php echo $form->textField($model,'contenido',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora'); ?>
		<?php echo $form->textField($model,'hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cliente'); ?>
		<?php echo $form->textField($model,'cliente',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'verificado'); ?>
		<?php echo $form->textField($model,'verificado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_dest_aceptados'); ?>
		<?php echo $form->textField($model,'total_dest_aceptados'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_dest_rechazados'); ?>
		<?php echo $form->textField($model,'total_dest_rechazados'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_dest_cargados'); ?>
		<?php echo $form->textField($model,'total_dest_cargados'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->