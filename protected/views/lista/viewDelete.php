
<?php 
$this->widget(
    'booster.widgets.TbDetailView',
    array(
        //'id' => 'region-details',
        'data' => $model,
        //'url' => $endpoint,
        'attributes' => array(
            array('name'=>'login', 'label'=>'Usuario', "visible"=>Yii::app()->user->isAdmin()),
            array('name'=>'nombre', 'label'=>'Nombre'),
            array('name'=>'total', 'label'=>'Cantidad de destinatarios'),
        )
    )
);
?>
<br>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'context' => 'danger',
            'label' => 'Confirmar',
            'buttonType' =>'link',
            'url' => Yii::app()->controller->createUrl("deleteLista", array("id" => $model->id_lista)),
            'icon' => 'glyphicon glyphicon-trash',
            //'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Cerrar',
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
