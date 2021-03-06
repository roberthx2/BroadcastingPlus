<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html>
<head>
	<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
	<meta name="language" content="en">
	<meta content="<?php echo Yii::app()->request->baseUrl; ?>/img/icon.png" itemprop="image">

	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">-->

	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/menuLista.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/simple-sidebar.css">

	<?php  
	 $baseUrl = Yii::app()->baseUrl; 
	  Yii::app()->clientScript->registerCssFile($baseUrl.'/css/estilos.css'); 
	  Yii::app()->clientScript->registerCssFile($baseUrl.'/plugins/font-awesome-4.7.0/css/font-awesome.min.css');
	  Yii::app()->clientScript->registerCssFile($baseUrl.'/plugins/summernote/summernote.css');  
	  Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/funciones.js');
	  Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/bootstrap-notify/bootstrap-notify.min.js');
	  Yii::app()->clientScript->registerScriptFile($baseUrl.'/plugins/summernote/summernote.min.js');/*
	  $cs = Yii::app()->getClientScript();
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap-editable.js');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-editable.css');*/
	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="loader_superior"><div class="loader" style="display: block;"></div></div>
<?php
	$color = "";
	$label = "";
	$total = Notificaciones::model()->count("fecha BETWEEN :fecha_ini AND :fecha_fin AND id_usuario =:id_usuario AND estado = 0", array(":id_usuario"=>Yii::app()->user->id, ":fecha_ini"=>date('Y-m-d' , strtotime('-1 month', strtotime(date("Y-m-d")))), ":fecha_fin"=>date("Y-m-d")));
	
	if ($total > 0)
	{
		$color = "info";
		$label = $total;
	}

	$badge=$this->widget('booster.widgets.TbBadge', array(
        'context' => $color,
        // 'default', 'success', 'info', 'warning', 'danger'
        'label' => $label,
    ), true);

    $permisos = Yii::app()->user->getPermisos();

    if ($_SERVER['SERVER_NAME'] != 'broadcasting.insignia.web.ve')
    {
    	$old_version = "https://".$_SERVER['SERVER_NAME']."/broadcasting/2.2_ORIGINAL/ingresar.php?login_bcplus=".Yii::app()->user->name."&pwd_bcplus=".(isset($_SESSION["user_pass"]) ? $_SESSION["user_pass"] : '');
    }
    else
    {
    	$old_version = "https://insigniamobile.web.ve/broadcasting/2.2_ORIGINAL/ingresar.php?login_bcplus=".Yii::app()->user->name."&pwd_bcplus=".(isset($_SESSION["user_pass"]) ? $_SESSION["user_pass"] : '');
    }
?>

