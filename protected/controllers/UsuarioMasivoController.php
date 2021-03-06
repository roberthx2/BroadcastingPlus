<?php

class UsuarioMasivoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/menuAdministracion';

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
				'actions'=>array('create','update', 'index', 'view', 'admin', 'delete', 'accesoBcplus', 'updateAccesoBcplus', 'asignarSc', 'getScBcp', 'getInfUsuario'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new UsuarioMasivo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UsuarioMasivo']))
		{
			$model->attributes=$_POST['UsuarioMasivo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_usuario));
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UsuarioMasivo']))
		{
			$model->attributes=$_POST['UsuarioMasivo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_usuario));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UsuarioMasivo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UsuarioMasivo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UsuarioMasivo']))
			$model->attributes=$_GET['UsuarioMasivo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UsuarioMasivo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UsuarioMasivo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UsuarioMasivo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-masivo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAccesoBcplus()
	{
		$model=new UsuarioMasivo('searchAccesoBcplus');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UsuarioMasivo']))
			$model->buscar=$_GET['UsuarioMasivo']['buscar'];

		$this->render('accesoBcplus',array(
			'model'=>$model,
		));
	}

	public function actionUpdateAccesoBcplus()
	{
		$id = Yii::app()->request->getParam('id');
		$valor = Yii::app()->request->getParam('valor');

        if (Yii::app()->request->isAjaxRequest)
        {
        	$valor = ($valor == 'true') ? 1 : 0;

        	$sql = "INSERT INTO permisos (id_usuario, acceso_sistema) VALUES (".$id.", ".$valor.") ON DUPLICATE KEY UPDATE acceso_sistema = ".$valor;
        	$bandera = Yii::app()->db_masivo_premium->createCommand($sql)->execute();

        	if ($bandera)
        	{
	            echo CJSON::encode(array(
	                'error' => 'false',
	            ));
	            Yii::app()->end();
	        }
	        else
	        {
	        	echo CJSON::encode(array(
                'error' => 'true',
	            ));
	            Yii::app()->end();
	        }
        }
	}

	public function actionAsignarSc($id)
	{
		$model = new UsuarioMasivoScForm;

		if(isset($_POST['UsuarioMasivoScForm']))
		{
			$model->attributes=$_POST['UsuarioMasivoScForm'];

			$criteria = new CDbCriteria;
			$criteria->select = "GROUP_CONCAT(id) AS id";
			$criteria->compare("id_cliente_sms", $model->id_cliente_sms);
			$criteria->compare("sc", $model->sc);
			$clientes_bcp = ClientesBcp::model()->find($criteria);

			$transaction = Yii::app()->db_insignia_alarmas->beginTransaction();
			$transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

			try
		    {
				UsuarioClientesBcp::model()->deleteAll("id_cliente_bcp IN (".$clientes_bcp->id.")");

				if (isset($_POST["operadora"]))
				{
					$operadoras = $_POST["operadora"];

					$operadoras_inversa = array();

			    	foreach ($operadoras as $id_operadora => $value)
					{
						foreach ($value as $key => $aux)
						{
							$operadoras_inversa[$key][] = $id_operadora;	
						}
					}

					foreach ($operadoras_inversa as $alfanumerico => $ids_operadoras)
					{
						$criteria = new CDbCriteria;
						$criteria->select = "GROUP_CONCAT(CONCAT('(', ".$model->id_usuario.", ',', id, ')'))  AS id";
						$criteria->compare("id_cliente_sms", $model->id_cliente_sms);
						$criteria->compare("sc", $model->sc);
						$criteria->addInCondition("id_operadora", $ids_operadoras);
						$criteria->compare("alfanumerico", $alfanumerico);
						$insert = ClientesBcp::model()->find($criteria);

						$sql = "INSERT INTO usuario_clientes_bcp (id_usuario, id_cliente_bcp) VALUES ".$insert->id;
						Yii::app()->db_insignia_alarmas->createCommand($sql)->execute();
					}
				}

				$log = "Usuario BCP: ".UsuarioSmsController::actionGetLogin($model->id_usuario)." configurado por el Administrador: ".UsuarioSmsController::actionGetLogin(Yii::app()->user->id);

				Yii::app()->Procedimientos->setLog($log);

				$transaction->commit();
				$transaction2->commit();

				$sms = "Usuario configurado correctamente";
                Yii::app()->user->setFlash("success", $sms);

            	$this->redirect(array('asignarSc','id'=>$model->id_usuario));

			} catch (Exception $e)
                {
                    $sms = "Ocurrio un error al procesar los datos, intente nuevamente.";
                    Yii::app()->user->setFlash("danger", $sms);
                    $transaction->rollBack();
                    $transaction2->rollBack();
                }
		}

		$model->id_usuario = $id;

		$this->render('asignarSc', array( 
			'model'=>$model,
		));
	}

	public function actionGetScBcp()
	{
		$id_cliente = Yii::app()->request->getParam('id_cliente_sms');
		$id_usuario = Yii::app()->request->getParam('id_usuario');

		if (Yii::app()->request->isAjaxRequest)
        {

            $data = Yii::app()->Procedimientos->getScClienteBCPConfiguracion($id_cliente, $id_usuario);

            if($data)
            {
                echo CJSON::encode(array(
                                        'error' => 'false',
                                        'status' => 'SC obtenidos correctamente',
                                        'data' => $data
                                   )                                
                     );
                Yii::app()->end();
            } else {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'El cliente no posee sc asociados'
                ));
                Yii::app()->end();
            }
        }
	}

	public function actionGetInfUsuario()
	{
		$id_usuario = Yii::app()->request->getParam('id_usuario');
		$id_cliente = Yii::app()->request->getParam('id_cliente_sms');
		$sc = Yii::app()->request->getParam('sc');
        
        if (Yii::app()->request->isAjaxRequest)
        {
			$operadoras_cliente = ClientesBcpController::actionGetOperadorasCliente($id_cliente, $sc);

			$sql = "SELECT t.* FROM (
					SELECT c.id, c.sc, cb.id_operadora, alfanumerico FROM usuario_clientes_bcp uc
					INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
					INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
					WHERE uc.id_usuario = :id_usuario AND cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1) AS t
					INNER JOIN operadora_cliente oc ON t.id = oc.id_cliente AND t.id_operadora = oc.id_op
					GROUP BY oc.id_op, alfanumerico";

			$sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
			$sql->bindParam(":id_cliente_sms", $id_cliente, PDO::PARAM_INT);
			$sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
	        $sql->bindParam(":sc", $sc, PDO::PARAM_INT);
	        $operadoras_usuario = $sql->queryAll();

			if($operadoras_cliente) {
	            echo CJSON::encode(array(
		                        'error' => 'false',
		                        'status' => 'Operadoras obtenidas correctamente',
		                        'operadoras_usuario' => $operadoras_usuario,
		                        'operadoras_cliente' => $operadoras_cliente,
		                   )                                
	                 );
	            Yii::app()->end();
	        } else {
	            echo CJSON::encode(array(
	                'error' => 'true',
	                'status' => 'El SC no posee operadoras asociadas'
	            ));
	            Yii::app()->end();
	        }
	    }
	}
}
