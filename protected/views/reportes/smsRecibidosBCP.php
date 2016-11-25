<br>
<?php
Yii::app()->clientScript->registerScript('searchMensualSmsPorCodigoBCP', "

$('.BCP form').submit(function(){
    $('#mensualSmsPorCodigoBCP').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

");

?>
<div class="BCP col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('busquedaSmsRecibidosBCP',array('model'=>$model)); ?>
</div><!-- search-form -->

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php //$this->renderPartial('mensualSmsDetallePeriodo',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'mensualSmsPorCodigoBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchSmsRecibidosBCP(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),

        'columns'=> array( 
        	array(
	            'name' => 'origen',
	            'header' => 'Número',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
            array(
                'name' => 'contenido',
                'header' => 'Mensaje',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            ),
        	array(
                'name' => 'time_arrive',
                'header' => 'Hora',
                'type' => 'time',
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            ),
        ),
    ));
?>

<script type="text/javascript">

	function updateInfo()
    {
        var url_action = "<?php echo Yii::app()->createUrl('promocionesPremium/reporteMensualSmsPorCodigo'); ?>";

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

    function updatePromociones()
    {
        var url_action = "<?php echo Yii::app()->createUrl('promocionesPremium/getPromociones'); ?>";

        $.ajax({
            url:url_action,
            type:"POST",   
            dataType:'json', 
            data: $('.BCP form').serialize(),

            success: function(data) 
            {
                if (data.error == "false")
                {
                    $("#Smsin_id_promo").empty();
                    var promociones = data.data;
                    $.each(promociones, function(i, value) {
                        $("#Smsin_id_promo").append($("<option>").text(value.nombrePromo).attr("value",value.id_promo));
                    });
                }
                else
                {
                    $("#Smsin_id_promo").empty();
                    $("#Smsin_id_promo").append($("<option>").text("No existen promociones").attr("value","null"));
                    console.log(data.status);
                }
            },
            error: function()
            {
                alert("Ocurrio un error al actualizar el resumen general");
            }
        });
    }


	$(document).ready(function()
	{
		//updateInfo();
        $('[data-tooltip="tooltip"]').tooltip();
        $("#Smsin_id_cliente").on('change', function(){
            updatePromociones();
        });
	});

</script>
