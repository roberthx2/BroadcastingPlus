<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
	<div class="panel-group" id="accordion">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		      	<h4 class="panel-title">
		        	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
		          		<span class="glyphicon glyphicon-list-alt"></span> Información 
		        	</a>
		      	</h4>
		    </div>
		    <div id="collapseOne" class="panel-collapse collapse in">
		      	<div class="panel-body">
		        	<ul class="list-group">
		        		<li class="list-group-item" style="padding: 0px;">
		                	<?php
		                		$this->widget(
								    'booster.widgets.TbEditableDetailView',
								    array(
								        'id' => 'region-details',
								        'data' => $model_promocion,
								        //'showbuttons' => false,
								        'mode' => 'inline',
								        'htmlOptions' => array('style' => 'text-align: right;'),
								        'url' => $this->createUrl('lista/editableSaver'),
								        'params' => array("model"=>"Lista"),
								        'attributes' => array(
								            'nombre',
								        ),
								        'success' => 'js: function(response, newValue) {
									       if(!response.success) return response.msg;
									    }',
									   	'options' => array(
									    	'ajaxOptions' => array('dataType' => 'json')
									   	), 
								    )
								);
		                	?>
		        		</li>
			        	<li class="list-group-item">
			        		<?php $this->widget(
			                    'booster.widgets.TbBadge',
			                    array(
			                        //'context' => $context,
			                        // 'default', 'success', 'info', 'warning', 'danger'
			                        'label' => $model_promocion->login,
			                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
			                    )
			                ); ?>
			                <?php echo '<strong>Usuario</strong>'; ?>
			        	</li>
			        	<li class="list-group-item">
			        		<?php $this->widget(
			                    'booster.widgets.TbBadge',
			                    array(
			                        //'context' => $context,
			                        // 'default', 'success', 'info', 'warning', 'danger'
			                        'label' => $model_promocion	->total,
			                        'htmlOptions' => array('style' => 'background-color: #5cb85c; color: white'),
			                    )
			                ); ?>
			                <?php echo '<strong>Total destinatarios</strong>'; ?>
			        	</li>
		        	</ul>
		      	</div>
		    </div>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
<?php 
	$data = $this->actionReporteTorta($model_promocion->id_promo);
	echo $this->renderPartial("/TmpProcesamiento/graficoTorta", array("data"=>$data), true); 
?>
</div>

<br>
<?php
	Yii::app()->clientScript->registerScript('searchDetalleBCP', "

	$('.search-form form').submit(function(){
	    $('#promocionBCP-grid').yiiGridView('update', {
	        data: $(this).serialize()
	    });
	    return false;
	});

	");
?>

<div class="clearfix visible-xs-block"></div>

<div class="search-form ">
    <?php $this->renderPartial('busqueda',array('model'=>$model_outgoing, 'id_promo'=>$model_promocion->id_promo)); ?>
</div><!-- search-form -->

<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'promocionBCP-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model_outgoing->searchDetalleBCP($model_promocion->id_promo),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'selectableRows' => 2,
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
	            'name' => 'destinatario',
	            'header' => 'Destinatario',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	/*array(
	            'name' => 'o.descripcion',
	            'header' => 'Operadora',
                'value' => function($data)
                {
                    $this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'context' => '',
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => $data["descripcion_oper"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorOperadoraBCNL($data["id_operadora"]).';'),    
                        )
                    );
                },
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),*/
        ),
    ));
?>
