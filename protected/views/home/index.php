<?php

$this->widget(
    'booster.widgets.TbTabs',
    array(
    	'id' => 'mytabs',
        'type' => 'tabs',
        //'justified' => true,
        'tabs' => array(
        	array('label' => 'Broadcasting', 'content' => 'loading ....', 'active' => true),
        	array('label' => 'Broadcasting Premium', 'content' => $this->renderPartial('promocionesBCP', array('model'=>$model), true)),
        ),
    )
);
?>