
        <?php /** @var TbActiveForm $form */
            $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                array(
                    'id' => 'updateSCInSMS-form',
                    'type' => 'vertical',
                    'enableAjaxValidation'=>false,
                    'enableClientValidation'=>true,
                    'clientOptions' => array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>false,
                        'afterValidate'=>'js:enviar'
                    ),
                )
            );
            ?>
            <div id="respuesta" class="alert alert-success" role="alert" style="display: none;"></div>
            <?php 
            echo $form->textFieldGroup(
                $model,
                'valor',
                array(
                    'wrapperHtmlOptions' => array(
                        //'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('maxlength' => 10, 'autocomplete' => 'off', 'class'=>'input_prefijo'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
                    ),
                    'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
                )
            );
        ?>
    <div class="modal-footer" id="modal_footer">
	     <?php $this->widget('booster.widgets.TbButton', array(
	    	'label'=>'Guardar',
	    	'url'=>'#',
	    	'htmlOptions'=>array('class'=>'btn btn-success', 'onclick' => 'enviar()'),
		)); ?>

		<?php $this->widget(
	        'booster.widgets.TbButton',
	        array(
	            'label' => 'Cerrar',
	            'url' => '#',
	            'htmlOptions' => array('data-dismiss' => 'modal'),
	        )
	    ); ?>
	    
	    <?php

	        $this->endWidget();
	        unset($form);
	    ?>
    </div>
 
<script type="text/javascript">

    function enviar(form,data,hasError)
    {
        if(!hasError)
        {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl('configuracionSistemaAcciones/updateSCInSMS'); ?>",
                type:"POST",    
                data:$("#updateSCInSMS-form").serialize(),
                
                beforeSend: function()
                {
                   // $("#bontonCrear").attr("disabled",true);
                   $("#updateSCInSMS-form div.form-group").removeClass("has-error").removeClass("has-success");
                   $("#ConfiguracionSistemaAccionesForm_valor_em_").hide();
                   $("#respuesta").hide();
                },
                complete: function()
                {
                },
                success: function(data)
                {
                    if (data.salida == 'true')
                    {
                    	$("#updateSCInSMS-form div.form-group").addClass("has-success");
                        $("#respuesta").html("Actualizacion realizada exitosamente");
                        $("#respuesta").show();

                        $('#configuracion-sistema-acciones-grid').yiiGridView('update', {
							data: $(this).serialize()
						});
						return;
                    }
                    else (data.salida == 'false')
                    {
                    	$("#updateSCInSMS-form div.form-group").addClass("has-error");
                    	$("#ConfiguracionSistemaAccionesForm_valor_em_").show();

                        var error = data.error.valor;

                        $.each(error, function(i, value) {
                            $("#ConfiguracionSistemaAccionesForm_valor_em_").html(value);
                        });
                        return;
                    }
                },
                error: function()
                {
                }
            });
        }

        return false;
    }
</script>

