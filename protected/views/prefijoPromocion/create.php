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

            echo $form->textFieldGroup(
                $model,
                'prefijo',
                array(
                    'wrapperHtmlOptions' => array(
                        //'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('maxlength' => 10, 'autocomplete' => 'off'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
                    ),
                    'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
                )
            );
        ?>
    </div>
        <div id="respuesta"> </div>
    <div class="modal-footer" id="modal_footer_prefijo">
        <?php
            echo CHtml::submitButton('Crear Prefijo', array('id' => 'bontonCrear', 'class'=>'btn btn-success'));

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
                    $("#bontonCrear").attr("disabled",true);
                },
                complete: function()
                {
                    //alert("termine");
                },
                success: function(data)
                {
                    $("#PrefijoPromocion_prefijo_em_").show();

                    if (data.salida == 'true')
                    {
                        $(".form-group").removeClass("has-error").addClass("has-success");

                        $("#PrefijoPromocion_prefijo_em_").html("El prefijo fue creado correctamente");
                    }
                    else (data.salida == 'false')
                    {
                        $(".form-group").removeClass("has-success").addClass("has-error");

                        var error = data.error.prefijo;

                        $.each(error, function(i, value) {
                            $("#PrefijoPromocion_prefijo_em_").html(value);
                        });
                    }
                    
                    $("#bontonCrear").attr("disabled",false);
                },
                error: function()
                {
                    document.getElementById('respuesta').innerHTML = "Error occured.please try again" + data;
                    $("#bontonCrear").attr("disabled",false);
                }
            });
        }

        return false;
    }
</script>

