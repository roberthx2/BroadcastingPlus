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
        'filter'=> $model,
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
	            	$estado = PromocionesPremiumController::actionObtenerStatus($data["estado"], $data["fecha"], $data["hora"], $data["fecha_limite"], $data["hora_limite"], $data["no_enviados"], $data["total"]);

	            	$objeto = estadoPromo($estado);

	            	$this->widget(
					    'booster.widgets.TbLabel',
					    array(
					        'context' => $objeto['clase'],
					        // 'default', 'primary', 'success', 'info', 'warning', 'danger'
					        'label' => $objeto['label'],
					        'htmlOptions'=>array('background-color'=>'#434A54'),	
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
                    Controller::widget('booster.widgets.TbProgress', array(
                    	//'context' => 'djkqdjkqnd',
                    	'context'=>$avance==100?"success":"danger",
                        'percent' => $avance,
                        'content' => $avance.'%',
                        'striped' => true,
				        'animated' => true,
				        'htmlOptions'=> array('style'=>'height: 20px; margin-bottom:0px;'),
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
	            			'options'=>array('class'=>'glyphicon glyphicon-eye-open', 'title'=>'Ver', 'style'=>'color:black;'),
	            			'url'=>'Yii::app()->createUrl("#")',
	            			),
	            	'Confirmar'=>array(
	            			'label'=>' ',
	            			'options'=>array('class'=>'glyphicon glyphicon-ok', 'title'=>'Confirmar', 'style'=>'color:black;'),
	            			'url'=>'Yii::app()->createUrl("#")',
	            			),
	            	'Cancelar'=>array(
	            			'label'=>' ',
	            			'options'=>array('class'=>'glyphicon glyphicon-remove', 'title'=>'Cancelar', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-target' => '#modelEliminar'),
	            			'url'=>'Yii::app()->createUrl("#")',
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
		$objeto = array('label'=> 'No confirmada', 'clase' => 'default');
	elseif ($estado == 1)
		$objeto = array('label'=> 'Enviada', 'clase' => 'success');
	elseif ($estado == 2)
		$objeto = array('label'=> 'Confirmada', 'clase' => 'primary');
	elseif ($estado == 3)
		$objeto = array('label'=> 'Incompleta', 'clase' => '');
	elseif ($estado == 4)
		$objeto = array('label'=> 'Cancelada', 'clase' => 'danger');
	elseif ($estado == 5)
		$objeto = array('label'=> 'No enviada', 'clase' => '');
	elseif ($estado == 6)
		$objeto = array('label'=> 'Transito', 'clase' => 'warning');
	elseif ($estado == 7)
		$objeto = array('label'=> 'Enviada y Cancelada', 'clase' => '');

	return $objeto;
}
?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modelEliminar')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Cancelar Promoción</h4>
    </div>
 
    <div class="modal-body">
       
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

<style type="text/css">
	.trOverFlow {
	    text-align : left;
	    overflow: hidden;
	    text-overflow: ellipsis; 
	}
</style>