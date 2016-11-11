<br>
<?php
Yii::app()->clientScript->registerScript('searchDetallesBCP', "

$('.search-form form').submit(function(){
    $('#detallesBCP').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

");

?>
<div class="search-form">
    <?php $this->renderPartial('/promocion/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->
<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'detallesBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchVerDetalles(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        //'filter'=> $model,
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
	            'htmlOptions' => array('style' => 'text-align: center;'),
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
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'header' => 'Estado',
	            'type' => 'raw',
	            'value' => function($data){
	            	$label = "";
	            	$clase = "";
	            	$estado = PromocionesPremiumController::actionObtenerStatusDetalle($data["id_promo"]);

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
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
            array(
                'name' => 'fecha',
                'header' => 'Fecha',
                'type' => 'date',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            ),
            array(
            	'header' => 'Total',
                'name' => 'total',
            	'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            ),
        ),
    ));
?>

<?php

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

?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalConfirmar')
); ?>

 
<?php $this->endWidget(); ?>