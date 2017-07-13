
<?php 
$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            array('name'=>'nombre', 'label'=>'Nombre'),
            array('name'=>'correo', 'label'=>'Correo'),
            array('name'=>'numero', 'label'=>'Número'),
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
            'url' => Yii::app()->controller->createUrl("deleteContacto", array("id" => $model->id_contacto)),
            'icon' => 'glyphicon glyphicon-trash',
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
