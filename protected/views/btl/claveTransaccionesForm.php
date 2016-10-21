<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'claveTransaccionesForm',
	'type'=>'vertical',

        'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions' => array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>true,
                'validateOnType'=>true,
        ),
)); ?>
        

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row">
            <div class="col-md-12">
                <h4>Usuario: <?php echo $model->login; ?></h4>
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <?php echo $form->passwordFieldGroup($model, 'pwd'); ?>
            </div>
        </div>
        

<?php $this->endWidget(); unset($form); ?>

<script>
    $(document).ready(function()
  {
    $("#Usuario_masivo_pwd").val("");
  });
  
   $('#myModal').keypress(function(event) {
       
        if (event.keyCode == 13) {
            event.preventDefault();

            $('#confirmarForm').click();
        }
   
    });
</script>
