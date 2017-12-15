<?php
/* @var $this ClientesBcpController */
/* @var $model ClientesBcp */


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#clientes-bcp-grid').yiiGridView('update', {
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
 
    <legend>Administrar Burst Clientes BCP</legend>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php $this->renderPartial('/busqueda/busqueda',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'clientes-bcp-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search2(),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
                array(
                    'name' => 'descripcion',
                    'header' => 'Cliente',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                    'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
                ),
                array(
                    'name' => 'sc',
                    'header' => 'Short Code',
                    'type' => 'text',
                    'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                    'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
                ),
                array(
                    'class' => 'booster.widgets.TbEditableColumn',
                    'name' => 'burst',
                    'header' => 'Burst',
                    //'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                    'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
                    'editable' => array(    //editable section
                        //'apply'      => '$data->user_status != 4', //can't edit deleted users
                        'url'        => $this->createUrl('lista/editableSaver'),
                        'params' => array("model"=>"ClienteAlarmas"),
                        //'showbuttons' => false,
                        //'inputclass' => 'input-mini',
                        //'placement'  => 'right',
                        'title' => '',
                        'success' => 'js: function(response, newValue) {
                           if(!response.success) return response.msg;
                        }',
                        'options' => array(
                            'ajaxOptions' => array('dataType' => 'json')
                        ), 
                        
                    )
                ),
                array(
                    'class' => 'booster.widgets.TbEditableColumn',
                    'name' => 'segundos',
                    'header' => 'Segundos',
                    //'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                    'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
                    'editable' => array(    //editable section
                        //'apply'      => '$data->user_status != 4', //can't edit deleted users
                        'url'        => $this->createUrl('lista/editableSaver'),
                        'params' => array("model"=>"ClienteAlarmas"),
                        //'showbuttons' => false,
                        //'inputclass' => 'input-mini',
                        //'placement'  => 'right',
                        'title' => '',
                        'success' => 'js: function(response, newValue) {
                           if(!response.success) return response.msg;
                        }',
                        'options' => array(
                            'ajaxOptions' => array('dataType' => 'json')
                        ), 
                        
                    )
                ),
	       ),
        )
    );
?>
</fieldset>