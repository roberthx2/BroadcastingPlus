<br>
<?php
	Yii::app()->clientScript->registerScript('searchDetalleBCNL', "

	$('.search-form form').submit(function(){
	    $('#promocionBCNL-grid').yiiGridView('update', {
	        data: $(this).serialize()
	    });
	    return false;
	});

	");
?>

<div class="clearfix visible-xs-block"></div>

<div class="search-form ">
    <?php $this->renderPartial('busqueda',array('model'=>$model_outgoing, 'id_promo'=>$model_promocion->id_promo)); ?>
</div><!-- search-form -->

<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'promocionBCNL-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model_outgoing->searchDetalleBCNL($model_promocion->id_promo),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'selectableRows' => 2,
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
	            'name' => 'number',
	            'header' => 'Destinatario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	/*array(
	            'name' => 'o.descripcion',
	            'header' => 'Operadora',
                'value' => function($data)
                {
                    $this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'context' => '',
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => $data["descripcion_oper"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorOperadoraBCP($data["operadora"]).';'),    
                        )
                    );
                },
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),*/
            array(
                'name' => 'e.descripcion',
                'header' => 'Estado',
                'value' => function($data)
                {
                    $this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'label' => $data["descripcion_estado"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorLabelEstadoDestinatarioBCNL($data["status"]).';'),    
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
