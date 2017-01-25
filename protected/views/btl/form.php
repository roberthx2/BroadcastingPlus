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
	            //'afterValidate'=>'js:enviar'
	        ),
	    )
	);
?>

<div>
	<?php echo $form->dropDownListGroup(
		$model,
		'sc',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
			),
			'widgetOptions' => array(
				'data' => array("123","456","789"),//$dataTipo,//CHtml::listData(BroadcastingModulos::model()->findAll(array("condition"=>"estado = 1","order"=>"id_modulo")), 'id_modulo', 'descripcion_corta'),
				'htmlOptions' => array('prompt' => 'Seleccionar sc...'), /*'onchange'=>'js:test();'*/
				/*'ajax' => array(
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
                ),*/
			),
			'prepend' => '<i class="glyphicon glyphicon-check"></i>',
		)
	);
	?>
</div>

<div>
	<?php echo $form->dropDownListGroup(
		$model,
		'productos',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				'style'=>'display: none;',
			),
			'widgetOptions' => array(
				//'data' => test(),
				//'value' => 'null',
				'htmlOptions' => array('prompt' => 'Seleccionar productos...', 'multiple' => true),
			),
			'prepend' => '<i class="glyphicon glyphicon-user"></i>',
		)
	); ?>
</div>
<div>
	<?php
		echo $form->select2Group(
			$model,
			'operadoras',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'asDropDownList' => true,
					'data'=>CHtml::listData(OperadorasRelacion::model()->findAll(array('group'=>'id_operadora_bcnl')), 'id_operadora_bcnl', 'descripcion'),
					'options' => array(
						//'tags' => $model_lista,//array('clever', 'is', 'better', 'clevertech'),
						'placeholder' => 'Seleccione las operadoras...',
						'allowClear'=>true,
						/* 'width' => '40%', */
						'tokenSeparators' => array(',', ' ')
					),
					'htmlOptions'=>array(
						'multiple'=>'multiple',
						//'disabled'=>true,
					),
				),
				'prepend' =>  '<strong>Todas</strong> '.$form->CheckBox($model, 'all_operadoras', array('title'=>'Seleccionar todas', /*'onclick'=>'js:disabledPuertos();'*/)),
			)
		);?>
</div>
<div>
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
					'endDate' => date('Y-m-d' , strtotime('+1 month', strtotime(date("Y-m-d")))),
					'autoclose' => true,
				),
				'htmlOptions' => array('value'=>date("Y-m-d"), 'readonly'=>true, 'style'=>'background-color: white; z-index: 200000 !important;'),
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5 fecha',
			),
			//'hint' => 'Click inside! This is a super cool date field.',
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
		)
	); ?>
</div>

<?php
	$this->endWidget();
    unset($form);
?>

<style>
	
	#Btl_fecha_inixddd
	{
	    z-index: 200000 !important;
	}
</style>

