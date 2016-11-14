<?php /** @var TbActiveForm $form */
	$form2 = $this->beginWidget(
		'booster.widgets.TbActiveForm',
		array(
			'id' => 'prefijo-promocion-form',
			'type' => 'vertical',
			//'action'=>Yii::app()->createUrl('prefijoPromocion/create'),
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

<?php 
	$this->widget(
        'booster.widgets.TbButton',
        array(
        	'id'=>'agregar',
        	'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Crear Prefijo',
            'icon' => 'glyphicon glyphicon-plus',
            //'url' => Yii::app()->createUrl("lista/agregarNumeros", array("id_lista"=>$model_lista->id_lista)),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6', 'data-toggle' => 'modal', 'data-target' => '#modalPrefijo'),
        )
    ); 
?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalPrefijo')
); ?>
 
    <div class="modal-header" style="background-color:#d2322d">
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Crear Prefijo</h4>
    </div>
 	
    <div class="modal-body" id="divModalPrefijo" >
       <div class="form form-group">
		    <div class="input-group">
		    	<span class="input-group-addon" aria-hidden="true"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span></span>
		      		<?php echo $form2->textField($model,'prefijo',array('class'=>'form-control','size' => 30, 'maxlength' => 10, 'placeholder' => 'Crear Prefijo', 'autocomplete'=>'off')); ?>
		    </div>
		    <div class="input-group">
		     	<?php echo $form2->error($model,'prefijo'); ?>
		    </div>
		</div>
    </div>

    <div class="modal-footer" id="modal_footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
            	'id'=>'crearPrefijo',
                'context' => 'success',
                'label' => 'Crear',
                'url' => Yii::app()->createUrl("prefijoPromocion/create"),
                'icon' => 'glyphicon glyphicon-trash',
                'htmlOptions' => array('data-loading-text'=>'Creando...', 'autocomplete'=>'off'),
            )
        ); ?>
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>

<script type="text/javascript">

$(document).ready(function()
{
	$("a[data-toggle=modal]").click(function(){
	    var target = $(this).attr('data-target');
	    var url = $(this).attr('href');
	    if(url){
	        $(target).find(".modal-body").load(url);
	    }
	});

	$('#crearPrefijo').click(function(){
	    $.ajax({
            url:"<?php echo Yii::app()->createUrl('prefijoPromocion/create'); ?>",
            type:"POST",    
            data: $("#prefijo-promocion-form").serialize(),

            success: function(data)
            {
            	if (data.salida !== 0)
            	{
            		var mensaje = "<center><strong>Prefijo(s) eliminado(s) correctamente</center></strong>";
            		$("#prefijo-promocion-grid").yiiGridView("update"); 
            	}
            	else
            	{
            		var mensaje = "<center><strong>No se pudo eliminar ningún prefijo, intente nuevamente</center></strong>";
            	}

                $("#divModalEliminar").html(mensaje);
                $("#modal_footer").hide();
            },
            error: function()
            {
                $("#divModalEliminar").html("<center><strong>Ocurrio un ERROR al intentar eliminar los prefijo</center></strong>");
                $("#modal_footer").hide();
            }
        });
	});
});
</script>