<div id="page-content-wrapper">
<?php if(Yii::app()->user->hasFlash('success')):?>
    <br>
    <div class="container-fluid alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="glyphicon glyphicon-ok"></span> <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php
echo "<h3>Promociones del dia</h3>";

$contenido = array();
$active = true;

if (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_cpei)
{
    $modelBCNL = new Promociones('searchHome');
    $modelBCNL->unsetAttributes();
    if(isset($_GET['Promociones']))
        $modelBCNL->buscar = $_GET['Promociones']["buscar"];
            
    $contenido = array(
            		array('label' => 'Broadcasting', 'content' => $this->renderPartial('promocionesBCNL', array('model'=>$modelBCNL), true), 'active' => $active),
            	);
    $active = false;
}

if (Yii::app()->user->getPermisos()->broadcasting_premium)
{
    /*if ( isset( $_GET[ 'pageSize' ] ) )
    {
        //Yii::app()->user->setState( 'pageSize', (int) $_GET[ 'pageSize' ] );
        $_SESSION["pageSize"] = (int) $_GET[ 'pageSize' ];
        unset( $_GET[ 'pageSize' ] );
    }*/

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

<!-- Esto aplica solo si viene desde el broadcasting viejo-->
<script type="text/javascript">

function quitarFrame() 
{
    if (self.parent.frames.length != 0)
        self.parent.location='../../../../broadcasting/testVersion/Broadcasting/secure.php';
}

$(document).ready(function() 
{
    var aux = '<?php echo (isset($_SESSION["redireccionar"]) == true) ? $_SESSION["redireccionar"] : 1; ?>';

    if(aux == 0)
        quitarFrame();
});
</script>