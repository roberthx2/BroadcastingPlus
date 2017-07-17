
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

<?php

    if ($model->escenario == 'operBase')
    {
        $data = CHtml::listData(OperadorasRelacion::model()->findAll(array("group"=>"id_operadora_bcnl")), 'id_operadora_bcnl', 'descripcion');
    }
    else if ($model->escenario == '')
    {

    }
?>

<?php 
    $model->valor = explode(",", $model->valor);
    
    echo $form->select2Group(
        $model,
        'valor',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
            ),
            'widgetOptions' => array(
                'asDropDownList' => true,
                'data'=>CHtml::listData(UsuarioSms::model()->findAll(array("condition"=>"id_perfil IN(1,2)", "order"=>"login")), 'id_usuario', 'login'),
                
                'options' => array(
                    //'tags' => $model_lista,//array('clever', 'is', 'better', 'clevertech'),
                    'placeholder' => 'Seleccione sus listas...',
                    'allowClear'=>true,
                    /* 'width' => '40%', */
                    'tokenSeparators' => array(',', ' ')
                ),
                'htmlOptions'=>array(
                    'multiple'=>'multiple',
                    //'disabled'=>true,
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-user"></i>',
        )
    ); 
?>
<?php echo $form->hiddenField($model, 'id'); ?>
<?php echo $form->hiddenField($model, 'propiedad'); ?>
<?php echo $form->hiddenField($model, 'escenario'); ?>
        
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
 