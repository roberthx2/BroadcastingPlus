<?php /** @var TbActiveForm $form */
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'horizontalForm',
			'type' => 'horizontal',
		)
	); ?>
	 
	<fieldset>
 
		<legend>Crear Promoción</legend>

		<?php echo $form->dropDownListGroup(
			$model,
			'tipo',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4',
				),
				'widgetOptions' => array(
					'data' => $dataTipo,
					'htmlOptions' => array('prompt' => 'Seleccionar...'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
				),
				'prepend' => '<i class="glyphicon glyphicon-check"></i>'
			)
		); ?>

		<?php echo $form->dropDownListGroup(
			$model,
			'id_cliente',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4',
				),
				'widgetOptions' => array(
					'data' => $dataTipo,
					'htmlOptions' => array('prompt' => 'Seleccionar...'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
				),
				'prepend' => '<i class="glyphicon glyphicon-user"></i>'
			)
		); ?>

		<?php echo $form->textFieldGroup(
			$model,
			'nombre',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4',
				),
				'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
			)
		); ?>

		<?php echo $form->textAreaGroup(
			$model,
			'mensaje',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 5),
				),
				'prepend' => '<i class="glyphicon glyphicon-envelope"></i>'
			)
		); ?>

		<?php echo $form->datePickerGroup(
			$model,
			'fecha',
			array(
				'widgetOptions' => array(
					'options' => array(
						'language' => 'es',
					),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4',
				),
				//'hint' => 'Click inside! This is a super cool date field.',
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>

		<?php echo $form->timePickerGroup(
			$model,
			'hora_inicio',
			array(
				'widgetOptions' => array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4'
					),
				),
				//'hint' => 'Nice bootstrap time picker',
			)
		); ?>

		<?php echo $form->timePickerGroup(
			$model,
			'hora_fin',
			array(
				'widgetOptions' => array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4'
					),
				),
				//'hint' => 'Nice bootstrap time picker',
			)
		); ?>

		<?php echo $form->textAreaGroup(
			$model,
			'destinatarios',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 5),
				),
				'prepend' => '<i class="glyphicon glyphicon-phone"></i>'
			)
		); ?>

		<?php echo $form->select2Group(
			$model,
			'listas',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-4',
				),
				'widgetOptions' => array(
					'asDropDownList' => false,
					'options' => array(
						'tags' => CHtml::listData(Lista::model()->findAll(array("order"=>"nombre")), 'id_lista', 'nombre'),//array('clever', 'is', 'better', 'clevertech'),
						'placeholder' => 'Seleccione sus listas...',
						/* 'width' => '40%', */
						'tokenSeparators' => array(',', ' ')
					)
				),
				'prepend' => '<i class="glyphicon glyphicon-th-list"></i>'
			)
		);?>

	</fieldset>
		 
	<div class="form-actions">
		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'context' => 'primary',
				'label' => 'Submit'
			)
		); ?>

		<?php $this->widget(
			'booster.widgets.TbButton',
			array('buttonType' => 'reset', 'label' => 'Reset')
		); ?>
	</div>

	<?php
		$this->endWidget();
		unset($form);
	?>