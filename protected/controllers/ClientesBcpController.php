<?php

class ClientesBcpController extends Controller
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
				'actions'=>array('create','update', 'index', 'view', 'admin', 'delete', 'getSc', 'getOperadoras', 'activateCliente', 'getInfCliente', 'updateEstado'),
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
		$model=new ClientesBcpForm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClientesBcpForm']))
		{
			$model->attributes=$_POST['ClientesBcpForm'];

			if (isset($_POST["operadora"]))
			{
				$bandera = true;

				if (isset($_POST["sc_alf"]))
				{
					//Valida si hay 1 operadora Alf seleccionada y si se ingreso su sc
					if ($this->actionValidarScAlf($_POST["operadora"], $_POST["sc_alf"]))
					{
						//Valida que se haya seleccionado por lo menos 1 oper numerica
						if ($this->actionValidarOperNumeric($_POST["operadora"]))
						{
							$bandera = true;
						}
						else 
						{
							$bandera = false;
							$sms = "Debe seleccionar al menos una operadora numerica";
                			Yii::app()->user->setFlash("danger", $sms);
						}
					}
					else
					{
						$bandera = false;
						$sms = "Debe ingresar los sc alfanumericos para las operadoras alf seleccionadas";
                		Yii::app()->user->setFlash("danger", $sms);
					}
				}

				if ($bandera)
				{
					if ($model->validate())
            		{
            			$operadoras = $_POST["operadora"];

            			$transaction = Yii::app()->db_insignia_alarmas->beginTransaction();
        				$transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

		                try
		                {
	            			if ($this->actionClienteExisteEnAlarmas($model->id_cliente, $model->sc)) //Nuevo (Esto solo aplica para los clientes existentes antes de implementar el Broadcasting Plus)
	            			{
	            				$this->actionCrearClienteEnviadorExistenteEnAlarmas($model, $operadoras);
	            			}
	            			else
	            			{
			                	$this->actionCrearClienteEnviadorNuevo($model, $operadoras);
	            			}

	            			$transaction->commit();
		                	$transaction2->commit();

							$sms = "Cliente configurado correctamente";
		                    Yii::app()->user->setFlash("success", $sms);

		                	$this->redirect(array('update','id'=>$model->id_cliente));

        				} catch (Exception $e)
		                    {
		                        $sms = "Ocurrio un error al procesar los datos, intente nuevamente.";
		                        Yii::app()->user->setFlash("danger", $sms);
		                        $transaction->rollBack();
		                        $transaction2->rollBack();
		                        //print_r($e);
		                    } 
            		}
				}
			}
			else
			{
				$sms = "Debe seleccionar una operadora";
                Yii::app()->user->setFlash("danger", $sms);
			}
		}

		$criteria = new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(DISTINCT id_cliente_sms) AS id_cliente_sms";
		$model_bcp = ClientesBcp::model()->find($criteria);
		$model_bcp = ($model_bcp->id_cliente_sms == "") ? "null":$model_bcp->id_cliente_sms;

		$criteria = new CDbCriteria;
		$criteria->select = "Id_cliente, Des_cliente";
		$criteria->addNotInCondition("Id_cliente", explode(",", $model_bcp));
		$criteria->order = "Des_cliente ASC";
		$clientes = ClienteSms::model()->findAll($criteria);

		$this->render('create',array(
			'model'=>$model,
			'clientes'=>$clientes,
			'operadoras'=>$this->actionGetOperadoras()
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = new ClientesBcpForm;

		if(isset($_POST['ClientesBcpForm']))
		{
			$model->attributes=$_POST['ClientesBcpForm'];

			if (isset($_POST["operadora"]))
			{
				$bandera = true;

				if (isset($_POST["sc_alf"]))
				{
					//Valida si hay 1 operadora Alf seleccionada y si se ingreso su sc
					if ($this->actionValidarScAlf($_POST["operadora"], $_POST["sc_alf"]))
					{
						//Valida que se haya seleccionado por lo menos 1 oper numerica
						if ($this->actionValidarOperNumeric($_POST["operadora"]))
						{
							$bandera = true;
						}
						else 
						{
							$bandera = false;
							$sms = "Debe seleccionar al menos una operadora numerica";
                			Yii::app()->user->setFlash("danger", $sms);
						}
					}
					else
					{
						$bandera = false;
						$sms = "Debe ingresar los sc alfanumericos para las operadoras alf seleccionadas";
                		Yii::app()->user->setFlash("danger", $sms);
					}
				}

				if ($bandera)
				{
					if ($model->validate())
            		{
            			
            			$operadoras = $_POST["operadora"];

            			$transaction = Yii::app()->db_insignia_alarmas->beginTransaction();
        				$transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

		                try
		                {
	            			if ($this->actionClienteExisteEnAlarmas($model->id_cliente, $model->sc)) //Nuevo (Esto solo aplica para los clientes existentes antes de implementar el Broadcasting Plus)
	            			{
	            				if ($this->actionClienteExisteEnClientesBcp($model->id_cliente, $model->sc))
	            				{
	            					$this->actionCrearClienteEnviadorExistenteEnClientesBcp($model, $operadoras);
	            				}
	            				else
	            				{
	            					$this->actionCrearClienteEnviadorExistenteEnAlarmas($model, $operadoras);
	            				}
	            			}
	            			else
	            			{
	            				$this->actionCrearClienteEnviadorNuevo($model, $operadoras);
	            			}

	            			$transaction->commit();
		                	$transaction2->commit();

							$sms = "Cliente configurado correctamente";
		                    Yii::app()->user->setFlash("success", $sms);

		                	$this->redirect(array('update','id'=>$model->id_cliente));

        				} catch (Exception $e)
		                    {
		                        $sms = "Ocurrio un error al procesar los datos, intente nuevamente.";
		                        Yii::app()->user->setFlash("danger", $sms);
		                        $transaction->rollBack();
		                        $transaction2->rollBack();
		                        print_r($e);
		                    } 
            		}
				}
			}
			else
			{
				$sms = "Debe seleccionar una operadora";
                Yii::app()->user->setFlash("danger", $sms);
			}
		}

        $sql = "SELECT 
					(SELECT GROUP_CONCAT(DISTINCT c.sc) AS sc FROM cliente c 
						WHERE c.id_cliente_sms = :id_cliente_sms AND c.id_cliente_sc_numerico = 0 AND sc NOT REGEXP '[a-zA-Z]+') AS sc_all,
					(SELECT GROUP_CONCAT(DISTINCT c.sc) AS sc FROM cliente c 
						WHERE c.id_cliente_sms = :id_cliente_sms AND c.id_cliente_sc_numerico = 0 AND sc NOT REGEXP '[a-zA-Z]+' AND c.onoff = 1) AS sc_habilitados";

		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_cliente_sms", $id, PDO::PARAM_INT);
        $sc_alarmas = $sql->queryRow();

        $criteria = new CDbCriteria;
        $criteria->select = "GROUP_CONCAT(DISTINCT t.sc_id) AS sc_id";
        $criteria->join = "INNER JOIN producto p ON t.id_sc = p.id_sc";
        $criteria->condition = "p.cliente = ".$id." AND ";
        $criteria->condition .= "t.sc_id NOT IN(".$sc_alarmas["sc_all"].") AND ";
        $criteria->condition .= "p.desc_producto NOT LIKE 'CERRADO%' ";
        $sc_sms = ScId::model()->find($criteria);

        $sc_all = trim($sc_alarmas["sc_habilitados"].",".$sc_sms->sc_id, ",");

        if ($sc_all != "")
        {
	        $sc_aux = array_unique(explode(",", $sc_all));

	        foreach ($sc_aux as $value)
	        {
	        	$sc[$value] = $value;
	        }

	        asort($sc);
	    }
	    else $sc = array();

        $model->id_cliente = $id;

		$this->render('update',array(
			'model'=>$model,
			'sc'=>$sc,
			'operadoras'=>$this->actionGetOperadoras()
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	/*public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}*/

	/**
	 * Lists all models.
	 */
	/*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ClientesBcp');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ClientesBcp('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClientesBcp']))
			$model->buscar = $_GET['ClientesBcp']["buscar"];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ClientesBcp the loaded model
	 * @throws CHttpException
	 */
	/*public function loadModel($id)
	{
		$model=ClientesBcp::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}*/

	/**
	 * Performs the AJAX validation.
	 * @param ClientesBcp $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='clientes-bcp-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetSc()
	{
		$id_cliente = Yii::app()->request->getParam('id_cliente');
        
        if (Yii::app()->request->isAjaxRequest)
        {
            /*$criteria = new CDbCriteria;
            $criteria->select = "GROUP_CONCAT(DISTINCT id_sc) AS id_sc";
            $criteria->join = "INNER JOIN cliente c ON t.cliente = c.Id_cliente ";
            $criteria->condition = "c.Id_cliente = ".$id_cliente." AND ";
            $criteria->condition .= "t.desc_producto NOT LIKE 'CERRADO%' ";
            $model = Producto::model()->find($criteria);
            $sc_id = ($model->id_sc == "") ? "null":$model->id_sc;

            $criteria = new CDbCriteria;
            $criteria->select = "DISTINCT sc_id";
            $criteria->addInCondition("id_sc", explode(",", $sc_id));
            $model = ScId::model()->findAll($criteria);*/

            $criteria = new CDbCriteria;
            $criteria->select = "DISTINCT t.sc_id";
            $criteria->join = "INNER JOIN producto p ON t.id_sc = p.id_sc";
            $criteria->condition = "p.cliente = ".$id_cliente." AND ";
            $criteria->condition .= "p.desc_producto NOT LIKE 'CERRADO%' ";
            $model = ScId::model()->findAll($criteria);

        	if($model) {
                echo CJSON::encode(array(
                                        'error' => 'false',
                                        'status' => 'SC obtenidos correctamente',
                                        'data' => $model,
                                   )                                
                     );
                Yii::app()->end();
            } else {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'No posee SC asociado'
                ));
                Yii::app()->end();
            }
        }
	}

	public function actionGetOperadoras()
	{
    	$criteria = new CDbCriteria;
    	$criteria->select = "t.id_operadora, t.descripcion, r.alfanumerico AS estado";
    	$criteria->join = "INNER JOIN operadoras_relacion r ON t.id_operadora = r.id_operadora_bcnl";
		$criteria->compare("t.estado",1);
		$criteria->group = "r.id_operadora_bcnl, r.alfanumerico";
		$criteria->order = "id_operadora ASC, estado ASC";
		$model = OperadorasActivas::model()->findAll($criteria);

		$array = array();

		$operadoras = "<table>";

		foreach ($model as $key => $value)
		{
			$value->descripcion = ($value->estado == 0) ? $value->descripcion:$value->descripcion." ALF";

			$operadoras .= "<tr><td style='padding: 3px 10px 3px 10px; color: ".Yii::app()->Funciones->getColorOperadoraBCNL($value->id_operadora).";'><strong>".$value->descripcion."</strong></td><td style='padding: 3px 10px 3px 10px'>";

			$operadoras .= $this->widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => "operadora[$value->id_operadora][$value->estado]",
								    'value' => 0,
								    'htmlOptions'=> array('class'=> 'operadora'),
							    )
							, true);

			$operadoras .= "</td>";

			if ($value->estado == 1)
			{
				$operadoras .= '<td><input type="text" class="form-control sc_alf sc_alf_'.$value->id_operadora.'" autocomplete="off" maxlength="9" onkeypress="return validarScAlf(event);" placeholder="SC Alf" name=sc_alf['.$value->id_operadora.'] style="text-transform:uppercase;"></td>';
			}
			else
				$operadoras .= '<td></td>';

			$operadoras .= "</tr>";
		}

		$operadoras .= "</table>";

		return $operadoras;
	}

	private function actionValidarScAlf($operadoras, $sc_alf)
	{
		$bandera = true;

		foreach ($operadoras as $id_operadora => $value)
		{
			foreach ($value as $key => $aux)
			{
				if ($key == 1)
				{
					if ($sc_alf[$id_operadora] == "")
					{
						$bandera = false;
						break;
					}
				}
			}
		}
		
		return $bandera;
	}

	private function actionValidarOperNumeric($operadoras)
	{
		$bandera = false;

		foreach ($operadoras as $id_operadora => $value)
		{
			foreach ($value as $key => $aux)
			{
				if ($key == 0)
				{
					$bandera = true;
					break;
				}
			}
		}
		
		return $bandera;
	}

	private function actionClienteExisteEnAlarmas($id_cliente_sms, $sc)
	{
		$model = ClienteAlarmas::model()->COUNT("id_cliente_sms=:id_cliente_sms AND sc=:sc", array(":id_cliente_sms"=>$id_cliente_sms, ":sc"=>$sc));

		if ($model > 0)
			return true;

		return false;
	}

	private function actionClienteExisteEnClientesBcp($id_cliente_sms, $sc)
	{
		$model = ClientesBcp::model()->COUNT("id_cliente_sms=:id_cliente_sms AND sc=:sc", array(":id_cliente_sms"=>$id_cliente_sms, ":sc"=>$sc));

		if ($model > 0)
			return true;

		return false;
	}

	private function actionGetDescripcionCliente($nombre, $sc)
    {
        //Elimina el SC de la descripcion
        $nombre = str_replace($sc, " ", $nombre);
        //Reemplaza los espacios en blanco consecutivos por un espacio en blanco
        $nombre = preg_replace("/\s{2,}/", " ", $nombre);
        //Reemplaza los espacios en blanco por piso
        $nombre = preg_replace("/\s/", "_", $nombre);
        //Reemplaza los pisos consecutivos por un piso
        $nombre = preg_replace("/_{2,}/", "_", $nombre);
        //Elimina los espacios en blanco en los extremos
        $nombre = trim($nombre);
        //Elimina los pisos en los entremos
        $nombre = trim($nombre, "_");

        $nombre = explode("_", $nombre);

        $total = COUNT($nombre);

        if ($total <= 2)
        {
            $nombre_aux = $nombre[0];

            if (isset($nombre[1]))
                $nombre_aux .= "_".$nombre[1];
        }
        elseif ($total >= 3)
        {
            $nombre_aux = $nombre[0]."_".$nombre[2];
        }

        $nombre = strtoupper($nombre_aux);
        $nombre .= "_".$sc;

        return $nombre;
    }

    private function actionGetAbrevOper($id_operadora)
    {
    	$criteria = new CDbCriteria;
    	$criteria->select = "CONCAT(SUBSTRING(descripcion,1,1),SUBSTRING(descripcion,3,1),SUBSTRING(descripcion,5,1)) AS descripcion";
    	$criteria->compare("id_operadora", $id_operadora);
    	$model = OperadorasActivas::model()->find($criteria);

    	return $model->descripcion;
    }

    private function actionObtenerEventoAleatorio()
    {
        $sql = "SELECT id FROM evento";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryAll();
        
        $array = array();
        $valido = false;
        
        foreach ($sql as $value)
        {
            $array[] = $value;
        }
        
        do
        {
            $valor = rand(1000,20000);
            
            if (!in_array($valor, $array))
            {
                $valido = true;
            }
        } while ($valido == false);
        
        return $valor;
    }

    private function actionGetOperBCP($id_operadora, $alfanumerico)
    {
    	$criteria = new CDbCriteria;
    	$criteria->select = "GROUP_CONCAT(id_operadora_bcp) AS id_operadora_bcp";
    	$criteria->compare("id_operadora_bcnl", $id_operadora);
    	$criteria->compare("alfanumerico", $alfanumerico);
    	$model = OperadorasRelacion::model()->find($criteria);

    	$model = explode(",", $model->id_operadora_bcp);

    	return $model;
    }

    private function actionCrearCliente($model, $cliente_sms, $descripcion, $sc_alf, $alfanumerico, $id_operadora, $id_cliente_alarmas)
	{
		$model_cliente = new ClienteAlarmas;
    	$model_cliente->descripcion = ($alfanumerico == 0) ? $descripcion."@" : $descripcion."_".$this->actionGetAbrevOper($id_operadora)."_Alf@";
    	$model_cliente->sc = ($alfanumerico == 0) ? $model->sc : strtoupper($sc_alf[$id_operadora]);
    	$model_cliente->burst = 20;
    	$model_cliente->onoff = 1;
    	$model_cliente->segundos = 10;
    	$model_cliente->id_cliente_sms = $model->id_cliente;
    	$model_cliente->contacto_del_cliente = $cliente_sms->email;
    	$model_cliente->id_cliente_sc_numerico = ($alfanumerico == 0) ? 0 : $id_cliente_alarmas;
		$model_cliente->save();

		$id_cliente_alarmas = Yii::app()->db_insignia_alarmas->getLastInsertID();

    	$model_evento = new Evento;
    	$model_evento->id = $this->actionObtenerEventoAleatorio();
    	$model_evento->descripcion = ($alfanumerico == 0) ? $descripcion : $descripcion."_".$this->actionGetAbrevOper($id_operadora)."_Alf";
    	$model_evento->cliente = $id_cliente_alarmas;
    	$model_evento->save();

    	return $id_cliente_alarmas;
	}

	private function actionCrearClienteBCP($id_cliente_alarmas, $model, $id_operadora, $alfanumerico)
	{
		$model_clientesbcp = new ClientesBcp;
		$model_clientesbcp->id_cliente_bcp = $id_cliente_alarmas;
		$model_clientesbcp->id_cliente_sms = $model->id_cliente;
		$model_clientesbcp->sc = $model->sc;
		$model_clientesbcp->id_operadora = $id_operadora;
		$model_clientesbcp->alfanumerico = $alfanumerico;
		$model_clientesbcp->save();
	}

	private function actionCrearOperadoraCliente($id_operadora_bcp, $id_cliente_alarmas, $id_operadora_bcnl)
	{
		$model_operadora_cliente = new OperadoraCliente;
		$model_operadora_cliente->id_operadora = $id_operadora_bcp;
		$model_operadora_cliente->id_cliente = $id_cliente_alarmas;
		$model_operadora_cliente->id_op = $id_operadora_bcnl;
		$model_operadora_cliente->save();
	}

	private function actionGetIdClienteAlf($id_cliente, $id_operadora)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "id";
		$criteria->join = "INNER JOIN operadora_cliente o ON t.id = o.id_cliente";
		$criteria->compare("t.id_cliente_sc_numerico", $id_cliente);
		$criteria->compare("o.id_op", $id_operadora);
		$criteria->group = "o.id_op";
		$model = ClienteAlarmas::model()->find($criteria);

		if ($model)
			return $model->id;

		return "null";
	}

	private function actionCrearClienteEnviadorNuevo($model, $operadoras)
	{
		$operadoras_inversa = array();

    	foreach ($operadoras as $id_operadora => $value)
		{
			foreach ($value as $key => $aux)
			{
				$operadoras_inversa[$key][] = $id_operadora;	
			}
		}

		$criteria = new CDbCriteria;
		$criteria->select = "Des_cliente, email";
		$criteria->compare("Id_cliente", $model->id_cliente);
		$cliente_sms = ClienteSms::model()->find($criteria);

		$descripcion = $this->actionGetDescripcionCliente($cliente_sms->Des_cliente, $model->sc);
		$id_cliente_alarmas = 0;

		foreach ($operadoras_inversa as $alfanumerico => $ids_operadoras)
		{
        	if ($alfanumerico == 0) //Numerico
        	{
        		$id_cliente_alarmas = $this->actionCrearCliente($model, $cliente_sms, $descripcion, null, $alfanumerico, null, null);

            	foreach ($ids_operadoras as $id_operadora_bcnl)
            	{
            		$operadoras_bcp = $this->actionGetOperBCP($id_operadora_bcnl, $alfanumerico);

            		foreach ($operadoras_bcp as $id_operadora_bcp)
            		{
            			$this->actionCrearOperadoraCliente($id_operadora_bcp, $id_cliente_alarmas, $id_operadora_bcnl);
            		}

            		$this->actionCrearClienteBCP($id_cliente_alarmas, $model, $id_operadora_bcnl, $alfanumerico);
            	}

            	$log = "Cliente BCP creado correctamente: id_sms=".$model->id_cliente." | id_cliente_bcp=".$id_cliente_alarmas." | sc=".$model->sc;

				Yii::app()->Procedimientos->setLog($log);
        	}
        	else //Alfanumerico
        	{
        		foreach ($ids_operadoras as $id_operadora_bcnl)
            	{
            		$id_cliente_alarmas_alf = $this->actionCrearCliente($model, $cliente_sms, $descripcion, $_POST["sc_alf"], $alfanumerico, $id_operadora_bcnl, $id_cliente_alarmas);

            		$operadoras_bcp = $this->actionGetOperBCP($id_operadora_bcnl, $alfanumerico);

            		foreach ($operadoras_bcp as $id_operadora_bcp)
            		{
            			$this->actionCrearOperadoraCliente($id_operadora_bcp, $id_cliente_alarmas_alf, $id_operadora_bcnl);
            		}

            		$this->actionCrearClienteBCP($id_cliente_alarmas_alf, $model, $id_operadora_bcnl, $alfanumerico);

            		$log = "Cliente BCP creado correctamente: id_sms=".$model->id_cliente." | id_cliente_bcp=".$id_cliente_alarmas_alf." | sc=".strtoupper($_POST["sc_alf"][$id_operadora_bcnl]);
            	
					Yii::app()->Procedimientos->setLog($log);
            	}
        	}				                	
		}
	}

	private function actionCrearClienteEnviadorExistenteEnAlarmas($model, $operadoras)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "id";
		$criteria->compare("id_cliente_sms", $model->id_cliente);
		$criteria->compare("sc", $model->sc);
		$criteria->compare("id_cliente_sc_numerico", 0);
		$model_cliente_alarmas = ClienteAlarmas::model()->find($criteria);

		$operadoras_inversa = array();

    	foreach ($operadoras as $id_operadora => $value)
		{
			foreach ($value as $key => $aux)
			{
				$operadoras_inversa[$key][] = $id_operadora;	
			}
		}

		$criteria = new CDbCriteria;
		$criteria->select = "Des_cliente, email";
		$criteria->compare("Id_cliente", $model->id_cliente);
		$cliente_sms = ClienteSms::model()->find($criteria);

		$descripcion = $this->actionGetDescripcionCliente($cliente_sms->Des_cliente, $model->sc);

		ClienteAlarmas::model()->updateAll(array("onoff"=>"0"),"id_cliente_sc_numerico=:id", array(":id"=>$model_cliente_alarmas->id));

		foreach ($operadoras_inversa as $alfanumerico => $ids_operadoras)
		{
        	if ($alfanumerico == 0) //Numerico
        	{
        		$model_cliente_alarmas->descripcion = $descripcion."@";
        		$model_cliente_alarmas->contacto_del_cliente = $cliente_sms->email;
        		$model_cliente_alarmas->onoff = 1;
        		$model_cliente_alarmas->save();

        		$criteria = new CDbCriteria;
        		$criteria->select = "id";
        		$criteria->compare("cliente", $model_cliente_alarmas->id);
        		$model_evento = Evento::model()->find($criteria);

        		$model_evento->descripcion = $descripcion;
        		$model_evento->save();

        		OperadoraCliente::model()->deleteAll("id_cliente=:id_cliente", array(":id_cliente"=>$model_cliente_alarmas->id));

            	foreach ($ids_operadoras as $id_operadora_bcnl)
            	{
            		$operadoras_bcp = $this->actionGetOperBCP($id_operadora_bcnl, $alfanumerico);

            		foreach ($operadoras_bcp as $id_operadora_bcp)
            		{
            			$this->actionCrearOperadoraCliente($id_operadora_bcp, $model_cliente_alarmas->id, $id_operadora_bcnl);
            		}

            		$this->actionCrearClienteBCP($model_cliente_alarmas->id, $model, $id_operadora_bcnl, $alfanumerico);
            	}

            	$log = "Cliente BCP enlazado correctamente: id_sms=".$model->id_cliente." | id_cliente_bcp=".$model_cliente_alarmas->id." | sc=".$model->sc;

				Yii::app()->Procedimientos->setLog($log);
        	}
        	else //Alfanumerico
        	{
        		foreach ($ids_operadoras as $id_operadora_bcnl)
            	{
     				$id_cliente_alarmas_alf = $this->actionGetIdClienteAlf($model_cliente_alarmas->id, $id_operadora_bcnl);

     				if ($id_cliente_alarmas_alf == "null")
     				{
     					$id_cliente_alarmas_alf = $this->actionCrearCliente($model, $cliente_sms, $descripcion, $_POST["sc_alf"], $alfanumerico, $id_operadora_bcnl, $model_cliente_alarmas->id);
     				}
     				else
     				{
     					$model_cliente_alarmas_alf = ClienteAlarmas::model()->findByPk($id_cliente_alarmas_alf);

     					$model_cliente_alarmas_alf->descripcion = $descripcion."_".$this->actionGetAbrevOper($id_operadora_bcnl)."_Alf@";
     					$model_cliente_alarmas_alf->sc = strtoupper($_POST["sc_alf"][$id_operadora_bcnl]);
                		$model_cliente_alarmas_alf->contacto_del_cliente = $cliente_sms->email;
                		$model_cliente_alarmas_alf->onoff = 1;
                		$model_cliente_alarmas_alf->save();

                		$criteria = new CDbCriteria;
                		$criteria->select = "id";
                		$criteria->compare("cliente", $id_cliente_alarmas_alf);
                		$model_evento = Evento::model()->find($criteria);

                		$model_evento->descripcion = $descripcion."_".$this->actionGetAbrevOper($id_operadora_bcnl)."_Alf";
                		$model_evento->save();
     				}

            		OperadoraCliente::model()->deleteAll("id_cliente=".$id_cliente_alarmas_alf."");

            		$operadoras_bcp = $this->actionGetOperBCP($id_operadora_bcnl, $alfanumerico);

            		foreach ($operadoras_bcp as $id_operadora_bcp)
            		{
            			$this->actionCrearOperadoraCliente($id_operadora_bcp, $id_cliente_alarmas_alf, $id_operadora_bcnl);
            		}

            		$this->actionCrearClienteBCP($id_cliente_alarmas_alf, $model, $id_operadora_bcnl, $alfanumerico);

            		$log = "Cliente BCP enlazado correctamente: id_sms=".$model->id_cliente." | id_cliente_bcp=".$id_cliente_alarmas_alf." | sc=".strtoupper($_POST["sc_alf"][$id_operadora_bcnl]);
        
					Yii::app()->Procedimientos->setLog($log);
            	}
        	}				                	
		}
	}

	private function actionCrearClienteEnviadorExistenteEnClientesBcp($model, $operadoras)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "id";
		$criteria->compare("id_cliente_sms", $model->id_cliente);
		$criteria->compare("sc", $model->sc);
		$criteria->compare("id_cliente_sc_numerico", 0);
		$model_cliente_alarmas = ClienteAlarmas::model()->find($criteria);

		$operadoras_inversa = array();

    	foreach ($operadoras as $id_operadora => $value)
		{
			foreach ($value as $key => $aux)
			{
				$operadoras_inversa[$key][] = $id_operadora;	
			}
		}

		$criteria = new CDbCriteria;
		$criteria->select = "Des_cliente, email";
		$criteria->compare("Id_cliente", $model->id_cliente);
		$cliente_sms = ClienteSms::model()->find($criteria);

		$descripcion = $this->actionGetDescripcionCliente($cliente_sms->Des_cliente, $model->sc);

		ClienteAlarmas::model()->updateAll(array("onoff"=>"0"),"id_cliente_sc_numerico=:id", array(":id"=>$model_cliente_alarmas->id));

		foreach ($operadoras_inversa as $alfanumerico => $ids_operadoras)
		{
			if ($alfanumerico == 0) //Numerico
        	{
        		$model_cliente_alarmas->descripcion = $descripcion."@";
        		$model_cliente_alarmas->contacto_del_cliente = $cliente_sms->email;
        		$model_cliente_alarmas->onoff = 1;
        		$model_cliente_alarmas->save();

        		$criteria = new CDbCriteria;
        		$criteria->select = "id";
        		$criteria->compare("cliente", $model_cliente_alarmas->id);
        		$model_evento = Evento::model()->find($criteria);

        		$model_evento->descripcion = $descripcion;
        		$model_evento->save();

        		OperadoraCliente::model()->deleteAll("id_cliente=:id_cliente", array(":id_cliente"=>$model_cliente_alarmas->id));

        		foreach ($ids_operadoras as $id_operadora_bcnl)
            	{
            		$operadoras_bcp = $this->actionGetOperBCP($id_operadora_bcnl, $alfanumerico);

            		foreach ($operadoras_bcp as $id_operadora_bcp)
            		{
            			$this->actionCrearOperadoraCliente($id_operadora_bcp, $model_cliente_alarmas->id, $id_operadora_bcnl);
            		}

            		$count = ClientesBcp::model()->COUNT("id_cliente_sms=:id_cliente_sms AND sc=:sc AND id_operadora=:id_operadora AND alfanumerico=:alfanumerico", array(":id_cliente_sms"=>$model->id_cliente, ":sc"=>$model->sc, ":id_operadora"=>$id_operadora_bcnl, ":alfanumerico"=>$alfanumerico));

            		if ($count == 0)
            			$this->actionCrearClienteBCP($model_cliente_alarmas->id, $model, $id_operadora_bcnl, $alfanumerico);
            	}

            	$log = "Cliente BCP enlazado correctamente: id_sms=".$model->id_cliente." | id_cliente_bcp=".$model_cliente_alarmas->id." | sc=".$model->sc;

				Yii::app()->Procedimientos->setLog($log);
        	}
        	else //Alfanumerico
        	{
        		foreach ($ids_operadoras as $id_operadora_bcnl)
            	{
     				$id_cliente_alarmas_alf = $this->actionGetIdClienteAlf($model_cliente_alarmas->id, $id_operadora_bcnl);

     				if ($id_cliente_alarmas_alf == "null")
     				{
     					$id_cliente_alarmas_alf = $this->actionCrearCliente($model, $cliente_sms, $descripcion, $_POST["sc_alf"], $alfanumerico, $id_operadora_bcnl, $model_cliente_alarmas->id);
     				}
     				else
     				{
     					$model_cliente_alarmas_alf = ClienteAlarmas::model()->findByPk($id_cliente_alarmas_alf);

     					$model_cliente_alarmas_alf->descripcion = $descripcion."_".$this->actionGetAbrevOper($id_operadora_bcnl)."_Alf@";
     					$model_cliente_alarmas_alf->sc = strtoupper($_POST["sc_alf"][$id_operadora_bcnl]);
                		$model_cliente_alarmas_alf->contacto_del_cliente = $cliente_sms->email;
                		$model_cliente_alarmas_alf->onoff = 1;
                		$model_cliente_alarmas_alf->save();

                		$criteria = new CDbCriteria;
                		$criteria->select = "id";
                		$criteria->compare("cliente", $id_cliente_alarmas_alf);
                		$model_evento = Evento::model()->find($criteria);

                		$model_evento->descripcion = $descripcion."_".$this->actionGetAbrevOper($id_operadora_bcnl)."_Alf";
                		$model_evento->save();
     				}

            		OperadoraCliente::model()->deleteAll("id_cliente=".$id_cliente_alarmas_alf."");

            		$operadoras_bcp = $this->actionGetOperBCP($id_operadora_bcnl, $alfanumerico);

            		foreach ($operadoras_bcp as $id_operadora_bcp)
            		{
            			$this->actionCrearOperadoraCliente($id_operadora_bcp, $id_cliente_alarmas_alf, $id_operadora_bcnl);
            		}

            		$count = ClientesBcp::model()->COUNT("id_cliente_sms=:id_cliente_sms AND sc=:sc AND id_operadora=:id_operadora AND alfanumerico=:alfanumerico", array(":id_cliente_sms"=>$model->id_cliente, ":sc"=>$model->sc, ":id_operadora"=>$id_operadora_bcnl, ":alfanumerico"=>$alfanumerico));

            		if ($count == 0)
            			$this->actionCrearClienteBCP($id_cliente_alarmas_alf, $model, $id_operadora_bcnl, $alfanumerico);

            		$log = "Cliente BCP enlazado correctamente: id_sms=".$model->id_cliente." | id_cliente_bcp=".$id_cliente_alarmas_alf." | sc=".strtoupper($_POST["sc_alf"][$id_operadora_bcnl]);
        
					Yii::app()->Procedimientos->setLog($log);
            	}
        	}
		}	
	}

	public function actionGetInfCliente()
	{
		$id_cliente_sms = Yii::app()->request->getParam('id_cliente_sms');
		$sc = Yii::app()->request->getParam('sc');
        
        if (Yii::app()->request->isAjaxRequest)
        {
			$operadoras = Yii::app()->Procedimientos->getScOperadorasBCP($id_cliente_sms, $sc);

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

	public function actionActivateCliente($id_cliente_sms)
	{
		$model=new ClienteAlarmas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClienteAlarmas']))
			$model->attributes=$_GET['ClienteAlarmas'];

		$this->render('habilitar_cliente_enviador',array(
			'model'=>$model,
			'id_cliente_sms'=>$id_cliente_sms
		));
	}

	public function actionUpdateEstado()
	{
		$id = Yii::app()->request->getParam('id');
		$valor = Yii::app()->request->getParam('valor');

        if (Yii::app()->request->isAjaxRequest)
        {
        	$model=ClienteAlarmasController::loadModel($id);
        	$model->onoff = ($valor == 'true') ? 1 : 0;
        	
        	if ($model->save())
        	{
        		ClienteAlarmas::model()->updateAll(array("onoff"=>"0"),"id_cliente_sc_numerico=:id", array(":id"=>$model->id));
        		
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
}
