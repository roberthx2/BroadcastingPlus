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
	<?php echo $form->dropDownListGroup(
		$model,
		'year',
		array(
			'wrapperHtmlOptions' => array(
				//'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				'data' => array(
					//date('Y',strtotime('-2 year', strtotime(date('Y'))))=>date('Y',strtotime('-2 year', strtotime(date('Y')))), 
					date('Y',strtotime('-1 year', strtotime(date('Y'))))=>date('Y',strtotime('-1 year', strtotime(date('Y')))),
					date('Y')=>date('Y'),
					),
				'htmlOptions' => array('options'=>array(date("Y")=>array('selected'=>true))),	
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
				'data' => array("01"=>"Enero", "02"=>"Febrero", "03"=>"Marzo", "04"=>"Abril", "05"=>"Mayo", "06"=>"Junio", "07"=>"Julio", "08"=>"Agosto", "09"=>"Septiembre", "10"=>"Octubre", "11"=>"Noviembre", "12"=>"Diciembre"),
				'htmlOptions' => array('options'=>array(date("m")=>array('selected'=>true))),
			),
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
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