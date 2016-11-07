<?php
/* @var $this ListaController */
/* @var $model Lista */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#notificaciones-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="page-content-wrapper">
<h1>Notificaciones</h1>
<br><br>

<div class="search-form">
    <?php $this->renderPartial('_search',array('model'=>$model, 'id_usuario'=>$id_usuario)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'notificaciones-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search_usuario($id_usuario),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
	            //'name' => "asunto",
	            'header' => 'Asunto',
	            'type' => 'raw',
	            'value' => function($data)
	            {
	            	$url = Yii::app()->createUrl('notificaciones/view', array("id_notificacion"=>$data["id_notificacion"]));
	            	$var = '<a href="'.$url.'">'.$data["asunto"].'</a>';
	            	return $var;
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),

        	array(
	            'name' => 'fecha',
	            'header' => 'Fecha',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),

        	array(
	            'name' => 'hora',
	            'header' => 'Hora',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        ),
    ));
?>
<div>