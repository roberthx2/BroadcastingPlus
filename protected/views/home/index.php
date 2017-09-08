<div id="page-content-wrapper">
<?php if(Yii::app()->user->hasFlash('success')):?>
    <br>
    <div class="container-fluid alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="glyphicon glyphicon-ok"></span> <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php
echo "<h3>Promociones del día</h3>";

$contenido = array();
$active = true;

if (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_cpei)
{
    $modelBCNL = new Promociones('searchHome');
    $modelBCNL->unsetAttributes();
    
    if (Yii::app()->request->isAjaxRequest)
    {
        if(isset($_GET['Promociones']))
        {
            $modelBCNL->buscar = $_GET['Promociones']["buscar"];
            $modelBCNL->pageSize = $_GET['Promociones']["pageSize"];

            $_SESSION["buscarBcnl"] = $_GET['Promociones']["buscar"];
            $_SESSION["pageSizeBcnl"] = $_GET['Promociones']["pageSize"];
        }
        else if($_GET["ajax"] == "detallesBCNLToday")
        {
            $modelBCNL->buscar = $_SESSION["buscarBcnl"];
            $modelBCNL->pageSize = $_SESSION["pageSizeBcnl"];
        }
    }
            
    $contenido = array(
            		array('label' => 'Broadcasting', 'content' => $this->renderPartial('promocionesBCNL', array('model'=>$modelBCNL), true), 'active' => $active),
            	);
    $active = false;
}

if (Yii::app()->user->getPermisos()->broadcasting_premium)
{
    $modelBCP = new PromocionesPremium('searchHome');
    $modelBCP->unsetAttributes();

    if (Yii::app()->request->isAjaxRequest)
    {
        if(isset($_GET['PromocionesPremium']))
        {
            $modelBCP->buscar = $_GET['PromocionesPremium']["buscar"];
            $modelBCP->pageSize = $_GET['PromocionesPremium']["pageSize"];

            $_SESSION["buscarBcp"] = $_GET['PromocionesPremium']["buscar"];
            $_SESSION["pageSizeBcp"] = $_GET['PromocionesPremium']["pageSize"];
        }
        else if($_GET["ajax"] == "detallesBCPToday")
        {
            $modelBCP->buscar = $_SESSION["buscarBcp"];
            $modelBCP->pageSize = $_SESSION["pageSizeBcp"];
        }
    }

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

<!-- Esto aplica solo si viene desde el broadcasting viejo-->
<script type="text/javascript">

function quitarFrame() 
{
    if (self.parent.frames.length != 0)
        self.parent.location='../../../../broadcasting/testVersion/Broadcasting/secure.php';
}

function updateStatus()
{
	$('#detallesBCPToday').yiiGridView('update', {
        data: $(this).serialize()
    });
	
	$('#detallesBCNLToday').yiiGridView('update', {
        data: $(this).serialize()
    });
}

$(document).ready(function() 
{
    var aux = '<?php echo (isset($_SESSION["redireccionar"]) == true) ? $_SESSION["redireccionar"] : 1; ?>';

    if(aux == 0)
        quitarFrame();
	
	setInterval(function() {
		updateNotifations();
	}, 30000);
});
</script>