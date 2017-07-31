<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordionBCP">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	      	<h4 class="panel-title">
	        	<a data-toggle="collapse" data-parent="#accordionBCP" href="#collapseBCP">
	          		<span class="glyphicon glyphicon-search"></span> Búsqueda
	        	</a>
	      	</h4>
	    </div>
	    <div id="collapseBCP" class="panel-collapse collapse in">
	      	<div class="panel-body">
				<?php
				    $contenido = array();

				    //array_push($contenido, array('label' => 'Mensual', 'content' => $this->renderPartial('busquedaPorMes', array('model'=>new Reportes()), true), 'active' => true));

				    array_push($contenido, array('label' => 'Periodo', 'content' => $this->renderPartial('busquedaPorPeriodo', array('model'=>$model, "form"=>$form), true), 'active' => false));

				    //array_push($contenido, array('label' => 'Día', 'content' => $this->renderPartial('busquedaPorDia', array('model'=>new Reportes()), true), 'active' => false));

				    $this->widget(
				        'booster.widgets.TbTabs',
				        array(
				            'id' => 'mytabs',
				            'type' => 'tabs',
				            'justified' => true,
				            //'justified' => true,
				            'tabs' => $contenido
				        )
				); ?>
			</div>
	    </div>
	</div>
</div><!-- Search-form -->
<?php $this->endWidget(); ?>