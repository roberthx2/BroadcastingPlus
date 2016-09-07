<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<style type="text/css">
	@media (max-width: 768px) {
	 	.alinear {
		  	float: left;
		}
	}

	@media (min-width: 768px) {
		.alinear {
		  	float: right;
		}
	}
</style>
<body>

<div class="container-fluid">
	<?php
		$this->widget(
	    'booster.widgets.TbNavbar',
	    array(
	        'type' => 'inverse',
	        'brand' => Yii::app()->name,//.CHtml::image(Yii::app()->getBaseUrl().'/images/logoInsig3.png'),
	        'brandUrl' => '#',
	        'collapse' => true, // requires bootstrap-responsive.css
	        'fixed' => 'top',
	        'fluid' => true,
	        'items' => array(
	            array(
	                'class' => 'booster.widgets.TbMenu',
	                'type'  => 'navbar',
	                'htmlOptions' => array('class' => 'alinear'),
	                'items' =>  array(
		                    array('label' => 'Inicio', 'icon'=>'glyphicon glyphicon-home','url' => Yii::app()->createUrl('site/index'), 'active' => true, 'visible'=>!Yii::app()->user->isGuest),
		                    array('label' => 'CPEI', 'url' => '#', 'icon'=>'glyphicon glyphicon-tag','visible'=>!Yii::app()->user->isGuest),
		                    array('label' => 'Broadcasting Premium', 'icon'=>'glyphicon glyphicon-tags','url' => '#', 'visible'=>!Yii::app()->user->isGuest),
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

<div class="container-fluid well">
<div class="clear"></div>
	<?php echo $content; ?>

	
</div>
<div class="footer">
	  <div class="container-fluid">
		<div class="row">
			<center>Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?></center>
		</div> <!-- /row -->
	  </div> <!-- /container -->
	</div>

</body>
</html>
