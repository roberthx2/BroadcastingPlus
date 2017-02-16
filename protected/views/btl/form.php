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
	        /*'enableAjaxValidation'=>false,
	        'enableClientValidation'=>true,
	        'clientOptions' => array(
	            'validateOnSubmit'=>true,
	            'validateOnChange'=>false,
	            //'afterValidate'=>'js:enviar'
	        ),*/
	    )
	);
?>
<fieldset>
 
	<legend></legend>
<div class="row col-lg-6">
	<div class="col-lg-12">
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
	                                    $("#'.CHTML::activeId($model,'productos').'").append($("<option>").text(value.desc_producto).attr("value",value.id_producto));
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

	<div class="col-lg-12">
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
					'prepend' =>  '<strong>Todas</strong> '.$form->CheckBox($model, 'all_operadoras', array('title'=>'Seleccionar todas', 'disabled'=>true ,'onclick'=>'js:checkedOperadoraBTL();')),
					//'prepend' => '<i class="glyphicon glyphicon-phone"></i>',
				)
			); ?>
	</div>

	<div class="col-lg-12">
		<?php echo $form->datePickerGroup(
			$model,
			'fecha_inicio',
			array(
				//'value' => date("Y-m-d"),
				'widgetOptions' => array(
					'options' => array(
						'language' => 'es',
						'format' => 'yyyy-mm-dd',
						'endDate' => date("Y-m-d"),
						'startDate' => date('Y-m-d' , strtotime('-2 Year', strtotime(date("Y-m-d")))),
						'autoclose' => true,
					),
					'htmlOptions' => array('value'=>date("Y-m-d"), 'readonly'=>true, 'style'=>'background-color: white;'),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				//'hint' => 'Click inside! This is a super cool date field.',
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>
	</div>

	<div class="col-lg-12">
		<?php echo $form->datePickerGroup(
			$model,
			'fecha_fin',
			array(
				//'value' => date("Y-m-d"),
				'widgetOptions' => array(
					'options' => array(
						'language' => 'es',
						'format' => 'yyyy-mm-dd',
						'endDate' => date("Y-m-d"),
						'startDate' => date('Y-m-d' , strtotime('-2 Year', strtotime(date("Y-m-d")))),
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

</div>
<div class="row col-lg-6">
	<div class="col-lg-12">
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
					//'data'=>CHtml::listData(PromocionesPremium::model()->findAll(), 'id_promo', 'nombrePromo'),
					//'value' => 'null',
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

