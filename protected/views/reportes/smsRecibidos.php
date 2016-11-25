<fieldset> 
    <legend>Reporte SMS Recibidos</legend>
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

if (Yii::app()->user->getPermisos()->reporte_sms_recibidos_bcp)
{
    $modelBCP = new Smsin('searchMensualSmsPorCodigo');
    $modelBCP->unsetAttributes();
    
    if(isset($_GET['Smsin']))
    {
        $modelBCP->mes=$_GET['Smsin']["mes"];
        $modelBCP->id_cliente=$_GET['Smsin']["id_cliente"];
        $modelBCP->id_promo=$_GET['Smsin']["id_promo"];
    }

    array_push($contenido, array('label' => 'BCP', 'content' => $this->renderPartial('SmsRecibidosBCP', array('model'=>$modelBCP), true), 'active' => $active));
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