<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordionBCPPeriodo">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	      	<h4 class="panel-title"> 
	        	<a data-toggle="collapse" data-parent="#accordionBCPPeriodo" href="#collapseBCPPeriodo">
	          		<span class="glyphicon glyphicon-list-alt"></span> Totales
	        	</a>
	      	</h4>
	    </div>
	    <div id="collapseBCPPeriodo" class="panel-collapse collapse in">
	      	<div class="panel-body">
	      		<div class="loader" style="display: none;"></div>
	        	<ul class="list-group">
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'detallePeriodoBCP visible-md visible-lg trOverFlow'),
		                    )
		                ); ?>
		                <?php echo '<strong class="visible-md visible-lg">Periodo</strong>'; ?>

		                <div class="visible-xs visible-sm"><strong>Periodo</strong></div>
		        		<div class="detallePeriodoBCP visible-xs visible-sm trOverFlow"></div>
		        	</li>

		        	<div id="detalleCliente"></div>

		        	<div id="detalleOperadoraBCP"></div>
		        	
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('id'=>'detalleTotalBCP', 'style' => 'background-color: #5cb85c; color: white', 'class'=>'trOverFlow', 'title'=>'', 'data-tooltip'=>'tooltip'),
		                    )
		                ); ?>
		                <?php echo '<strong>Total</strong>'; ?>
		        	</li>
	        	</ul>
	      	</div>
	    </div>
	</div>
</div>
<?php $this->endWidget(); ?>