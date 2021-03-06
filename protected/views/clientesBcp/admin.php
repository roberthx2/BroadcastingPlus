<?php
/* @var $this ClientesBcpController */
/* @var $model ClientesBcp */


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#clientes-bcp-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br>
<?php if(Yii::app()->user->hasFlash('success')):?>
	<br>
    <div class="container-fluid alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="glyphicon glyphicon-ok"></span> <?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif; ?>

<fieldset>
 
    <legend>Administrar Clientes</legend>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs ">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php 
    $this->widget(
        'booster.widgets.TbButton',
        array(
            'id'=>'agregar',
            'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Crear Cliente BCP',
            'icon' => 'glyphicon glyphicon-user',
            'url' => '#',
            'url' => Yii::app()->createUrl("clientesBcp/create"),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        )
    ); 
?>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 visible-xs ">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'clientes-bcp-grid',
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
                    //'name' => 'cliente',
                    'header' => 'Cliente',
                    'value' => function($data)
                    {
                        return ReportesController::actionGetDescripcionClienteBCNL($data["id_cliente_sms"]);
                    },
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                    'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
                ),
                array(
                    'name' => 'sc',
                    'header' => 'Short Codes',
                    'value' => function($data)
                    {
                        return str_replace(",", ", ", Yii::app()->Funciones->limpiarNumerosTexarea($data["sc"]));
                    },
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                    'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
                ),
                array(
                    'class' => 'CButtonColumn',
                    'header' => 'Acciones',
                    'template' => '{Editar}&#09;{Habilitar}',
                    'headerHtmlOptions' => array('class'=>'tableHover'),
                    'htmlOptions' => array('style' => 'text-align: center;'),
                    'buttons' => array(
                        'Editar'=>array(
                                'label'=>' ',
                                'url'=>'Yii::app()->controller->createUrl("/clientesBcp/update", array("id"=>$data["id_cliente_sms"]))',
                                'options'=>array('class'=>'glyphicon glyphicon-pencil', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Asignar SC', 'style'=>'color:black;'),
                                'click' => 'function() {
                                    $(".loader_superior").css("display", "block");
                                }'
                                ),
                        'Habilitar'=>array(
                                'label'=>' ',
                                'url'=>'Yii::app()->controller->createUrl("/clientesBcp/activateCliente", array("id_cliente_sms"=>$data["id_cliente_sms"]))',
                                'options'=>array('class'=>'glyphicon glyphicon-off', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Estado cliente enviador', 'style'=>'color:black;'),
                                'click' => 'function() {
                                    $(".loader_superior").css("display", "block");
                                }'
                                ),
                        )
                )
	       ),
        )
    );
?>
</fieldset>