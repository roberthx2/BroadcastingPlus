<div class="modal-body trOverFlow" id="divModalEliminar" >
<?php
    echo $this->renderPartial('viewDetalles', array("model"=>$model, 'cliente'=>$cliente, 'estado'=>$estado));
?>
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'id' => 'boton_cancelar_bcp',
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
            'label' => 'Cerrar',
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $("#boton_cancelar_bcp").click(function(){
            $("#boton_cancelar_bcp i.glyphicon").removeClass("glyphicon glyphicon-remove").addClass("fa fa-spinner fa-spin");
            $("#boton_cancelar_bcp").addClass("disabled");
        });
    });
</script>