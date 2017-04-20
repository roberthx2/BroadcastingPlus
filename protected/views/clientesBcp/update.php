
<?php
	$flashMessages = Yii::app()->user->getFlashes();
	if ($flashMessages) {
	    echo '<br><div class="container-fluid">';
	    foreach($flashMessages as $key => $message) {
	        echo '<div class="alert alert-'.$key.'">';
	        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	        echo '<span class="glyphicon glyphicon-'. (($key == "success") ? "ok":"ban-circle").'"></span> '.$message;
	    }
	    echo '</div></div>';
	}
?>

<?php
	$form = $this->beginWidget(
	    'booster.widgets.TbActiveForm',
	    array(
	        'id' => 'clienteBcp-form',
	        'type' => 'vertical',
	        'enableAjaxValidation'=>false,
	        'enableClientValidation'=>true,
	        'clientOptions' => array(
	            'validateOnSubmit'=>true,
	            'validateOnChange'=>false,
	            //'afterValidate'=>'js:validarDatos'
	        ),
	    )
	);
?>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs"><b style="font-size: 21px;"> Editar Cliente BCP </b></div> <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="center" style=""><img class="img" src="<?php echo Yii::app()->request->baseUrl; ?>/img/user.png" align="middle" width="28" height="28"> &nbsp;&nbsp;<b> <?php echo ReportesController::actionGetDescripcionClienteBCNL($model->id_cliente); ?></b></div>
<br><HR width=100% align="center">

	<br>
	<?php
        $flashMessages = Yii::app()->user->getFlashes();
        if ($flashMessages) {
            echo '<br><div class="container-fluid">';
            foreach($flashMessages as $key => $message) {
                echo '<div class="alert alert-'.$key.'">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<span class="glyphicon glyphicon-'. (($key == "success") ? "ok":"ban-circle").'"></span> '.$message;
            }
            echo '</div></div>';
        }
    ?>
	<br>
    <div class="container-fluid alert alert-danger" id="div_error" style="display:none;">
        <span class="glyphicon glyphicon-ban-circle"></span> El SC no posee operadoras asociadas.
	</div>
	<?php echo $form->hiddenField($model, 'id_cliente'); ?>

	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<?php echo $form->dropDownListGroup(
				$model,
				'sc',
				array(
					'wrapperHtmlOptions' => array(
						//'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
						//'style'=>'display: none;',
					),
					'widgetOptions' => array(
						'data' => $sc,
						'htmlOptions' => array(/*'prompt' => 'Seleccionar sc...',*/'multiple' => false, 
							'ajax' => array(
		                        'type'=>'POST', //request type
		                        'dataType' => 'json',
		                        'url'=>Yii::app()->createUrl('/clientesBcp/getInfCliente'), //url to call.
		                        'data' => array('id_cliente_sms' => 'js:$("#ClientesBcpForm_id_cliente").val()', 'sc' => 'js:$("#ClientesBcpForm_sc").val()'),
		                        'beforeSend' => 'function(){
		                        	reiniciarOperadoras();
		                        	$("#div_error").hide();
		                        }',
		                        'success' => 'function(response){
		                                if (response.error == "false")
		                                {
		                                    var data = response.data;
		                                    activarOperadoras(data);
		                                }
		                                else
		                                {
		                                    $("#div_error").show();
		                                    console.log(response.status);
		                                }
		                            }'
		                		),	
						),
					),
					'prepend' => '<i class="glyphicon glyphicon-tags"></i>',
					'hint' => 'Haz clic <a href="'.Yii::app()->createUrl("/clientesBcp/activateCliente", array("id_cliente_sms"=>$model->id_cliente)).'">aqui</a> para habilitar los SC que no aparecen en esta lista',
				)
			); ?>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
		<?php 
			echo "<center>".$operadoras."</center>";
		?>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">	
		<br><br>
	<?php
		echo CHtml::submitButton('Guardar Cambios', array('id' => 'bontonCrear', 'class'=>'btn btn-success'));
		$this->endWidget();
	    unset($form);
	?>
	</div>

<script type="text/javascript">

	function reiniciarOperadoras()
	{
		$(".operadora").each(function () 
		{ 
			if( $(this).is(":checked") ) 
				$(this).click(); 
		});

		$(".sc_alf").val("");
	} 

	function activarOperadoras(data)
	{
        $.each(data, function(i, value)
        {
            $("#operadora_"+ value.id_operadora + "_" + value.alfanumerico).click();

            if (value.alfanumerico == 1)
            {
            	$(".sc_alf_" + value.id_operadora).val(value.sc);
            }
        });
	}

	$(document).ready(function() 
    {
    	if ($("#ClientesBcpForm_sc").val() != "")
		{
			$.ajax({
	            url: "<?php echo Yii::app()->createUrl('/clientesBcp/getInfCliente'); ?>",
	            type: "POST",
	            dataType: 'json',    
	            data:{id_cliente_sms:$("#ClientesBcpForm_id_cliente").val(), sc:$("#ClientesBcpForm_sc").val()},
	            
	            beforeSend: function(){
                    $("#div_error").hide();
                },
	            success: function(response)
	            {
	            	if (response.error == "false")
                    {
                        var data = response.data;
                        activarOperadoras(data);
                    }
                    else
                    {
                        $("#div_error").show();
                        //console.log(response.status);
                    }
	            },
	            error: function()
	            {
	                alert("Ocurrio un error al cargar la información del cliente");
	            }
	        });
		}
    });

</script>