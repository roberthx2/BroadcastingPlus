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
		'year',
		array(
			'wrapperHtmlOptions' => array(
				//'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				'data' => $anios,
				'htmlOptions' => array('options'=>array(date("Y")=>array('selected'=>true))),	
			),
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
		)
	); ?>
</div><!-- /.col-lg-6 -->

