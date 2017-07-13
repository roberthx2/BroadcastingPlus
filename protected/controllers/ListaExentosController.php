<?php

class ListaExentosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/menuApp';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'admin', 'adminDestinatarios', 'deleteNumber', 'addNumbers'),
				'users'=>array('@'),
			),
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$id_usuario = Yii::app()->user->id;
		$existe = ListaExentos::model()->find("id_usuario = ".$id_usuario);

		if ($existe===null)
			$this->actionCreate($id_usuario);

		if (UsuarioSmsController::actionIsAdmin($id_usuario))
			$this->redirect(Yii::app()->createUrl("listaExentos/admin"));
		else $this->redirect(Yii::app()->createUrl("listaExentos/adminDestinatarios", array("id"=>$existe->id_lista)));

		//$this->render('index');
	}

	public function actionCreate($id)
	{
		$login = UsuarioSmsController::actionGetLogin($id);

		$model = new ListaExentos;
		$model->id_usuario = $id;
		$model->nombre = "Exentos_".$login;
		$model->fecha = date("Y-m-d");
		$model->save();

		$log = "LISTA DE EXENTOS (CREAR) | id_lista: ".$model->primarykey." | usuario: ".$login;
		Yii::app()->Procedimientos->setLog($log);
	}

	public function actionAdmin()
	{
		$model=new ListaExentos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListaExentos']))
			$model->buscar = $_GET['ListaExentos']["buscar"];

		$this->render('admin', array('model'=>$model));
	}

	public function actionAdminDestinatarios($id)
	{
		$model=new ListaExentosDestinatarios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListaExentosDestinatarios']))
			$model->buscar = $_GET['ListaExentosDestinatarios']["buscar"];

		$this->render('adminDestinatarios', array('model_destinatarios'=>$model, 'id_lista'=>$id));
	}

	public function actionDeleteNumber()
	{
		$transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
			$id_lista = $_POST['id_lista'];
			$numeros = explode(",", $_POST['numeros']);

			$criteria = new CDbCriteria;
			$criteria->compare("id_lista", $id_lista);
			$criteria->addInCondition("numero", $numeros);
			$msj = ListaExentosDestinatarios::model()->deleteAll($criteria);

			$login = UsuarioSmsController::actionGetLogin(Yii::app()->user->id);

			$log = "LISTA DE EXENTOS (ELIMINAR) | id_lista: ".$id_lista." | Destinatarios: ".COUNT($numeros)." | Ejecutado por: ".$login;
		    Yii::app()->Procedimientos->setLog($log);

			$transaction->commit();

		} catch (Exception $e)
			{
        		$transaction->rollBack();
    		}

		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode(array('salida' => $msj));
	}

	public function actionAddNumbers($id_lista)
	{
		$model=new ListaForm;
		$model->scenario = "agregarNumeros";

		if(isset($_POST['ListaForm']))
		{
			$model->attributes=$_POST['ListaForm'];
			
			if ($model->validate())
			{
				$transaction = Yii::app()->db_masivo_premium->beginTransaction();

	            try
	            {
					$id_proceso = Yii::app()->Procedimientos->getNumeroProceso();

					//Guarda los numeros ingresados en el textarea en la tabla de procesamiento
					Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $model->numeros);

					//Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
					Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso);

					//Updatea en estado 3 todos los numeros duplicados
					Yii::app()->Filtros->filtrarDuplicados($id_proceso);

					//Updatea en estado 3 todos los numeros duplicados que ya estan en la lista
					$this->actionFiltarDuplicadosExistentes($id_lista, $id_proceso);

					//Updatea en estado 10 todos los numeros administrativos
					Yii::app()->Filtros->filtrarNumerosAdministrativos($id_proceso);

					//Updatea a esatdo = 1 todos los numeros validos 
					Yii::app()->Filtros->filtrarAceptados($id_proceso);

					//Cantidad de destinatarios validos
					$total = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);

					if ($total > 0)
					{
						$model_lista=$this->loadModel($id_lista);
						$sql = "INSERT INTO lista_exentos_destinatarios (id_lista, numero, id_operadora) SELECT ".$id_lista.", numero, id_operadora FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado = 1";
						Yii::app()->db_masivo_premium->createCommand($sql)->execute();

						$login = UsuarioSmsController::actionGetLogin(Yii::app()->user->id);

						$log = "LISTA DE EXENTOS (AGREGAR) | id_lista: ".$id_lista." | Destinatarios: ".$total. " | Ejecutado por: ".$login;;

	                    Yii::app()->Procedimientos->setLog($log);

						$transaction->commit();

						$url = Yii::app()->createUrl("lista/reporteCrearLista", array("id_proceso"=>$id_proceso, "nombre"=>$model_lista->nombre));

						$this->redirect($url);
					}
					else
					{
						$error = "No se agrego ningún destinatario ya que no contiene números validos o son números duplicados";
						Yii::app()->user->setFlash("danger", $error);
						$transaction->rollBack();
					}	            	
            	} catch (Exception $e)
					{
						$error = "Ocurrio un error al procesar los datos, intente nuevamente.";
						Yii::app()->user->setFlash("danger", $error);
						//}print_r($e);
	            		$transaction->rollBack();
	        		}
			}
		}

		$this->render('/lista/agregarNumeros',array(
			'model'=>$model,
		));
	}

	public function actionFiltarDuplicadosExistentes($id_lista, $id_proceso)
	{
		$sql = "UPDATE tmp_procesamiento SET estado = 3 
				WHERE id_proceso =".$id_proceso." AND estado IS NULL AND numero IN (
				SELECT numero FROM lista_exentos_destinatarios WHERE id_lista = ".$id_lista.")";
		Yii::app()->db_masivo_premium->createCommand($sql)->execute();
	}

	public function loadModel($id)
	{
		$model=ListaExentos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}