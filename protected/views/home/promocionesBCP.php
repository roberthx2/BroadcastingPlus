<br>
<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchHome(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow'),
        //'filter'=> $model,
        'columns'=> array( 
        	array(
	            'name' => 'id',
	            'header' => 'Id promo',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'prueba'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'visible'=>Yii::app()->user->isAdmin()
        	), 
        	array(
	            'name' => 'nombrePromo',
	            'header' => 'Nombre',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'login',
	            'header' => 'Usuario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'name' => 'id_cliente',
	            'header' => 'Cliente',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'name' => 'hora',
	            'header' => 'Hora inicio',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'hora_limite',
	            'header' => 'Hora fin',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'header' => 'Estado',
	            'type' => 'raw',
	            'value' => function($data){
	            	$label = "";
	            	$clase = "";
	            	//$estado = PromocionesPremiumController::actionObtenerStatus($data["estado"], $data["fecha"], $data["hora"], $data["fecha_limite"], $data["hora_limite"], $data["no_enviados"], $data["total"]);
                    $estado = PromocionesPremiumController::actionGetStatusPromocion($data["id"]);
	            	$objeto = estadoPromo($estado);

	            	$this->widget(
					    'booster.widgets.TbLabel',
					    array(
					        'context' => $objeto['clase'],
					        // 'default', 'primary', 'success', 'info', 'warning', 'danger'
					        'label' => $objeto['label'],
					        'htmlOptions'=>array('style'=>'background-color: '.$objeto['background_color'].';'),	
					    )
					);
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
                'header' => 'Avance',
                'value' => function($data)
                {
                	$avance = avance($data["total"], $data["enviados"]);
                	//$estado = PromocionesPremiumController::actionObtenerStatus($data["estado"], $data["fecha"], $data["hora"], $data["fecha_limite"], $data["hora_limite"], $data["no_enviados"], $data["total"]);
                    $estado = PromocionesPremiumController::actionGetStatusPromocion($data["id"]);

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
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
            ),
            array(
            	'header' => 'Enviados/Total',
            	'value' => function ($data){
            		echo $data["enviados"]." / ".$data["total"];
            	},
            	'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
            ),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{ver}&#09;{Confirmar}&#09;{Cancelar}',
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'ver'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("promocionesPremium/view", array("id"=>$data["id"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-eye-open', 'title'=>'Ver', 'style'=>'color:black;'),
	            			),
	            	'Confirmar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("#")',
	            			'visible'=>'visibleConfirmar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-ok', 'title'=>'Confirmar', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-target' => '#modalConfirmar'),
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
                                            alert("Ocurrio un error al cargar la información");
                                        }
                                    });
                                }'
                            ),
	            	'Cancelar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("#")',
	            			'visible'=>'visibleCancelar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-remove', 'title'=>'Cancelar', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-target' => '#modalEliminar'),
	            			)
	            ),
	        ),
        ),
    ));
?>

<?php
function avance($total, $enviados)
{
	return floor(($enviados * 100) / $total);
}

function estadoPromo($estado)
{
	$objeto = array();

	if($estado == 0)
		$objeto = array('label'=> 'No confirmada', 'clase' => 'default', 'background_color' => '');
	elseif ($estado == 1)
		$objeto = array('label'=> 'Enviada', 'clase' => 'success', 'background_color' => '');
	elseif ($estado == 2)
		$objeto = array('label'=> 'Confirmada', 'clase' => 'primary', 'background_color' => '');
	elseif ($estado == 3)
		$objeto = array('label'=> 'Incompleta', 'clase' => 'success', 'background_color' => '#FC6E51');
	elseif ($estado == 4)
		$objeto = array('label'=> 'Cancelada', 'clase' => 'danger', 'background_color' => '');
	elseif ($estado == 5)
		$objeto = array('label'=> 'No enviada', 'clase' => '', 'background_color' => '#434A54');
	elseif ($estado == 6)
		$objeto = array('label'=> 'Transito', 'clase' => 'warning', 'background_color' => '');
	elseif ($estado == 7)
		$objeto = array('label'=> 'Enviada y Cancelada', 'clase' => '', 'background_color' => '#967ADC');

	return $objeto;
}

function visibleConfirmar($data)
{
    $estado = PromocionesPremiumController::actionGetStatusPromocion($data["id"]);
	//$estado = PromocionesPremiumController::actionObtenerStatus($data["estado"], $data["fecha"], $data["hora"], $data["fecha_limite"], $data["hora_limite"], $data["no_enviados"], $data["total"]);
	//Confirmada
	if ($estado == 0)
		return true;
	else 
		return false;
}

function visibleCancelar($data)
{
    $estado = PromocionesPremiumController::actionGetStatusPromocion($data["id"]);
	//$estado = PromocionesPremiumController::actionObtenerStatus($data["estado"], $data["fecha"], $data["hora"], $data["fecha_limite"], $data["hora_limite"], $data["no_enviados"], $data["total"]);
	//Confirmada / En transito
	if ($estado == 2 || $estado == 6)
		return true;
	else 
		return false;
}

?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalConfirmar')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
        <h4 class="modal-title" style="color:#fff;">Confirmar Promoción</h4>
    </div>
 
    <div class="modal-body" id="divModalConfirmar">
       
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'label' => 'Aceptar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
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

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEliminar')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
		<h4 class="modal-title" style="color:#fff;">Cancelar Promoción</h4>
    </div>
 
    <div class="modal-body" id="divModalEliminar">
       
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'label' => 'Aceptar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
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