<div class="container-fluid">
		<?php		
		$this->widget(
	    'booster.widgets.TbNavbar',
	    array(
	        'type' => 'inverse',
	        'brand' => Yii::app()->name.' <span class="none" aria-hidden="true"></span> ',//.CHtml::image(Yii::app()->getBaseUrl().'/images/logoInsig3.png'),
	        'brandUrl' => '#',
	        'brandOptions' => array("class"=>"boton_menu"),
	        'collapse' => true, // requires bootstrap-responsive.css
	        'fixed' => 'top',
	        'fluid' => true,
	        'items' => array(
	            array(
	                'class' => 'booster.widgets.TbMenu',
	                'type'  => 'navbar',
	                'htmlOptions' => array('class' => 'menu_superior'),
	                'items' =>  array(
		                    array('label' => 'Inicio', 'icon'=>'glyphicon glyphicon-home','url' => Yii::app()->createUrl('home/index'), 'visible'=>!Yii::app()->user->isGuest, 'itemOptions'=>array('id'=>'boton_home')),
		                    array('label' => 'Aplicación', 'icon'=>'glyphicon glyphicon-phone','url' => Yii::app()->createUrl('promocion/create'), 'visible'=>!Yii::app()->user->isGuest && $permisos && ($permisos->broadcasting || $permisos->broadcasting_premium || $permisos->broadcasting_cpei)),
		                    array('label'=>'Administración', 'icon'=>'glyphicon glyphicon-cog','url'=>Yii::app()->createUrl('ConfiguracionSistemaAcciones/admin'), 'visible'=>!Yii::app()->user->isGuest && $permisos && $permisos->modulo_administracion),
		                    array('label'=>'Notificaciones '.$badge, 'encodeLabel'=> false, 'icon'=>'glyphicon glyphicon-bell', 'url'=>Yii::app()->createUrl('/notificaciones/index'), 'visible'=>!Yii::app()->user->isGuest),
		                    array('label'=>'Versión Anterior', 'icon'=>'glyphicon glyphicon-cog', 'url'=>$old_version, 'linkOptions'=>array('target'=> '_blank'), 'visible'=>!Yii::app()->user->isGuest && $permisos && $permisos->modulo_administracion),
		                    array('label' => 'Contactos', 'icon'=>'glyphicon glyphicon-earphone','url' => Yii::app()->createUrl('site/contactosIMC')),
		                    array('label'=>'Iniciar Sesión', 'url'=>Yii::app()->createUrl('site/login'), 'visible'=>Yii::app()->user->isGuest),
		                    array(
		                        'label' => Yii::app()->user->name,
		                        'url' => '#',
		                        'icon' => 'glyphicon glyphicon-user',
		                        'visible'=>!Yii::app()->user->isGuest,
		                        'items' => array(
		                            array('label'=>'Cerrar Sesión', 'icon'=>'glyphicon glyphicon-off', 'url'=>Yii::app()->createUrl('/site/logout'))
		                   	 	),
		                	),
	    				),
	        		),
	    		)
	        )
		);
	?>
</div>
<div class="container-fluid contenedor_principal">
	<?php echo $content; ?>
	<div class="clear"></div>
</div>
<!--<div class="footer img-responsive" style="background-image: url('<?php //echo Yii::app()->request->baseUrl; ?>/img/footer.jpg')"></div>-->
<!--<div style="position:fixed; right:0; left:0; z-index:1030; bottom:0; margin-bottom: 0; border-width:1px 0 0; border-radius: 0;">
	<img class="img-responsive" src="<?php //echo Yii::app()->request->baseUrl; ?>/img/footer.jpg">
</div>-->

<!--<div id="footer" class=" visible-sm visible-md visible-lg" onclick="window.location = 'http://insignia.com.ve/';" style="cursor: pointer; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/img/footer-lg.png'); background-repeat: no-repeat">
</div>-->

<br><br>
<div class="hidden-xs" id="footer_new">
   <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/logo_imc_red.png" width="150px" height="40px">
   <br><strong>Copyright &copy; <?php echo date('Y'); ?> by <a href="http://insignia.com.ve/">Insignia Mobile Communications C.A.</strong></a>.<br/>
   <strong>All Rights Reserved.</strong><br/>
</div><!-- footer -->

</body>
</html>

<style type="text/css">
	#eedfooter {
	width: 100%;
	height: 10%;
	background: #333;
	border-top: 0px solid #000;
	position: absolute;
	bottom: 0;
}

/* Sticky footer styles
-------------------------------------------------- */
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  padding-top: 0%;/*50px;*/
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 7%;
  text-align: center;
  color: white;
  /*background: url("<?php echo Yii::app()->request->baseUrl; ?>/img/footer.jpg");*/
  background-repeat: no-repeat;
  /* background-color: #3F3E3E; */
}

#footer_new
{
    position:fixed;
    right:0;
    left:0;
    z-index:1030;
    bottom:0;
    margin: 0px 0px;
    font-size: 0.8em;
    text-align: center;
    border-top: 1px solid grey;
    background: white;
}


/*************************************************/

</style>

