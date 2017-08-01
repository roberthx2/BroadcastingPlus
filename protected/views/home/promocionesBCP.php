<br>
<?php
Yii::app()->clientScript->registerScript('searchDetallesBCPToday', "

$('.BCP form').submit(function(){
    $('#detallesBCPToday').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

/*$('.BCP_pager form').change(function(){
    $.fn.yiiGridView.update('detallesBCPToday',{data:{pageSize:$('#pageSize').val()}});
});*/

$('.BCP form').change(function(){
    $('#detallesBCPToday').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

");

?>
<div class="BCP">
    <?php $this->renderPartial('/promocion/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'detallesBCPToday',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchHome(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'ajaxUrl' => Yii::app()->createUrl('home/index'),
        'columns'=> array( 
        	array(
	            'name' => 'id_promo',
	            'header' => 'Id promo',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'visible'=>Yii::app()->user->isAdmin()
        	), 
        	array(
	            'name' => 'nombrePromo',
	            'header' => 'Nombre',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'u.login',
                'value' => function($data)
                {
                    return $data["login"];
                },
	            'header' => 'Usuario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'name' => 'hora',
	            'header' => 'Hora inicio',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'd_o.hora_limite',
                'value' => function($data)
                {
                    return $data["hora_limite"];
                },
	            'header' => 'Hora fin',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'header' => 'Estado',
	            'type' => 'raw',
	            'value' => function($data){
                    $array = array(
                        "estado"=>$data["estado"], 
                        "fecha"=>$data["fecha"], 
                        "hora"=>$data["hora"], 
                        "fecha_limite"=>$data["fecha_limite"], 
                        "hora_limite"=>$data["hora_limite"], 
                        "total"=>$data["total"], 
                        "enviados"=>$data["enviados"], 
                        "no_enviados"=>($data["total"] - $data["enviados"])
                    );

                    $estado = PromocionesPremiumController::actionGetStatusPromocionRapida($array);
	            	$objeto = Yii::app()->Funciones->getColorLabelEstadoPromocionesBCP($estado);

	            	Controller::widget(
					    'booster.widgets.TbLabel',
					    array(
					        'label' => $objeto['label'],
					        'htmlOptions'=>array('style'=>'background-color: '.$objeto['background_color'].';'),	
					    )
					);
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
                'header' => 'Avance',
                'value' => function($data)
                {
                    $array = array(
                        "estado"=>$data["estado"], 
                        "fecha"=>$data["fecha"], 
                        "hora"=>$data["hora"], 
                        "fecha_limite"=>$data["fecha_limite"], 
                        "hora_limite"=>$data["hora_limite"], 
                        "total"=>$data["total"], 
                        "enviados"=>$data["enviados"], 
                        "no_enviados"=>($data["total"] - $data["enviados"])
                    );

                    $estado = PromocionesPremiumController::actionGetStatusPromocionRapida($array);
                    $avance = floor(($data["enviados"] * 100) / $data["total"]);

                	if ($estado == 1) //Enviada
                		$clase = 'success';
                	else if ($estado == 6) //Transito
                		$clase = 'warning';
                	else $clase = 'danger';

                    Controller::widget('booster.widgets.TbProgress', array(
                    	'context'=>$clase,
                        'percent' => $avance,
                        'content' => $avance.'%',
                        'striped' => true,
				        'animated' => true,
				        'htmlOptions'=> array('style'=>'height:20px; margin-bottom:0px; color:#000000;'),
                        ));
                },
                'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            ),
            array(
            	'header' => 'Enviados/Total',
            	'value' => function ($data){
            		echo $data["enviados"]." / ".$data["total"];
            	},
            	'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            ),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{ver}&#09;{Confirmar}&#09;{Cancelar}',
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
                    'ver'=>array(
                            'label'=>' ',
                            'url'=>'Yii::app()->createUrl("promocionesPremium/viewInformacion", array("id_promo"=>$data["id_promo"]))',
                            'options'=>array('class'=>'glyphicon glyphicon-eye-open', 'data-toggle'=>'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalVer', 'title'=>'Ver', 'style'=>'color:black;'),
                            'click' => 'function() {
                                    $.ajax({
                                        beforeSend: function(){
                                           $("#divModalVer").addClass("loading");
                                        },
                                        complete: function(){
                                           $("#divModalVer").removeClass("loading");
                                        },
                                        type: "POST",
                                        url: $(this).attr("href"),
                                        success: function(data) { 
                                            $("#divModalVer").html(data);
                                        },
                                        error: function() { 
                                            alert("No se puede cargar la vista.");
                                        }
                                    });
                                }'
                            ),
	            	'Confirmar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("promocionesPremium/viewConfirmar", array("id_promo"=>$data["id_promo"]))',
	            			'visible'=>'visibleConfirmar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-ok', 'title'=>'Confirmar', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalConfirmar'),
                            'click' => 'function(){
                                    $.ajax({
                                        beforeSend: function(){
                                           $("#divModalConfirmar").addClass("loading");
                                        },
                                        complete: function(){
                                           $("#divModalConfirmar").removeClass("loading");
                                        },
                                        type: "POST",
                                        url: $(this).attr("href"),
                                        success: function(data) { 
                                            $("#divModalConfirmar").html(data);
                                        },
                                        error: function() { 
                                            alert("No se puede cargar la vista.");
                                        }
                                    });
                                }'
                            ),
	            	'Cancelar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("promocionesPremium/viewCancelar", array("id_promo"=>$data["id_promo"]))',
	            			'visible'=>'visibleCancelar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-remove', 'title'=>'Cancelar', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalEliminar'),
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
                                            alert("No se puede cargar la vista.");
                                        }
                                    });
                                }'
	            			)
	            ),
	        ),
        ),
    ));
?>

<?php

function visibleConfirmar($data)
{
    $hora_actual = time();
    $hora_limite = strtotime($data["fecha_limite"] . " " . $data["hora_limite"]);

	//Confirmada
	if ($data["estado"] == 0 && ($hora_actual < $hora_limite))
		return true;
	else 
		return false;
}

function visibleCancelar($data)
{
    $array = array(
        "estado"=>$data["estado"], 
        "fecha"=>$data["fecha"], 
        "hora"=>$data["hora"], 
        "fecha_limite"=>$data["fecha_limite"], 
        "hora_limite"=>$data["hora_limite"], 
        "total"=>$data["total"], 
        "enviados"=>$data["enviados"], 
        "no_enviados"=>($data["total"] - $data["enviados"])
    );

    $estado = PromocionesPremiumController::actionGetStatusPromocionRapida($array);

	//Confirmada / En transito
	if ($estado == 2 || $estado == 6)
		return true;
	else 
		return false;
}

?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalVer')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Información Promoción</h4>
    </div>
 
    <div class="modal-body" id="divModalVer">
       
    </div>
 
<?php $this->endWidget(); ?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalConfirmar')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirmar Promoción</h4>
    </div>
 
    <div class="modal-body" id="divModalConfirmar">
       
    </div>
 
<?php $this->endWidget(); ?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEliminar')
); ?>
 
    <div class="modal-header" style="background-color:#d2322d">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar Promoción</h4>
    </div>
 
    <div class="modal-body" id="divModalEliminar">
       
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