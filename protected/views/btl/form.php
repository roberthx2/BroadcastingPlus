<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<?php 
	$baseUrl = Yii::app()->baseUrl; 
	Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/funciones.js');
	$smsinBtl_minDate = $this->actionGetFechaMinSmsin();
?>

<?php
	$form = $this->beginWidget(
	    'booster.widgets.TbActiveForm',
	    array(
	        'id' => 'btl-form',
	        'type' => 'vertical',
	        'enableAjaxValidation'=>false,
	        'enableClientValidation'=>true,
	        'clientOptions' => array(
	            'validateOnSubmit'=>true,
	            'validateOnChange'=>false,
	            'afterValidate'=>'js:validarDatos'
	        ),
	    )
	);
?>

<?php echo $form->hiddenField($model, 'tipo_busqueda', array("value"=>1)); ?>

<fieldset>
 
	<legend></legend>
<div class="row col-lg-6">
	<div class="col-lg-12 form-group_sc">
		<?php echo $form->dropDownListGroup(
			$model,
			'sc',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData($sc, 'sc_id', 'sc_id'),
					'htmlOptions' => array('prompt' => 'Seleccionar sc...', /*'onchange'=>'js:test();'*/
					'ajax' => array(
	                    'type'=>'POST', //request type
	                    'dataType' => 'json',
	                    'url'=>Yii::app()->createUrl('/btl/getProductosAndOperadoras'), //url to call.
	                    'data' => array('sc' => 'js:$("#Btl_sc").val()'),
	                    'beforeSend' => 'function(){
	                    	$("#bontonEnviarBTL").addClass("disabled");
	                    	$(".loader").show();
	                    }',
	                    'complete' => 'function(){
	                    	$("#bontonEnviarBTL").removeClass("disabled");
	                    	$(".loader").hide();
	                    }',
	                    'success' => 'function(response){
	                            if (response.error == "false")
	                            {
	                                $("#'.CHTML::activeId($model,'productos').'").empty();
	                                var productos = response.productos;
	                                $.each(productos, function(i, value) {
	                                    $("#'.CHTML::activeId($model,'productos').'").append($("<option id=\""+value.desc_producto+"\">").text(value.desc_producto).attr("value",value.id_producto));
	                                });

	                                $("#'.CHTML::activeId($model,'operadoras').'").empty();
	                                var operadoras = response.operadoras;
	                                $.each(operadoras, function(i, value) {
	                                    $("#'.CHTML::activeId($model,'operadoras').'").append($("<option>").text(value.descripcion).attr("value",value.id_operadora_bcnl));
	                                });

	                                defaultOperadoraBTL();
	                            }
	                            else
	                            {
	                                $("#'.CHTML::activeId($model,'productos').'").empty();
	                                $("#'.CHTML::activeId($model,'operadoras').'").empty();
	                                console.log(response.status);
	                                defaultOperadoraBTL();
	                            }
	                        }'
	            		),
	                ),
				),
				'prepend' => '<i class="glyphicon glyphicon-check"></i>',
			)
		);
		?>
	</div>

	<div class="col-lg-12 form-group_operadoras">
			<?php echo $form->dropDownListGroup(
				$model,
				'operadoras',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
						//'style'=>'display: none;',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('multiple' => true),
					),
					'prepend' =>  '<strong>Todas</strong> '.$form->CheckBox($model, 'all_operadoras', array('title'=>'Seleccionar todas' ,'onclick'=>'js:checkedOperadoraBTL();')),
					//'prepend' => '<i class="glyphicon glyphicon-phone"></i>',
				)
			); ?>
	</div>
	<div class="col-lg-12 form-group_fechas">
		<div>
			<?php echo $form->radioButtonListGroup(
					$model,
					'tipo_busqueda',
					array(
						'widgetOptions' => array(
							'data' => array(1=>' Periodo', 2=>' Mes', 3=>' A&ntilde;o', 4=>' D&iacute;a'),
						),
						'inline'=>true
					)
				); ?>
		</div>
		<div id="div_busqueda_1" class="div_busqueda" style="display: block;"><?php echo $this->renderPartial('busquedaPorPeriodo', array('model'=>$model, "form"=>$form, 'smsinBtl_minDate'=>$smsinBtl_minDate), true); ?></div>

		<div id="div_busqueda_2" class="div_busqueda" style="display: none;"><?php echo $this->renderPartial('busquedaPorMes', array('model'=>$model, "form"=>$form, 'smsinBtl_minDate'=>$smsinBtl_minDate), true); ?></div>

		<div id="div_busqueda_3" class="div_busqueda" style="display: none;"><?php echo $this->renderPartial('busquedaPorAnio', array('model'=>$model, "form"=>$form, 'smsinBtl_minDate'=>$smsinBtl_minDate), true); ?></div>
		
		<div id="div_busqueda_4" class="div_busqueda" style="display: none;"><?php echo $this->renderPartial('busquedaPorDia', array('model'=>$model, "form"=>$form, 'smsinBtl_minDate'=>$smsinBtl_minDate), true); ?></div>
	</div>
