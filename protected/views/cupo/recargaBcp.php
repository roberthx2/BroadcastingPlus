<?php
/* @var $this ListaController */
/* @var $model Lista */
/* @var $form CActiveForm */
?>
<br>

<?php if(Yii::app()->user->hasFlash('danger')):?>
	<br>
    <div class="container-fluid">
	        <div class="alert alert-danger">
	          <button type="button" class="close" data-dismiss="alert">&times;</button>
	          <span class="glyphicon glyphicon-ban-circle"></span> <?php echo Yii::app()->user->getFlash('danger'); ?>
	        </div>
	    </div>
<?php endif; ?>

<div class="form col-xs-12 col-sm-6 col-md-6 col-lg-6" >

<?php 

$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'cupoBcp-form',
		'type' => 'horizontal',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
            //'afterValidate'=>'js:enviar'
        ),
	)
); ?>
	

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php if (Yii::app()->user->isAdmin()){ ?>

		<?php
			$criteria = new CDbcriteria;
			$criteria->select = "t.id_usuario, t.login";
			$criteria->join = "INNER JOIN insignia_masivo_premium.permisos p ON t.id_usuario = p.id_usuario";
			$criteria->compare("p.acceso_sistema", 1);
			$criteria->compare("p.broadcasting_premium", 1);
			$criteria->order = "login ASC";
		?>
		<div>
			<?php echo $form->dropDownListGroup(
				$model,
				'id_usuario',
				array(
					'wrapperHtmlOptions' => array(
						//'class' => 'col-sm-5',
					),
					'widgetOptions' => array(
						//'data' => CHtml::listData(UsuarioMasivo::model()->findAll(array("order"=>"login")), 'id_usuario', 'login'),
						'data' => CHtml::listData(UsuarioMasivo::model()->findAll($criteria), 'id_usuario', 'login'),
						'htmlOptions' => array('prompt' => 'Seleccionar...'),
					),
					'prepend' => '<i class="glyphicon glyphicon-user"></i>',
					'hint' => 'En caso de seleccionar un usuario, el cupo sera asignado a dicho usuario',
				)
			); ?>
		</div>
	<?php } ?>

	<div>
		<?php echo $form->textFieldGroup(
				$model,
				'cantidad',
				array(
					'wrapperHtmlOptions' => array(
						//'class' => 'col-sm-5',
					),
					'widgetOptions' => array(
						'htmlOptions' => array('placeholder' => 'Cantidad', 'autocomplete'=>'off'),
					),
					'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
				)
			); ?>
	</div>

	<br><br>
	<div class="">
		<center><?php
            echo CHtml::submitButton('Recargar', array('id' => 'bontonRecargar', 'class'=>'btn btn-success', 'js:onClick=updateInfoBcp();'));
        ?>
		</center>
	</div>

</div><!-- form -->
<?php $this->endWidget(); unset($form); ?>


<div class="form col-xs-12 col-sm-6 col-md-6 col-lg-6" >
	<br>
	<?php $this->renderPartial('recargaBcpDetalle'); ?>
</div>

<script type="text/javascript">
    function enviar(form,data,hasError)
    {
        if(!hasError)
        {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl('prefijoPromocion/create2'); ?>",
                type:"POST",    
                data:$("#prefijo-promocion-form").serialize(),
                
                beforeSend: function()
                {
                   // $("#bontonCrear").attr("disabled",true);
                   $("#prefijo-promocion-form div.form-group").removeClass("has-error").removeClass("has-success");
                   $("#PrefijoPromocion_prefijo_em_").hide();
                   $("#respuesta").hide();
                },
                complete: function()
                {
                    //alert("termine");
                   // $("#prefijo-promocion-form div.form-group").removeClass("has-error").removeClass("has-success");
                   // $("#PrefijoPromocion_prefijo_em_").hide();
                    //$("#respuesta").hide();
                },
                success: function(data)
                {
                    if (data.salida == 'true')
                    {
                    	$("#PrefijoPromocion_prefijo").val("");
                    	$("#prefijo-promocion-form div.form-group").addClass("has-success");
                        $("#respuesta").html("El prefijo fue creado correctamente");
                        $("#respuesta").show();

                        $('#prefijo-promocion-grid').yiiGridView('update', {
							data: $(this).serialize()
						});
						return;
                    }
                    else (data.salida == 'false')
                    {
                    	$("#prefijo-promocion-form div.form-group").addClass("has-error");
                    	$("#PrefijoPromocion_prefijo_em_").show();

                        var error = data.error.prefijo;

                        $.each(error, function(i, value) {
                            $("#PrefijoPromocion_prefijo_em_").html(value);
                        });
                        return;
                    }
                    
                   // $("#bontonCrear").attr("disabled",false);
                },
                error: function()
                {
                	//$("#respuesta").show();
                    //$("#respuesta").html("Ocurrio un error al procesar los datos intente nuevamente" + data);
                    //$("#bontonCrear").attr("disabled",false);
                }
            });
        }

        return false;
    }

    function updateInfoBcp()
    {
    	$.ajax({
            url:"<?php echo Yii::app()->createUrl('cupo/getInfoCupoBcp'); ?>",
            type:"POST",
            dataType:'json',    
            data:$("#cupoBcp-form").serialize(),
            
            beforeSend: function()
            {

            },
            complete: function()
            {

            },
            success: function(data)
            {
                $(".detalleUsuarioBCP").text(data.login);
                $(".detalleDisponibleoBCP").text(data.cupo_disponible);
                $(".detalleUltimaRecargaBCP").text(data.fecha);
                $(".detalleEjecutadoPorBCP").text(data.ejecutado_por);
            },
            error: function()
            {

            }
        });
    }

    $(document).ready(function() 
    {
        updateInfoBcp();
    });

</script>

