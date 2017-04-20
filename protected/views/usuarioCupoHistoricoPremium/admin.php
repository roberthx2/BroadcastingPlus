<br>
<?php
/* @var $this UsuarioCupoHistoricoPremiumController */
/* @var $model UsuarioCupoHistoricoPremium */

Yii::app()->clientScript->registerScript('search', "
$('.BCP form').submit(function(){
	$('#usuario-cupo-historico-premium-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="BCP col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'usuario-cupo-historico-premium-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'columns'=> array( 
        	array(
	            'name' => 'id_usuario',
	            //'value' => 'id',
	            'header' => 'Usuario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'name' => 'ejecutado_por',
	            //'value' => 'id',
	            'header' => 'Ejecutado Por',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'name' => 'descripcion',
	            //'value' => 'id',
	            'header' => 'Descripcion',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center; size: 10px;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'cantidad',
	            //'value' => 'id',
	            'header' => 'Cant.',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'fecha',
	            //'value' => 'id',
	            'header' => 'Fecha',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'hora',
	            //'value' => 'id',
	            'header' => 'Hora',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
        		'name' => 'tipo_operacion',
	            'header' => 'Tipo',
	            'type' => 'raw',
	            'value' => function($data){

	            	$bg = Yii::app()->Funciones->getColorLabelTipoOperacionCupoBCP($data["tipo_operacion"]);

	            	Controller::widget(
					    'booster.widgets.TbLabel',
					    array(
					        'label' => $data['descripcion_operacion'],
					        'htmlOptions'=>array('style'=>'background-color: '.$bg.';'),	
					    )
					);
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        ),
    ));
?>
