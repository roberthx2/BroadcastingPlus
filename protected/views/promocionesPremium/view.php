<div class="col-md-7">
	<?php 
		echo $this->renderPartial("informacionPromocion", array("model_promocion"=>$model_promocion), true); 
	?>
</div>

<div class="col-md-5">
<?php 
	$data = $this->actionReporteTorta($model_promocion->id_promo);
	echo $this->renderPartial("/TmpProcesamiento/graficoTorta", array("data"=>$data), true); 
?>
</div>

<div class="clearfix visible-xs-block"></div>

<?php 

	$model_outgoing=new OutgoingPremium('search');
	$model_outgoing->unsetAttributes();

	if(isset($_GET['OutgoingPremium']))
		$model_outgoing->buscar = $_GET['OutgoingPremium']["buscar"];

	echo $this->renderPartial("informacionDestinatarios", array("model_promocion"=>$model_promocion, 'model_outgoing'=>$model_outgoing), true); 
?>