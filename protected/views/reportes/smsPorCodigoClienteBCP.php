<?php Yii::import("application.controllers.ReportesController", true); ?>

<fieldset> 
    <legend>Reporte de SMS por Código / Cliente</legend>
<br>
<?php
Yii::app()->clientScript->registerScript('searchSmsPorCodigoBCP', "

$('.BCP form').submit(function(){
    $('#smsPorCodigoBCP').yiiGridView('update', {
        data: $(this).serialize()
    });
    updateInfo($(this));
    return false;
});

");

?>
<div class="BCP col-xs-12 col-sm-5 col-md-5 col-lg-5">
    <?php $this->renderPartial('busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<div class="col-xs-12 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('detalleBusquedaBCP'); ?>
</div><!-- search-form -->

<?php

$data_arr[] = array(
                //'name' => 'id',
                'header' => 'Cliente',
                'value' => function($data)
	            {
	            	return ReportesController::actionGetDescripcionClienteBCP($data["id"]);
	            },
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            );

$data_arr[] = array(
                'name' => 'sc',
                'header' => 'Sc',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            );

$grid = $this->actionCreateColumnasOper();

$columnas = array_merge($data_arr, $grid);

?>

<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'smsPorCodigoBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchSmsPorCodigoCliente(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros',
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'ajaxUrl' => Yii::app()->createUrl('reportes/smsPorCodigoCliente'),
        'columns'=> $columnas,
    ));
?>
</fieldset>

<script type="text/javascript">

	function updateInfo(datos)
    {
        var url_action = "<?php echo Yii::app()->createUrl('/reportes/smsPeriodoResumen'); ?>";

        $.ajax({
            url:url_action,
            type:"POST",   
            dataType:'json', 
            data: datos.serialize(),

            success: function(data) 
            {
                var objeto = data.objeto;
                $(".detallePeriodoBCP").text(objeto.periodo);
                $("#detalleTotalBCP").text(objeto.total);
                $("#detalleOperadoraBCP").html(objeto.data);
            },
            error: function()
            {
                alert("Ocurrio un error al actualizar el resumen general");
            }
        });
    }

</script>
