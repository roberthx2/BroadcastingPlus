<?php 
$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'seleccionForm',
	'type'=>'vertical',
	
        'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions' => array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>true,
                'validateOnType'=>true,
        ),
)); ?>
        

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row">
            <div class="col-md-12">

                <?php echo $form->dropDownListGroup(
			$model,
			'productosId',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
	   			'widgetOptions' => array(
	   				'data' => array_unique($productosArray),
					'htmlOptions' => array('multiple' => true),
				)
			)
		); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <?php echo $form->checkboxListGroup(
			$model,
			'operadoras',
			array(
				'widgetOptions' => array(
					'data' => $operadoras
				),
				'inline'=>true
			)
		); ?>
            </div>
        </div>


        <?php 
//      	$this->widget('booster.widgets.TbButton', 
//                        array(
//                      
//                            'context' => 'success',
//                            'label'=>'submit', 
//                            'icon' => 'ok',
//                            'buttonType'=>'ajaxSubmit',
//                            'url'=>Yii::app()->createUrl('btl/getNumeros'),
//                            'ajaxOptions'=>array( 
//                            'update'=>'#pruebaE',
//                            'beforeSend'=>'function(){$("#fieldProductos").addClass("loading");}',
//                            'complete'=>'function(){$("#fieldProductos").removeClass("loading");}',
//                            'success'=>'function(data){ alert(data);}',
//                            ),  
//                            'htmlOptions' => array(
//                            'id' => 'sendBtlData',
//                            'class' => 'pull-center follow-page-btn' )
//                            
//        
//                    )); 
        ?>
        

<?php $this->endWidget(); unset($form); ?>



<script>
$( document ).ready(function() {
    $("#Producto_operadoras_3").prop('checked', true);
});

$("#Producto_operadoras_2").change(function() {
        $("#Producto_operadoras_3").prop('checked', false);
});

$("#Producto_operadoras_1").change(function() {
        $("#Producto_operadoras_3").prop('checked', false);
});

$("#Producto_operadoras_0").change(function() {
        $("#Producto_operadoras_3").prop('checked', false);
});

$("#Producto_operadoras_3").change(function() {
        $("#Producto_operadoras_2").prop('checked', false);
        $("#Producto_operadoras_1").prop('checked', false);
        $("#Producto_operadoras_0").prop('checked', false);
});
$('#sendBtlData').on('click', function() {
    $.ajax({
            beforeSend: function() {
                $("#fieldBTL").addClass("loading");
            },
            complete: function() {
                $("#fieldBTL").removeClass("loading");
            },
            data: $("#seleccionForm").serialize(),
            type: "POST",
            url: '<?php echo Yii::app()->createUrl('btl/getNumeros'); ?>',
           // data: $("#claveTransaccionesForm").serialize(), 
            success: function(data){
                if(data!="-1"){
                    $("textarea#Promociones_numerosBtl").val(data);
//                    bootbox.alert("Se genero data BTL");
                }else{
//                    bootbox.alert("No hay data BTL");
                }
               // $("textarea#numerosBTLTextArea").val(data); 
                

            }
    });
});


</script>