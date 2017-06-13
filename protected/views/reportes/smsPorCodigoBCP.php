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

$data_arr[] = array(
                'name' => 'sc',
                'header' => 'sc',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            );

$grid = $this->actionCreateColumnasOper(/*$model*/);

$columnas = array_merge($data_arr, $grid);

?>

<?php
/*$url=Yii::app()->createUrl('reportes/mensualSmsPorCodigo', array( 'Agent' => 'asas' ) );
print_r($url);
print_r("<br><br><br>");
print_r($url." deco: ".Yii::app()->createUrl($url)."<br>");*/

/*$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'mensualSmsPorCodigoBCP',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchSmsPorCodigo(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        /*'pagination' => array(
            'pageSize' => 3,
            'params' => array('my_new_param' => 'myvalue'),
        ),*/
        //'extraParams'=>array("a"=>"asd"),
         //'ajaxUrl' => Yii::app()->createUrl($this->route, array( 'Agent' => 'asas' ) ),
      /*  'columns'=> $columnas,
    ));*/
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'mensualSmsPorCodigoBCP',
    'dataProvider'=>$model->searchSmsPorCodigo(),
    //'filter'=>$model,
    'columns'=> $columnas,
)); ?>
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
