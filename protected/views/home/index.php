<?php
$aux = PromocionesPremiumController::actionPrueba();

$this->widget(
    'booster.widgets.TbTabs',
    array(
    	'id' => 'mytabs',
        'type' => 'tabs',
        //'justified' => true,
        'tabs' => array(
        	array('id'=>'tabBnl', 'label' => 'Broadcasting', 'content' => 'loading ....', 'active' => true),
        	array('id'=>'tabBcp', 'label' => 'Broadcasting Premium', 'content' => 'loading ....'),
        	//array('label' => 'Broadcasting Premium', 'content' => return PartialView('../promocionesPremium/indexPromociones')),
        ),
        'events'=>array('shown'=>'js:cargarPromociones')
    )
);
?>

<script type="text/javascript">

function cargarPromociones(e){
alert("entre");
    var tabId = e.target.getAttribute("href");

    var ctUrl = ''; 

    if(tabId == '#tabBnl') {
        ctUrl = "<?php echo Yii::app()->createUrl('home/promocionesBNL'); ?>";
    } else if(tabId == '#tabBcp') {
        ctUrl = "<?php echo Yii::app()->createUrl('home/promocionesBCP'); ?>"; 
    }

    if(ctUrl != '') {
        $.ajax({
            url      : ctUrl,
            type     : 'POST',
            dataType : 'html',
            cache    : false,
            success  : function(html)
            {
                jQuery(tabId).html(html);
            },
            error:function(){
                    alert('Request failed');
            }
        });
    }

    preventDefault();
    return false;
}
</script>