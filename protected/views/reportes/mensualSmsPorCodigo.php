<fieldset> 
    <legend>Reporte Mensual de SMS por Código</legend>
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

if (Yii::app()->user->getPermisos()->reporte_mensual_sms_por_codigo_bcp)
{
    $modelBCP = new PromocionesPremium('searchMensualSmsPorCodigo');
    $modelBCP->unsetAttributes();
    
    if(isset($_GET['PromocionesPremium']))
    {
        $modelBCP->mes=$_GET['PromocionesPremium']["mes"];
        $modelBCP->ano=$_GET['PromocionesPremium']["ano"];
    }

    array_push($contenido, array('label' => 'BCP', 'content' => $this->renderPartial('mensualSmsPorCodigoBCP', array('model'=>$modelBCP), true), 'active' => $active));
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