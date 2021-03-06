<fieldset>
 
    <legend>Detalles de las Promociones</legend>
<?php

$contenido = array();
$active = true;

if (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_cpei)
{
    $modelBCNL = new Promociones('searchVerDetalles');
    $modelBCNL->unsetAttributes();
    if(isset($_GET['Promociones']))
        $modelBCNL->buscar = $_GET['Promociones']["buscar"];
            
    $contenido = array(
            		array('label' => 'BCNL', 'content' => $this->renderPartial('verDetallesBCNL', array('model'=>$modelBCNL), true), 'active' => $active),
            	);
    $active = false;
}

if (Yii::app()->user->getPermisos()->broadcasting_premium)
{
    $modelBCP = new PromocionesPremium('searchVerDetalles');
    $modelBCP->unsetAttributes();
    if(isset($_GET['PromocionesPremium']))
        $modelBCP->buscar = $_GET['PromocionesPremium']["buscar"];

    array_push($contenido, array('label' => 'BCP', 'content' => $this->renderPartial('verDetallesBCP', array('model'=>$modelBCP), true), 'active' => $active));
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

<script type="text/javascript">
    $(document).ready(function(){
        $(".paginacion").hide();
    });
</script>