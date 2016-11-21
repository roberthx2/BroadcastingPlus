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
		                <div class="cantainer"><strong>Cliente</strong></div>
		        		<div class="cantainer trOverFlow" style="font-size:12px;">
		        			<br><strong><input style="border:0;" id="detalleClienteBCP" value="<?php echo 'cliente'; ?>" readonly></strong>
		        		</div>
		        	</li>
		        	<li class="list-group-item">
		        		<div class="cantainer"><strong>Enviados</strong></div>
		        		<div class="cantainer trOverFlow" style="font-size:12px;">
		        			<br><strong><input style="border:0;" id="detalleEnviadosBCP" value="<?php echo 'cliente'; ?>" readonly></strong>
		        		</div>
		        	</li>
		        	<li class="list-group-item">
		        		<div class="cantainer"><strong>No enviados</strong></div>
		        		<div class="cantainer trOverFlow" style="font-size:12px;">
		        			<br><strong><input style="border:0;" id="detalleNoEnviadosBCP" value="<?php echo 'cliente'; ?>" readonly></strong>
		        		</div>
		        	</li>
		        	<li class="list-group-item">
		        		<div class="cantainer"><strong>Total</strong></div>
		        		<div class="cantainer trOverFlow" style="font-size:12px;">
		        			<br><strong><input style="border:0;" id="detalleTotalBCP" value="<?php echo 'cliente'; ?>" readonly></strong>
		        		</div>
		        	</li>
	        	</ul>
	      	</div>
	    </div>
	</div>
</div>
<?php $this->endWidget(); ?>