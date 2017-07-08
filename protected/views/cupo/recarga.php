<fieldset>
 
    <legend>Recarga de Cupo</legend>
<?php

$contenido = array();
$active = true;

/*if (Yii::app()->user->getPermisos()->historico_cupo_bcnl)
{
    $modelBCNL = new Promociones('searchVerDetalles');
    $modelBCNL->unsetAttributes();
    if(isset($_GET['Promociones']))
        $modelBCNL->buscar = $_GET['Promociones']["buscar"];
            
    $contenido = array(
            		array('label' => 'BCNL', 'content' => $this->renderPartial('verDetallesBCNL', array('model'=>$modelBCNL), true), 'active' => $active),
            	);
    $active = false;
}*/

if (Yii::app()->user->getPermisos()->historico_cupo_bcp)
{
    $modelBCP = new RecargaCupoBcpForm;

    array_push($contenido, array('label' => 'BCP', 'content' => $this->renderPartial('recargaBcp', array('model'=>$modelBCP), true), 'active' => $active));
}

$this->widget(
    'booster.widgets.TbTabs',
    array(
    	'id' => 'mytabs',
        'type' => 'tabs',
        //'justified' => true,
        'tabs' => $contenido
    )
);
?>
</fieldset>