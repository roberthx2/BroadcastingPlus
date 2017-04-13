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
            'mensaje:html',
        ),
    )
);
?>

</div>