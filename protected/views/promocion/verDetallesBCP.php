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
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover '),
	            'visible'=>Yii::app()->user->isAdmin()
        	), 
        	array(
	            'name' => 'nombrePromo',
	            'header' => 'Nombre',
	            'type' => 'raw',
	            'value' => function($data)
	            {
	            	$url = Yii::app()->createUrl('promocionesPremium/view', array("id"=>$data["id_promo"]));
	            	$var = '<a href="'.$url.'" data-toggle="tooltip" data-placement="top" title="Ver detalles">'.$data["nombrePromo"].'</a>';
	            	return $var;
	            },
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
	            	$estado = PromocionesPremiumController::actionGetStatusPromocion($data["id_promo"]);

	            	$objeto = Yii::app()->Funciones->getColorLabelEstadoPromocionesBCP($estado);

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
