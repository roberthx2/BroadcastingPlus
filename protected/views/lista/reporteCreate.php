<div class="col-md-4">
	<?php 
		$objeto = TmpProcesamientoController::actionResumenGeneral($id_proceso, $nombre);
		echo $this->renderPartial("/TmpProcesamiento/resumenGeneral", array("objeto"=>$objeto), true); 
	?>
</div>
<div class="col-md-8">
<?php 
	$data = TmpProcesamientoController::actionReporteTortaBCNL($id_proceso);
	echo $this->renderPartial("/TmpProcesamiento/graficoTortaBCNL", array("data"=>$data), true); 
?>
</div>
<div class="col-md-12">
	<?php $model_procesamiento = new TmpProcesamiento("searchReporteLista");
		//$model_procesamiento->unsetAttributes();
		if(isset($_GET['TmpProcesamiento'])){
			//$model_procesamiento->attributes=$_GET['TmpProcesamiento'];
			$model_procesamiento->buscar = $_GET['TmpProcesamiento']["buscar"];
		}

		echo $this->renderPartial("/TmpProcesamiento/reporteCrearLista", array("model_procesamiento"=>$model_procesamiento,'id_proceso'=>$id_proceso), true);

	//TmpProcesamientoController::actionReporteCrearLista($id_proceso);

		?>
</div>