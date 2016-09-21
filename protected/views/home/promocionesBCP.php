<br>
<?php
$this->widget( 'booster.widgets.TbGridView' , array (
        'type'=>'striped bordered condensed', 
        'dataProvider' => $model->search(), 
        'template'=>"{items}",  
        'filter'=> $model,
        'columns'=> array('id_promo', 'id_cliente', 'fecha', 'hora', 'loaded_by', 'contenido', 'nombrePromo'),
        'htmlOptions' => array('class' => 'table-responsive'),
    ));

?>