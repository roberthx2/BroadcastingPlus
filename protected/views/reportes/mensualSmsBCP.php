<br>
<?php
Yii::app()->clientScript->registerScript('searchMensualSmsBCP', "

$('.BCP form').submit(function(){
    $('#mensualSmsBCP').yiiGridView('update', {
        data: $(this).serialize()
    });
    updateInfo();
    return false;
});

");

?>
<div class="BCP col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('busquedaMensualSmsBCP',array('model'=>$model)); ?>
</div><!-- search-form -->

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php 	$this->renderPartial('mensualSmsBCPDetalle',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'mensualSmsBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchMensualSms(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'columns'=> array( 
        	array(
	            'name' => 'nombrePromo',
	            'header' => 'Promoción',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
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
        		'name' => 'no_enviados',
	            'header' => 'No enviados',
	            'value' => function($data)
	            {
	            	$estado = ($data["total_sms"]-$data["enviados"]) == 0 ? 0 : 1;

	            	Controller::widget(
                        'booster.widgets.TbLabel',
                        array(
                            'label' => $data["total_sms"]-$data["enviados"],
                            'htmlOptions'=>array('class'=>'label-no-enviados', 'style'=>'background-color: '.Yii::app()->Funciones->getColorLabelEstadoReportes($estado).';'),    
                        )
                    );
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
        		'name'=>'enviados',
	            'header' => 'Enviados',
	            'value' => function($data)
	            {
	            	$estado = $data["enviados"] == 0 ? 0 : 2;

	            	Controller::widget(
                        'booster.widgets.TbLabel',
                        array(
                            'label' => $data["enviados"],
                            'htmlOptions'=>array('class'=>'label-enviados', 'style'=>'background-color: '.Yii::app()->Funciones->getColorLabelEstadoReportes($estado).';'),    
                        )
                    );
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
        		'name' => 'total_sms',
	            'header' => 'Total',
	            'value' => function($data)
	            {
	            	Controller::widget(
                        'booster.widgets.TbLabel',
                        array(
                            'label' => $data["total_sms"],
                            'htmlOptions'=>array('class'=>'label-total', 'style'=>'background-color: '.Yii::app()->Funciones->getColorLabelEstadoReportes(3).';'),    
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
		var url_action = "<?php echo Yii::app()->createUrl('promocionesPremium/reporteMensualSms'); ?>";

		$.ajax({
            url:url_action,
            type:"POST",   
            dataType:'json', 
            data: $('.BCP form').serialize(),

            success: function(data) 
            {
            	var aux = $( "#PromocionesPremium_id_cliente option:selected" ).text();
            	var objeto = data.objeto;

				$(".detalleClienteBCP").text(aux);
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
