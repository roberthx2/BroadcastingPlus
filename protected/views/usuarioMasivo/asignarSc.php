
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
	        'id' => 'usuarioMasivoSc-form',
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
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs"><b style="font-size: 21px;"> Asignar Short Code </b></div> <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="center" style=""><img class="img" src="<?php echo Yii::app()->request->baseUrl; ?>/img/user.png" align="middle" width="28" height="28"> &nbsp;&nbsp;<b> <?php echo UsuarioSmsController::actionGetLogin($model->id_usuario); ?></b></div>
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
    <div class="container-fluid alert alert-danger" id="div_error" style="display:none;"></div>
	<?php echo $form->hiddenField($model, 'id_usuario'); ?>

	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<?php echo $form->dropDownListGroup(
				$model,
				'id_cliente_sms',
				array(
					'wrapperHtmlOptions' => array(
					),
					'widgetOptions' => array(
						'data' => CHtml::listData(Yii::app()->Procedimientos->getClientesBCP($model->id_usuario, true), 'id_cliente', 'descripcion'),
						'htmlOptions' => array('multiple' => false, 'onChange'=>'js:getScBcp()'),
					),
					'prepend' => '<i class="glyphicon glyphicon-tags"></i>',
				)
			); ?>

			<?php echo $form->dropDownListGroup(
				$model,
				'sc',
				array(
					'wrapperHtmlOptions' => array(
					),
					'widgetOptions' => array(
						'htmlOptions' => array('multiple' => false, 'onChange'=>'js:getInfUsuario()'),
					),
					'prepend' => '<i class="glyphicon glyphicon-tags"></i>',
				)
			); ?>
	</div>

	<div id="div_operadoras" class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="display: none;">
		<?php 
			echo $this->widget(
				    'booster.widgets.TbSwitch',
				    array(
				        'name' => "null",
					    'value' => 0,
					    'htmlOptions'=> array('class'=> 'operadora'),
					    'options' => array(
					    	'onColor'=>'success', 
							'offColor'=>'danger',
					    )
				    )
				, true);
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

	function getScBcp()
	{
		if ($("#UsuarioMasivoScForm_id_cliente_sms").val() != "")
		{
			$.ajax({
	            url: "<?php echo Yii::app()->createUrl('/usuarioMasivo/getScBcp'); ?>",
	            type: "POST",
	            dataType: 'json',    
	            data:{id_usuario:$("#UsuarioMasivoScForm_id_usuario").val(), sc:$("#UsuarioMasivoScForm_sc").val(), id_cliente_sms:$("#UsuarioMasivoScForm_id_cliente_sms").val()},
	            
	            beforeSend: function(){
                    $("#div_operadoras").hide();
		            $("#div_error").hide();
                },
	            success: function(response)
	            {
	            	if (response.error == "false")
		           	{
		            	var sc = response.data;;

	                    $("#UsuarioMasivoScForm_sc").empty();
	                    var sc = response.data;
	                    $.each(sc, function(i, value) {
	                        $("#UsuarioMasivoScForm_sc").append($("<option>").text(value.sc).attr("value",value.sc));
	                    });

	                    getInfUsuario();
                	}
                	else
                	{
                		$("#UsuarioMasivoScForm_sc").empty();
                         $("#div_error").html('<span class="glyphicon glyphicon-ban-circle"></span> '+response.status).show();
                        $("#div_operadoras").hide();
                	}
	            },
	            error: function()
	            {
	                alert("Ocurrio un error al cargar los short codes del cliente");
	            }
	        });
		}
	}

	function getInfUsuario()
	{
		if ($("#UsuarioMasivoScForm_sc").val() != "")
		{
			$.ajax({
	            url: "<?php echo Yii::app()->createUrl('/usuarioMasivo/getInfUsuario'); ?>",
	            type: "POST",
	            dataType: 'json',    
	            data:{id_usuario:$("#UsuarioMasivoScForm_id_usuario").val(), sc:$("#UsuarioMasivoScForm_sc").val(), id_cliente_sms:$("#UsuarioMasivoScForm_id_cliente_sms").val()},
	            
	            beforeSend: function(){
                    $("#div_operadoras").hide();
		            $("#div_error").hide();
                },
	            success: function(response)
	            {
	            	if (response.error == "false")
                    {
                        var oper_usuario = response.operadoras_usuario;
                        var oper_cliente = response.operadoras_cliente;

                        $("#div_operadoras").html("<center>"+oper_cliente+"</center>");
                        $(".operadora").bootstrapSwitch("onColor", "success");
                        $(".operadora").bootstrapSwitch("offColor", "danger");
                        $("#div_operadoras").show();
                        activarOperadoras(oper_usuario);
                    }
                    else
                    {
                        $("#div_error").html('<span class="glyphicon glyphicon-ban-circle"></span> '+response.status).show();
		                $("#div_operadoras").hide();
                    }
	            },
	            error: function()
	            {
	                alert("Ocurrio un error al cargar la información del usuario");
	            }
	        });
		}
	}

	$(document).ready(function() 
    {
    	getScBcp();
    });

</script>