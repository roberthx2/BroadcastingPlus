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
						if (!Yii::app()->user->isAdmin())
			            {
			                $this->actionEstatusBroadcasting(); //Verificar si el broadcasting est suspendido
			            }

						$log = "Login exitoso del usuario: ".Yii::app()->user->name;
						Yii::app()->Procedimientos->setLog($log);
						$_SESSION["user_pass"] = $model->password;
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
					if (!Yii::app()->user->isAdmin())
		            {
		                $this->actionEstatusBroadcasting(); //Verificar si el broadcasting est suspendido
		            }
			            
					$log = "Login exitoso del usuario: ".Yii::app()->user->name;
					Yii::app()->Procedimientos->setLog($log);
					$_SESSION["user_pass"] = $model->password;
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

	private function actionEstatusBroadcasting()
	{
	    $fecha_actual = date('Y-m-d');
	    $hora_actual = date('H:i:s');
	    $suspender = false;
	    
	    //Periodo
	    $fecha_periodo = $fecha_actual." ".$hora_actual;
	    $sql = "SELECT id_mensaje FROM mensajes_broadcasting WHERE tipo_mensaje = 1 AND '".$fecha_periodo."' BETWEEN concat(fecha_inicio,' ', hora_inicio) AND concat(fecha_fin,' ', hora_fin)";
	    $total_msj = Yii::app()->db->createCommand($sql)->queryRow();

	    if ($total_msj)
	    {
	        $suspender = true;
	    }
	    else //Diario
	    {
	        $sql = "SELECT id_mensaje FROM mensajes_broadcasting WHERE tipo_mensaje = 2 AND '".$hora_actual."' BETWEEN hora_inicio AND hora_fin";
	        $total_msj = Yii::app()->db->createCommand($sql)->queryRow();
	        
	        if ($total_msj)
	        {
	            $suspender = true;
	        }
	        else
	        {
	            //Personalizado
	            $dia_semana = date("w")+1;//Se le suma un dia porque en BD va desde 1 hasta 7 y en PHP va desde 0 hasta 6 (Domingo-Sabado)
	            $sql = "SELECT m.id_mensaje FROM mensajes_broadcasting m
	                    INNER JOIN mensajes_broadcasting_dias d ON m.id_mensaje = d.id_mensaje
	                    WHERE m.tipo_mensaje = 3 AND '".$hora_actual."' BETWEEN hora_inicio AND hora_fin AND d.dia_semana = ".$dia_semana;
	            $total_msj = Yii::app()->db->createCommand($sql)->queryRow();

	            if ($total_msj)
	            {
	                $suspender = true;
	            }
	        }
	    }
	    
	    if ($suspender)
	    {
	        $id_mensaje = $total_msj["id_mensaje"];
	        $url = Yii::app()->createUrl("site/suspender", array("id_mensaje"=>$id_mensaje));
	        $this->redirect($url);
	    }
	}

	public function actionSuspender($id_mensaje)
	{
		$model = MensajesBroadcasting::model()->find($id_mensaje);

		if ($model->fecha_inicio == '0000-00-00')
		{
		    $model->fecha_fin = date('Y-m-d');
		}

		$usuario = Yii::app()->user->name;

		Yii::app()->user->logout();

		$this->render('suspendido', array('model'=>$model, 'usuario'=>$usuario));
	}
}