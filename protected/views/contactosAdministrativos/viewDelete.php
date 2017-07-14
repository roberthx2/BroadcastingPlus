
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
            'id' => 'boton_eliminar',
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

<script type="text/javascript">
    $(document).ready(function()
    {
        $("#boton_eliminar").click(function(){
            $("#boton_eliminar i.glyphicon").removeClass("glyphicon glyphicon-trash").addClass("fa fa-spinner fa-spin");
            $("#boton_eliminar").addClass("disabled");
        });
    });
</script>