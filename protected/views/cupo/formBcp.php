
<?php /** @var TbActiveForm $form */
    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'cupo-bcp-form',
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

<?php 
    echo $form->textFieldGroup(
        $model,
        'disponible',
        array(
            'wrapperHtmlOptions' => array(
                //'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('maxlength' => 10, 'autocomplete' => 'off'), //col-xs-12 col-sm-4 col-md-4 col-lg-4
            ),
            'prepend' => '<i class="glyphicon glyphicon-pencil"></i>'
        )
    );
?>

<?php echo $form->hiddenField($model, 'id_usuario'); ?>
        
<div class="modal-footer" id="modal_footer">
     <?php 

     $this->widget('booster.widgets.TbButton', array(
        'id'=>'boton_guardar',
    	'label'=>'Guardar',
    	'url'=>'#',
    	'htmlOptions'=>array('class'=>'btn btn-success', 'onclick' => 'enviar()'),
        'icon'=>'fa fa-floppy-o'
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
 