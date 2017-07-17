<div class="modal-body trOverFlow" id="divModalConfirmar" >
<?php

$objeto = Yii::app()->Funciones->getColorLabelEstadoPromocionesBCP($estado);

$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $model,
        'type' => 'striped',
        //'htmlOptions'=>array('class'=>'trOverFlow'),
        //'htmlOptions' => array('class'=>'trOverFlow'),
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