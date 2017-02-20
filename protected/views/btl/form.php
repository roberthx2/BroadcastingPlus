<?php 
	$baseUrl = Yii::app()->baseUrl; 
	Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/funciones.js');
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

	<div class="col-lg-12 form-group_fecha_inicio">
		<?php echo $form->datePickerGroup(
			$model,
			'fecha_inicio',
			array(
				'widgetOptions' => array(
					'options' => array(
						'language' => 'es',
						'format' => 'yyyy-mm-dd',
						'endDate' => date("Y-m-d"),
						'startDate' => date('Y-m-d' , strtotime('-2 Year', strtotime(date("Y-m-d")))),
						'autoclose' => true,
					),
					'htmlOptions' => array('readonly'=>true, 'style'=>'background-color: white;'),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				//'hint' => 'Click inside! This is a super cool date field.',
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>
	</div>

	<div class="col-lg-12 form-group_fecha_fin">
		<?php echo $form->datePickerGroup(
			$model,
			'fecha_fin',
			array(
				'widgetOptions' => array(
					'options' => array(
						'language' => 'es',
						'format' => 'yyyy-mm-dd',
						'endDate' => date("Y-m-d"),
						'startDate' => date('Y-m-d' , strtotime('-2 Year', strtotime(date("Y-m-d")))),
						'autoclose' => true,
					),
					'htmlOptions' => array('readonly'=>true, 'style'=>'background-color: white;'),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5',
				),
				//'hint' => 'Click inside! This is a super cool date field.',
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>
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
	echo CHtml::submitButton('Aceptar', array('id' => 'bontonEnviarBTL', 'class'=>'btn btn-success'));
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
                },
                complete: function()
                {

                },
                success: function(data)
                {
                	if (data.salida == 'true')
                    {
                        $("#PromocionForm_sc").val($("#Btl_sc").val());
	                	$("#PromocionForm_operadoras").val($("#Btl_operadoras").val());
	                	$("#PromocionForm_fecha_inicio").val($("#Btl_fecha_inicio").val());
	                	$("#PromocionForm_fecha_fin").val($("#Btl_fecha_fin").val());
	                	$("#PromocionForm_productos").val($("#Btl_productos").val());

	                	$("#Btl_productos").children(':selected').each(function()
                		{
                			$("#PromocionForm_desc_producto").val($("#PromocionForm_desc_producto").val()+$(this).text()+"#@#");
                		});
	                	/*$.each($("#Btl_productos").val(), function(i, value) {
                            $("#PromocionForm_productos").append($("<option>").text(value).attr("value",value));
                        });*/

	                	if ($("#Btl_all_operadoras").is(':checked') == true)
	                		$("#PromocionForm_all_operadoras").val(true);
	                	else $("#PromocionForm_all_operadoras").val(false);

	                	$("#modalBTL .close").click()
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
                        return;
                    }

                    console.log(data);
                },
                error: function()
                {
                	
                }
            });
        }

        return false;
    }

    $(document).ready(function(){
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
    });
</script>