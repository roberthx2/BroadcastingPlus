<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route/*, array("id_proceso"=>$id_proceso)*/),
	'method'=>'get',
)); ?>

<div class="form-group col-md-6">
    <div class="input-group">
      <?php echo $form->textField($model,'buscar',array('class'=>'form-control','size' => 45, 'maxlength' => 45, 'placeholder' => 'Buscar...', 'autocomplete'=>'off')); ?>
      <span class="input-group-btn" title="Buscar">
        <button class="btn btn-primary" type="submit" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->	
<?php $this->endWidget(); ?>
</div><!-- Search-form -->