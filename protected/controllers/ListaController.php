<?php

class ListaController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'admin', 'deleteLista', 'reporteCrearLista', 'viewDelete', 'editableSaver','descargarLista', 'deleteNumero', 'agregarNumeros'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	/*public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ListaForm;
		$model->scenario = "create";
		//$model_user=new usersMasivo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ListaForm']))
		{
			$model->attributes=$_POST['ListaForm'];
			//$model->scenario = "create";

			if ($model->validate())
			{
				$transaction = Yii::app()->db_masivo_premium->beginTransaction();

	            try
	            {
					if ($model->id_usuario == "")
						$model->id_usuario = Yii::app()->user->id;

					$id_proceso = Yii::app()->Procedimientos->getNumeroProceso();

					//Guarda los numeros ingresados en el textarea en la tabla de procesamiento
					Yii::app()->Procedimientos->setNumerosTmpProcesamiento($id_proceso, $model->numeros);

					//Updatea los id_operadora de los numeros validos, para los invalidos updatea el estado = 2
					Yii::app()->Filtros->filtrarInvalidosPorOperadora($id_proceso);

					//Updatea en estado 3 todos los numeros duplicados
					Yii::app()->Filtros->filtrarDuplicados($id_proceso);

					//Updatea a estado = 1 todos los numeros validos 
					Yii::app()->Filtros->filtrarAceptados($id_proceso);

					//Cantidad de destinatarios validos
					$total = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);

					if ($total > 0)
					{
						$model_lista = new Lista;
						$model_lista->id_usuario = $model->id_usuario;
						$model_lista->nombre = $model->nombre;
						$model_lista->save();
						$id_lista = $model_lista->primaryKey;

						$sql = "INSERT INTO lista_destinatarios (id_lista, numero, id_operadora) SELECT ".$id_lista.", numero, id_operadora FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado = 1";
						Yii::app()->db_masivo_premium->createCommand($sql)->execute();

						$log = "LISTA CREADA | id_lista: ".$id_lista." | Destinatarios: ".$total;
	                    Yii::app()->Procedimientos->setLog($log);

						$transaction->commit();
						$this->redirect(array("reporteCrearLista", "id_proceso"=>$id_proceso, "nombre"=>$model->nombre));
					}
					else
					{
						$error = "La lista no fue creada ya que no contiene destinatarios validos";
						Yii::app()->user->setFlash("danger", $error);
						$transaction->rollBack();
					}

					//Borra el id_proceso y todos los numeros en tmp_procesamiento asociados a el con el metodo de cascada
					//ProcesosActivos::model()->deleteByPk($id_proceso);           		

				} catch (Exception $e)
					{
						$error = "Ocurrio un error al procesar los datos, intente nuevamente.";
						Yii::app()->user->setFlash("danger", $error);
                		$transaction->rollBack();
            		}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lista']))
		{
			$model->attributes=$_POST['Lista'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_lista));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}*/

	public function actionUpdate($id)
	{
		//$model_lista = $this->loadModel($id);
		$criteria = new CDbCriteria;
		$criteria->select = "t.id_lista, t.nombre, u.login AS login, COUNT(ld.id_lista) AS total ";
		$criteria->join = "INNER JOIN lista_destinatarios ld ON t.id_lista = ld.id_lista ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario ";
		$criteria->compare("t.id_lista", $id);
		$model_lista = Lista::model()->find($criteria);
	//	$model_destinatarios = ListaDestinatarios::model()->findAll("id_lista = ".$id);
		$model_destinatarios=new ListaDestinatarios('search');
		$model_destinatarios->unsetAttributes();

		if(isset($_GET['ListaDestinatarios']))
			$model_destinatarios->buscar = $_GET['ListaDestinatarios']["buscar"];

		$this->render('viewUpdate',array(
			'model_lista'=>$model_lista, 'model_destinatarios' => $model_destinatarios
		));
	}

	public function actionAgregarNumeros($id_lista)
	{
		//$model=$this->loadModel($id_lista);
		$model=new ListaForm;
		$model->scenario = "agregarNumeros";
		//$model->id_lista = $id_lista;

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

					//Updatea a esatdo = 1 todos los numeros validos 
					Yii::app()->Filtros->filtrarAceptados($id_proceso);

					//Cantidad de destinatarios validos
					$total = Yii::app()->Procedimientos->getNumerosValidos($id_proceso);

					if ($total > 0)
					{
						$model_lista=$this->loadModel($id_lista);
						$sql = "INSERT INTO lista_destinatarios (id_lista, numero, id_operadora) SELECT ".$id_lista.", numero, id_operadora FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado = 1";
						Yii::app()->db_masivo_premium->createCommand($sql)->execute();

						$log = "LISTA EDITADA (AGREGAR) | id_lista: ".$id_lista." | Destinatarios: ".$total;
	                    Yii::app()->Procedimientos->setLog($log);

						$transaction->commit();
						$this->redirect(array("reporteCrearLista", "id_proceso"=>$id_proceso, "nombre"=>$model_lista->nombre));
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
	            		$transaction->rollBack();
	        		}
			}
		}

		$this->render('agregarNumeros',array(
			'model'=>$model,
		));
	}

	public function actionEditableSaver()
	{
	    $es = new EditableSaver($_POST["model"]);
	    try {
	        $es->update();
	    } catch(CException $e) {
	        echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
	        return;
	    }
	    echo CJSON::encode(array('success' => true));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */

	//Se ejecuta desde la vista Admin
	public function actionDeleteLista($id)
	{
		$this->loadModel($id)->delete();
		Yii::app()->user->setFlash("success", "La lista fue eliminada correctamente");

		$log = "LISTA ELIMINADA | id_lista: ".$id;
	    Yii::app()->Procedimientos->setLog($log);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionViewDelete($id_lista)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "t.id_lista, t.nombre, u.login AS login, COUNT(ld.id_lista) AS total";
		$criteria->join = "INNER JOIN lista_destinatarios ld ON t.id_lista = ld.id_lista ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario ";
		$criteria->compare('t.id_lista',$id_lista);
		$criteria->group = "ld.id_lista";

		$model = Lista::model()->find($criteria);

		$this->renderPartial('viewDelete',array("model"=>$model));
	}

	//Se ejecuta desde la vista viewDelete la cual tiene el detalle de la lista
	public function actionDeleteNumero()
	{
		$transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
			$id_lista = $_POST['id_lista'];
			//$numeros = "'".str_replace(",", "','", Yii::app()->request->post('numeros'))."'";
			$numeros = explode(",", $_POST['numeros']);

			$criteria = new CDbCriteria;
			$criteria->compare("id_lista", $id_lista);
			$criteria->addInCondition("numero", $numeros);
			$msj = ListaDestinatarios::model()->deleteAll($criteria);
			$listaDelete = 'false';

			$log = "LISTA EDITADA (ELIMINAR) | id_lista: ".$id_lista." | Destinatarios: ".COUNT($numeros);
		    Yii::app()->Procedimientos->setLog($log);

			if ($msj != 0)
			{
				$total = ListaDestinatarios::model()->count("id_lista=".$id_lista);

				if ($total == 0)
				{
					//$this->loadModel($id_lista)->delete();
					Lista::model()->deleteByPk($id_lista);
					$log = "LISTA ELIMINADA | id_lista: ".$id_lista;
		    		Yii::app()->Procedimientos->setLog($log);

					Yii::app()->user->setFlash("success", "La lista y los números fueron eliminados correctamente");
					$listaDelete = 'true';
				}
			}

			$transaction->commit();

		} catch (Exception $e)
			{
        		$transaction->rollBack();
    		}

		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode(array('salida' => $msj, 'listaDelete' => $listaDelete));
	}

	public function actionFiltarDuplicadosExistentes($id_lista, $id_proceso)
	{
		$sql = "UPDATE tmp_procesamiento SET estado = 3 
				WHERE id_proceso =".$id_proceso." AND estado IS NULL AND numero IN (
				SELECT numero FROM lista_destinatarios WHERE id_lista = ".$id_lista.")";
		Yii::app()->db_masivo_premium->createCommand($sql)->execute();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Lista');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Lista('search2');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lista']))
			$model->buscar = $_GET['Lista']["buscar"];
			//$model->attributes=$_GET['Lista'];

		if(Yii::app()->user->isAdmin())
			$id_usuario = null;
		else $id_usuario = Yii::app()->user->id;

		$this->render('admin',array('model'=>$model, 'id_usuario'=>$id_usuario));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lista the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Lista::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Lista $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lista-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionReporteCrearLista($id_proceso, $nombre)
	{
		$this->render("reporteCreate", array('id_proceso'=>$id_proceso, 'nombre'=>$nombre));
	}

	public function actionReporteTorta($id_lista)
	{
		$sql = "SELECT o.descripcion, COUNT(*) AS total, t.id_operadora FROM lista_destinatarios t 
				INNER JOIN (SELECT id_operadora_bcnl, descripcion FROM operadoras_relacion GROUP BY id_operadora_bcnl) o ON t.id_operadora = o.id_operadora_bcnl 
				WHERE t.id_lista = ".$id_lista." 
				GROUP BY id_operadora";

		$sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		$data = array();
		$bandera = 0;

		foreach ($sql as $value)
		{
			if ($bandera == 0)
			{
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]), 'sliced' => true, 'selected' => true);
          		$bandera++;
			}
          	else
          		$data[] = array('name' => $value["descripcion"], 'y' => intval($value["total"]), 'color' => Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]));
		}

		return $data;
	}

	public function actionDescargarLista($id_lista, $nombre)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(numero SEPARATOR ', ')  AS numero";
		$criteria->compare("id_lista", $id_lista);
		$lista = LIstaDestinatarios::model()->find($criteria);

		return Yii::app()->getRequest()->sendFile(strtoupper($nombre).".txt", $lista->numero);
	}
}
