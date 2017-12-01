
<?php 
$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            array('name'=>'mensaje', 'label'=>'Mensaje'),
            array('name'=>'fecha_inicio', 'label'=>'Fecha Inicio', 'type'=>'date'),
            array('name'=>'fecha_fin', 'label'=>'Fecha Fin', 'type'=>'date'),
            array('name'=>'hora_inicio', 'label'=>'Hora Inicio', 'type'=>'time'),
            array('name'=>'hora_fin', 'label'=>'Hora Fin', 'type'=>'time'),
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
            'url' => Yii::app()->controller->createUrl("deleteMensaje", array("id" => $model->id_mensaje)),
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