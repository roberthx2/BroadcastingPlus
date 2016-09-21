<?php
$aux = HomeController::actionIndex();

$this->widget(
    'booster.widgets.TbTabs',
    array(
        'type' => 'tabs',
        //'justified' => true,
        'tabs' => array(
        	array('label' => 'Broadcasting', 'content' => 'Home Content', 'active' => true),
        	array('label' => 'Broadcasting Premium', 'content' => Yii::app()->createUrl('promocionesPremium/indexPromociones')),
        	array('label' => 'Broadcasting Premium', 'content' => $aux),
        	//array('label' => 'Broadcasting Premium', 'content' => return PartialView('../promocionesPremium/indexPromociones')),
        ),
    )
);

?>