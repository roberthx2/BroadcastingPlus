
<?php
	/* @var $this ContactosAdministrativosController */
	/* @var $model ContactosAdministrativos */

	Yii::app()->clientScript->registerScript('searchUpdateLista', "

	$('.search-form form').submit(function(){
	    $('#contactos-administrativos-grid').yiiGridView('update', {
	        data: $(this).serialize()
	    });
	    return false;
	});

	");
?>
<br>
<?php if(Yii::app()->user->hasFlash('success')):?>
	<br>
    <div class="container-fluid alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="glyphicon glyphicon-ok"></span> <?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif; ?>

<fieldset>
 
    <legend>Contactos Administrativos</legend>


<div class="clearfix visible-xs-block"></div>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs ">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php 
	$this->widget(
        'booster.widgets.TbButton',
        array(
        	'id'=>'agregar',
        	'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Agregar Números',
            'icon' => 'glyphicon glyphicon-plus',
            'url' => Yii::app()->createUrl("contactosAdministrativos/create"),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        )
    ); 
?>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 visible-xs ">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'contactos-administrativos-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
        'columns'=> array( 
        	array(
	            'name' => 'nombre',
	            'header' => 'Nombre',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'correo',
	            'header' => 'Correo',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'numero',
	            'header' => 'Número',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
        		'name' => 'estado',
	            'header' => 'Estado',
	            'type' => 'raw',
	            'value' => function($data) {
	            	
	            	$bg = Yii::app()->Funciones->getColorValidoInvalido($data["estado"]);

	            	Controller::widget(
					    'booster.widgets.TbLabel',
					    array(
					        'label' => ($data["estado"] == 1) ? "Activo" : "Inactivo",
					        'htmlOptions'=>array('style'=>'background-color: '.$bg.';'),	
					    )
					);
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{Editar}&#09;{Eliminar}',
	            'headerHtmlOptions' => array('class'=>'tableHover'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'Editar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("contactosAdministrativos/update", array("id"=>$data["id_contacto"]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-pencil', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Editar Contacto', 'style'=>'color:black;'),
                            ),
	            	'Eliminar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("contactosAdministrativos/delete", array("id_lista" => $data["id_contacto]))',
	            			'options'=>array('class'=>'glyphicon glyphicon-trash', 'title'=>'Eliminar Contacto', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-tooltip'=>'tooltip', 'data-target' => '#modalEliminar'),
	            			'click' => 'function(){
                                    $.ajax({
                                        beforeSend: function(){
                                           $("#divModalEliminar").addClass("loading");
                                        },
                                        complete: function(){
                                           $("#divModalEliminar").removeClass("loading");
                                        },
                                        type: "POST",
                                        url: $(this).attr("href"),
                                        success: function(data) { 
                                            $("#divModalEliminar").html(data);
                                        },
                                        error: function() { 
                                            alert("No se puede cargar el formulario, intente de nuevo.");
                                        }
                                    });
                                }'
	            			)
	            ),
	        ),
        ),
    ));
?> 

</fieldset>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEliminar')
); ?>
 
    <div class="modal-header" style="background-color:#d2322d">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar Contacto</h4>
    </div>
 	
    <div class="modal-body trOverFlow" id="divModalEliminar" >
       
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

		$('[data-tooltip="tooltip"]').tooltip();
	});
</script>
