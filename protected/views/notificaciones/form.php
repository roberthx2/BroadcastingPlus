<?php 
	$this->widget(
        'booster.widgets.TbButton',
        array(
        	'id'=>'agregar',
        	'buttonType' => 'link',
            'context' => 'dafault',
            'label' => 'Agregar Números',
            'icon' => 'glyphicon glyphicon-plus',
            'url' => '#',
            //'url' => Yii::app()->createUrl("lista/agregarNumeros", array("id_lista"=>$model_lista->id_lista)),
            'htmlOptions' => array('class'=>'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        )
    ); 
?>