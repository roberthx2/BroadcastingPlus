<?php
/* @var $this PrefijoPromocionController */
/* @var $model PrefijoPromocion */

Yii::app()->clientScript->registerScript('searchPrefijo', "
$('.search-form form').submit(function(){
	$('#prefijo-promocion-grid').yiiGridView('update', {
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

<h1>Administrar Prefijos</h1>
<br>

<div class="search-form">
    <?php $this->renderPartial('_search',array('model'=>$model, 'id_usuario'=>$id_usuario)); ?>
</div><!-- search-form -->

<div class="add-prefijo-form">
    <?php $this->renderPartial('create',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'prefijo-promocion-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchPrefijo($id_usuario),
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
			            'label' => 'Eliminar Prefijo(s)',
			            'click' => 'js:confirmar',
			            'id' => 'boton_eliminar',
			            'icon' => 'glyphicon glyphicon-trash',
			            'htmlOptions' => array('class'=>'','data-toggle' => 'modal', 'data-target' => '#modalEliminar'),
		            ),
		    ),
		        // if grid doesn't have a checkbox column type, it will attach
		        // one and this configuration will be part of it
	        'checkBoxColumnConfig' => array(
	            'name' => 'id',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	        ),
	    ),
        'columns'=> array( 
        	array(
	            'name' => 'u.login',
	            'value' => '$data["login"]',
	            'header' => 'Usuario',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
        		'class' => 'booster.widgets.TbEditableColumn',
	            'name' => 'prefijo',
	            'header' => 'Prefijo',
	            //'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'editable' => array(    //editable section
                  	//'apply'      => '$data->user_status != 4', //can't edit deleted users
                  	'url'        => $this->createUrl('lista/editableSaver'),
                  	'params' => array("model"=>"PrefijoPromocion"),
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
        	),
        ),
    ));
?>

<input type="hidden" id="prefijos_eliminar" value="">

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEliminar')
); ?>
 
    <div class="modal-header" style="background-color:#d2322d">
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar Prefijo(s)</h4>
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
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>

<script type="text/javascript">
	function confirmar(values)
	{
		var mensaje = "<center><strong>¿Confirma eliminar "+values.length+" prefijo(s)?</strong></center>";
		$("#prefijos_eliminar").val(values);
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

		$('[data-tooltip="tooltip"]').tooltip();

		$('#confirmar').click(function(){
		    $.ajax({
                url:"<?php echo Yii::app()->createUrl('prefijoPromocion/deletePrefijo'); ?>",
                type:"POST",    
                data:{id:$("#prefijos_eliminar").val()},

                success: function(data)
                {
                	if (data.salida !== 0)
                	{
                		var mensaje = "<center><strong>Prefijo(s) eliminado(s) correctamente</center></strong>";
                		$("#prefijo-promocion-grid").yiiGridView("update"); 
                	}
                	else
                	{
                		var mensaje = "<center><strong>No se pudo eliminar ningún prefijo, intente nuevamente</center></strong>";
                	}

                    $("#divModalEliminar").html(mensaje);
                    $("#modal_footer").hide();
                },
                error: function()
                {
                    $("#divModalEliminar").html("<center><strong>Ocurrio un ERROR al intentar eliminar los prefijo</center></strong>");
                    $("#modal_footer").hide();
                }
            });
		});
	});
</script>