<?php /*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#configuracion-sistema-acciones-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>


<?php
/* @var $this ConfiguracionSistemaAccionesController */
/* @var $model ConfiguracionSistemaAcciones */


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#configuracion-sistema-acciones-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br>
<?php if(Yii::app()->user->hasFlash('success')):?>
	<br>
    <div class="container-fluid alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="glyphicon glyphicon-ok"></span> <?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif; ?>

<fieldset>
 
    <legend>Configurar Sistema</legend>


<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'configuracion-sistema-acciones-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
        		'class' => 'booster.widgets.TbEditableColumn',
	            'name' => 'nombre',
	            'header' => 'Nombre',
	            //'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'editable' => array(    //editable section
                  	//'apply'      => '$data->user_status != 4', //can't edit deleted users
                  	'url'        => $this->createUrl('lista/editableSaver'),
                  	'params' => array("model"=>"Lista"),
                  	//'showbuttons' => false,
                  	//'inputclass' => 'input-mini',
                  	//'placement'  => 'right',
                  	'title' => '',
                  	'success' => 'js: function(response, newValue) {
				       if(!response.success) return response.msg;
				    }',
				   	'options' => array(
				    	'ajaxOptions' => array('dataType' => 'json')
				   	), 
				   	
              	)
        	),/*
        	array(
        		'class' => 'booster.widgets.TbEditableColumn',
	            'name' => 'descripcion',
	            'header' => 'Descripcion',
	            //'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'editable' => array(    //editable section
                  	//'apply'      => '$data->user_status != 4', //can't edit deleted users
                  	'url'        => $this->createUrl('lista/editableSaver'),
                  	'params' => array("model"=>"Lista"),
                  	//'showbuttons' => false,
                  	//'inputclass' => 'input-mini',
                  	//'placement'  => 'right',
                  	'title' => '',
                  	'success' => 'js: function(response, newValue) {
				       if(!response.success) return response.msg;
				    }',
				   	'options' => array(
				    	'ajaxOptions' => array('dataType' => 'json')
				   	), 
				   	
              	)
        	),*/
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{Editar}',
	            'headerHtmlOptions' => array('class'=>'tableHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'Editar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl($data["action"], array("id" => $data["id"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-pencil', 'title'=>'Editar Configuración', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalEditar'),
	            			)
	            ),
	        ),
        ),
    ));
?>
</fieldset>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEditar')
); ?>

<div class="modal-header" style="background-color:#428bca">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar Configuración</h4>
    </div>
 	
    <div class="modal-body trOverFlow" id="divModalEditar" >
       
    </div>
 
<?php $this->endWidget(); ?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("a[data-toggle=modal]").click(function(){
		    var target = $(this).attr('data-target');
		    var url = $(this).attr('href');
		    if(url){
		        $(target).find(".modal-body").load(url);
		    }
		});

		$('[data-tooltip="tooltip"]').tooltip();
	});

	function enviar(form,data,hasError)
    {alert("ok");
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

</script>