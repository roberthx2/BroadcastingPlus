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
      				<li class="list-group-item">
      					<strong>Esta lista prodrá ser usada una vez sea analizada por el sistema </strong>
      				</li>
      				<li class="list-group-item">
      					<strong>Horarios de análisis:</strong>
      				</li>
      				<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '06:00 am / 10:00 am / 01:00 pm / 03:00 pm',
		                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'trOverFlow'),
		                    )
		                ); ?>
		                <?php echo '<strong>Lun - Jue</strong>'; ?>
		        	</li>
		        	<li class="list-group-item">
		        		<?php $this->widget(
		                    'booster.widgets.TbBadge',
		                    array(
		                        'label' => '06:00 am / 10:00 am / 02:00 pm',
		                        'htmlOptions' => array('style' => 'background-color: white; color: black', 'class'=>'trOverFlow'),
		                    )
		                ); ?>
		                <?php echo '<strong>Vie - Dom</strong>'; ?>
		        	</li>
	        	</ul>
      		</div>
    	</div>
  	</div>
</div>
<?php $this->endWidget(); ?>