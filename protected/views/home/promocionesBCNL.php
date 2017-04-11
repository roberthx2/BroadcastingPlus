<br>
<?php
Yii::app()->clientScript->registerScript('searchDetallesBCNLToday', "

$('.BCNL form').submit(function(){
    $('#detallesBCNLToday').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

");

?>
<div class="BCNL">
    <?php $this->renderPartial('/promocion/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'detallesBCNLToday',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchHome(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
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

                    $estado = PromocionesController::actionGetStatusPromocionRapida($array);
	            	$objeto = Yii::app()->Funciones->getColorLabelEstadoPromocionesBCNL($estado);

	            	$this->widget(
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

                    $estado = PromocionesController::actionGetStatusPromocionRapida($array);
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
	            			'url'=>'Yii::app()->createUrl("promociones/view", array("id"=>$data["id_promo"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-eye-open', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ver', 'style'=>'color:black;'),
	            			),
	            	'Confirmar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("promociones/viewConfirmar", array("id_promo"=>$data["id_promo"]))',
	            			'visible'=>'visibleConfirmarBCNL($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-ok', 'title'=>'Confirmar', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalConfirmarBCNL'),
                            'click' => 'function(){
                                    $.ajax({
                                        beforeSend: function(){
                                           $("#divModalConfirmarBCNL").addClass("loading");
                                        },
                                        complete: function(){
                                           $("#divModalConfirmarBCNL").removeClass("loading");
                                        },
                                        type: "POST",
                                        url: $(this).attr("href"),
                                        success: function(data) { 
                                            $("#divModalConfirmarBCNL").html(data);
                                        },
                                        error: function() { 
                                            alert("No se puede cargar la vista.");
                                        }
                                    });
                                }'
                            ),
	            	'Cancelar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("promociones/viewCancelar", array("id_promo"=>$data["id_promo"]))',
	            			'visible'=>'visibleCancelarBCNL($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-remove', 'title'=>'Cancelar', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalEliminarBCNL'),
                            'click' => 'function(){
                                    $.ajax({
                                        beforeSend: function(){
                                           $("#divModalEliminarBCNL").addClass("loading");
                                        },
                                        complete: function(){
                                           $("#divModalEliminarBCNL").removeClass("loading");
                                        },
                                        type: "POST",
                                        url: $(this).attr("href"),
                                        success: function(data) { 
                                            $("#divModalEliminarBCNL").html(data);
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

function visibleConfirmarBCNL($data)
{
    $hora_actual = time();
    $hora_limite = strtotime($data["fecha_limite"] . " " . $data["hora_limite"]);

	//No Confirmada
	if ($data["estado"] == 1 && ($hora_actual < $hora_limite))
		return true;
	else 
		return false;
}

function visibleCancelarBCNL($data)
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

    $estado = PromocionesController::actionGetStatusPromocionRapida($array);

	//Confirmada / En transito
	if ($estado == 2 || $estado == 4)
		return true;
	else 
		return false;
}

?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalConfirmarBCNL')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirmar Promoción</h4>
    </div>
 
    <div class="modal-body" id="divModalConfirmarBCNL">
       
    </div>
 
<?php $this->endWidget(); ?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEliminarBCNL')
); ?>
 
    <div class="modal-header" style="background-color:#d2322d">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar Promoción</h4>
    </div>
 
    <div class="modal-body" id="divModalEliminarBCNL">
       
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