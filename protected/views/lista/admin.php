<?php
/* @var $this ListaController */
/* @var $model Lista */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#lista-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="col-md-12">
<br>
<?php if(Yii::app()->user->hasFlash('success')):?>
	<br>
    <div class="container-fluid">
	      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	        <div class="alert alert-success">
	          <button type="button" class="close" data-dismiss="alert">&times;</button>
	          <span class="glyphicon glyphicon-ok"></span> <?php echo Yii::app()->user->getFlash('success'); ?>
	        </div>
	      </div>
	    </div>
<?php endif; ?>

<h1>Administrar Listas</h1>
<br><br>

<div class="search-form">
    <?php $this->renderPartial('_search',array('model'=>$model, 'id_usuario'=>$id_usuario)); ?>
</div><!-- search-form -->

<div class="col-md-12">
<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'lista-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->searchTmp($id_usuario),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
	            'name' => 'u.login',
	            'value' => '$data["login"]',
	            'header' => 'Usuario',
	            'type' => 'raw',
//	            'ajaxUpdate'=>true,
	            'htmlOptions' => array('style' => 'text-align: center;', 'class' => 'test'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'visible'=>Yii::app()->user->isAdmin()
        	),
        	array(
        		'class' => 'booster.widgets.TbEditableColumn',
	            'name' => 'nombre',
	            'header' => 'Nombre',
	            //'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'editable' => array(
	            	'type' => 'text',
	            	//'pk' => '$data["id_lista"]',
	            	'mode' => 'inline',
	            	'showbuttons' => false,
	            	'title' => 'Ingrese el nombre',
	            	//'text' => 'okno',
	            	'disabled' =>true,
	            	'encode' => false,
	            	//'params'=> array('id_usuario'=>'$data["id_usuario"]'),/*function ($params, $data) {
	            	//	$params["pk"] = $data["id_usuario"];
	            	//	return $params;
	            	//},*/
                    //'url' => $this->owner->createUrl('example/editable'),
                    //'url'=>Yii::app()->controller->createUrl('lista/editableSaver'),
                    'placement' => 'top',
                    'inputclass' => 'input-medium',
                    /*'validate' => 'js: function(value) {
						  $.ajax({
	                        url: "/BroadcastingPlus/index.php?r=lista/editableSaver",
	                        type:"post", 
	                        async:false,   
	                        data:{nombre:value},
	                        
	                        complete: function()
	                        {
	                            return "enviando";
	                        },
	                        success: function(data)
	                        {
	                            return data.output;
	                        },
	                        error: function()
	                        {
	                          return "mal";  
	                        }
	                    });
					}',*/
					/*'display' => 'js: function(value, sourceData) {
					  var escapedValue = $("<div>").text(value).html();
					  $(this).html("<b>" + escapedValue + "</b>")
					}',*/
					/*'onInit' => 'js: function(event, editable) {
					  console.debug("X-Editable field " + editable.options.name + " ready to serve.");
					}',*/
					/*'onShown' => 'js: function(event) {
					  var tip = $(this).data("editableContainer").tip();
					  tip.find("input").val("overwriting value of input.");
					}',*/
					/*'onHidden' => 'js: function(event, reason) {
					  if (reason === "save" || reason === "cancel") {
					    // auto-open next editable
					    $(this).closest("tr").next().find(".editable").editable("show");
					  }
					}',*/
					/*'onSave' => 'js: function(event, params) {
					  console.debug("Saved value: " + params.newValue);
					}'*/
                    /*'success' => 'js: function(response, newValue) {
					  if (!response.success) 
					    alert(response.output.errorHttpCode);
					}'*/
                )
        	),
        	array(
	            'name' => 'total',
	            'header' => 'Total Destinatarios',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
        	),
        	array(
	            'class' => 'CButtonColumn',
	            'header' => 'Acciones',
	            'template' => '{Editar}&#09;{Descargar}&#09;{Eliminar}',
	            'headerHtmlOptions' => array('class'=>'bg-primary text-center'),
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'buttons' => array(
	            	'Editar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("lista/update", array("id"=>$data["id_lista"]))',
	            			//'visible'=>'visibleConfirmar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-pencil', 'title'=>'Editar Lista', 'style'=>'color:black;'),
                            ),
	            	'Descargar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("lista/descargarLista", array("nombre" => $data["nombre"], "id_lista" => $data["id_lista"]))',
	            			//'visible'=>'visibleCancelar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-download-alt', 'title'=>'Descargar Lista', 'style'=>'color:black;',),
	            			),
	            	'Eliminar'=>array(
	            			'label'=>' ',
	            			'url'=>'Yii::app()->createUrl("lista/viewDelete", array("id_lista" => $data["id_lista"]))',
	            			//'visible'=>'visibleCancelar($data)',
	            			'options'=>array('class'=>'glyphicon glyphicon-trash', 'title'=>'Eliminar Lista', 'style'=>'color:black;', 'data-toggle' => 'modal', 'data-target' => '#modalEliminar'),
	            			)
	            ),
	        ),
        ),
    ));
?>
</div>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalEliminar')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
		<h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar Lista</h4>
    </div>
 	
    <div class="modal-body" id="divModalEliminar" >
       
    </div>
 
<?php $this->endWidget(); ?>

<style type="text/css">
    a:link, a:visited {
        color: white;
        text-decoration: none;
    }

    .test a:link, a:visited {
        color: black;
        text-decoration: block;
    }
</style>

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
	});
</script>