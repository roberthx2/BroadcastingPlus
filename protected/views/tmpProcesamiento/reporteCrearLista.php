<br>
<?php
Yii::app()->clientScript->registerScript('searchReporteLista', "

$('.search-form form').submit(function(){
    $('#reporte').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

");

?>
<div class="search-form">
    <?php $this->renderPartial('/TmpProcesamiento/busqueda',array('model'=>$model_procesamiento, 'id_proceso'=>$id_proceso)); ?>
</div><!-- search-form -->
<div class="col-md-12">
<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'reporte',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model_procesamiento->searchReporteLista($id_proceso),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
	            'name' => 'id_proceso',
	            'header' => 'Id proceso',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	), 
        	array(
	            'name' => 'numero',
	            'header' => 'Número',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            //'name' => 'descripcion',
	            'header' => 'Operadora',
                'value' => function($data)
                {
                    $this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'context' => '',
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => $data["descripcion_oper"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->colorOperadoraBCNL($data["id_operadora"]).';'),    
                        )
                    );
                },
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
            array(
                //'name' => 'descripcion',
                'header' => 'Estado',
                'value' => function($data)
                {
                    //$objeto = estado($data["estado"], $data["descripcion_estado"]);

                    $this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            //'context' => $objeto['clase'],
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => $data["descripcion_estado"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->colorValidoInvalido($data["estado"]).';'),    
                        )
                    );
                },
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
            ),
        ),
    ));
?>
</div>
<?php

function estado($estado, $descripcion_estado)
{
    $objeto = array();

    if ($estado == 1)
        $objeto = array('label'=>$descripcion_estado, 'clase' => 'success');
    else
    {
        $objeto = array('label'=>$descripcion_estado, 'clase' => 'danger');
    }

    return $objeto;
}

?>

<style type="text/css">
    a:link, a:visited {
        color: white;
        text-decoration: none;
    }
</style>