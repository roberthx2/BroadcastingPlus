<?php
	/* @var $this MensajesBroadcastingController */
	/* @var $model MensajesBroadcasting */

	Yii::app()->clientScript->registerScript('search', "

	$('.search-form form').submit(function(){
	    $('#mensajes-broadcasting-grid').yiiGridView('update', {
	        data: $(this).serialize()
	    });
	    return false;
	});

	");
?>
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

<fieldset>
 
    <legend>Suspender Broadcasting</legend>


<div class="clearfix visible-xs-block"></div>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs ">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php 
	$this->widget(
        'booster.widgets.TbButton',
        array(
        	'id'=>'agregar',
        	'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Agregar Mensaje',
            'icon' => 'glyphicon glyphicon-plus',
            'url' => Yii::app()->createUrl("mensajesBroadcasting/create"),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        )
    ); 
?>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 visible-xs ">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'mensajes-broadcasting-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'columns'=> array( 
        	array(
	            'name' => 'mensaje',
	            'header' => 'Mensaje',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: letf; width: 50%;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
            array(
                'header' => 'Tipo',
                'type' => 'text',
                'value' => function($data)
                {
                    if ($data["tipo_mensaje"] == 1)
                        return 'Periodo';
                    else if ($data["tipo_mensaje"] == 2)
                        return 'Diario';
                    else if ($data["tipo_mensaje"] == 3)
                        return 'Personalizado';
                },
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            ),
        	array(
	            'name' => 'fecha_inicio',
	            'header' => 'Fecha Inicio',
	            'type' => 'text',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'fecha_fin',
	            'header' => 'Fecha Fin',
	            'type' => 'text',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'hora_inicio',
	            'header' => 'Hora Inicio',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'hora_fin',
	            'header' => 'Fin Fin',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{Editar}&#09;{Eliminar}',
	            'headerHtmlOptions' => array('class'=>'tableHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            		'Editar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("mensajesBroadcasting/update", array("id"=>$data["id_mensaje"]))',
	            			'options'=>array('class'=>'action glyphicon glyphicon-pencil', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Editar Mensaje', 'style'=>'color:black;'),
	            			'click' => 'function() {
                                    $(".loader_superior").css("display", "block");
                                }'
                            ), 
	            		'Eliminar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("mensajesBroadcasting/viewDelete", array("id" => $data["id_mensaje"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-trash', 'title'=>'Eliminar Mensaje', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalEliminar'),
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
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar Mensaje</h4>
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

		$(".action").click(function(){
            $(".loader_superior").css("display", "block");
        });
	});
</script>
