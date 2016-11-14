<div class="col-md-4">
	<?php 
		$objeto = TmpProcesamientoController::actionResumenGeneral($id_proceso, $nombre);
		echo $this->renderPartial("/TmpProcesamiento/resumenGeneral", array("objeto"=>$objeto), true); 
	?>
</div>

<div class="col-md-8">
<?php 
	$data = TmpProcesamientoController::actionReporteTortaBCNL($id_proceso);
	echo $this->renderPartial("/TmpProcesamiento/graficoTorta", array("data"=>$data), true); 
?>
</div>

<div class="clearfix visible-xs-block"></div>

<?php 
	
	$model_procesamiento = new TmpProcesamiento("searchReporteLista");
	
	if(isset($_GET['TmpProcesamiento']))
	{
		$model_procesamiento->buscar = $_GET['TmpProcesamiento']["buscar"];
	}

	echo $this->renderPartial("/TmpProcesamiento/reporteBCNL", array("model_procesamiento"=>$model_procesamiento,'id_proceso'=>$id_proceso), true);
?>