<br>
<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model_procesamiento->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow'),
        //'filter'=> $model,
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
	            'header' => 'Numero',
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