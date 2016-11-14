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
	        	<?php if (Yii::app()->user->isAdmin()) { ?>
	        		<li class="list-group-item">
	        			<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => $model_promocion->id_promo,
		                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
		                    )
		                ); ?>
		                <?php echo '<strong>ID Promo</strong>'; ?>
	        		</li>
	        	<?php }	?>
	        	<?php if (Yii::app()->user->isAdmin()) { ?>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => $model_promocion->login,
		                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
		                    )
		                ); ?>
		                <?php echo '<strong>Usuario</strong>'; ?>
		        	</li>
		        <?php }	?>	
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => $model_promocion->nombrePromo,
		                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
		                    )
		                ); ?>
		                <?php echo '<strong>Nombre</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => $model_promocion->contenido,
		                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
		                    )
		                ); ?>
		                <?php echo '<strong>Mensaje</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => $model_promocion->fecha,
		                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
		                    )
		                ); ?>
		                <?php echo '<strong>Fecha</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => date("h:i a", strtotime($model_promocion->hora)),
		                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
		                    )
		                ); ?>
		                <?php echo '<strong>Hora Inicio</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => date("h:i a", strtotime($model_promocion->hora_limite)),
		                        'htmlOptions' => array('style' => 'background-color: white; color: black'),
		                    )
		                ); ?>
		                <?php echo '<strong>Hora Fin</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => $model_promocion->total,
		                        'htmlOptions' => array('style' => 'background-color: #5cb85c; color: white'),
		                    )
		                ); ?>
		                <?php echo '<strong>Total destinatarios</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php 
		        			$estado = $this->actionGetStatusPromocion($model_promocion->id_promo);
            				$objeto = Yii::app()->Funciones->getColorLabelEstadoPromocionesBCP($estado);

	            			$this->widget(
			                    'booster.widgets.TbBadge',
			                    array(
			                    	//'context' => $objeto['clase'],
			                        'label' => $objeto['label'],
			                        'htmlOptions' => array('style' => 'background-color: '.$objeto['background_color'].'; color: white'),
			                    )
			                );
			            ?>
			            <?php echo '<strong>Estado</strong>'; ?>
		        	</li>
	        	</ul>
	      	</div>
	    </div>
	</div>
</div>
<?php $this->endWidget(); ?>