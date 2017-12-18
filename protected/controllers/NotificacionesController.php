<?php

class NotificacionesController extends Controller
{
	public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

	public function accessRules() {

        return (array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'getNotificaciones', 'convertirValor'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    public function actionIndex()
    {
    	$model=new Notificaciones('search_usuario');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Notificaciones']))
			$model->buscar = $_GET['Notificaciones']["buscar"];
			//$model->attributes=$_GET['Lista'];
		
		$id_usuario = Yii::app()->user->id;

		$this->render('index',array('model'=>$model, 'id_usuario'=>$id_usuario));
    }

    public function actionView()
    {
    	if (isset($_GET["id_notificacion"]))
    	{
    		$id_notificacion = $_GET["id_notificacion"];
    		$model = Notificaciones::model()->findByPk($id_notificacion);
    		$model->estado = 1;
    		$model->save();

            if (!Yii::app()->user->isAdmin())
                $model->id_usuario_creador = ($model->id_usuario_creador == 0) ? "SISTEMA":"EQUIPO TECNICO";
            else 
            {
                $sql = "SELECT login FROM usuario WHERE id_usuario = ".$model->id_usuario_creador;
                $sql = Yii::app()->db->createCommand($sql)->queryRow();

                $model->id_usuario_creador = ($model->id_usuario_creador == 0) ? "SISTEMA":$sql["login"];
            }

    		$this->render('view', array('model'=>$model));	
    	}
    	else
    	{
    		$this->redirect(array("index"));
    	}
    	
    }

    public function actionConvertirValor()
    {
        echo CJSON::encode(array(
            'valor' => Yii::app()->createUrl("notificaciones/view", array("id_notificacion"=>Yii::app()->request->getParam('id_notificacion')))
        ));
        Yii::app()->end();
    }

    public function actionCreate()
    {
        $model = new Notificaciones;

        if(isset($_POST['Notificaciones']))
        {
            $model->attributes=$_POST['Notificaciones'];
            
            if ($model->validate())
            {
                $transaction = Yii::app()->db_masivo_premium->beginTransaction();

                try
                {
                    if ($model->id_usuario == "")
                    {
                        $criteria = new CDbCriteria;
                        $criteria->select = "GROUP_CONCAT(id_usuario) AS id_usuario";
                        $criteria->compare("acceso_sistema", 1);

                        // Si el usuario es un asociado busca todos los usuarios administrativos
                        if (!Yii::app()->user->isAdmin())
                        {
                            $criteria2 = new CDbCriteria;
                            $criteria2->select = "GROUP_CONCAT(id_usuario) AS id_usuario";
                            $criteria2->addInCondition("id_perfil", array(1,2));
                            $usuarios = UsuarioSms::model()->find($criteria2);
                            $usuarios = ($usuarios["id_usuario"] == "") ? "null":$usuarios["id_usuario"];

                            $criteria->addInCondition("id_usuario", explode(",", $usuarios));

                            $asunto = "ASISTENCIA TECNICA";
                        }
                        else
                        {
                            $asunto = "NOTIFICACION";
                        }

                        $usuarios = Permisos::model()->find($criteria);
                        $usuarios = ($usuarios["id_usuario"] == "") ? "null":$usuarios["id_usuario"];                            

                        $ids_usuarios = explode(",", $usuarios);
                    }
                    else
                    {
                        $asunto = "NOTIFICACION";
                        $ids_usuarios[] = $model->id_usuario;
                    }

                    foreach ($ids_usuarios as $value)
                    {
                        Yii::app()->Procedimientos->setNotificacion($value, Yii::app()->user->id, $asunto, $model->mensaje);
                    }

                    $this->actionEnviarCorreo($model->mensaje);

                    $model = new Notificaciones;
                    
                    $transaction->commit();

                    $sms = "Notificación enviada correctamente";
                    Yii::app()->user->setFlash("success", $sms);

                } catch (Exception $e)
                    {
                        $sms = "Ocurrio un error al enviar la notificación, intente nuevamente.";
                        Yii::app()->user->setFlash("danger", $sms);
                        $transaction->rollBack();
                    }
            }
        }   
        $this->render("form", array("model"=>$model));
    }

    public function actionGetNotificaciones()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $model = Notificaciones::model()->findAll("fecha BETWEEN :fecha_ini AND :fecha_fin AND id_usuario =:id_usuario AND estado = 0", array(":fecha_ini"=>date('Y-m-d' , strtotime('-1 month', strtotime(date("Y-m-d")))), ":fecha_fin"=>date("Y-m-d"), ":id_usuario"=>Yii::app()->user->id));

            if ($model)
            {
                echo CJSON::encode(array(
                    'error' => 'false',
                    'data' => $model,
                ));
                Yii::app()->end();
            }
            else
            {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'No posee cliente asociado'
                ));
                Yii::app()->end();
            }
        }
    }

    public function actionEnviarCorreo($mensaje)
    {
        $model_user = Yii::app()->user->modelSMS();

        if ($model_user->email_u != "")
        {
            $model_contactos = ContactosAdministrativos::model()->findAll("estado = 1");

            if ($model_contactos)
            {
                $asunto = "Acuse de recibo";
                $body = "Estimado Cliente, el equipo de Insignia Mobile ha recibido su notificaci&oacute;n; en la brevedad posible le estará dando respuesta a su caso.";
                $body .= '<br><small><i>'.$mensaje.'</small></i>';

                $destinatario[] = array("correo"=>$model_user->email_u, "nombre"=>$model_user->login);
                $destinatarios_copia = array();

                foreach ($model_contactos as $value)
                {
                    $destinatarios_copia[] = array("correo"=>$value["correo"], "nombre"=>$value["nombre"]);
                }

                EmailController::actionSendMail($asunto, $body, $destinatario, $destinatarios_copia);
            }
        }
    }
}