<script type="text/javascript">
	$(document).ready(function() 
	{
		$(".loader_superior").css("display", "none");

		$(".menu_superior a").click(function(){
			if ($(this).attr("class") != "dropdown-toggle")
	        	$(".loader_superior").css("display", "block");
	    });

	    var controlador = "<?php echo Yii::app()->controller->id; ?>";

	    if (controlador == "home")
	    {
	    	$("#boton_home").find(".glyphicon-home").removeClass("glyphicon glyphicon-home").addClass("glyphicon glyphicon-refresh");

	    	$("#boton_home").html(function(buscayreemplaza, reemplaza) {
		        return reemplaza.replace('Inicio', 'Actualizar');
		    });
	    }
	    else
	    {
	    	$("#boton_home").find(".glyphicon-refresh").removeClass("glyphicon glyphicon-refresh").addClass("glyphicon glyphicon-home");

	    	$("#boton_home").html(function(buscayreemplaza, reemplaza) {
		        return reemplaza.replace('Actualizar', 'Inicio');
		    });
	    }

	    if (controlador == "site" || controlador == "home" || controlador == "notificaciones")
	    {
	    	$(".boton_menu").find(".glyphicon-transfer").removeClass("glyphicon glyphicon-transfer").addClass("none");
	    }
	    else
	    {
	    	$(".boton_menu").find(".none").removeClass("none").addClass("glyphicon glyphicon-transfer");
	    }

		setInterval(function() {
			updateNotifations();
		}, 300000);
	});

	function updateNotifations()
	{
	    $.ajax({
	        url: "<?php echo Yii::app()->createUrl('/notificaciones/getNotificaciones'); ?>",
	        type: "POST",
	        dataType: 'json',    
	        data:{},
	        
	        complete: function()
	        {
	            
	        },

	        success: function(response)
	        {
	            if (response.error == "false")
	            {
	                var notificaciones = response.data;

	                $.each(notificaciones, function(i, value) {
	                	
	                	var url = "";

	                	$.ajax({
					        url: "<?php echo Yii::app()->createUrl('/notificaciones/convertirValor'); ?>",
					        type: "POST",
					        dataType: 'json',  
					        async : false,  
					        data:{id_notificacion:value.id_notificacion},

					        success: function(response)
					        {
					        	url = response.valor;
					        }
					    });

	                    $.notify({
	                        // options
	                        icon: 'glyphicon glyphicon-bell',
	                        title: value.asunto+"<br>",
	                        message: value.mensaje.replace("<br>","").substring(0, 20)+"...",
	                        url: url,
	                        target: '_self'
	                    },{
	                        // settings
	                        element: 'body',
	                        position: null,
	                        type: "success",
	                        allow_dismiss: true,
	                        newest_on_top: false,
	                        showProgressbar: false,
	                        placement: {
	                            from: "top",
	                            align: "right"
	                        },
	                        offset: 20,
	                        spacing: 10,
	                        z_index: 1031,
	                        delay: 15000,
	                        timer: 2000,
	                        url_target: '_blank',
	                        mouse_over: null,
	                        animate: {
	                            enter: 'animated fadeInDown',
	                            exit: 'animated fadeOutUp'
	                        },
	                        onShow: null,
	                        onShown: null,
	                        onClose: null,
	                        onClosed: null,
	                        icon_type: 'class',
	                        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
	                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>' +
	                            '<span data-notify="icon"></span> ' +
	                            '<span data-notify="title">{1}</span> ' +
	                            '<span data-notify="message">{2}</span>' +
	                            '<div class="progress" data-notify="progressbar">' +
	                                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
	                            '</div>' +
	                            '<a href="{3}" target="{4}" data-notify="url"></a>' +
	                        '</div>' 
	                    });
	                });
	            }
	        },
	        error: function()
	        {
	            //alert("Ocurrio un error al cargar los short codes del cliente");
	        }
	    });
	}
</script>