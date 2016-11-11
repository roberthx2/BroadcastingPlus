<?php

$contenido = array();
$active = true;

if (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_cpei)
{
    $contenido = array(
            		array('label' => 'BCNL', 'content' => 'loading ....', 'active' => $active),
            	);
    $active = false;
}

if (Yii::app()->user->getPermisos()->broadcasting_premium)
{
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
