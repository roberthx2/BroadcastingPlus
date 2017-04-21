<?php
/* @var $this ConfiguracionOperadoraReservacionController */
/* @var $model ConfiguracionOperadoraReservacion */
?>

<br>
<div class="container-fluid alert alert-success" id="div_success" style="display:none;">
          <span class="glyphicon glyphicon-ok"></span> <?php echo "Actualización realizada exitosamente" ?>
    </div>

    <div class="container-fluid alert alert-danger" id="div_error" style="display:none;">
          <span class="glyphicon glyphicon-remove"></span> <?php echo "Ocurrio un error al realizar la actualización" ?>
    </div>

<fieldset>

    <legend>Configurar reservación por operadoras</legend>
    
<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'configuracion-operadora-reservacion-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'columns'=> array( 
        	array(
              	'name' => 'descripcion',
              	'header' => 'Descripción',
              	'type' => 'raw',
              	'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
              	'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
          	),
          	array(
        		'class' => 'booster.widgets.TbEditableColumn',
	            'name' => 'sms_x_seg',
	            'header' => 'SMS por seg.',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'editable' => array(
                  	'url'        => $this->createUrl('lista/editableSaver'),
                  	'params' => array("model"=>"ConfiguracionOperadoraReservacion"),
                  	'mode'=>'inline',
                  	'title' => '',
                  	'success' => 'js: function(response, newValue) {
        				       if(!response.success) return response.msg;
        				    }',
        				   	'options' => array(
        				    	'ajaxOptions' => array('dataType' => 'json')
        				   	), 
				   	
              	)
        	),
        	array(
        		'class' => 'booster.widgets.TbEditableColumn',
	            'name' => 'porcentaje_permitido',
	            'header' => '% Permitido',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'editable' => array(
                  	'url'        => $this->createUrl('lista/editableSaver'),
                  	'params' => array("model"=>"ConfiguracionOperadoraReservacion"),
                  	'mode'=>'inline',
                  	'title' => '',
                  	'success' => 'js: function(response, newValue) {
				       if(!response.success) return response.msg;
				    }',
				   	'options' => array(
				    	'ajaxOptions' => array('dataType' => 'json')
				   	), 
				   	
              	)
        	),
    	),
    ));
?>
</fieldset>
