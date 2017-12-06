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
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<?php echo $form->dropDownListGroup(
				$model,
				'tipo_mensaje',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'data' => array(
							1=>'Periodo',
							2=>'Diario',
							3=>'Personalizado',
						),
						'htmlOptions' => array('onchange'=>'js:showInputs();')
					),
					'prepend' => '<i class="glyphicon glyphicon-check"></i>',
				)
			); ?>
		</div>
	</div>
	<div id="fechas">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->datePickerGroup(
				$model,
				'fecha_inicio',
				array(
					//'value' => date("Y-m-d"),
					'widgetOptions' => array(
						'options' => array(
							'language' => 'es',
							'format' => 'yyyy-mm-dd',
							'startDate' => date("Y-m-d"),
							//'endDate' => date("Y-m-d"),
							'autoclose' => true,
						),
						'htmlOptions' => array('value'=>date("Y-m-d"), 'readonly'=>true, 'style'=>'background-color: white;'),
					),
					'wrapperHtmlOptions' => array(
						//'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5',
					),
					//'hint' => 'Click inside! This is a super cool date field.',
					'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
				)
			); ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->datePickerGroup(
				$model,
				'fecha_fin',
				array(
					//'value' => date("Y-m-d"),
					'widgetOptions' => array(
						'options' => array(
							'language' => 'es',
							'format' => 'yyyy-mm-dd',
							'startDate' => date("Y-m-d"),
							//'endDate' => date("Y-m-d"),
							'autoclose' => true,
						),
						'htmlOptions' => array('value'=>date("Y-m-d"), 'readonly'=>true, 'style'=>'background-color: white;'),
					),
					'wrapperHtmlOptions' => array(
						//'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5',
					),
					//'hint' => 'Click inside! This is a super cool date field.',
					'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
				)
			); ?>
		</div>
	</div>
	<div id="horas">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->timePickerGroup(
				$model,
				'hora_inicio',
				array(
					'id'=>'MensajesBroadcastingForm_hora_inicio',
					'widgetOptions' => array(
						'options' => array(
							'defaultTime' => date('H:i'),
							'showMeridian' => false,
							'showSeconds' => false,
							'minuteStep' => 1,
						),
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
						),
						'htmlOptions' => array( 'readonly'=>true, 'style'=>'background-color: white;'),
					),
					//'hint' => 'Nice bootstrap time picker',
				)
			); ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $form->timePickerGroup(
				$model,
				'hora_fin',
				array(
					'id'=>'MensajesBroadcastingForm_hora_inicio',
					'widgetOptions' => array(
						'options' => array(
							'defaultTime' => date("H:i", strtotime ( '+60 minute' , strtotime ( date("H:i") ) )),
							'showMeridian' => false,
							'showSeconds' => false,
							'minuteStep' => 1,
						),
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
						),
						'htmlOptions' => array( 'readonly'=>true, 'style'=>'background-color: white;'),
					),
					//'hint' => 'Nice bootstrap time picker',
				)
			);  ?>
		</div>
	</div>

	<div id="dias" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label class="control-label required" for="MensajesBroadcastingForm_dias">Dias <span class="required">*</span></label>
		<?php echo $form->select2Group(
					$model,
					'dias',
					array(
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
						),
						'widgetOptions' => array(
							'asDropDownList' => true,
							'data'=>array(1=>' Domingo', 2=>' Lunes', 3=>' Martes', 4=>' Miercoles', 5=>' Jueves', 6=>' Viernes', 7=>' Sabado'),
							'options' => array(
								'placeholder' => 'Seleccione los dias...',
								'allowClear'=>true,
								'tokenSeparators' => array(',', ' ')
							),
							'htmlOptions'=>array(
								'multiple'=>'multiple',
							),
						),
						'prepend' => '<i class="glyphicon glyphicon-th-list"></i>'
					)
				);
			?>
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
		La herramienta estar&aacute; nuevamente disponible el d&iacute;a  <strong> FECHA_FIN </strong> a las  <strong> HORA_FIN </strong> 
		<br><br>
		<div id="information">Ofrecemos disculpas por las molestias ocasionadas.</div>
		<div style="text-align: right">Insignia Mobile, <strong> FECHA_ACTUAL </strong></div>
    </div>

</fieldset>
<br><br>

<div class="form-actions col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<center>
	<?php 
		echo CHtml::tag('button', array('id'=>'boton_enviar', 'type'=>'submit', 'class'=>'btn btn-success'), '<i class="fa"></i> Crear Mensaje'); ?>

	<?php
		$this->endWidget();
		unset($form);
	?>
	</center>
</div>

<script type="text/javascript">

	function showInputs()
	{
		if ($("#MensajesBroadcastingForm_tipo_mensaje").val() == 1)
		{
			$("#fechas").show()
			$("#horas").show()
			$("#dias").hide()
		}
		else if ($("#MensajesBroadcastingForm_tipo_mensaje").val() == 2)
		{
			$("#fechas").hide()
			$("#horas").show()
			$("#dias").hide()
		}
		else if ($("#MensajesBroadcastingForm_tipo_mensaje").val() == 3)
		{
			$("#fechas").hide()
			$("#horas").show()
			$("#dias").show()
		}
	}

    $(document).ready(function() 
    {
        $('#mensaje').summernote({
            theme: 'default',
            height: 200,
            placeholder: 'Description...',
        });

        showInputs()
    });


</script>