<div class="col-md-5">
	<?php 
		$objeto = TmpProcesamientoController::actionResumenGeneral($id_proceso, $nombre);
		echo $this->renderPartial("/tmpProcesamiento/resumenGeneralPromocion", array("objeto"=>$objeto, "url_confirmar"=>$url_confirmar, 'personalizada'=>$personalizada), true); 
	?>
</div>
<div class="col-md-7">
<?php

	$data = TmpProcesamientoController::actionReporteTortaBCNL($id_proceso);

	echo $this->renderPartial("/tmpProcesamiento/graficoTorta", array("data"=>$data), true); 
?>
</div>

<div class="clearfix visible-xs-block"></div>

<?php

	$model_procesamiento = new TmpProcesamiento("searchReporteBCNL");
	
	if(isset($_GET['TmpProcesamiento'])){
		$model_procesamiento->buscar = $_GET['TmpProcesamiento']["buscar"];
	}

	echo $this->renderPartial("/tmpProcesamiento/reporteBCNL", array("model_procesamiento"=>$model_procesamiento,'id_proceso'=>$id_proceso), true);

?>