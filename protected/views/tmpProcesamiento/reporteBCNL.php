<br>
<?php
Yii::app()->clientScript->registerScript('searchReporteBCNL', "

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

<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'reporte',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model_procesamiento->searchReporteBCNL($id_proceso),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	/*array(
	            'name' => 'id_proceso',
	            'header' => 'Id proceso',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),*/ 
        	array(
	            'name' => 'numero',
	            'header' => 'Número',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
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
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorOperadoraBCNL($data["id_operadora"]).';'),    
                        )
                    );
                },
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
            array(
                'name' => 'e.descripcion',
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
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorValidoInvalido($data["estado"]).';'),    
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