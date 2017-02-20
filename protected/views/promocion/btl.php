<?php 
    $this->widget(
        'booster.widgets.TbButton',
        array(
            'id'=>'botonBTL',
            'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Números BTL',
            'icon' => 'glyphicon glyphicon-plus',
            'htmlOptions' => array('class'=>'col-xs-6 col-sm-6 col-md-6 col-lg-6', 'data-toggle' => 'modal', 'data-target' => '#modalBTL'),
        )
    ); 
?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalBTL')
); ?>
 
    <div align="left" class="modal-header" style="background-color:#428bca">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Clave de transacciones</h4>
    </div>
    
    <div align="left" class="modal-body" id="divModalBTL" >
        <?php /** @var TbActiveForm $form */
            $form_btl = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                array(
                    'id' => 'btl-form',
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
            echo $form_btl->passwordFieldGroup(
                $model,
                'password',
                array(
                    'wrapperHtmlOptions' => array(
                        //'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('maxlength' => 10, 'autocomplete' => 'off', 'class'=>'input_btl'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
                    ),
                    'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
                )
            );
        ?>
    </div>
    <div class="modal-footer" id="modal_footer_btl">
        <?php
            echo CHtml::submitButton('Enviar', array('id' => 'bontonEnviar', 'class'=>'btn btn-success'));

            $this->endWidget();
            unset($form_btl);
        ?>
    </div>
 
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function enviar(form, data, hasError)
    {
        if(!hasError)
        {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl('btl/authenticate'); ?>",
                type:"POST",    
                data:$("#btl-form").serialize(),
                
                beforeSend: function()
                {
                   $("#btl-form div.form-group").removeClass("has-error").removeClass("has-success");
                   $("#Btl_password_em_").hide();
                   $("#respuesta").hide();
                },
                complete: function()
                {

                },
                success: function(data)
                {
                    if (data.salida == 'true')
                    {
                        formulario();
						return;
                    }
                    else (data.salida == 'false')
                    {
                    	$("#btl-form div.form-group").addClass("has-error");
                    	$("#Btl_password_em_").show();

                        var error = data.error.password;

                        $.each(error, function(i, value) {
                            $("#Btl_password_em_").html(value);
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

    function formulario()
    {
        $.ajax({
            url:"<?php echo Yii::app()->createUrl('btl/form'); ?>",
            type:"POST",    
            data:{sc: $("#PromocionForm_sc").val(), 
                  operadoras: $("#PromocionForm_operadoras").val(), 
                  all_operadoras: $("#PromocionForm_all_operadoras").val(),
                  fecha_inicio: $("#PromocionForm_fecha_inicio").val(),
                  fecha_fin: $("#PromocionForm_fecha_fin").val(),
                  productos: $("#PromocionForm_productos").val()},
            
            beforeSend: function()
            {
               //$("#divModalBTL").html("me estoy enviando");
            },
            complete: function()
            {
                //$("#divModalBTL").html("me envie");
            },
            success: function(data)
            {
                $("#modalBTL").find(".modal-dialog").addClass("modal-lg");
                $("#modalBTL").find(".modal-title").text('Datos de BTL');
                $("#divModalBTL").html(data);
                $("#modal_footer_btl").html("");
                //$( "#modal_footer_btl" ).remove();
            },
            error: function()
            {
                
            }
        });
    }

    function sleep(milliseconds) {
      var start = new Date().getTime();
      for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
          break;
        }
      }
    }

    $(document).ready(function() 
    {
        if ($("#PromocionForm_sc").val() != "")
        {
            formulario();
        }
    });

</script>

