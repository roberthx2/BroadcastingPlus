<div  id="page-content-wrapper">
	<div class="containder">
		<div class="panel-group" id="accordion">
			<div class="panel panel-primary">
			    <div class="panel-heading">
			      	<h4 class="panel-title">
			        	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			          		<span class="glyphicon glyphicon-list-alt"></span> SUSPENSION TEMPORAL DE HERRAMIENTA INSIGNIA BROADCASTING
			        	</a>
			      	</h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in">
			      	<div class="panel-body">
			      		<p>Estimado Asociado: <strong><?php echo $usuario; ?> </strong></p>
	                
		                <p><?php echo $model->mensaje; ?></p>
		                
		                <p>La herramienta estar&aacute; nuevamente disponible el d&iacute;a:  <strong><?php echo date_format(date_create($model->fecha_fin), 'd-m-Y'); ?> a las <?php echo date_format(date_create($model->hora_fin), 'h:i:s A'); ?></strong></p>

		                <br>
		                <div id="information">Ofrecemos disculpas por las molestias ocasionadas.</div>
		                <div style="text-align: right">Insignia Mobile, <?php echo date("d-m-Y")?></div>
			      	</div>
			    </div>
			</div>
		</div>
	</div>
</div>