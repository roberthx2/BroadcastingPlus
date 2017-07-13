<?php
/* @var $this ListaController */
/* @var $model Lista */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#lista-exentos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br>

<fieldset>
 
    <legend>Administrar Listas de Exentos</legend>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'lista-exentos-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros',
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'columns'=> array( 
        	array(
	            'name' => 'u.login',
	            'value' => '$data["login"]',
	            'header' => 'Usuario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'fecha',
	            'header' => 'Fecha',
	            'type' => 'raw',
	            'value' => function($data) {
	            	return ($data["fecha"] == '0000-00-00') ? '-' : $data["fecha"];
	            },
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover')
        	),
        	array(
	            'name' => 'total',
	            'header' => 'Total Destinatarios',
	            'type' => 'number',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover'),
        	),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{Ver}',
	            'headerHtmlOptions' => array('class'=>'tableHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'Ver'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("listaExentos/adminDestinatarios", array("id"=>$data["id_lista"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-eye-open', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ver Lista', 'style'=>'color:black;'),
                            ),
	            ),
	        ),
        ),
    ));
?>
</fieldset>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('[data-tooltip="tooltip"]').tooltip();
	});
</script>