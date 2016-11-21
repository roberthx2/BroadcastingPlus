<fieldset> 
    <legend>Reporte Mensual de SMS</legend>
<?php

$contenido = array();
$active = true;

/*if (Yii::app()->user->getPermisos()->reporte_mensual_sms_bcnl)
{        
    $contenido = array(
            		array('label' => 'BCNL', 'content' => $this->renderPartial('mensualSmsBCNL', false, true), 'active' => $active),
            	);
    $active = false;
}*/

if (Yii::app()->user->getPermisos()->reporte_mensual_sms_bcp)
{
    $modelBCP = new PromocionesPremium('searchMesualSms');
    $modelBCP->unsetAttributes();
    
    if(isset($_GET['PromocionesPremium']))
    {
        //$modelBCP->attributes=$_GET['PromocionesPremium'];
        $modelBCP->id_cliente=$_GET['PromocionesPremium']["id_cliente"];
        $modelBCP->mes=$_GET['PromocionesPremium']["mes"];
        $modelBCP->ano=$_GET['PromocionesPremium']["ano"];
    }

    array_push($contenido, array('label' => 'BCP', 'content' => $this->renderPartial('mensualSmsBCP', array('model'=>$modelBCP), true), 'active' => $active));
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