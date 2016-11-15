<div id="page-content-wrapper">
<?php
echo "<h3>Promociones del dia</h3>";

$contenido = array();
$active = true;

if (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_cpei)
{
    $modelBCNL = new Promociones('search');
    $modelBCNL->unsetAttributes();
    if(isset($_GET['Promociones']))
        $modelBCNL->buscar = $_GET['Promociones']["buscar"];
            
    $contenido = array(
            		array('label' => 'Broadcasting', 'content' => 'loading ....', 'active' => $active),
            	);
    $active = false;
}

if (Yii::app()->user->getPermisos()->broadcasting_premium)
{
    $modelBCP = new PromocionesPremium('searchHome');
    $modelBCP->unsetAttributes();
    if(isset($_GET['PromocionesPremium']))
        $modelBCP->buscar = $_GET['PromocionesPremium']["buscar"];

    array_push($contenido, array('label' => 'Broadcasting Premium', 'content' => $this->renderPartial('promocionesBCP', array('model'=>$modelBCP), true), 'active' => $active));
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
</div>