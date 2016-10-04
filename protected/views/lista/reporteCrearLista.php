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
    <?php $this->renderPartial('busqueda',array('model'=>$model_procesamiento, 'id_proceso'=>$id_proceso)); ?>
</div><!-- search-form -->

<?php

//$operadoras = operadoras();
$operadoras = "ok";

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
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'prueba'),
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
	            'name' => 'id_operadora',
	            'header' => 'Operadora',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        ),
    ));
?>

<?php

function operadoras()
{
    $operadoras = Yii::app()->Funciones->operadorasBCNL();

    foreach ($operadoras as $value)
    {
        $resultado[$value["id_operadora"]] = $value["descripcion"];
    }

    $resultado[null] = 'INVALIDO';

    return $resultado;
}

?>