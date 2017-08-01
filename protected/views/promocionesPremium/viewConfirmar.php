<div class="modal-body trOverFlow" id="divModalConfirmar" >
<?php
    echo $this->renderPartial('viewDetalles', array("model"=>$model, 'cliente'=>$cliente, 'estado'=>$estado));
?>
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'id' => 'boton_confirmar_bcp',
            'context' => 'success',
            'label' => 'Confirmar',
            'buttonType' =>'link',
            'icon' => 'glyphicon glyphicon-ok',
            'url' => Yii::app()->controller->createUrl("confirmarPromo", array("id_promo" => $model->id_promo)),
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
        $("#boton_confirmar_bcp").click(function(){
            $("#boton_confirmar_bcp i.glyphicon").removeClass("glyphicon glyphicon-ok").addClass("fa fa-spinner fa-spin");
            $("#boton_confirmar_bcp").addClass("disabled");
        });
    });
</script>