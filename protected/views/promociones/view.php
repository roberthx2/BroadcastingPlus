<div class="col-md-7">
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
	      		<?php
	      			echo $this->renderPartial('viewDetalles', array("model"=>$model, 'cliente'=>$cliente, 'estado'=>$estado));
	      		?>
		      	</div>
    		</div>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>

<div class="clearfix visible-xs-block"></div>

<?php 

	$model_outgoing=new Outgoing('search');
	$model_outgoing->unsetAttributes();

	if(isset($_GET['Outgoing']))
		$model_outgoing->buscar = $_GET['Outgoing']["buscar"];

	echo $this->renderPartial("informacionDestinatarios", array("model_promocion"=>$model, 'model_outgoing'=>$model_outgoing), true); 
?>