<div class="modal-body trOverFlow" id="divModalVer" >
<?php
    echo $this->renderPartial('viewDetalles', array("model"=>$model, 'cliente'=>$cliente, 'estado'=>$estado));
?>
</div>
<div class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'id' => 'boton_ver_bcp',
            'context' => 'success',
            'label' => 'Ver mas...',
            'buttonType' =>'link',
            'icon' => 'glyphicon glyphicon-plus-sign',
            'url' => Yii::app()->controller->createUrl("view", array("id" => $model->id_promo)),
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
        $("#boton_ver_bcp").click(function(){
            $("#boton_ver_bcp i.glyphicon").removeClass("glyphicon glyphicon-plus-sign").addClass("fa fa-spinner fa-spin");
            $("#boton_ver_bcp").addClass("disabled");
        });
    });
</script>