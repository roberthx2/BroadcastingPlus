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

<body>

<div>
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
	                'htmlOptions' => array('class' => 'pull-right '),
	                'items' =>  array(
		                    array('label' => 'Inicio', 'icon'=>'glyphicon glyphicon-home','url' => Yii::app()->createUrl('site/index'), 'active' => true, 'visible'=>!Yii::app()->user->isGuest),
		                    array('label' => 'CPEI', 'url' => '#', 'icon'=>'glyphicon glyphicon-tag','visible'=>!Yii::app()->user->isGuest),
		                    array('label' => 'Broadcasting Premium', 'icon'=>'glyphicon glyphicon-tags','url' => '#', 'visible'=>!Yii::app()->user->isGuest),
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

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>Yii::app()->createUrl('site/index')),
				array('label'=>'About', 'url'=>Yii::app()->createUrl('site/page')),
				array('label'=>'Contact', 'url'=>Yii::app()->createUrl('site/contact')),
				array('label'=>'Login', 'url'=>Yii::app()->createUrl('site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