</div>
<div class="row col-lg-6">
	<div class="col-lg-12 form-group_productos">
		<?php echo $form->dropDownListGroup(
			$model,
			'productos',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					'style'=>'display: none;',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('prompt' => 'Seleccionar productos...', 'multiple' => true),
				),
				'prepend' => '<i class="glyphicon glyphicon-th-list"></i>',
			)
		); ?>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">	
<?php
	//echo CHtml::submitButton('Aceptar', array('id' => 'bontonEnviarBTL', 'class'=>'btn btn-success'));
	echo CHtml::tag('button', array('id'=>'bontonEnviarBTL', 'type'=>'submit', 'class'=>'btn btn-success'), '<i class="fa"></i> Consultar');
	$this->endWidget();
    unset($form);
?>
</div>
</fieldset>

<style>
	.clsDatePicker {
	    z-index: 100000 !important;
	}
</style>

<script type="text/javascript">

	function validarDatos(form, data, hasError)
    {
        if(!hasError)
        {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl('btl/validarDatosForm'); ?>",
                type:"POST",    
                data:$("#btl-form").serialize(),
                
                beforeSend: function()
                {
                   	$("#btl-form div").removeClass("has-error").removeClass("has-success");
                   	$("#bontonEnviarBTL i.fa").addClass("fa-spinner").addClass("fa-spin");
                    $("#bontonEnviarBTL").addClass("disabled");
                },
                success: function(data)
                {
                	if (data.salida == 'true')
                    {
	                	getNumeros();
						return;
                    }
                    else (data.salida == 'false')
                    {
                        var error = data.error;

                        $.each(error, function(i, value) {
                        	$("#btl-form div.form-group_"+i).addClass("has-error");
                            $("#Btl_"+i+"_em_").html(value);
                            $("#Btl_"+i+"_em_").show();
                        });

                        $("#bontonEnviarBTL i.fa").removeClass("fa-spinner").removeClass("fa-spin");
                    	$("#bontonEnviarBTL").removeClass("disabled");

                        return;
                    }
                },
                error: function()
                {
                	alert("Ocurrio un error al validar los datos");	
                }
            });
        }

        return false;
    }

    function getNumeros()
    {
    	$.ajax({
            url:"<?php echo Yii::app()->createUrl('btl/getNumeros'); ?>",
            type:"POST",    
            data:$("#btl-form").serialize(),
            
            beforeSend: function()
            {
            	$("#div_destinatarios_btl").hide();
            	$("#PromocionForm_numeros_btl").val('');
            	$("#boton_close").hide();
            },
            complete: function()
            {
            	$("#boton_close").show();
            },
            success: function(data)
            {
            	if (data.existe == 'true')
            	{
            		//////////// Asignando valores del formulario BTL

            		$("#PromocionForm_sc").val($("#Btl_sc").val());
                	$("#PromocionForm_operadoras").val($("#Btl_operadoras").val());
                	$("#PromocionForm_fecha_inicio").val($("#Btl_fecha_inicio").val());
                	$("#PromocionForm_fecha_fin").val($("#Btl_fecha_fin").val());
                	$("#PromocionForm_productos").val($("#Btl_productos").val());

                	$("#Btl_productos").children(':selected').each(function()
            		{
            			$("#PromocionForm_desc_producto").val($("#PromocionForm_desc_producto").val()+$(this).text()+"#@#");
            		});

                	if ($("#Btl_all_operadoras").is(':checked') == true)
                		$("#PromocionForm_all_operadoras").val(true);
                	else $("#PromocionForm_all_operadoras").val(false);

                	/////////////////////////

            		$("#PromocionForm_numeros_btl").val(data.numeros_btl);

            		var texto = '';
            		var total = 0;

            		$.each(data.mensaje, function(i, value) {
            			total += parseInt(value.total);
            			if (texto == '')
                        	texto += value.descripcion+': '+value.total;
                        else texto += ' | '+value.descripcion+': '+value.total;
                    });

                    if (texto == '')
                        texto += 'Total: '+total;
                    else texto += ' | Total: '+total;

                    $("#div_btl_count").html('<strong>'+texto+'</strong>');
					$("#cant_btl").val(total);
					updateCantTotal();
            		$("#div_destinatarios_btl").show();
            		$("#modalBTL .close").click();
            	}
            	else
            	{
            		////////Vaciando valores del formulario BTL oculto
            		$("#PromocionForm_sc").val("");
                	$("#PromocionForm_operadoras").val("");
                	$("#PromocionForm_fecha_inicio").val("");
                	$("#PromocionForm_fecha_fin").val("");
                	$("#PromocionForm_productos").val("");
                	$("#PromocionForm_desc_producto").val("");
                	$("#PromocionForm_all_operadoras").val(false);
                	///////////////////////////////////

            		alert("No hay destinatarios para el rango de fecha seleccionado");
            	}

            	$("#bontonEnviarBTL i.fa").removeClass("fa-spinner").removeClass("fa-spin");
                $("#bontonEnviarBTL").removeClass("disabled");
                //console.log(data);
            },
            error: function()
            {
            	alert("Ocurrio un error al buscar los destinatarios");
            }
        });
    }

    $(document).ready(function(){

    	$('.datepicker').on('open', function() {
		    $('.datepicker').appendTo('body');
		});
		
        if ($("#PromocionForm_sc").val() != "")
		{
	        $.ajax({
	            url: "<?php echo Yii::app()->createUrl('/btl/getProductosAndOperadoras'); ?>",
	            type: "POST",
	            dataType: 'json',    
	            data:{sc:$("#PromocionForm_sc").val()},
	            
	            complete: function()
	            {
	                
	            },
	            success: function(response)
	            {
	            	if (response.error == "false")
	                {
	                    $("#Btl_productos").empty();
                        var productos = response.productos;
                        $.each(productos, function(i, value) {
                            $("#Btl_productos").append($("<option id=\""+value.desc_producto+"\">").text(value.desc_producto).attr("value",value.id_producto));
                        });

                        $("#Btl_operadoras").empty();
                        var operadoras = response.operadoras;
                        $.each(operadoras, function(i, value) {
                            $("#Btl_operadoras").append($("<option>").text(value.descripcion).attr("value",value.id_operadora_bcnl));
                        });

                        if ($("#PromocionForm_all_operadoras").val() == 'true')
						{
							defaultOperadoraBTL();
						}
						else
						{
							var values = $("#PromocionForm_operadoras").val();
							$.each(values.split(","), function(i,e){
							    $("#Btl_operadoras option[value='" + e + "']").prop("selected", true);
							});
						}

						var values = $("#PromocionForm_desc_producto").val();
						$.each(values.split("#@#"), function(i,e){
						    $("#Btl_productos option[id='" + e + "']").prop("selected", true);
						});

                        //defaultOperadoraBTL();
	                }
	                else
	                {
	                    $("#Btl_productos").empty();
                        $("#Btl_operadoras").empty();
                        //defaultOperadoraBTL();
	                }
	            },
	            error: function()
	            {
	                alert("Ocurrio un error al cargar los datos de btl");
	            }
	        });
	    }

	    $("input[name='Btl[tipo_busqueda]']").change(function(){
	    	var element = $(this).val();
	    	$(".div_busqueda").hide();
	    	$("#div_busqueda_"+element).show();
    	});
    });
</script>