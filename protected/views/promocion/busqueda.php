<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route/*, array("id_proceso"=>$id_proceso)*/),
	'method'=>'get',
)); ?>

<div class="form-group">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    <div class="input-group">
	      <?php echo $form->textField($model,'buscar',array('class'=>'form-control','size' => 45, 'maxlength' => 45, 'placeholder' => 'Buscar...', 'autocomplete'=>'off')); ?>
	      <span class="input-group-btn" title="Buscar">
	        <button class="btn btn-primary" type="submit" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	      </span>
	    </div><!-- /input-group -->
	</div>
	<div class="col-xs-4 col-sm-5 col-md-5 col-lg-4" style="padding-top: 5px; padding-right: 0px;"> <p align="right"><?php echo $form->labelEx($model,'pageSize'); ?> </p> </div>

	<div class="col-xs-2 col-sm-1 col-md-1 col-lg-2">

	    <div class="input-group">
	    	<?php
	                $pageSize = Yii::app()->params['defaultPageSize'];                
	                echo $form->dropDownList(
	                    $model,
	                    'pageSize',
	                    array( 10 => 10, 25 => 25, 50 => 50, 100 => 100 ),
	                    //array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
	                    array(
	                        'class'    => 'change-pagesize form-control',                    )
	                );
	            ?>
	    </div><!-- /input-group -->
    </div>
    <br><br>
</div><!-- /.col-lg-6 -->	
<?php $this->endWidget(); ?>
</div><!-- Search-form -->