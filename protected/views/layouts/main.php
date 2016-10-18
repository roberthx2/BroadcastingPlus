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

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/menuLista.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/simple-sidebar.css">

	<?php  
	 $baseUrl = Yii::app()->baseUrl; 
	  Yii::app()->clientScript->registerCssFile($baseUrl.'/css/estilos.css');  
	 /* Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	  $cs = Yii::app()->getClientScript();
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap-editable.js');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-editable.css');*/
	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<style type="text/css">
	/*@media (max-width: 768px) {
	 	.menu_superior {
		  	float: left;
		}
	}*/

	@media (min-width: 768px) {
		.menu_superior {
		  	float: right;
		}
	}
</style>
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
		                    array('label' => 'Inicio', 'icon'=>'glyphicon glyphicon-home','url' => Yii::app()->createUrl('home/index'), 'visible'=>!Yii::app()->user->isGuest),
		                    array('label' => 'CPEI', 'url' => Yii::app()->createUrl('#'), 'icon'=>'glyphicon glyphicon-tag','visible'=>!Yii::app()->user->isGuest && Yii::app()->user->getAccesos()->broadcasting_lite),
		                    array('label' => 'Broadcasting Premium', 'icon'=>'glyphicon glyphicon-tags','url' => Yii::app()->createUrl('promocionesPremium/create'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->getAccesosBCP()->broadcasting_premium),
		                    array('label'=>'Listas', 'icon'=>'glyphicon glyphicon-list','url'=>Yii::app()->createUrl('lista/admin'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->getAccesosBCP()->listas),
		                    array('label'=>'Exentos', 'icon'=>'glyphicon glyphicon-ban-circle','url'=>Yii::app()->createUrl('#'), 'visible'=>!Yii::app()->user->isGuest),
		                    array('label'=>'Iniciar Sesión', 'url'=>Yii::app()->createUrl('site/login'), 'visible'=>Yii::app()->user->isGuest),
		                    array('label' => 'Contactos', 'icon'=>'glyphicon glyphicon-earphone','url' => Yii::app()->createUrl('site/contactosIMC')),
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
<br><br>
<!--<div class="footer visible-sm visible-md visible-lg" onclick="window.location = 'http://insignia.com.ve/';" style="height: 145px; cursor: pointer; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/footerIzquierda.png')">
</div>-->

</body>
</html>
