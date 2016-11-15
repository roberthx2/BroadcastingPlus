<div class="modal-body trOverFlow" id="divModalEliminar" >
<?php

$objeto = Yii::app()->Funciones->getColorLabelEstadoPromociones($estado);

$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $model,
        'type' => 'striped',
        'attributes' => array(
            array('name'=>'id_promo', 'label'=>'ID Promo', "visible"=>Yii::app()->user->isAdmin()),
            array('name'=>'login', 'label'=>'Usuario', "visible"=>Yii::app()->user->isAdmin()),
            array('value'=>str_replace("@", "", $cliente), 'label'=>'Cliente', "visible"=>Yii::app()->user->isAdmin()),
            array('name'=>'nombrePromo', 'label'=>'Nombre'),
            array('name'=>'hora', 'label'=>'Hora Inicio', 'type'=>'time'),
            array('name'=>'hora_limite', 'label'=>'Hora Limite', 'type'=>'time'),
            array('value'=>$objeto["label"], 'label'=>'Estado'),
            array('value'=>$model->enviados." / ".$model->total, 'label'=>'Enviados/Total'),
        )
    )
);
?>
</div>
<br>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'context' => 'danger',
            'label' => 'Cancelar',
            'buttonType' =>'link',
            'icon' => 'glyphicon glyphicon-remove',
            'url' => Yii::app()->controller->createUrl("cancelarPromo", array("id_promo" => $model->id_promo)),
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
