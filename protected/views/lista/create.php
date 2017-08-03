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
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
            'validateOnType'=>false,
            'afterValidate' => 'js:function(form, data, hasError){
                $.each(data, function(index, value) { 
                    if(index != "__proto"){
                        var temp = data[index][0];   
                        $("#"+index+"_em_").html("<li>"+temp+"</li>");
                    }
                });

	            if(!hasError)
	            {
	            	$("#boton_enviar i.fa").addClass("fa-spinner").addClass("fa-spin");
	            	$("#botonBTL").addClass("disabled");
        			$("#boton_enviar").addClass("disabled");
	                return true;    
	            }
            }'   
        ),
	)
); ?>
	
	<fieldset>
 
	<legend>Crear Lista</legend>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php if (Yii::app()->user->isAdmin()){ ?>

		<?php
			$criteria = new CDbcriteria;
			$criteria->select = "t.id_usuario, t.login";
			$criteria->join = "INNER JOIN insignia_masivo_premium.permisos p ON t.id_usuario = p.id_usuario";
			$criteria->compare("p.acceso_sistema", 1);
			$criteria->order = "login ASC";
		?>
		<div>
			<?php echo $form->dropDownListGroup(
				$model,
				'id_usuario',
				array(
					'wrapperHtmlOptions' => array(
						//'class' => 'col-sm-5',
					),
					'widgetOptions' => array(
						//'data' => CHtml::listData(UsuarioMasivo::model()->findAll(array("order"=>"login")), 'id_usuario', 'login'),
						'data' => CHtml::listData(UsuarioMasivo::model()->findAll($criteria), 'id_usuario', 'login'),
						'htmlOptions' => array('prompt' => 'Seleccionar...'),
					),
					'prepend' => '<i class="glyphicon glyphicon-user"></i>',
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
					),
					'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
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
					'htmlOptions' => array('class'=>'numerosTextarea', 'onKeyPress' => 'return processKeydown(event);', 'rows' => 10, 'placeholder'=>'4140000000,4240000000,4160000000,4260000000,4120000000'),
				),
				'prepend' => '<i class="glyphicon glyphicon-phone"></i>'
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
		<?php 
			echo CHtml::tag('button', array('id'=>'boton_enviar', 'type'=>'submit', 'class'=>'btn btn-success'), '<i class="fa"></i> Crear Lista'); ?>
		</div>
	</div>

</div><!-- form -->
<?php $this->endWidget(); ?>