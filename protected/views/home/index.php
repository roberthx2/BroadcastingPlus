<div id="page-content-wrapper">
<?php
echo "<h3>Promociones del dia</h3>";

$contenido = array();
$active = true;

if (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_cpei)
{
    $contenido = array(
            		array('label' => 'Broadcasting', 'content' => 'loading ....', 'active' => $active),
            	);
    $active = false;
}

if (Yii::app()->user->getPermisos()->broadcasting_premium)
{
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