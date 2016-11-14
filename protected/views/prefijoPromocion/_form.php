<?php /** @var TbActiveForm $form */
	$form = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'prefijo-promocion-form',
			'type' => 'vertical',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>true,
                'validateOnType'=>true,   
            ),
		)
); ?>

<?php //$form=$this->beginWidget('CActiveForm', array(
	//'action'=>Yii::app()->createUrl('prefijoPromocion/create', array("id_usuario"=>4)),
	//'method'=>'POST',
//)); ?>

<div class="form form-group">
    <div class="input-group">
    	<span class="input-group-addon" aria-hidden="true"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span></span>
      		<?php echo $form->textField($model,'prefijo',array('class'=>'form-control','size' => 30, 'maxlength' => 10, 'placeholder' => 'Crear Prefijo', 'autocomplete'=>'off')); ?>
      	<span class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Crear Prefijo">
        	<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
      	</span>
    </div>
    <div class="input-group">
     	<?php echo $form->error($model,'prefijo'); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
