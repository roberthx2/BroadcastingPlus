<div class="form-group">
	<?php echo $form->datePickerGroup(
		$model,
		'fecha',
		array(
			//'value' => date("Y-m-d"),
			'widgetOptions' => array(
				'options' => array(
					'language' => 'es',
					'format' => 'yyyy-mm-dd',
					'startDate' => $smsinBtl_minDate,
					'endDate' => date("Y-m-d"),
					'autoclose' => true,
				),
				'htmlOptions' => array('value'=>date("Y-m-d"), 'readonly'=>true, 'style'=>'background-color: white;'),
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5',
			),
			//'hint' => 'Click inside! This is a super cool date field.',
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
		)
	); ?>
</div>