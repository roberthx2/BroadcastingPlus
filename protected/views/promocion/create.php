
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
                'validateOnChange'=>true,
                'validateOnType'=>true,
                //'beforeValidateAttribute'=>'js:function(form, attribute){alert("working");}',   
            ),
		)
	); ?>
	 
	<fieldset>
 
	<legend>Crear Promoción</legend>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?php echo $form->dropDownListGroup(
			$model,
			'tipo',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'data' => $dataTipo,//CHtml::listData(BroadcastingModulos::model()->findAll(array("condition"=>"estado = 1","order"=>"id_modulo")), 'id_modulo', 'descripcion_corta'),
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
                                }
                                else
                                {
                                    $("#'.CHTML::activeId($model,'id_cliente').'").empty();
                                    hideShowFormPromocion($("#PromocionForm_tipo").val());
                                    console.log(response.status);
                                }
                            }'
                		),
                    ), //col-xs-12 col-sm-4 col-md-4 col-lg-4
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
						//'data' => test(),
						//'value' => 'null',
						'htmlOptions' => array('prompt' => 'Seleccionar...'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
					),
					'prepend' => '<i class="glyphicon glyphicon-user"></i>',
				)
			); ?>
			<div style="float: right; font: bold 13px Arial;"><strong>Cupo disponible:</strong>
				<?php echo CHTML::textField('cupo','',array('size'=>4 ,'style'=>'align:right; margin-left:10px; border:0;', 'readonly' => true)); ?></div>
		</div>

		<div class="clearfix visible-xs-block"></div>

		<div id="div_nombre" style="display:none;">
			<?php echo $form->textFieldGroup(
				$model,
				'nombre',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('maxlength' => 25, 'autocomplete' => 'off'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
					),
					'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
				)
			); ?>
		</div>

		<div id="div_prefijo" style="display:none;">
			<?php //Visible si tiene permisos al modulo de prefijos
			if (Yii::app()->user->getPermisos()->modulo_btl)
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

		<div class="clearfix visible-xs-block"></div>		

	</div> <!--Cierre de la columna #1-->

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div id="div_fecha" style="display:none;">
			<?php echo $form->datePickerGroup(
				$model,
				'fecha',
				array(
					//'value' => date("Y-m-d"),
					'widgetOptions' => array(
						'options' => array(
							'language' => 'es',
							'format' => 'yyyy-mm-dd',
							'startDate' => date("Y-m-d"),
							'endDate' => date('Y-m-d' , strtotime('+1 month', strtotime(date("Y-m-d")))),
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
		
		<div id="div_hora_inicio" style="display:none;">
			<?php echo $form->timePickerGroup(
				$model,
				'hora_inicio',
				array(
					'id'=>'PromocionesForm_hora_inicio',
					'widgetOptions' => array(
						'options' => array(
							'defaultTime' => date("H:i"),
							'showMeridian' => false,
							'showSeconds' => false,
							'minuteStep' => 1,
						),
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
						),
						'htmlOptions' => array( 'readonly'=>false, 'style'=>'background-color: white;'),
					),
					//'hint' => 'Nice bootstrap time picker',
				)
			); ?>
		</div>

		<div id="div_hora_fin" style="display:none;">
			<?php echo $form->timePickerGroup(
				$model,
				'hora_fin',
				array(
					'widgetOptions' => array(
						'options' => array(
							'defaultTime' => date('H:i' , strtotime('+1 hours', strtotime(date("H:i")))),
							'showMeridian' => false,
							'showSeconds' => false,
							'minuteStep' => 1,
						),
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
						),
						'htmlOptions' => array('readonly'=>false, 'style'=>'background-color: white;'),
					),
					//'hint' => 'Nice bootstrap time picker',
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
						//'data'=>CHtml::listData(UsuarioMasivo::model()->find(array("condition"=>"id_usuario = ".Yii::app()->user->id)), 'puertos', 'puertos'),
						'data'=> $puertos,
						//'data'=>array("1"=>"1", "2"=>"2", "3"=>"3"),
						'options' => array(
							//'tags' => $model_lista,//array('clever', 'is', 'better', 'clevertech'),
							'placeholder' => 'Seleccione sus listas...',
							'allowClear'=>true,
							/* 'width' => '40%', */
							'tokenSeparators' => array(',', ' ')
						),
						'htmlOptions'=>array(
							'multiple'=>'multiple',
							//'disabled'=>true,
						),
					),
					//'prepend' => '<i class="glyphicon glyphicon-random"></i>',
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

		<div class="clearfix visible-xs-block"></div>

		<div id="div_listas" style="display:none;">
			<?php 
			//Visible si tiene permisos al modulo de listas
			if (Yii::app()->user->getPermisos()->modulo_listas)
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
							//'data'=>CHtml::listData(Lista::model()->findAll("id_usuario = ".Yii::app()->user->id), 'id_lista','nombre'),
							'data'=>$listas,
							'options' => array(
								//'tags' => $model_lista,//array('clever', 'is', 'better', 'clevertech'),
								'placeholder' => 'Seleccione sus listas...',
								'allowClear'=>true,
								/* 'width' => '40%', */
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

		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'context' => 'success',
				'label' => 'Crear Promoción',
				'htmlOptions' => array(),
			)
		); ?>

		<?php
			$this->endWidget();
			unset($form);
		?>

		<?php
			//Visible si tiene permisos al modulo de btl
			if (Yii::app()->user->getPermisos()->modulo_btl)
			{
				$model_btl = new Btl;
	           	$this->renderPartial('btl', array("model"=>$model_btl));
	        }
        ?>	
	</div>

<script type="text/javascript">
	$(document).ready(function() 
    {
		//enableFormPromocion($("#PromocionForm_tipo").val());
        hideShowFormPromocion($("#PromocionForm_tipo").val());
        contarCaracterPromocion();
		//processKeydown(-1);

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
	                }
	                else
	                {
	                    $("#PromocionForm_id_cliente").empty();
	                    hideShowFormPromocion($("#PromocionForm_tipo").val());
	                    console.log(response.status);
	                }
	            },
	            error: function()
	            {
	                alert("Ocurrio un error al cargar los clientes")
	            }
	        });
	    }
	});

</script>