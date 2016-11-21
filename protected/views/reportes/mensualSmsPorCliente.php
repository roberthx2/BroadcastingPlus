<fieldset> 
    <legend>Reporte Mensual de SMS por Cliente</legend>
<?php

$contenido = array();
$active = true;

/*if (Yii::app()->user->getPermisos()->reporte_mensual_sms_por_cliente_bcnl)
{        
    $contenido = array(
            		array('label' => 'BCNL', 'content' => $this->renderPartial('mensualSmsBCNL', false, true), 'active' => $active),
            	);
    $active = false;
}*/

if (Yii::app()->user->getPermisos()->reporte_mensual_sms_por_cliente_bcp)
{
    $modelBCP = new OutgoingPremium('searchMesualSms');
    $modelBCP->unsetAttributes();
    
    if(isset($_GET['OutgoingPremium']))
    {
        $modelBCP->mes=$_GET['OutgoingPremium']["mes"];
        $modelBCP->ano=$_GET['OutgoingPremium']["ano"];
    }

    array_push($contenido, array('label' => 'BCP', 'content' => $this->renderPartial('mensualSmsPorClienteBCP', array('model'=>$modelBCP), true), 'active' => $active));
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