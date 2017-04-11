<?php
/* @var $this ConfiguracionReservacionPorDiaController */
/* @var $model ConfiguracionReservacionPorDia */


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#configuracion-reservacion-por-dia-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br>

<fieldset>
    <div class="container-fluid alert alert-success" id="div_success" style="display:none;">
          <span class="glyphicon glyphicon-ok"></span> <?php echo "Actualización realizada exitosamente" ?>
    </div>

    <legend>Configurar Reservación por dia</legend>


<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'configuracion-reservacion-por-dia-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
              	'name' => 'descripcion',
              	'header' => 'Descripcion',
              	'type' => 'raw',
              	'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
              	'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
          	),
          	array(
            	'header' => 'Estado',
            	'value' => function($data)
	            {
	                $this->widget(
					    'booster.widgets.TbSwitch',
					    array(
					        'name' => $data["id_dia"],
					        'events' => array(
					            'switchChange' => 'js:function(event, state){enviar(this, state);}'
					        )
					    )
					);
	            },
            	'htmlOptions' => array('style' => 'text-align: center;'),
            	'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
          	),
    	),
    ));
?>
</fieldset>
<script type="text/javascript">
	
	function enviar(id, value)
	{
	    $.ajax({
	        url:"<?php echo Yii::app()->createUrl('configuracionReservacionPorDia/update'); ?>",
	        type:"POST",    
	        data:{id_dia:id,valor:value},
	        
	        success: function(data)
	        {
	          	
	        },
	        error: function()
	        {

	        }
	    });
	}
</script>