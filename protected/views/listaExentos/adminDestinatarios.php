
<br>

<?php
	Yii::app()->clientScript->registerScript('searchUpdateLista', "

	$('.search-form form').submit(function(){
	    $('#listaUpdate-grid').yiiGridView('update', {
	        data: $(this).serialize()
	    });
	    return false;
	});

	");
?>

<fieldset>
 
    <legend>Administrar Lista de Exentos</legend>


<div class="clearfix visible-xs-block"></div>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs ">
    <?php $this->renderPartial('busqueda',array('model'=>$model_destinatarios, 'id_lista'=>$id_lista)); ?>
</div><!-- search-form -->

<?php 
	$this->widget(
        'booster.widgets.TbButton',
        array(
        	'id'=>'agregar',
        	'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Agregar Números',
            'icon' => 'glyphicon glyphicon-plus',
            'url' => Yii::app()->createUrl("listaExentos/addNumbers", array("id_lista"=>$id_lista)),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        )
    ); 
?>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 visible-xs ">
    <?php $this->renderPartial('busqueda',array('model'=>$model_destinatarios, 'id_lista'=>$id_lista)); ?>
</div><!-- search-form -->

<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'listaUpdate-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model_destinatarios->search($id_lista),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'selectableRows' => 2,
        'bulkActions' => array(
		    'actionButtons' => array(
		        array(
			            'buttonType' => 'button',
			            'context' => 'danger',
			            'size' => 'small',
			            'label' => 'Eliminar Numero(s)',
			            'click' => 'js:confirmar',
			            'id' => 'boton_eliminar',
			            'icon' => 'glyphicon glyphicon-trash',
			            'htmlOptions' => array('class'=>'','data-toggle' => 'modal', 'data-target' => '#modalEliminar'),
		            ),
		    ),
		        // if grid doesn't have a checkbox column type, it will attach
		        // one and this configuration will be part of it
	        'checkBoxColumnConfig' => array(
	            'name' => 'numero',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	        ),
	    ),
        'columns'=> array( 
        	array(
	            'name' => 'numero',
	            'header' => 'Número',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'o.descripcion',
	            'header' => 'Operadora',
                'value' => function($data)
                {
                    Controller::widget(
                        'booster.widgets.TbLabel',
                        array(
                            'context' => '',
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => $data["descripcion_oper"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorOperadoraBCNL($data["id_operadora"]).';'),    
                        )
                    );
                },
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        ),
    ));
?>
</fieldset>
	
<input type="hidden" id="numeros_eliminar" value="">

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEliminar')
); ?>
 
    <div class="modal-header" style="background-color:#d2322d">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar Número(s)</h4>
    </div>
 	
    <div class="modal-body" id="divModalEliminar" >
       
    </div>

    <div class="modal-footer" id="modal_footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
            	'id'=>'confirmar',
                'context' => 'danger',
                'label' => 'Confirmar',
                //'url' => Yii::app()->createUrl("lista/deleteNumero"),
                'icon' => 'glyphicon glyphicon-trash',
                'htmlOptions' => array('data-loading-text'=>'Eliminando...', 'autocomplete'=>'off'),
            )
        ); ?>
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Cerrar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>

<script type="text/javascript">

	function confirmar(values)
	{
		//var total = values.length;
		var mensaje = "<center><strong>¿Confirma eliminar "+values.length+" número(s)?</strong></center>";
		$("#numeros_eliminar").val(values);
		$("#divModalEliminar").html(mensaje);
		$("#modal_footer").show();
	}

	$(document).ready(function()
	{
		$("a[data-toggle=modal]").click(function(){
		    var target = $(this).attr('data-target');
		    var url = $(this).attr('href');
		    if(url){
		        $(target).find(".modal-body").load(url);
		    }
		});

		$('#confirmar').click(function(){
			var id_lista = "<?php echo $id_lista; ?>";
		    $.ajax({
                url:"<?php echo Yii::app()->createUrl('listaExentos/deleteNumber'); ?>",
                type:"POST",    
                data:{id_lista:id_lista, numeros:$("#numeros_eliminar").val()},
                
                complete: function()
                {
                    //alert("termine");
                },
                success: function(data)
                {
                	if (data.salida !== 0)
                	{
                		var mensaje = "<center><strong>Registro(s) eliminado(s) correctamente</center></strong>";
                		$("#listaUpdate-grid").yiiGridView("update"); 
                		
                	}
                	else
                	{
                		var mensaje = "<center><strong>No se pudo eliminar ningún número, intente nuevamente</center></strong>";
                	}

                    $("#divModalEliminar").html(mensaje);
                    $("#modal_footer").hide();
                },
                error: function()
                {
                    $("#divModalEliminar").html("<center><strong>Ocurrio un ERROR al intentar eliminar los números</center></strong>");
                    $("#modal_footer").hide();
                }
            });
		});
	});
</script>