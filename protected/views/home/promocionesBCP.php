<style type="text/css">
	.trOverFlow {
	    text-align : left;
	    overflow: hidden;
	    text-overflow: ellipsis; 
	}
</style>

<br>
<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'type'=>'striped bordered condensed', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchHome(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template'=>"{items}\n{pager}",  
        'filter'=> $model,
        'columns'=> array( 
        	array(
	            'name' => 'id',
	            'header' => 'Id promo',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	), 
        	array(
	            'name' => 'nombrePromo',
	            'header' => 'Nombre',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: left;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'login',
	            'header' => 'Usuario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'id_cliente',
	            'header' => 'Cliente',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'hora',
	            'header' => 'Hora inicio',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'hora_limite',
	            'header' => 'Hora fin',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary'),
        	),
        	array(
	            'name' => 'estado',
	            'header' => 'Estado',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{ver}{Confirmar}{Cancelar}',
	            'headerHtmlOptions' => array('style' => 'color: white; background: #004d99;text-align: center;'),
	            'buttons' => array(
	            	'ver'=>array(
	            			'label'=>'',
	            			'options'=>array('class'=>'glyphicon glyphicon-eye-open'),
	            			'url'=>'Yii::app()->createUrl("#")',
	            			),
	            	'Confirmar'=>array(
	            			'url'=>'Yii::app()->createUrl("#")',
	            			),
	            	'Cancelar'=>array(
	            			'url'=>'Yii::app()->createUrl("#")',
	            			)
	            ),
	        ),
        ),
        
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow'),
    ));

?>	