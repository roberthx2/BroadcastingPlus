<?php
/* @var $this ContactosAdministrativosController */
/* @var $model ContactosAdministrativos */
?>

<br>
<?php
    $flashMessages = Yii::app()->user->getFlashes();
    if ($flashMessages) {
        echo '<br><div class="container-fluid">';
        foreach($flashMessages as $key => $message) {
            echo '<div class="alert alert-'.$key.'">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<span class="glyphicon glyphicon-'. (($key == "success") ? "ok":"ban-circle").'"></span> '.$message;
        }
        echo '</div></div>';
    }
?>

<?php /** @var TbActiveForm $form */
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'contactos-administrativos-form',
			'type' => 'vertical',
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
	        			$("#boton_enviar").addClass("disabled");
		                return true;    
		            }
	            }'   
	        ),
		)
	); 
?>

<fieldset>
 
	<legend>Crear Contacto Administrativo</legend>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-lg-push-3">
		<div>
			<?php echo $form->textFieldGroup(
				$model,
				'nombre',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('maxlength' => 50, 'autocomplete' => 'off'), 
					),
					'prepend' => '<i class="glyphicon glyphicon-font"></i>'
				)
			); ?>
		</div>
		<div>
			<?php echo $form->textFieldGroup(
				$model,
				'correo',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('maxlength' => 50, 'autocomplete' => 'off', 'placeholder'=>'correo@example.com'),
					),
					'prepend' => '<i class="glyphicon glyphicon-envelope"></i>'
				)
			); ?>
		</div>
		<div>
			<?php echo $form->textFieldGroup(
				$model,
				'numero',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('maxlength' => 10, 'autocomplete' => 'off', 'placeholder'=>'416XXXXXXX'),
					),
					'prepend' => '<i class="glyphicon glyphicon-envelope"></i>'
				)
			); ?>
		</div>
	</div>

</fieldset>
<br><br>

<div class="form-actions col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<center>
	<?php 
		echo CHtml::tag('button', array('id'=>'boton_enviar', 'type'=>'submit', 'class'=>'btn btn-success'), '<i class="fa"></i> Crear'); ?>

	<?php
		$this->endWidget();
		unset($form);
	?>
	</center>
</div>