<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route, array("id_proceso"=>$id_proceso)),
	'method'=>'get',
)); ?>

    <div class="form-group">
        <?php echo $form->textField($model,'buscar',array('size' => 45, 'maxlength' => 45, 'placeholder' => 'Nombre del profesor')); ?>
        <button type="submit" class="small btn-warning" style="border-left-width: 2px; margin-left: 10px; margin-top: 2px;">Buscar</button>
    </div>
<?php $this->endWidget(); ?>

</div><!-- Search-form -->