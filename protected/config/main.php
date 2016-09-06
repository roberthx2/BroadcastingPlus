<?php

if(($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '72.14.188.47')){

	//Servidores
	$host_F1 = "200.109.237.18";
	$host_F2 = "200.109.237.18";
	$host_Hostgator = "200.109.237.18";

	//Datos F1
	$user_F1 = 'roberth.riera';
	$pwd_F1 = 'WPjvzyb7na';

	//Datos F2
	$user_F2 = 'roberth.riera';
	$pwd_F2 = 'WPjvzyb7na';

	//Datos insignia_masivo_premium
	$user_F2_mp = 'roberth.riera';
	$pwd_F2_mp = 'WPjvzyb7na';

	//Datos Hostgator
	$user_Hostgator = 'roberth.riera';
	$pwd_Hostgator = 'WPjvzyb7na';
} else
	{
		//Servidores
		$host_F1 = "72.233.82.70";
		$host_F2 = "72.232.85.20";
		$host_Hostgator = "www.insigniamobile.com.ve";

		//Datos F1
		$user_F1 = 'rcma';
		$pwd_F1 = 'rcma';

		//Datos F2
		$user_F2 = 'rcma';
		$pwd_F2 = 'rcma';

		//Datos insignia_masivo_premium
		$user_F2_mp = 'envios_mt';
		$pwd_F2_mp = 'AfnEn1istb';

		//Datos Hostgator
		$user_Hostgator = 'insignia_envios';
		$pwd_Hostgator = 'fkhXOF3UXhIMC2015';
	}

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('booster', dirname(__FILE__).'/../extensions/booster');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Broadcasting Plus',
	'timeZone' => 'America/Caracas',
    'language'=>'es',
    //'theme'=>'blackboot',

	// preloading 'log' component
	'preload'=>array('log', 'booster'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		'booster' => array(
    		'class' => 'booster.components.Booster',
		),

		// uncomment the following to enable URLs in path-format
		
		/*'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),*/

		'urlManager'=>array(
			'urlFormat'=>'path',
			
			'showScriptName'=>false,
			'rules'=>array(
				'' => 'site/index', // normal URL rules
		                   array( // your custom URL handler
			  					'class' => 'application.components.CustomUrlRule',
			  				),       
	  			
			),
		),
		

		// database settings are configured in database.php
		//'db'=>require(dirname(__FILE__).'/database.php'),

		'db'=>array(
			'connectionString' => 'mysql:host='.$host_F2.';dbname=insignia_masivo',
			'emulatePrepare' => true,
			'username' => $user_F2,
			'password' => $pwd_F2,
			'charset' => 'utf8',
		),

		'db_masivo_premium'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host='.$host_F2.';dbname=insignia_masivo_premium',
			'emulatePrepare' => true,
			'username' => $user_F2_mp,
			'password' => $pwd_F2_mp,
			'charset' => 'utf8',
		),

		'db_insignia_alarmas'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host='.$host_Hostgator.';dbname=insignia_alarmas',
			'emulatePrepare' => true,
			'username' => $user_Hostgator,
			'password' => $pwd_Hostgator,
			'charset' => 'utf8',
		),

		'db_sms'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host='.$host_F1.';dbname=sms',
			'emulatePrepare' => true,
			'username' => $user_F1,
			'password' => $pwd_F1,
			'charset' => 'utf8',
		),

		'db_insignia_admin'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host='.$host_F1.';dbname=insignia_admin',
			'emulatePrepare' => true,
			'username' => $user_F1,
			'password' => $pwd_F1,
			'charset' => 'utf8',
		),

		'db_supervision_modems'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host='.$host_F2.';dbname=supervision_modems',
			'emulatePrepare' => true,
			'username' => $user_F2,
			'password' => $pwd_F2,
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
