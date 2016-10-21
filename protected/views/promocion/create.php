<?php /** @var TbActiveForm $form */
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'horizontalForm',
			'type' => 'vertical',
			//'enableAjaxValidation'=>true,
		)
	); ?>
	 
	<fieldset>
 
	<legend>Crear Promoción</legend>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?php echo $form->dropDownListGroup(
			$model,
			'tipo',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
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
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
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
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
			)
		); ?>

		<?php echo $form->textAreaGroup(
			$model,
			'mensaje',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 5, 'maxlength' => 158, 'style'=> 'resize:none;','onMouseDown' => 'contarCaracterPromocion()', 'onChange' => 'contarCaracterPromocion()', 'onBlur' => 'contarCaracterPromocion()','onKeyDown' => 'contarCaracterPromocion()','onFocus' => 'contarCaracterPromocion()','onKeyUp' => 'contarCaracterPromocion()'),
				),
				'prepend' => '<i class="glyphicon glyphicon-envelope"></i>'
			)
		); ?>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xs-push-6 col-sm-push-6 col-md-push-6 col-lg-push-6" style="font: bold 13px Arial;"><strong>Caracteres restantes:</strong>
			<?php echo CHTML::textField('caracteres',158,array('size'=>2 ,'style'=>'align:right; margin-left:10px; border:0;', 'readonly' => true)); ?></div>
		<div class="clearfix visible-xs-block"></div>

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
					'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5',
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
						'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
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
						'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
					),
				),
				//'hint' => 'Nice bootstrap time picker',
			)
		); ?>

	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

		<?php echo $form->select2Group(
			$model,
			'puertos',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'asDropDownList' => true,
					//'data'=>CHtml::listData(Lista::model()->findAll("id_usuario = ".Yii::app()->user->id), 'id_lista','nombre'),
					'data'=>array("1"=>"1", "2"=>"2", "3"=>"3"),
					'options' => array(
						//'tags' => $model_lista,//array('clever', 'is', 'better', 'clevertech'),
						'placeholder' => 'Seleccione sus listas...',
						'allowClear'=>true,
						/* 'width' => '40%', */
						'tokenSeparators' => array(',', ' ')
					),
					'htmlOptions'=>array(
						'multiple'=>'multiple',
					),
				),
				//'prepend' => '<i class="glyphicon glyphicon-random"></i>',
				'prepend' =>  '<strong>Todos</strong> '.CHtml::CheckBox('all_puertos',false, array('value'=>'true','title'=>'Seleccionar todos', 'onclick'=>'js:disabledPuertos();')),
			)
		);?>

		<?php echo $form->textAreaGroup(
			$model,
			'destinatarios',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('onKeyPress' => 'return processKeydown(event);', 'rows' => 5, 'placeholder' => '4160000000,4260000000,4140000000,4240000000,4120000000'),
				),
				'prepend' => '<i class="glyphicon glyphicon-phone"></i>'
			)
		); ?>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xs-push-8 col-sm-push-8 col-md-push-8 col-lg-push-8" style="font: bold 13px Arial;"><strong>Total: </strong>
			<?php echo CHTML::textField('total',0,array('size'=>2 ,'style'=>'margin-left:10px; border:0;', 'readonly' => true)); ?>
		</div>
		<div class="clearfix visible-xs-block"></div>

		<?php echo $form->select2Group(
			$model,
			'listas',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				),
				'widgetOptions' => array(
					'asDropDownList' => true,
					//'data'=>CHtml::listData(Lista::model()->findAll("id_usuario = ".Yii::app()->user->id), 'id_lista','nombre'),
					'data'=>$listas,
					'options' => array(
						//'tags' => $model_lista,//array('clever', 'is', 'better', 'clevertech'),
						'placeholder' => 'Seleccione sus listas...',
						'allowClear'=>true,
						/* 'width' => '40%', */
						'tokenSeparators' => array(',', ' ')
					),
					'htmlOptions'=>array(
						'multiple'=>'multiple',
					),
				),
				'prepend' => '<i class="glyphicon glyphicon-th-list"></i>'
			)
		);?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div align="center" style="padding: 30px 0 0px 0px;">
			<?php
                echo $this->renderPartial('/btl/index',false,true);
            ?>
            </div>
            <div id="numerosBTLDiv" style="display: none;" >
                <?php 
                echo $form->textAreaGroup(
						$model,
						'btl',
						array(
							'wrapperHtmlOptions' => array(
								//'class' => 'col-sm-5',
							),
							'widgetOptions' => array(
								'htmlOptions' => array('rows' => 5, 'onKeyPress' => 'return processKeydown(event);'),
							)
						)
					); 
                ?>
            </div>
		</div>

	</div>

	</fieldset>
	<br><br>
	<div class="form-actions col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xs-push-4 col-sm-push-5 col-md-push-5 col-lg-push-5">
		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'context' => 'success',
				'label' => 'Crear'
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
