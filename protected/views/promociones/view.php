<div class="col-md-6">
	<?php 
		echo $this->renderPartial("informacionPromocion", array("model_promocion"=>$model_promocion), true); 
	?>
</div>

<div class="col-md-6">
<?php 
	$data = $this->actionReporteTorta($model_promocion->id_promo);
	echo $this->renderPartial("/TmpProcesamiento/graficoTorta", array("data"=>$data), true); 
?>
</div>

<div class="clearfix visible-xs-block"></div>

<?php 

	$model_outgoing=new Outgoing('search');
	$model_outgoing->unsetAttributes();

	if(isset($_GET['Outgoing']))
		$model_outgoing->buscar = $_GET['Outgoing']["buscar"];

	echo $this->renderPartial("informacionDestinatarios", array("model_promocion"=>$model_promocion, 'model_outgoing'=>$model_outgoing), true); 
?>