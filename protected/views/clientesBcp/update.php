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
<fieldset>
 
	<legend>Editar Cliente BCP</legend>
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
        <span class="glyphicon glyphicon-ban-circle"></span> El cliente seleccionado no posee Short Code asociados
	</div>

	<div id="div_id_cliente" class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		<?php echo $form->dropDownListGroup(
			$model,
			'id_cliente',
			array(
				'wrapperHtmlOptions' => array(
					//'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
					//'style'=>'display: none;',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData($clientes, 'Id_cliente', 'Des_cliente'),
					//'value' => 'null',
					'htmlOptions' => array('prompt' => 'Seleccionar...',
					'ajax' => array(
                        'type'=>'POST', //request type
                        'dataType' => 'json',
                        'url'=>Yii::app()->createUrl('/clientesBcp/getSc'), //url to call.
                        'data' => array('id_cliente' => 'js:$("#ClientesBcpForm_id_cliente").val()'),
                        'beforeSend' => 'function(){
                        	$("#div_error").hide();
                        }',
                        'success' => 'function(response){
                                if (response.error == "false")
                                {
                                    $("#'.CHTML::activeId($model,'sc').'").empty();
                                    var sc = response.data;
                                    $.each(sc, function(i, value) {
                                        $("#'.CHTML::activeId($model,'sc').'").append($("<option>").text(value.sc_id).attr("value",value.sc_id));
                                    });
                                }
                                else
                                {
                                    $("#'.CHTML::activeId($model,'sc').'").empty();
                                    $("#div_error").show();
                                    console.log(response.status);
                                }
                            }'
                		),
					),
				),
				'prepend' => '<i class="glyphicon glyphicon-user"></i>',
			)
		); ?>
	</div>

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
						'htmlOptions' => array('prompt' => 'Seleccionar sc...','multiple' => false),
					),
					'prepend' => '<i class="glyphicon glyphicon-tags"></i>',
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
		echo CHtml::submitButton('Crear Cliente', array('id' => 'bontonCrear', 'class'=>'btn btn-success'));
		$this->endWidget();
	    unset($form);
	?>
	</div>
</fieldset>

<script type="text/javascript">

	$(document).ready(function() 
    {
    	if ($("#ClientesBcpForm_id_cliente").val() != "")
		{
			$.ajax({
	            url: "<?php echo Yii::app()->createUrl('/clientesBcp/getSc'); ?>",
	            type: "POST",
	            dataType: 'json',    
	            data:{id_cliente:$("#ClientesBcpForm_id_cliente").val()},
	            
	            beforeSend: function(){
                    $("#div_error").hide();
                },
	            success: function(response)
	            {
	            	if (response.error == "false")
	                {
	                	var sc_id = "<?php echo $model->sc; ?>";

	                	$("#ClientesBcpForm_sc").empty();

	                	var sc = response.data;
                        $.each(sc, function(i, value) {
                            $("#ClientesBcpForm_sc").append($("<option>").text(value.sc_id).attr("value",value.sc_id));
                        });

                        $("#ClientesBcpForm_sc option[value='" + sc_id + "']").prop("selected", true);
	                }
	                else
	                {
	                	$("#ClientesBcpForm_sc").empty();
                        $("#div_error").show();
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