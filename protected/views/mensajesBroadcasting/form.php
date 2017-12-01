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
			'id' => 'mensaje-broadcasting-form',
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
 
	<legend>Crear Mensaje de Suspensión</legend>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<div>
		<?php echo $form->radioButtonListGroup(
			$model,
			'tipo_mensaje',
			array(
				'widgetOptions' => array(
					'data' => array(
						1=>' Periodo',
						2=>' Diario',
						3=>' Personalizado',
					)
				),
				'inline'=>true
			)
		); ?>
	</div>
	<div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->textFieldGroup(
				$model,
				'fecha_inicio',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 form-control floating-label',
					),
					'widgetOptions' => array(
						'htmlOptions' => array(), //col-xs-12 col-sm-4 col-md-4 col-lg-4
					),
					'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
				)
			); ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->textFieldGroup(
				$model,
				'fecha_fin',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 form-control floating-label',
					),
					'widgetOptions' => array(
						'htmlOptions' => array(), //col-xs-12 col-sm-4 col-md-4 col-lg-4
					),
					'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
				)
			); ?>
		</div>
	</div>
	<div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->textFieldGroup(
				$model,
				'hora_inicio',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 form-control floating-label',
					),
					'widgetOptions' => array(
						'htmlOptions' => array(), //col-xs-12 col-sm-4 col-md-4 col-lg-4
					),
					'prepend' => '<i class="glyphicon glyphicon-time"></i>'
				)
			); ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->textFieldGroup(
				$model,
				'hora_fin',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 form-control floating-label',
					),
					'widgetOptions' => array(
						'htmlOptions' => array(), //col-xs-12 col-sm-4 col-md-4 col-lg-4
					),
					'prepend' => '<i class="glyphicon glyphicon-time"></i>'
				)
			); ?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div>
			<?php echo $form->labelEx($model,'mensaje'); ?>
	        <?php 
		        echo $form->textArea($model, 'mensaje', array('id'=>'mensaje', 'maxlength' => 300, 'rows' => 5));
		        echo $form->error($model,'mensaje');
	        ?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo $form->checkboxListGroup(
			$model,
			'dias',
			array(
				'widgetOptions' => array(
					'data' => array(1=>' Domingo', 2=>' Lunes', 3=>' Martes', 4=>' Miercoles', 5=>' Jueves', 6=>' Viernes', 7=>' Sabado')
				),
				'inline'=>true
			)
		); ?>
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

<script type="text/javascript">
    $(document).ready(function() 
    {
        $('#mensaje').summernote({
            theme: 'default',
            height: 200,
            placeholder: 'Description...',
        });
    });


</script>