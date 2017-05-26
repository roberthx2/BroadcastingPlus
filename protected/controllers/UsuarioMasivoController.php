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
				'actions'=>array('create','update', 'index', 'view', 'admin', 'delete', 'accesoBcplus', 'updateAccesoBcplus', 'asignarSc', 'getInfUsuario'),
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

		}

		$criteria = new CDbCriteria;
		$criteria->select = "id_cliente, cadena_sc";
		$criteria->compare("id_usuario", $id);
		$usuario = UsuarioSms::model()->find($criteria);

		$cadena_sc = Yii::app()->Funciones->limpiarNumerosTexarea($usuario->cadena_sc);
		$cadena_sc = ($cadena_sc == "") ? "null" : $cadena_sc;

		$criteria = new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(DISTINCT sc_id) AS sc_id";
		$criteria->addInCondition("id_sc", explode(",", $cadena_sc));
		$sc_id = ScId::model()->find($criteria);

		$cadena_sc = ($sc_id->sc_id == "") ? "null" : $sc_id->sc_id;

		$sql = "SELECT GROUP_CONCAT(DISTINCT c.sc) AS sc FROM cliente c 
						WHERE c.id_cliente_sms = ".$usuario->id_cliente." AND c.id_cliente_sc_numerico = 0 AND sc IN (".$cadena_sc.") AND sc NOT REGEXP '[a-zA-Z]+' AND c.onoff = 1";

		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

        if ($sql["sc"] != "")
        {
	        $sc_aux = array_unique(explode(",", $sql["sc"]));

	        foreach ($sc_aux as $value)
	        {
	        	$sc[$value] = $value;
	        }

	        asort($sc);
	    }
	    else $sc = array();

		$model->id_usuario = $id;

		$this->render('asignarSc', array( 
			'model'=>$model,
			'sc'=>$sc,
			'operadoras'=>ClientesBcpController::actionGetOperadoras(),
		));
	}

	public function actionGetInfUsuario()
	{
		$id_usuario = Yii::app()->request->getParam('id_usuario');
		$sc = Yii::app()->request->getParam('sc');
        
        if (Yii::app()->request->isAjaxRequest)
        {
        	$criteria = new CDbCriteria;
			$criteria->select = "id_cliente";
			$criteria->compare("id_usuario", $id_usuario);
			$usuario = UsuarioSms::model()->find($criteria);

			$operadoras = Yii::app()->Procedimientos->getScOperadorasBCP($usuario->id_cliente, $sc);

			if($operadoras) {
	            echo CJSON::encode(array(
		                        'error' => 'false',
		                        'status' => 'Operadoras obtenidas correctamente',
		                        'data' => $operadoras,
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
