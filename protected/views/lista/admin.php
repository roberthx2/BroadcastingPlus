<?php
/* @var $this ListaController */
/* @var $model Lista */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#lista-grid').yiiGridView('update', {
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

<?php $mensaje = "Las listas pendientes podrán ser usadas una vez sean analizadas por el sistema. Horarios de análisis:  Lun-Juev - 06:00 am / 10:00 am / 01:00 pm / 03:00 pm 	/	Vie-Dom - 06:00 am / 10:00 am / 02:00 pm"; ?>

<fieldset>
  
    <legend>Administrar Listas <i class="fa fa-commenting" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo $mensaje; ?>"></i></legend>

<div class="search-form">
    <?php $this->renderPartial('_search',array('model'=>$model, 'id_usuario'=>$id_usuario)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'lista-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchTmp($id_usuario),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
	            'name' => 'u.login',
	            'value' => '$data["login"]',
	            'header' => 'Usuario',
	            'type' => 'raw',
//	            'ajaxUpdate'=>true,
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
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
        	),
        	array(
	            'name' => 'fecha',
	            'header' => 'Fecha',
	            'type' => 'raw',
	            'value' => function($data) {
	            	return ($data["fecha"] == '0000-00-00') ? '-' : $data["fecha"];
	            },
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover')
        	),
        	array(
        		'name' => 'estado',
	            'header' => 'Estado',
	            'type' => 'raw',
	            'value' => function($data) {
	            	
	            	$bg = Yii::app()->Funciones->getColorValidoInvalido($data["estado"]);

	            	Controller::widget(
					    'booster.widgets.TbLabel',
					    array(
					        'label' => ($data["estado"] == 1) ? "Analizada" : "Pendiente",
					        'htmlOptions'=>array('style'=>'background-color: '.$bg.';'),	
					    )
					);
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'total',
	            'header' => 'Total Destinatarios',
	            'type' => 'number',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover'),
        	),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{Editar}&#09;{Descargar}&#09;{Eliminar}',
	            'headerHtmlOptions' => array('class'=>'tableHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'Editar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("lista/update", array("id"=>$data["id_lista"]))',
	            			//'visible'=>'visibleConfirmar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-pencil', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Editar Lista', 'style'=>'color:black;'),
	            			'click' => 'function() {
                                    $(".loader_superior").css("display", "block");
                                }'
	            			),
	            	'Descargar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("lista/descargarLista", array("nombre" => $data["nombre"], "id_lista" => $data["id_lista"]))',
	            			//'visible'=>'visibleCancelar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-download-alt', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Descargar Lista', 'style'=>'color:black;',),
	            			),
	            	'Eliminar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("lista/viewDelete", array("id_lista" => $data["id_lista"]))',
	            			//'visible'=>'visibleCancelar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-trash', 'title'=>'Eliminar Lista', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalEliminar'),
	            			'click' => 'function(){
                                    $.ajax({
                                        beforeSend: function(){
                                           $("#divModalEliminar").addClass("loading");
                                        },
                                        complete: function(){
                                           $("#divModalEliminar").removeClass("loading");
                                        },
                                        type: "POST",
                                        url: $(this).attr("href"),
                                        success: function(data) { 
                                            $("#divModalEliminar").html(data);
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
    array('id' => 'modalEliminar')
); ?>
 
    <div class="modal-header" style="background-color:#d2322d">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar Lista</h4>
    </div>
 	
    <div class="modal-body trOverFlow" id="divModalEliminar" >
       
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
</script>