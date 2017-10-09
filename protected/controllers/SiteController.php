<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if (!Yii::app()->user->isGuest)
		{
			$this->redirect(Yii::app()->createUrl('home/index'));
		}
		else
		{
			$this->redirect(Yii::app()->createUrl('site/login'));	
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionContactosIMC()
	{
		$this->render('contactosIMC',array());
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		$error = false;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				if(isset(Yii::app()->user->getPermisos()->acceso_sistema) && (isset(Yii::app()->user->getPermisos()->broadcasting) || isset(Yii::app()->user->getPermisos()->broadcasting_premium) || isset(Yii::app()->user->getPermisos()->broadcasting_cpei)))
				{
					if(Yii::app()->user->getPermisos()->acceso_sistema == 1 && (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_premium || Yii::app()->user->getPermisos()->broadcasting_cpei))
					{
						$log = "Login exitoso del usuario: ".Yii::app()->user->name;
						Yii::app()->Procedimientos->setLog($log);
						$this->redirect(Yii::app()->createUrl('home/index'));
					}
				}
				
				$log = "Login fallido del usuario: ".Yii::app()->user->name." debido a que no posee acceso al sistema";
				Yii::app()->Procedimientos->setLog($log);

				Yii::app()->user->logout();
				$error = true;
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model, 'error'=>$error));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		//$this->redirect(Yii::app()->homeUrl);
		$this->redirect(Yii::app()->createUrl('site/login'));
	}

	public function actionAutoLogin()
	{
		$model=new LoginForm;
		$error = false;

		session_start();

		$model->username = $_SESSION["bcplus_user"];
		$model->password = $_SESSION["bcplus_pass"];

		// validate user input and redirect to the previous page if valid
		if($model->validate() && $model->login())
		{
			if(isset(Yii::app()->user->getPermisos()->acceso_sistema) && (isset(Yii::app()->user->getPermisos()->broadcasting) || isset(Yii::app()->user->getPermisos()->broadcasting_premium) || isset(Yii::app()->user->getPermisos()->broadcasting_cpei)))
			{
				if(Yii::app()->user->getPermisos()->acceso_sistema == 1 && (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_premium || Yii::app()->user->getPermisos()->broadcasting_cpei))
				{
					$log = "Login exitoso del usuario: ".Yii::app()->user->name;
					Yii::app()->Procedimientos->setLog($log);
					$this->redirect(Yii::app()->createUrl('promocion/create'));
				}
			}
			
			$log = "Login fallido del usuario: ".Yii::app()->user->name." debido a que no posee acceso al sistema";
			Yii::app()->Procedimientos->setLog($log);

			Yii::app()->user->logout();
			$error = true;
		}

		// display the login form
		$this->render('login',array('model'=>$model, 'error'=>$error));
	}
}