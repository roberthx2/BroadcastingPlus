<fieldset> 
    <legend>Reporte de SMS por Código</legend>
<br>
<?php
Yii::app()->clientScript->registerScript('searchMensualSmsPorCodigoBCP', "

$('.BCP form').submit(function(){
    $('#mensualSmsPorCodigoBCP').yiiGridView('update', {
        data: $(this).serialize()
    });
    //updateInfo();
    return false;
});

");

?>
<div class="BCP col-xs-12 col-sm-5 col-md-5 col-lg-5">
    <?php $this->renderPartial('busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php //$this->renderPartial('mensualSmsDetallePeriodo',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
    $model_oper=OperadorasActivas::model()->findAll();
    $data_arr[] = array(
                'name' => 'sc',
                'header' => 'sc',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            );

    $total=array();

    foreach ($model_oper as $value)
    {
        $data_arr[] = array(
                'name' => $value["descripcion"],
                'header' => ucfirst(strtolower($value["descripcion"])),
                'type' => 'number',
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            );
        $total[]= $value["descripcion"];
    }
//    print_r($total);

    $data_arr[] = array(
//                'name' => 'total',
                'header' => 'Total',
                'type' => 'number',
                'value' => function($data, $total)
                {
                    print_r($total);
                },
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            );
?>

<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'mensualSmsPorCodigoBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchSmsPorCodigo(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),

        'columns'=> $data_arr,
    ));
?>
</fieldset>

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


	$(document).ready(function()
	{
		//updateInfo();
        //$('[data-tooltip="tooltip"]').tooltip();
	});

</script>
