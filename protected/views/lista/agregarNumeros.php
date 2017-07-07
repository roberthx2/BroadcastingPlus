<?php
/* @var $this ListaController */
/* @var $model Lista */
/* @var $form CActiveForm */
?>

<?php if(Yii::app()->user->hasFlash('danger')):?>
	<br>
    <div class="container-fluid">
	      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	        <div class="alert alert-danger">
	          <button type="button" class="close" data-dismiss="alert">&times;</button>
	          <span class="glyphicon glyphicon-ban-circle"></span> <?php echo Yii::app()->user->getFlash('danger'); ?>
	        </div>
	      </div>
	    </div>
<?php endif; ?>

<div class="form col-xs-12 col-sm-12 col-md-10 col-lg-8" >

<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'lista-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));*/
$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'lista-form',
		'type' => 'horizontal',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
		'clientOptions' => array(
                'validateOnSubmit'=>true,
                'beforeValidateAttribute'=>'js:function(form, attribute){alert("working");}',   
            ),
	)
); ?>

	<fieldset> 
 
	<legend>Agregar Números</legend>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<div>
		<?php echo $form->textAreaGroup(
			$model,
			'numeros',
			array(
				'wrapperHtmlOptions' => array(
					//'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('class'=>'numerosTextarea', 'onKeyPress' => 'return processKeydown(event);', 'rows' => 10, 'placeholder'=>'4140000000,4240000000,4160000000,4260000000,4120000000'),
				)
			)
		); ?>
		<div style="float: right; font: bold 13px Arial;"><strong>Total: </strong>
				<?php echo CHTML::textField('total',0,array('size'=>2 ,'style'=>'margin-left:10px; border:0;', 'readonly' => true)); ?>
		</div>
	</div>
	</fieldset>
	<br><br>
	<div>
		<div class="col-xs-offset-4 col-sm-offset-10 col-md-offset-10 col-lg-offset-10">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
			<?php $this->widget(
					'booster.widgets.TbButton',
					array(
						'buttonType' => 'submit',
						'context' => 'success',
						'label' => 'Agregar',
					)
				); ?>
		</div>
	</div>

</div><!-- form -->
<?php $this->endWidget(); ?>