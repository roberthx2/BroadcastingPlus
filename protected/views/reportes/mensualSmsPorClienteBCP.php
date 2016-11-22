<br>
<?php
Yii::app()->clientScript->registerScript('searchMensualSmsPorClienteBCP', "

$('.BCP form').submit(function(){
    $('#mensualSmsPorClienteBCP').yiiGridView('update', {
        data: $(this).serialize()
    });
    updateInfo();
    return false;
});

");

?>
<div class="BCP col-xs-12 col-sm-5 col-md-5 col-lg-5">
    <?php $this->renderPartial('busquedaMensualSmsPorPeriodo',array('model'=>$model)); ?>
</div><!-- search-form -->

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php 	$this->renderPartial('mensualSmsDetallePeriodo',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'mensualSmsPorClienteBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchMensualSmsPorCliente(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
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

	function updateInfo()
	{
		var url_action = "<?php echo Yii::app()->createUrl('promocionesPremium/reporteMensualSmsPorCliente'); ?>";

		$.ajax({
            url:url_action,
            type:"POST",   
            dataType:'json', 
            data: $('.BCP form').serialize(),
            
            success: function(data) 
            {
            	var objeto = data.objeto;

				$(".detallePeriodoBCP").text(objeto.periodo);
				$("#detalleTotalBCP").text(objeto.total);

				$("#detalleEnviadosBCP").text(objeto.enviados_label);
				$('#detalleEnviadosBCP').prop('title', objeto.enviados_title);

				$("#detalleNoEnviadosBCP").text(objeto.no_enviados);
				$('#detalleNoEnviadosBCP').prop('title', objeto.no_enviados_title);
            },
            error: function()
            {
                alert("Ocurrio un error al actualizar el resumen general");
            }
        });
	}

	$(document).ready(function()
	{
		updateInfo();
		$('[data-tooltip="tooltip"]').tooltip();
	});

</script>
