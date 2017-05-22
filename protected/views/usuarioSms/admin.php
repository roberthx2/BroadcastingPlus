<?php
/* @var $this UsuarioSmsController */
/* @var $model UsuarioSms */


Yii::app()->clientScript->registerScript('search', "

$('.search-form form').submit(function(){
	$('#usuario-sms-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<fieldset>

    <legend>Administrar Usuarios</legend>

<div class="BCP col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'usuario-sms-grid',
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
              	'name' => 'login',
              	'header' => 'Usuario',
              	'type' => 'raw',
              	'htmlOptions' => array('style' => 'text-align: letf;', 'class'=>'trOverFlow'),
              	'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
          	),
          	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{permisos}&#09;{sc}',
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'permisos'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("permisos/update", array("id"=>$data["id_usuario"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-lock', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Permisos', 'style'=>'color:black;'),
	            			),
                'sc'=>array(
                    'label'=>' ',
                    'visible'=>'PermisosController::actionPermiso($data["id_usuario"], "crear_promo_bcp")',
                    'url'=>'Yii::app()->createUrl("permisos/update", array("id"=>$data["id_usuario"]))',
                    'options'=>array('class'=>'glyphicon glyphicon-pencil', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Asignar SC', 'style'=>'color:black;'),
                    ),
	            ),
	        ),
    	),
    ));
?>
</fieldset>