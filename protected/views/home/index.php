<div id="page-content-wrapper">
<?php
echo "<h3>Promociones del dia</h3>";

$contenido = array(
        		array('label' => 'Broadcasting', 'content' => 'loading ....', 'active' => true),
        	);

if (Yii::app()->user->getAccesosBCP()->broadcasting_premium)
    array_push($contenido, array('label' => 'Broadcasting Premium', 'content' => $this->renderPartial('promocionesBCP', array('model'=>$modelBCP), true)));

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