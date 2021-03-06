
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

<fieldset>
    <div class="container-fluid alert alert-success" id="div_success" style="display:none;">
          <span class="glyphicon glyphicon-ok"></span> <?php echo "Actualización realizada exitosamente" ?>
    </div>

    <legend>Configurar Sistema</legend>

<div class="BCP col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

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
              'name' => 'nombre',
              'header' => 'Nombre',
              'sortable' => false,
              'type' => 'raw',
              'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
              'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
          ),
          array(
             // 'name' => 'c.valor',
              'header' => 'Valor',
              'value' => function($data)
              {
                  return $data["valor"];
              },
              'type' => 'raw',
              'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
              'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
          ),
        	array(
              //'name' => 'c.descripcion',
              'value' => function($data)
              {
                  return $data["descripcion"];
              },
              'header' => 'Descripción',
              'type' => 'raw',
              'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
              'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
          ),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{Editar}',
	            'headerHtmlOptions' => array('class'=>'tableHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'Editar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("configuracionSistemaAcciones/formulario", array("id" => $data["id"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-pencil', 'title'=>'Editar Configuración', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalEditar'),
                    'click' => 'function(){
                          $.ajax({
                              beforeSend: function(){
                                 $("#divModalEditar").addClass("loading");
                              },
                              complete: function(){
                                 $("#divModalEditar").removeClass("loading");
                              },
                              type: "POST",
                              url: $(this).attr("href"),
                              success: function(data) { 
                                  $("#divModalEditar").html(data);
                              },
                              error: function() { 
                                  alert("No se puede cargar el formulario, intente de nuevo.");
                              }
                          });
                      }'
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

  function enviar()
  {
    $.ajax({
        url:"<?php echo Yii::app()->createUrl('configuracionSistemaAcciones/update'); ?>",
        type:"POST",    
        data:$("#configuracion-form").serialize(),
        
        beforeSend: function()
        {
          $("#boton_guardar i.fa").removeClass("fa-floppy-o").addClass("fa-spinner fa-spin");
          $("#boton_guardar").addClass("disabled");
          $("#configuracion-form div.form-group").removeClass("has-error").removeClass("has-success");
          $("#ConfiguracionSistemaAcciones_valor_em_").hide();
          $("#div_success").hide();
        },
        complete: function()
        {
          $("#boton_guardar i.fa").removeClass("fa-spinner fa-spin").addClass("fa-floppy-o");
          $("#boton_guardar").removeClass("disabled");
        },
        success: function(data)
        {
          if (data.salida == 'true')
          {
            $("#configuracion-form div.form-group").addClass("has-success");
              $("#respuesta").html("Actualizacion realizada exitosamente");
              $("#div_success").show();

              $('#configuracion-sistema-acciones-grid').yiiGridView('update', {
                data: $(this).serialize()
              });

              $("#modalEditar .close").click()

              return;
          }
          else (data.salida == 'false')
          {
            $("#configuracion-form div.form-group").addClass("has-error");
            $("#ConfiguracionSistemaAcciones_valor_em_").show();

              var error = data.error.valor;

              $.each(error, function(i, value) {
                  $("#ConfiguracionSistemaAcciones_valor_em_").html(value);
              });
              return;
          }
        },
        error: function()
        {
        }
    });
  }

</script>