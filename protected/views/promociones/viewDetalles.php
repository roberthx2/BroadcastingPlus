<?php

$objeto = Yii::app()->Funciones->getColorLabelEstadoPromocionesBCNL($estado);

$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $model,
        'type' => 'striped',
        //'htmlOptions'=>array('class'=>'trOverFlow'),
        //'htmlOptions' => array('class'=>'trOverFlow'),
        'attributes' => array(
            array('name'=>'id_promo', 'label'=>'ID Promo', "visible"=>Yii::app()->user->isAdmin()),
            array('value'=>$cliente, 'label'=>'Cliente', "visible"=>Yii::app()->user->isAdmin()),
            array('name'=>'login', 'label'=>'Usuario', "visible"=>Yii::app()->user->isAdmin()),
            array('name'=>'nombrePromo', 'label'=>'Nombre'),
            array('name'=>'contenido', 'label'=>'Mensaje'),
            array('name'=>'fecha', 'label'=>'Fecha', 'type'=>'date'),
            array('name'=>'hora', 'label'=>'Hora Inicio', 'type'=>'time'),
            array('name'=>'hora_limite', 'label'=>'Hora Limite', 'type'=>'time'),
            array('value'=>$objeto["label"], 'label'=>'Estado'),
            array('value'=>$model->enviados." / ".$model->total, 'label'=>'Enviados/Total'),
        )
    )
);
?>