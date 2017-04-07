
<?php /** @var TbActiveForm $form */
    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'configuracion-form',
            'type' => 'vertical',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>false,
            ),
        )
    );
?>
<div id="respuesta" class="alert alert-success" role="alert" style="display: none;"></div>

<?php echo $form->timePickerGroup(
    $model,
    'valor',
    array(
        'widgetOptions' => array(
            'options' => array(
                //'defaultTime' => $interval_minute["hora_ini"],
                'showMeridian' => false,
                'showSeconds' => false,
                //'minuteStep' => $interval_minute["interval_minute"],
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-5'
            ),
            'htmlOptions' => array( 'readonly'=>false, 'style'=>'background-color: white;'),
        ),
        //'hint' => 'Nice bootstrap time picker',
    )
); ?>

<?php echo $form->hiddenField($model, 'id'); ?>
<?php echo $form->hiddenField($model, 'propiedad'); ?>
<?php echo $form->hiddenField($model, 'escenario'); ?>
        
<div class="modal-footer" id="modal_footer">
     <?php 

     $this->widget('booster.widgets.TbButton', array(
    	'label'=>'Guardar',
    	'url'=>'#',
    	'htmlOptions'=>array('class'=>'btn btn-success', 'onclick' => 'enviar()'),
	)); ?>

	<?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
    
    <?php

        $this->endWidget();
        unset($form);
    ?>
</div>

<style>
    #bootstrap-timepicker-widget {
        z-index: 100000 !important;
    }
</style>