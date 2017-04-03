<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordionBCPDetalle">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	      	<h4 class="panel-title">
	        	<a data-toggle="collapse" data-parent="#accordionBCPDetalle" href="#collapseBCPDetalle">
	          		<span class="glyphicon glyphicon-list-alt"></span> Totales
	        	</a>
	      	</h4>
	    </div>
	    <div id="collapseBCPDetalle" class="panel-collapse collapse in">
	      	<div class="panel-body">
	        	<ul class="list-group">
	        		<li class="list-group-item">
	        			<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'detalleClienteBCP visible-md visible-lg trOverFlow'),
		                    )
		                ); ?>
		                <?php echo '<strong class="visible-md visible-lg">Cliente</strong>'; ?>

		                <div class="visible-xs visible-sm "><strong>Cliente</strong></div>
		        		<div class="detalleClienteBCP visible-xs visible-sm trOverFlow"></div>
		        	</li>
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
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('id'=>'detalleEnviadosBCP', 'style' => 'background-color: #5cb85c; color: white', 'class'=>'trOverFlow', 'title'=>'', 'data-tooltip'=>'tooltip'),
		                    )
		                ); ?>
		                <?php echo '<strong class="">Enviados</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('id'=>'detalleNoEnviadosBCP', 'style' => 'background-color: #d9534f; color: white', 'class'=>'trOverFlow', 'title'=>'', 'data-tooltip'=>'tooltip'),
		                    )
		                ); ?>
		                <?php echo '<strong>No enviados</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('id'=>'detalleTotalBCP', 'style' => 'background-color: #337ab7; color: white', 'class'=>'trOverFlow', 'title'=>'', 'data-tooltip'=>'tooltip'),
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