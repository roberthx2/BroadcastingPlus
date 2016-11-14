<?php
/* @var $this PromocionesController */
/* @var $model Promociones */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promociones-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombrePromo'); ?>
		<?php echo $form->textField($model,'nombrePromo',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombrePromo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadena_usuarios'); ?>
		<?php echo $form->textArea($model,'cadena_usuarios',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cadena_usuarios'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contenido'); ?>
		<?php echo $form->textField($model,'contenido',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'contenido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora'); ?>
		<?php echo $form->textField($model,'hora'); ?>
		<?php echo $form->error($model,'hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cliente'); ?>
		<?php echo $form->textField($model,'cliente',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verificado'); ?>
		<?php echo $form->textField($model,'verificado'); ?>
		<?php echo $form->error($model,'verificado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_dest_aceptados'); ?>
		<?php echo $form->textField($model,'total_dest_aceptados'); ?>
		<?php echo $form->error($model,'total_dest_aceptados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_dest_rechazados'); ?>
		<?php echo $form->textField($model,'total_dest_rechazados'); ?>
		<?php echo $form->error($model,'total_dest_rechazados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_dest_cargados'); ?>
		<?php echo $form->textField($model,'total_dest_cargados'); ?>
		<?php echo $form->error($model,'total_dest_cargados'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->