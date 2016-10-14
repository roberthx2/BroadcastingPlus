<div class="col-md-5">
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
								        'data' => $model_lista,
								        'showbuttons' => false,
								        'mode' => 'inline',
								        'htmlOptions' => array('class' => 'color: black; text-decoration: none;'),
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
			                        'label' => $model_lista->login,
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
			                        'label' => $model_lista->total,
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

<div class="col-md-7">
<?php 
	$data = $this->actionReporteTorta($model_lista->id_lista);
	echo $this->renderPartial("/TmpProcesamiento/graficoTortaBCNL", array("data"=>$data), true); 
?>
</div>
<div class="col-md-12">
	<br>
<?php
Yii::app()->clientScript->registerScript('searchUpdateLista', "

$('.search-form form').submit(function(){
    $('#listaUpdate-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});

");

?>
<div class="search-form">
    <?php $this->renderPartial('_searchViewUpdate',array('model'=>$model_destinatarios, 'id_lista'=>$model_lista->id_lista)); ?>
</div><!-- search-form -->
<div class="col-md-12">
<?php

$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'listaUpdate-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model_destinatarios->searchViewUpdate($model_lista->id_lista),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow'),
        'selectableRows' => 2,
       // 'filter'=> $model_procesamiento,
        'bulkActions' => array(
		    'actionButtons' => array(
		        array(
		            'buttonType' => 'button',
		            'context' => 'primary',
		            'size' => 'small',
		            'label' => 'Testing Primary Bulk Actions',
		            'click' => 'js:function(values){console.log(values);}',
		            'id' => 'id_lista',
		            )
		    ),
		        // if grid doesn't have a checkbox column type, it will attach
		        // one and this configuration will be part of it
	        'checkBoxColumnConfig' => array(
	            'name' => 'id_lista',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'col-xs-1 col-sm-1 col-md-1 col-lg-1'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
	        ),
	    ),
        'columns'=> array( 
        	array(
	            'name' => 'numero',
	            'header' => 'Número',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
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
        	),
        ),
    ));
?>
</div>
</div>