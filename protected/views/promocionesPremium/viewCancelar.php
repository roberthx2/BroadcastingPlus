<div class="modal-body trOverFlow" id="divModalEliminar" >
<?php

$objeto = Yii::app()->Funciones->getColorLabelEstadoPromocionesBCP($estado);

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