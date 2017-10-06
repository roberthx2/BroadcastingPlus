<div class="col-md-4">
	<?php 
		$objeto = TmpProcesamientoController::actionResumenGeneral($id_proceso, $nombre);
		echo $this->renderPartial("/tmpProcesamiento/resumenGeneral", array("objeto"=>$objeto), true); 
	?>
</div>

<div class="col-md-7 pull-right">
<?php 
	if ($show_horario == 'true')
		echo $this->renderPartial("mensajeHorario"); 
?>
</div>

<div class="clearfix visible-xs-block"></div>

<?php 
	
	$model_procesamiento = new TmpProcesamiento("searchReporteLista");
	
	if(isset($_GET['TmpProcesamiento']))
	{
		$model_procesamiento->buscar = $_GET['TmpProcesamiento']["buscar"];
	}

	echo $this->renderPartial("/tmpProcesamiento/reporteBCNL", array("model_procesamiento"=>$model_procesamiento,'id_proceso'=>$id_proceso), true);
?>