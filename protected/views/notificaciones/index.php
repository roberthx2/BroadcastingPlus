<?php
/* @var $this ListaController */
/* @var $model Lista */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#notificaciones-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="page-content-wrapper">
<h1>Notificaciones</h1>
<br><br>

<div class="clearfix visible-xs-block"></div>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs ">
    <?php $this->renderPartial('_search',array('model'=>$model, 'id_usuario'=>$id_usuario)); ?>
</div><!-- search-form -->

<?php 
	$this->widget(
        'booster.widgets.TbButton',
        array(
        	'id'=>'agregar',
        	'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Crear Notificación',
            'icon' => 'glyphicon glyphicon-envelope',
            'url' => '#',
            'url' => Yii::app()->createUrl("notificaciones/create"),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        )
    ); 
?>

<div class="search-form col-xs-12 col-sm-6 col-md-6 col-lg-6 visible-xs ">
    <?php $this->renderPartial('_search',array('model'=>$model, 'id_usuario'=>$id_usuario)); ?>
</div><!-- search-form -->

<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'id'=>'notificaciones-grid',
        'type'=>'striped bordered', 
        'responsiveTable' => true,
        'dataProvider' => $model->search_usuario($id_usuario),
        'summaryText'=>'Mostrando {start} a {end} de {count} registros', 
        //'template'=>"{items}\n{pager}",
        'template' => '{items}<div class="form-group"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
        'htmlOptions' => array('class' => 'trOverFlow col-xs-12 col-sm-12 col-md-12 col-lg-12'),
       // 'filter'=> $model_procesamiento,
        'columns'=> array( 
        	array(
	            'name' => 'id_usuario_creador',
	            'value'=> function($data)
	            {
	            	if (!Yii::app()->user->isAdmin())
                		return ($data["id_usuario_creador"] == 0) ? "SISTEMA":"EQUIPO TECNICO";
	            	else
	            	{
	            		if ($data["id_usuario_creador"] == 0)
	            			return 'SISTEMA';
	            		else
	            		{
			            	$cliteria = new CDbCriteria;
			            	$cliteria->select = "login";
			            	$cliteria->compare("id_usuario", $data["id_usuario_creador"]);
			          		$usuario = UsuarioSms::model()->find($cliteria);

			            	return $usuario->login;
			            }
		            }
	            },
	            'header' => 'De',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            //'name' => "asunto",
	            'header' => 'Asunto',
	            'type' => 'raw',
	            'value' => function($data)
	            {
	            	$nuevo = "";

	            	if ($data["estado"] == 0)
	            	{
	            		$nuevo=$this->widget('booster.widgets.TbBadge', array(
					        'context' => 'success',
					        // 'default', 'success', 'info', 'warning', 'danger'
					        'label' => 'Nuevo',
					    ), true);
	            	}

	            	$url = Yii::app()->createUrl('notificaciones/view', array("id_notificacion"=>$data["id_notificacion"]));
	            	$var = '<a href="'.$url.'">'.$data["asunto"].'</a>'." ".$nuevo;
	            	return $var;
	            },
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'fecha',
	            'header' => 'Fecha',
	            'type' => 'raw',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        	array(
	            'name' => 'hora',
	            'header' => 'Hora',
	            'type' => 'time',
	            'htmlOptions' => array('style' => 'text-align: center;'),
	            'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
        	),
        ),
    ));
?>
<div>