<div id="page-content-wrapper">
<h1>Notificación</h1>
<br><br>

<?php

$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => $model,
        'type' => 'striped', 
        'attributes' => array(
            array('name' => 'id_usuario_creador', 'label' => 'De'),
            array('name' => 'asunto', 'label' => 'Asunto'),
            array('name' => 'fecha', 'label' => 'Fecha'),
            array('name' => 'hora', 'label' => 'Hora'),
            //'mensaje:html',
        ),
    )
); ?>

<div class="container">
    <div class="container" style="padding: 8px; line-height: 1.42857143; vertical-align: top; border-top: 1px solid #ddd;  font-size: 14px; color: #333;"><center><strong>Mensaje</strong></center></div>
    <div class="container"><?php echo $model->mensaje; ?></div>
</div>

<div class="container">
    <center>
        <?php 
            $this->widget(
                'booster.widgets.TbButton',
                array(
                    'id'=>'botonCrearPrefijo',
                    'buttonType' => 'link',
                    'context' => 'success',
                    'label' => 'Responder',
                    'url' => Yii::app()->controller->createUrl("notificaciones/create"),
                    //'icon' => 'glyphicon glyphicon-plus',
                    //'htmlOptions' => array(),
                )
            ); 
            //echo CHtml::tag('button', array('type'=>'link', 'class'=>'btn btn-success'), '<i class="fa"></i> Responder');
        ?>
    </center>
</div>

</div>