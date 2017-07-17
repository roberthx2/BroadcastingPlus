<?php 
    $this->widget(
        'booster.widgets.TbButton',
        array(
            'id'=>'botonCrearPrefijo',
            'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Crear Prefijo',
            'icon' => 'glyphicon glyphicon-plus',
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6', 'data-toggle' => 'modal', 'data-target' => '#modalCrearPrefijo'),
        )
    ); 
?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalCrearPrefijo')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Crear Prefijo</h4>
    </div>
    
    <div class="modal-body" id="divModalPrefijo" >
        <?php /** @var TbActiveForm $form */
            $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                array(
                    'id' => 'prefijo-promocion-form',
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
                'prefijo',
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
    </div>
    <div class="modal-footer" id="modal_footer_prefijo">
        <?php
            echo CHtml::tag('button', array('id'=>'bontonCrear', 'type'=>'submit', 'class'=>'btn btn-success'), '<i class="fa"></i> Crear Prefijo');
            $this->endWidget();
            unset($form);
        ?>
    </div>
 
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function enviar(form,data,hasError)
    {
        if(!hasError)
        {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl('prefijoPromocion/create2'); ?>",
                type:"POST",    
                data:$("#prefijo-promocion-form").serialize(),
                
                beforeSend: function()
                {
                   // $("#bontonCrear").attr("disabled",true);
                    $("#bontonCrear i.fa").addClass("fa-spinner").addClass("fa-spin");
                    $("#bontonCrear").addClass("disabled");
                    $("#prefijo-promocion-form div.form-group").removeClass("has-error").removeClass("has-success");
                    $("#PrefijoPromocion_prefijo_em_").hide();
                    $("#respuesta").hide();
                },
                complete: function()
                {
                    //alert("termine");
                   // $("#prefijo-promocion-form div.form-group").removeClass("has-error").removeClass("has-success");
                   // $("#PrefijoPromocion_prefijo_em_").hide();
                    //$("#respuesta").hide();
                    $("#bontonCrear i.fa").removeClass("fa-spinner").removeClass("fa-spin");
                    $("#bontonCrear").removeClass("disabled");
                },
                success: function(data)
                {
                    if (data.salida == 'true')
                    {
                    	$("#PrefijoPromocion_prefijo").val("");
                    	$("#prefijo-promocion-form div.form-group").addClass("has-success");
                        $("#respuesta").html("El prefijo fue creado correctamente");
                        $("#respuesta").show();

                        $('#prefijo-promocion-grid').yiiGridView('update', {
							data: $(this).serialize()
						});
						return;
                    }
                    else (data.salida == 'false')
                    {
                    	$("#prefijo-promocion-form div.form-group").addClass("has-error");
                    	$("#PrefijoPromocion_prefijo_em_").show();

                        var error = data.error.prefijo;

                        $.each(error, function(i, value) {
                            $("#PrefijoPromocion_prefijo_em_").html(value);
                        });
                        return;
                    }
                    
                   // $("#bontonCrear").attr("disabled",false);
                },
                error: function()
                {
                	//$("#respuesta").show();
                    //$("#respuesta").html("Ocurrio un error al procesar los datos intente nuevamente" + data);
                    //$("#bontonCrear").attr("disabled",false);
                }
            });
        }

        return false;
    }
</script>

 