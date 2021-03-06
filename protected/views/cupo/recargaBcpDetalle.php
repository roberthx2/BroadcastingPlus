<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordionBCP">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	      	<h4 class="panel-title">
	        	<a data-toggle="collapse" data-parent="#accordionBCP" href="#collapseBCP">
	          		<span class="glyphicon glyphicon-list-alt"></span> Detalle Cupo
	        	</a>
	      	</h4>
	    </div>
	    <div id="collapseBCP" class="panel-collapse collapse in">
	      	<div class="panel-body">
	      		<div class="loader"></div>
	        	<ul class="list-group">
	        		<?php if (Yii::app()->user->isAdmin()) { ?>
	        			<li class="list-group-item">
			        		<?php $this->widget(
			                    'booster.widgets.TbBadge',
			                    array(
			                        'label' => '',
			                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'detalleUsuarioBCP visible-md visible-lg trOverFlow'),
			                    )
			                ); ?>
			                <?php echo '<strong class="visible-md visible-lg">Usuario</strong>'; ?>

			                <div class="visible-xs visible-sm"><strong>Usuario</strong></div>
			        		<div class="detalleUsuarioBCP visible-xs visible-sm trOverFlow"></div>
			        	</li>
					<?php } ?>

		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'detalleDisponibleoBCP visible-md visible-lg trOverFlow'),
		                    )
		                ); ?>
		                <?php echo '<strong class="visible-md visible-lg">Disponible</strong>'; ?>

		                <div class="visible-xs visible-sm"><strong>Disponible</strong></div>
		        		<div class="detalleDisponibleoBCP visible-xs visible-sm trOverFlow"></div>
		        	</li>

		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'detalleUltimaRecargaBCP visible-md visible-lg trOverFlow'),
		                    )
		                ); ?>
		                <?php echo '<strong class="visible-md visible-lg">Ultima recarga</strong>'; ?>

		                <div class="visible-xs visible-sm"><strong>Ultima recarga</strong></div>
		        		<div class="detalleUltimaRecargaBCP visible-xs visible-sm trOverFlow"></div>
		        	</li>

		        	<?php if (Yii::app()->user->isAdmin()) { ?>
			        	<li class="list-group-item">
			        		<?php $this->widget(
			                    'booster.widgets.TbBadge',
			                    array(
			                        'label' => '',
			                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'detalleEjecutadoPorBCP visible-md visible-lg trOverFlow'),
			                    )
			                ); ?>
			                <?php echo '<strong class="visible-md visible-lg">Ejecutada por</strong>'; ?>

			                <div class="visible-xs visible-sm"><strong>Ejecutada por</strong></div>
			        		<div class="detalleEjecutadoPorBCP visible-xs visible-sm trOverFlow"></div>
			        	</li>
					<?php } ?>		        	
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '',
		                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'detalleMontoMaximoBCP visible-md visible-lg trOverFlow'),
		                    )
		                ); ?>
		                <?php echo '<strong class="visible-md visible-lg">Monto máximo a recargar</strong>'; ?>

		                <div class="visible-xs visible-sm"><strong>Monto máximo a recargar</strong></div>
		        		<div class="detalleMontoMaximoBCP visible-xs visible-sm trOverFlow"></div>
		        	</li>
	        	</ul>
	      	</div>
	    </div>
	</div>
</div>
<?php $this->endWidget(); ?>