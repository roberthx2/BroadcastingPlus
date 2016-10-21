<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

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
	  Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/funciones.js');/*
	  $cs = Yii::app()->getClientScript();
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap-editable.js');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-editable.css');*/
	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container-fluid">
	<?php
		$this->widget(
	    'booster.widgets.TbNavbar',
	    array(
	        'type' => 'inverse',
	        'brand' => Yii::app()->name.' <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> ',//.CHtml::image(Yii::app()->getBaseUrl().'/images/logoInsig3.png'),
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
		                    array('label' => 'Home', 'icon'=>'glyphicon glyphicon-home','url' => Yii::app()->createUrl('home/index'), 'visible'=>!Yii::app()->user->isGuest),
		                    array('label' => 'Aplicación', 'icon'=>'glyphicon glyphicon-phone','url' => Yii::app()->createUrl('app/index'), 'visible'=>!Yii::app()->user->isGuest && (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_premium || Yii::app()->user->getPermisos()->broadcasting_cpei)),
		                    array('label'=>'Administración', 'icon'=>'glyphicon glyphicon-cog','url'=>Yii::app()->createUrl('#'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->getPermisos()->modulo_administracion),
		                    array('label' => 'Contactos', 'icon'=>'glyphicon glyphicon-earphone','url' => Yii::app()->createUrl('site/contactosIMC')),
		                    array('label'=>'Iniciar Sesión', 'url'=>Yii::app()->createUrl('site/login'), 'visible'=>Yii::app()->user->isGuest),
		                    array(
		                        'label' => Yii::app()->user->name,
		                        'url' => '#',
		                        'icon' => 'glyphicon glyphicon-user',
		                        'visible'=>!Yii::app()->user->isGuest,
		                        'items' => array(
		                            array(
		                            	'label'=>'Cerrar Sesión',
		                            	'icon'=>'glyphicon glyphicon-off', 
		                            	'url'=>Yii::app()->createUrl('/site/logout'), 
		                        	)
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
<!--<div class="footer"></div>
<br><br>-->
<!--<div id="footer" class=" visible-sm visible-md visible-lg" onclick="window.location = 'http://insignia.com.ve/';" style="cursor: pointer; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/img/footer-lg.png'); background-repeat: no-repeat">
</div>-->


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
  padding-top: 10px;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 10%;
  text-align: center;
  color: white;
  background: url("<?php echo Yii::app()->request->baseUrl; ?>/img/footer-lg.png");
  /* background-color: #3F3E3E; */
}

/*************************************************/

</style>