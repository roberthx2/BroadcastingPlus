
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
<?php echo $form->passwordFieldGroup($model,'valor',array(
    'prepend' => '<i class="glyphicon glyphicon-pencil"></i>',
    'widgetOptions' => array(
    )
)); ?>

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
