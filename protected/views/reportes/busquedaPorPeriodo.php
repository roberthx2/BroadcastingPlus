<?php 
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
<br>
<div class="form-group">
	<?php echo $form->datePickerGroup(
		$model,
		'fecha_ini',
		array(
			//'value' => date("Y-m-d"),
			'widgetOptions' => array(
				'options' => array(
					'language' => 'es',
					'format' => 'yyyy-mm-dd',
					'startDate' => Yii::app()->Procedimientos->getMinDateHistorial(),
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

	<?php echo $form->datePickerGroup(
		$model,
		'fecha_fin',
		array(
			//'value' => date("Y-m-d"),
			'widgetOptions' => array(
				'options' => array(
					'language' => 'es',
					'format' => 'yyyy-mm-dd',
					'startDate' => Yii::app()->Procedimientos->getMinDateHistorial(),
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