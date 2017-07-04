<?php 
	//$model = new Reportes();

	$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		//'id' => 'lista-form',
		'action'=>Yii::app()->createUrl($this->route/*, array("id_proceso"=>$id_proceso)*/),
		'method'=>'get',
		'type' => 'vertical',
		//'enableAjaxValidation'=>false,
	)
);
?>
<?php echo $form->hiddenField($model, 'tipo_busqueda', array('value'=>1)); ?>
<br>

<?php 
	$anio_min = date("Y", strtotime(Yii::app()->Procedimientos->getMinDateHistorial()));
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
		'year',
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
		'month',
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

	<?php 
		if (isset($_SESSION["objeto"]["show_cliente"]) && $_SESSION["objeto"]["show_cliente"])
		{
			$show = (Yii::app()->user->isAdmin()) ? "block" : "none";

			echo "<div style='display: ".$show."'>";
				echo $form->dropDownListGroup(
					$model,
					'id_cliente_bcnl',
					array(
						'wrapperHtmlOptions' => array(
							'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
						),
						'widgetOptions' => array(
							'data' => CHtml::listData(Yii::app()->Procedimientos->getClientesBCP(Yii::app()->user->id), 'id_cliente', 'descripcion'),
							//'htmlOptions' => array('prompt' => 'Seleccionar...'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
						),
						'prepend' => '<i class="glyphicon glyphicon-user"></i>',
					)
				);
			echo "</div>"; 
		}
	?>

  	<?php $this->widget(
    'booster.widgets.TbButton',
        array(
            'context' => 'primary',
            'label' => 'Consultar',
            'buttonType' =>'submit',
            'icon' => 'glyphicon glyphicon-search',
            'htmlOptions' => array("style"=>"float:right;"),
        )
    ); ?>
</div><!-- /.col-lg-6 -->
<?php $this->endWidget(); ?>

<script type="text/javascript">

	function getMonthArray(ini, fin)
	{
		var meses = {01:"Enero", 02:"Febrero", 03:"Marzo", 04:"Abril", 05:"Mayo", 06:"Junio", 07:"Julio", 08:"Agosto", 09:"Septiembre", 10:"Octubre", 11:"Noviembre", 12:"Diciembre"};

		$("#Reportes_month").empty();

		for (var i=parseInt(ini); i<=parseInt(fin); i++)
		{
			$("#Reportes_month").append($("<option>").text(meses[i]).attr("value",i));
		} 
	}
	
	function getMonth()
	{
		var anio_min = '<?php echo date("Y", strtotime(Yii::app()->Procedimientos->getMinDateHistorial())); ?>';
		var anio_select = $("#Reportes_year").val();
		var anio_actual = '<?php echo date("Y"); ?>';
		var mes_min = '<?php echo date("m", strtotime(Yii::app()->Procedimientos->getMinDateHistorial())); ?>';
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
    	$("#Reportes_month option[value='" + parseInt('<?php echo date("m"); ?>') + "']").prop("selected", true);
    });

</script>

