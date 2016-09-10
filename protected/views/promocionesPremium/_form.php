<?php
/* @var $this PromocionesPremiumController */
/* @var $model PromocionesPremium */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promociones-premium-form',
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
		<?php echo $form->textField($model,'nombrePromo',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombrePromo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente'); ?>
		<?php echo $form->textField($model,'id_cliente',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'id_cliente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'estado'); ?>
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
		<?php echo $form->labelEx($model,'loaded_by'); ?>
		<?php echo $form->textField($model,'loaded_by',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'loaded_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contenido'); ?>
		<?php echo $form->textField($model,'contenido',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'contenido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_cargada'); ?>
		<?php echo $form->textField($model,'fecha_cargada'); ?>
		<?php echo $form->error($model,'fecha_cargada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora_cargada'); ?>
		<?php echo $form->textField($model,'hora_cargada'); ?>
		<?php echo $form->error($model,'hora_cargada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verificada'); ?>
		<?php echo $form->textField($model,'verificada'); ?>
		<?php echo $form->error($model,'verificada'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->