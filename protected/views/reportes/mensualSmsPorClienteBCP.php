<br>
<?php
Yii::app()->clientScript->registerScript('searchMensualSmsPorClienteBCP', "

$('.search-form form').submit(function(){
    $('#mensualSmsPorClienteBCP').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

");

?>
<div class="search-form col-xs-12 col-sm-5 col-md-5 col-lg-5">
    <?php $this->renderPartial('busquedaMensualSmsPorCliente',array('model'=>$model)); ?>
</div><!-- search-form -->

<!--<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php //	$this->renderPartial('mensualSmsBCPDetalle',array('model'=>$model)); ?>
</div>--><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'mensualSmsPorClienteBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchMensualSmsPorCliente(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12"><br />{extendedSummary}</div>{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        //'filter'=> $model,
        'extendedSummary' => array(
	        'title' => 'Totales',
	        'columns' => array(
	            'enviados' => array('label'=>'Enviados', 'class'=>'TbSumOperation'),
	            'no_enviados' => array('label'=>'No enviados', 'class'=>'TbSumOperation'),
	            'total' => array('label'=>'Total', 'class'=>'TbSumOperation'),
	            /*'total' => array(
	                'label'=>'Total Expertise',
	                'types' => array(
	                    '4'=>array('label'=>'html'),
	                    '7453'=>array('label'=>'html2')
	                ),
	                'class'=>'TbPercentOfTypeOperation'
	            )*/
	        )
	    ),
	    'extendedSummaryOptions' => array(
	        'class' => 'well pull-right col-xs-12 col-sm-12 col-lg-12 col-md-12',
	        'style' => 'width:200px;'
	    ),
        'columns'=> array( 
        	//'id_cliente',
        	array(
	            //'name' => 'cliente',
	            'header' => 'Cliente',
	            'value' => function($data)
	            {
	            	return $this->actionGetDescripcionClienteBCP($data["cliente"]);
	            },
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
        		'name' => 'no_enviados',
	            'header' => 'No enviados',
	            //'type' => 'date',
	            'value' => function($data)
	            {
	            	$estado = ($data["total"]-$data["enviados"]) == 0 ? 0 : 1;

	            	$this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'label' => $data["total"]-$data["enviados"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorLabelEstadoReportes($estado).';'),    
                        )
                    );
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
        		'name'=>'enviados',
	            'header' => 'Enviados',
	            //'type' => 'date',
	            'value' => function($data)
	            {
	            	$estado = $data["enviados"] == 0 ? 0 : 2;

	            	$this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'label' => $data["enviados"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorLabelEstadoReportes($estado).';'),    
                        )
                    );
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
        		'name' => 'total',
	            'header' => 'Total',
	            //'type' => 'date',
	            'value' => function($data)
	            {
	            	$this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'label' => $data["total"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorLabelEstadoReportes(3).';'),    
                        )
                    );
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        ),
    ));
?>

<script type="text/javascript">

	function updateDescripcion()
	{
		var aux = $( "#PromocionesPremium_id_cliente option:selected" ).text();
		$("#detalleClienteBCP").val(aux);
	}

	$(document).ready(function()
	{
		//$("#boton_consultar").click(function(){
			//$("#boton_consultar").addClass("disabled");
		//});
	});

</script>
