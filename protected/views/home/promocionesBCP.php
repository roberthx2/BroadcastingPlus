<br>
<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchHome(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow'),
        'filter'=> $model,
        'columns'=> array( 
        	array(
	            'name' => 'id',
	            'header' => 'Id promo',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'prueba'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'visible'=>Yii::app()->user->isAdmin()
        	), 
        	array(
	            'name' => 'nombrePromo',
	            'header' => 'Nombre',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: left;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'login',
	            'header' => 'Usuario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'name' => 'id_cliente',
	            'header' => 'Cliente',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
	            'name' => 'hora',
	            'header' => 'Hora inicio',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'hora_limite',
	            'header' => 'Hora fin',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'estado',
	            'header' => 'Estado',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'name' => 'estado',
	            'header' => 'Avance',
	            'value'=>"Yii::app()->controller->widget('booster.widgets.TbProgress', array(
				        'percent' => '50',
				        'striped' => true,
				        'animated' => true,
				    ),
                	true)",
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
                'header' => 'Postęp',
                'value' => function($data)
                {
                    Controller::widget('booster.widgets.TbProgress', array(
                        'percent' => '22'
                        ));
                },
            ),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{ver}&#09;{Confirmar}&#09;{Cancelar}',
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'buttons' => array(
	            	'ver'=>array(
	            			'label'=>' ',
	            			'options'=>array('class'=>'glyphicon glyphicon-eye-open', 'title'=>'Ver'),
	            			'url'=>'Yii::app()->createUrl("#")',
	            			),
	            	'Confirmar'=>array(
	            			'label'=>' ',
	            			'options'=>array('class'=>'glyphicon glyphicon-ok', 'title'=>'Confirmar'),
	            			'url'=>'Yii::app()->createUrl("#")',
	            			),
	            	'Cancelar'=>array(
	            			'label'=>' ',
	            			'options'=>array('class'=>'glyphicon glyphicon-remove', 'title'=>'Cancelar', 'data-toggle' => 'modal', 'data-target' => '#modelEliminar'),
	            			'url'=>'Yii::app()->createUrl("#")',
	            			)
	            ),
	        ),
        ),
    ));

?>

<?php
function avance($total, $enviado)
{
	$porcentaje = floor(($enviado * 100) / $total);
	return '<div class="progress">
	  	<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.$enviado.'" aria-valuemin="0" aria-valuemax="'.$total.'" style="min-width: '.$enviado.'em; width: 2%;">
	    '.$porcentaje.'%
	  	</div> 
	</div>';
}

?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modelEliminar')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Cancelar Promoción</h4>
    </div>
 
    <div class="modal-body">
       
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'label' => 'Aceptar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>

<style type="text/css">
	.trOverFlow {
	    text-align : left;
	    overflow: hidden;
	    text-overflow: ellipsis; 
	}

	@media (max-width: 768px) {
	 	.prueba {
		  	text-align: left;
		}
	}
</style>