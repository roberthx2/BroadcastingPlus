
<link rel="stylesheet" href="./css/ripples.min.css"/>

<link rel="stylesheet" href="./css/bootstrap-material-datetimepicker.css" />
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="./js/ripples.min.js"></script>
<script src="./js/material.min.js"></script>
<script type="text/javascript" src="./js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-material-datetimepicker.js"></script>
<div class="loader" style="display: none;"></div>
<?php if(Yii::app()->user->hasFlash('danger')):?>
	<br>
    <div class="container-fluid">
	        <div class="alert alert-danger">
	          <button type="button" class="close" data-dismiss="alert">&times;</button>
	          <span class="glyphicon glyphicon-ban-circle"></span> <?php echo Yii::app()->user->getFlash('danger'); ?>
	        </div>
	    </div>
<?php endif; ?>

<?php /** @var TbActiveForm $form */
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'promocion-form',
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
		            	$("#botonBTL").addClass("disabled");
            			$("#boton_enviar").addClass("disabled");
		                return true;    
		            }
                }'   
            ),
		)
	); 

		$interval_minute = Yii::app()->Procedimientos->getIntervalMinute();
	?>
	 
	<fieldset>
 
	<legend>Crear Promoción</legend>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
		<?php echo $form->dropDownListGroup(
			$model,
			'tipo',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'data' => $dataTipo,
					'htmlOptions' => array('prompt' => 'Seleccionar...', /*'onchange'=>'js:test();'*/
					'ajax' => array(
                        'type'=>'POST', //request type
                        'dataType' => 'json',
                        'url'=>Yii::app()->createUrl('/promocion/getCliente'), //url to call.
                        'data' => array('tipo' => 'js:$("#PromocionForm_tipo").val()'),
                        'success' => 'function(response){
                                if (response.error == "false")
                                {
                                    $("#'.CHTML::activeId($model,'id_cliente').'").empty();
                                    var cliente = response.data;
                                    $.each(cliente, function(i, value) {
                                        $("#'.CHTML::activeId($model,'id_cliente').'").append($("<option>").text(value.descripcion).attr("value",value.id_cliente));
                                    });
                                    $("#cupo").val(response.cupo);
                                    hideShowFormPromocion($("#PromocionForm_tipo").val());
                                    getScBCP();
                                }
                                else
                                {
                                    $("#'.CHTML::activeId($model,'id_cliente').'").empty();
                                    $("#'.CHTML::activeId($model,'sc_bcp').'").empty();
                                    $("#div_sc_oper").html("");
                                    hideShowFormPromocion($("#PromocionForm_tipo").val());
                                    console.log(response.status);
                                }
                            }'
                		),
                    ), 
				),
				'prepend' => '<i class="glyphicon glyphicon-check"></i>',
			)
		); ?>

		<div id="div_id_cliente" style="display:none;">
			<?php echo $form->dropDownListGroup(
				$model,
				'id_cliente',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
						'style'=>'display: none;',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('prompt' => 'Seleccionar...',
						'ajax' => array(
	                        'type'=>'POST', //request type
	                        'dataType' => 'json',
	                        'url'=>Yii::app()->createUrl('/promocion/getScBCP'), //url to call.
	                        'data' => array('id_cliente' => 'js:$("#PromocionForm_id_cliente").val()', 'tipo' => 'js:$("#PromocionForm_tipo").val()'),
	                        'success' => 'function(response){
	                                if (response.error == "false")
	                                {
	                                    $("#'.CHTML::activeId($model,'sc_bcp').'").empty();
	                                    var sc = response.data;
	                                    $.each(sc, function(i, value) {
	                                        $("#'.CHTML::activeId($model,'sc_bcp').'").append($("<option>").text(value.sc).attr("value",value.sc));
	                                    });
	                                    getScOperadorasBCP();
	                                }
	                                else
	                                {
	                                    $("#'.CHTML::activeId($model,'sc_bcp').'").empty();
	                                    console.log(response.status);
	                                }
	                            }'
	                		),
						),
					),
					'prepend' => '<i class="glyphicon glyphicon-user"></i>',
				)
			); ?>
			<div style="float: right; font: bold 13px Arial;"><strong>Cupo disponible:</strong>
				<?php echo CHTML::textField('cupo','',array('size'=>4 ,'style'=>'align:right; margin-left:10px; border:0;', 'readonly' => true)); ?></div>
		</div>

		<div id="div_id_sc" style="display:none;">
			<?php echo $form->dropDownListGroup(
				$model,
				'sc_bcp',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
						'style'=>'display: none;',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('prompt' => 'Seleccionar...',
						'ajax' => array(
	                        'type'=>'POST', //request type
	                        'dataType' => 'json',
	                        'url'=>Yii::app()->createUrl('/promocion/getScOperadorasBCP'), //url to call.
	                        'data' => array('id_cliente' => 'js:$("#PromocionForm_id_cliente").val()', 'sc' => 'js:$("#PromocionForm_sc_bcp").val()'),
	                        'success' => 'function(response){
	                                if (response.error == "false")
	                                {
	                                    $("#div_sc_oper").html("");
	                                    var radios = response.data;
	                                    $("#div_sc_oper").html(radios);
	                                }
	                                else
	                                {
	                                    $("#div_sc_oper").html(response.status);
	                                    console.log(response.status);
	                                }
	                            }'
	                		),
	                	),
					),
					'hint' => 'Short Code desde el cual será enviado el SMS por operadora',
					'prepend' => '<i class="glyphicon glyphicon-tags"></i>',
				)
			); ?>

			<div id="div_sc_oper" style="display:block;">	</div>
		</div>

		<div id="div_nombre" style="display:none;">
			<?php echo $form->textFieldGroup(
				$model,
				'nombre',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('maxlength' => 25, 'autocomplete' => 'off'),
					),
					'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
				)
			); ?>
		</div>

		<div id="div_prefijo" style="display:none;">
			<?php //Visible si tiene permisos al modulo de prefijos
			if ($permisos->administrar_prefijo)
			{
				echo $form->dropDownListGroup(
					$model,
					'prefijo',
					array(
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
							'style'=>'display: none;',
						),
						'widgetOptions' => array(
							'data' => CHtml::listData(PrefijoPromocion::model()->findAll(array("condition"=>"id_usuario = ".Yii::app()->user->id,"order"=>"prefijo")), 'prefijo', 'prefijo'),
							//'value' => 'null',
							'htmlOptions' => array('prompt' => 'Seleccionar...', 'onChange' => 'js:insertarPrefijo();'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
						),
						'prepend' => '<i class="glyphicon glyphicon-bookmark"></i>',
					)
				);
			} ?>
		</div>

		<div id="div_mensaje" style="display:none;">
			<?php echo $form->textAreaGroup(
				$model,
				'mensaje',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('rows' => 5, 'maxlength' => 158, 'style'=> 'resize:none;','onMouseDown' => 'contarCaracterPromocion()', 'onChange' => 'contarCaracterPromocion()', 'onBlur' => 'contarCaracterPromocion()','onKeyDown' => 'contarCaracterPromocion()','onFocus' => 'contarCaracterPromocion()','onKeyUp' => 'contarCaracterPromocion()'),
					),
					'prepend' => '<i class="glyphicon glyphicon-envelope"></i>'
				)
			); ?>

			<div style="float: right; font: bold 13px Arial;"><strong>Caracteres restantes:</strong>
				<?php echo CHTML::textField('caracteres',158,array('size'=>2 ,'style'=>'align:right; margin-left:10px; border:0;', 'readonly' => true)); ?></div>
		</div>		

		<!--<div id="div_fecha" style="display:none;">
			<?php /*echo $form->datePickerGroup(
				$model,
				'fecha',
				array(
					//'value' => date("Y-m-d"),
					'widgetOptions' => array(
						'options' => array(
							'language' => 'es',
							'format' => 'yyyy-mm-dd',
							'startDate' => date("Y-m-d"),
							'endDate' => date('Y-m-d' , strtotime('+1 day', strtotime(date("Y-m-d")))),
							'autoclose' => true,
						),
						'htmlOptions' => array('value'=>date("Y-m-d"), 'readonly'=>true, 'style'=>'background-color: white;'),
					),
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5',
					),
					//'hint' => 'Click inside! This is a super cool date field.',
					'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
				)
			); */?>
		</div>-->

		<div id="div_fecha" style="display:none;">
			<?php echo $form->textFieldGroup(
				$model,
				'fecha',
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
	
		<div id="div_duracion" style="display:none;">
			<?php echo $form->dropDownListGroup(
				$model,
				'duracion',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5',
					),
					'widgetOptions' => array(
						'data' => array('20'=>'20', '25'=>'25','30'=>'30','35'=>'35','40'=>'40','45'=>'45','50'=>'50','60'=>'60'),
						'htmlOptions' => array(),
					),
					'prepend' => '<i class="glyphicon glyphicon-time"></i>'
				)
			); ?>
		</div>
		
		<!--<div id="div_hora_inicio" style="display:none;">
			<?php /*echo $form->timePickerGroup(
				$model,
				'hora_inicio',
				array(
					'id'=>'PromocionesForm_hora_inicio',
					'widgetOptions' => array(
						'options' => array(
							'defaultTime' => $interval_minute["hora_ini"],
							'showMeridian' => false,
							'showSeconds' => false,
							'minuteStep' => $interval_minute["interval_minute"],
						),
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
						),
						'htmlOptions' => array( 'readonly'=>false, 'style'=>'background-color: white;'),
					),
					//'hint' => 'Nice bootstrap time picker',
				)
			);*/ ?>
		</div>-->

		<div id="div_hora_inicio" style="display:none;">
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

		<!--<div id="div_hora_fin" style="display:none;">
			<?php /*echo $form->timePickerGroup(
				$model,
				'hora_fin',
				array(
					'widgetOptions' => array(
						'options' => array(
							'defaultTime' => $interval_minute["hora_fin"],
							'showMeridian' => false,
							'showSeconds' => false,
							'minuteStep' => $interval_minute["interval_minute"],
						),
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
						),
						'htmlOptions' => array('readonly'=>false, 'style'=>'background-color: white;'),
					),
					//'hint' => 'Nice bootstrap time picker',
				)
			); */?>
		</div>-->

		<div id="div_hora_fin" style="display:none;">
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

		<div id="div_puertos" style="display:none;">
			<?php

			$puertos = array();
			$sql = "SELECT puertos FROM usuario WHERE id_usuario = ".Yii::app()->user->id;
			$sql = Yii::app()->db->createCommand($sql)->queryRow();

			if($sql["puertos"] != "")
				$puertos = explode(",", $sql["puertos"]);
			
			echo $form->select2Group(
				$model,
				'puertos',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'asDropDownList' => true,
						'data'=> $puertos,
						'options' => array(
							'placeholder' => 'Seleccione sus puertos...',
							'allowClear'=>true,
							'tokenSeparators' => array(',', ' ')
						),
						'htmlOptions'=>array(
							'multiple'=>'multiple',
						),
					),
					'prepend' =>  '<strong>Todos</strong> '.$form->CheckBox($model, 'all_puertos', array('title'=>'Seleccionar todos', 'onclick'=>'js:disabledPuertos();')),
				)
			);?>
		</div>

		<div id="div_destinatarios" style="display:none;">
			<?php echo $form->textAreaGroup(
				$model,
				'destinatarios',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('class'=>'numerosTextarea', 'onKeyPress' => 'return processKeydown(event);', 'rows' => 5, 'placeholder' => '4160000000,4260000000,4140000000,4240000000,4120000000'),
					),
					'prepend' => '<i class="glyphicon glyphicon-phone"></i>'
				)
			); ?>

			<div style="float: right; font: bold 13px Arial;"><strong>Total: </strong>
				<?php echo CHTML::textField('total',0,array('size'=>2 ,'style'=>'margin-left:10px; border:0;', 'readonly' => true)); ?>
			</div>
		</div>

		<div id="div_listas" style="display:none;">
			<?php 
			//Visible si tiene permisos al modulo de listas
			if ($permisos->modulo_listas)
			{
				echo $form->select2Group(
					$model,
					'listas',
					array(
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
						),
						'widgetOptions' => array(
							'asDropDownList' => true,
							'data'=>$listas,
							'options' => array(
								'placeholder' => 'Seleccione sus listas...',
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
			} ?>
		</div>
		
		<div id="div_destinatarios_btl" style="display:none;">
			<?php echo $form->textAreaGroup(
				$model,
				'numeros_btl',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('class'=>'numerosTextarea', 'rows' => 5, 'readonly' => true),
					),
					'prepend' => '<i class="glyphicon glyphicon-phone"></i>'
				)
			); ?>
			<?php echo CHtml::hiddenField('cant_btl', 0, array('id'=>'cant_btl')); ?>
			<div id="div_btl_count" style="float: right; font: bold 13px Arial;"></div>
		</div>
		<div class="clearfix visible-xs-block"></div>
		<hr>
		<div style="float: right; font: bold 13px Arial;"><strong>Cantidad total de sms: </strong>
				<?php echo CHTML::textField('cant_total',0,array('size'=>2 ,'style'=>'margin-left:10px; border:0;', 'readonly' => true)); ?>
		</div>
	</div>

	</fieldset>
	<br><br>

	<!--BTL-->
	<?php echo $form->hiddenField($model, 'sc'); ?>
	<?php echo $form->hiddenField($model, 'operadoras'); ?>
	<?php echo $form->hiddenField($model, 'all_operadoras'); ?>
	<?php echo $form->hiddenField($model, 'fecha_inicio'); ?>
	<?php echo $form->hiddenField($model, 'fecha_fin'); ?>
	<?php echo $form->hiddenField($model, 'productos'); ?>
	<?php echo $form->hiddenField($model, 'desc_producto'); ?>

	<div id="div_botones" class="form-actions col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display:none;">

		<?php 
			echo CHtml::tag('button', array('id'=>'boton_enviar', 'type'=>'submit', 'class'=>'btn btn-success'), '<i class="fa"></i> Crear Promoción'); ?>

		<?php
			$this->endWidget();
			unset($form);
		?>

		<?php
			//Visible si tiene permisos al modulo de btl
			if ($permisos->modulo_btl)
			{
				$model_btl = new Btl;
	           	$this->renderPartial('btl', array("model"=>$model_btl));
	        }
        ?>	
	</div>
<br><br>
<script type="text/javascript">
	$(document).ready(function() 
    {
        hideShowFormPromocion($("#PromocionForm_tipo").val());
        contarCaracterPromocion();

        if ($("#PromocionForm_numeros_btl").val() != "")
        {
        	$("#div_destinatarios_btl").show();
        }
        else
        {
        	$("#div_destinatarios_btl").hide();	
        }

        var maxDate = "<?php echo date('Y-m-d' , strtotime('+1 day', strtotime(date("Y-m-d")))); ?>"
        var admin = "<?php echo Yii::app()->user->isAdmin(); ?>"
        var hipico = "<?php echo Yii::app()->Procedimientos->clienteIsHipicoLotero(Yii::app()->user->modelSMS()->id_cliente); ?>"

        if (admin == 1 || hipico == 0)
        	maxDate = "<?php echo date('Y-m-d' , strtotime('+6 day', strtotime(date("Y-m-d")))); ?>"
        
		$('#PromocionForm_fecha').bootstrapMaterialDatePicker
		({
			lang : 'es',
			time: false,
			clearButton: true,
			format: 'YYYY-MM-DD',
			clearButton: false,
			switchOnClick: true,
			year: false,
			currentDate: "<?php echo date('Y-m-d'); ?>",
			minDate: "<?php echo date('Y-m-d'); ?>",
			maxDate: maxDate

		});

		$('#PromocionForm_hora_inicio').bootstrapMaterialDatePicker
		({
			date: false,
			shortTime: false,
			format: 'HH:mm',
			shortTime: true
		});

		$('#PromocionForm_hora_fin').bootstrapMaterialDatePicker
		({
			date: false,
			shortTime: false,
			format: 'HH:mm',
			shortTime: true
		});

		$('#PromocionForm_hora_inicio').bootstrapMaterialDatePicker('setDate', "<?php echo $interval_minute['hora_ini']; ?>");
		$('#PromocionForm_hora_fin').bootstrapMaterialDatePicker('setDate', "<?php echo $interval_minute['hora_fin']; ?>");

		if ($("#PromocionForm_tipo").val() != "")
		{
			if ($("#PromocionForm_all_puertos").is(":checked"))
			{
				$("#PromocionForm_puertos").prop('disabled', true);
			}

	        $.ajax({
	            url: "<?php echo Yii::app()->createUrl('/promocion/getCliente'); ?>",
	            type: "POST",
	            dataType: 'json',    
	            data:{tipo:$("#PromocionForm_tipo").val()},
	            
	            complete: function()
	            {
	                
	            },
	            success: function(response)
	            {
	            	if (response.error == "false")
	                {
	                	var id_cliente = "<?php echo $model->id_cliente; ?>";

	                    $("#PromocionForm_id_cliente").empty();
	                    var cliente = response.data;
	                    $.each(cliente, function(i, value) {
	                        $("#PromocionForm_id_cliente").append($("<option>").text(value.descripcion).attr("value",value.id_cliente));
	                    });
	                    $("#cupo").val(response.cupo);
	                    $("#PromocionForm_id_cliente option[value='" + id_cliente + "']").prop("selected", true);

	                    hideShowFormPromocion($("#PromocionForm_tipo").val());
	                    getScBCP();
	                }
	                else
	                {
	                	$("#PromocionForm_sc_bcp").empty();
                        $("#div_sc_oper").html("");
	                    $("#PromocionForm_id_cliente").empty();
	                    hideShowFormPromocion($("#PromocionForm_tipo").val());
	                    //console.log(response.status);
	                }
	            },
	            error: function()
	            {
	                alert("Ocurrio un error al cargar los clientes")
	            }
	        });
	    }
	});

	function getScBCP()
	{
		$.ajax({
            url: "<?php echo Yii::app()->createUrl('/promocion/getScBCP'); ?>",
            type: "POST",
            dataType: 'json',    
            data:{id_cliente:$("#PromocionForm_id_cliente").val(), tipo:$("#PromocionForm_tipo").val()},
            
            complete: function()
            {
                
            },
            success: function(response)
            {
                if (response.error == "false")
                {
                    $("#PromocionForm_sc_bcp").empty();
                    var sc = response.data;
                    $.each(sc, function(i, value) {
                        $("#PromocionForm_sc_bcp").append($("<option>").text(value.sc).attr("value",value.sc));
                    });

                    var sc = "<?php echo $model->sc_bcp; ?>";
                    $("#PromocionForm_sc_bcp option[value='" + sc + "']").prop("selected", true);
                    getScOperadorasBCP();
                }
                else
                {
                    $("#PromocionForm_sc_bcp").empty();
                    //console.log(response.status);
                }
            },
            error: function()
            {
                alert("Ocurrio un error al cargar los short codes del cliente");
            }
        });
	}

	function getScOperadorasBCP()
	{
		$.ajax({
            url: "<?php echo Yii::app()->createUrl('/promocion/getScOperadorasBCP'); ?>",
            type: "POST",
            dataType: 'json',    
            data:{id_cliente:$("#PromocionForm_id_cliente").val(), sc:$("#PromocionForm_sc_bcp").val()},
            
            complete: function()
            {
                
            },
            success: function(response)
            {
                if (response.error == "false")
                {
                    $("#div_sc_oper").html("");
                    var radios = response.data;
                    $("#div_sc_oper").html(radios);

                	var operadoras_bcp = <?php echo json_encode($operadoras_bcp);?>;

                	$.each(operadoras_bcp, function(i, value) {
                    	$('.operadoras_bcp_'+i).filter('[value="'+ value +'"]').click();
                	});
                	//console.log(operadoras_bcp);
                }
                else
                {
                    $("#div_sc_oper").html(response.status);
                    //console.log(response.status);
                }
            },
            error: function()
            {
                alert("Ocurrio un error al cargar los short codes del cliente");
            }
        });
	}

</script>