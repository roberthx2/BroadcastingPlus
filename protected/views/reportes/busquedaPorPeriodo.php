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
<?php echo $form->hiddenField($model, 'tipo_busqueda', array('value'=>2)); ?>
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

	<?php 
		if (isset($cliente) && $cliente)
		{
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