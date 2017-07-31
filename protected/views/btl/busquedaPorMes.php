<?php 
	$anio_min = date("Y", strtotime($smsinBtl_minDate));
	$anios = array();

	do
	{
		$anios[$anio_min] = $anio_min;
		$anio_min++;
	} while ($anio_min <= date("Y"));
?>

<div class="form-group">
	<?php echo $form->dropDownListGroup(
		$model,
		'anio',
		array(
			'wrapperHtmlOptions' => array(
				//'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				'data' => $anios,
				'htmlOptions' => array('onchange'=>'js:getMonth()', 'options'=>array(date("Y")=>array('selected'=>true))),	
			),
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
		)
	); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'mes',
		array(
			'wrapperHtmlOptions' => array(
				//'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				//'htmlOptions' => array('options'=>array(date("m")=>array('selected'=>true))),
			),
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
		)
	); ?>
</div><!-- /.col-lg-6 -->

<script type="text/javascript">

	function getMonthArray(ini, fin)
	{
		var meses = {01:"Enero", 02:"Febrero", 03:"Marzo", 04:"Abril", 05:"Mayo", 06:"Junio", 07:"Julio", 08:"Agosto", 09:"Septiembre", 10:"Octubre", 11:"Noviembre", 12:"Diciembre"};

		$("#Btl_mes").empty();

		for (var i=parseInt(ini); i<=parseInt(fin); i++)
		{
			$("#Btl_mes").append($("<option>").text(meses[i]).attr("value",i));
		} 
	}
	
	function getMonth()
	{
		var anio_min = '<?php echo date("Y", strtotime($smsinBtl_minDate)); ?>';
		var anio_select = $("#Btl_anio").val();
		var anio_actual = '<?php echo date("Y"); ?>';
		var mes_min = '<?php echo date("m", strtotime($smsinBtl_minDate)); ?>';
		var mes_actual = '<?php echo date("m"); ?>';

		if (anio_select == anio_actual)
		{
			if (anio_min < anio_actual)
				getMonthArray(1, mes_actual);
			else
				getMonthArray(mes_min, mes_actual);
		}
		else
		{
			if (anio_min < anio_select)
				getMonthArray(1, 12);
			else
				getMonthArray(mes_min, 12);
		}

	}

	$(document).ready(function() 
    {
    	getMonth();
    	$("#Btl_mes option[value='" + parseInt('<?php echo date("m"); ?>') + "']").prop("selected", true);
    });

</script>

