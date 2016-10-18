<?php
/* @var $this ListaController */
/* @var $model Lista */
/* @var $form CActiveForm */
?>

<?php if(Yii::app()->user->hasFlash('danger')):?>
	<br>
    <div class="container-fluid">
	        <div class="alert alert-danger">
	          <button type="button" class="close" data-dismiss="alert">&times;</button>
	          <span class="glyphicon glyphicon-ban-circle"></span> <?php echo Yii::app()->user->getFlash('danger'); ?>
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
	)
); ?>

	<h2>Crear Lista</h2>
	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php if (Yii::app()->user->isAdmin()){ ?>
		<div>
			<?php echo $form->dropDownListGroup(
				$model,
				'id_usuario',
				array(
					'wrapperHtmlOptions' => array(
						//'class' => 'col-sm-5',
					),
					'widgetOptions' => array(
						'data' => CHtml::listData(UsuarioMasivo::model()->findAll(array("order"=>"login")), 'id_usuario', 'login'),
						'htmlOptions' => array('prompt' => 'Seleccionar...'),
					),
					'hint' => 'En caso de seleccionar un usuario, la lista sera asociada a dicho usuario',
				)
			); ?>
		</div>
	<?php } ?>

	<div>
		<?php echo $form->textFieldGroup(
				$model,
				'nombre',
				array(
					'wrapperHtmlOptions' => array(
						'placeholder' => 'Nombre de la lista',
						//'class' => 'col-sm-5',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('placeholder' => 'Nombre de la lista', 'autocomplete'=>'off'),
					)
				)
			); ?>
	</div>

	<div>
		<?php echo $form->textAreaGroup(
			$model,
			'numeros',
			array(
				'wrapperHtmlOptions' => array(
					//'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 10, 'placeholder'=>'4140000000,4240000000,4160000000,4260000000,4120000000'),
				)
			)
		); ?>
	</div>

	<div>
		<div class="col-xs-offset-4 col-sm-offset-10 col-md-offset-10 col-lg-offset-10">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
			<?php $this->widget(
					'booster.widgets.TbButton',
					array(
						'buttonType' => 'submit',
						'context' => 'primary',
						'label' => 'Crear Lista',
					)
				); ?>
		</div>
	</div>

</div><!-- form -->
<?php $this->endWidget(); ?>