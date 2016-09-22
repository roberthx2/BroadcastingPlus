<br>
<?php
$this->widget( 'booster.widgets.TbExtendedGridView' , array (
        'type'=>'striped bordered condensed', 
        'responsiveTable' => true,
        'dataProvider' => $model,
        'summaryText'=>'Displaying {start}-{end} of {count} results.', 
        'template'=>"{items}{pager}",  
        'filter'=> $model,
        'columns'=> array('id_promo', 'id_cliente', 'fecha', 'hora', 'loaded_by', 'contenido', 'nombrePromo'),
        //'htmlOptions' => array('class' => 'table-responsive'),
    ));

?>