<div class="col-md-5">
	<?php 
		$objeto = TmpProcesamientoController::actionResumenGeneral($id_proceso, $nombre);
		echo $this->renderPartial("/TmpProcesamiento/resumenGeneral", array("objeto"=>$objeto), true); 
	?>
</div>
<div class="col-md-7">
<?php 
	$data = TmpProcesamientoController::actionReporteTortaBCP($id_proceso);
	echo $this->renderPartial("/TmpProcesamiento/graficoTorta", array("data"=>$data), true); 
?>
</div>

<div class="clearfix visible-xs-block"></div>

<?php 
	$this->widget(
        'booster.widgets.TbButton',
        array(
        	'id'=>'agregar',
        	'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Confirmar',
            'icon' => 'glyphicon glyphicon-plus',
            'url' => Yii::app()->createUrl("lista/agregarNumeros", array()),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6', 'style'=>'float:rigth;'),
        )
    ); 
?>

<div class="clearfix visible-xs-block"></div>

<?php $model_procesamiento = new TmpProcesamiento("searchReporteBCP");
	//$model_procesamiento->unsetAttributes();
	if(isset($_GET['TmpProcesamiento'])){
		//$model_procesamiento->attributes=$_GET['TmpProcesamiento'];
		$model_procesamiento->buscar = $_GET['TmpProcesamiento']["buscar"];
	}

	echo $this->renderPartial("/TmpProcesamiento/reporteBCP", array("model_procesamiento"=>$model_procesamiento,'id_proceso'=>$id_proceso), true);
?>