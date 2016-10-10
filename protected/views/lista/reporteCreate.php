<div class="col-md-5">
	<?php 
		$objeto = TmpProcesamientoController::actionResumenGeneral($id_proceso, $nombre);
		echo $this->renderPartial("/TmpProcesamiento/resumenGeneral", array("objeto"=>$objeto), true); 
	?>
</div>
<div class="col-md-7">
<?php 
	echo $this->renderPartial("/TmpProcesamiento/graficoTorta", false, true); 
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