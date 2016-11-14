<?php

class Procedimientos extends CApplicationComponent
{
	public function getNumeroProceso()
	{
		$proceso = "";
		$valido = true;

		do
		{
			$proceso = rand(1000, 10000);
			$proceso_tmp = ProcesosActivos::model()->findByPk($proceso);

			if ($proceso_tmp == null)
			{
				$model = new ProcesosActivos;
				$model->id_proceso = $proceso;
				$model->hora = date("H:i:s");
				$model->save();
				$valido = false;
			}
			
		} while ($valido);

		return $proceso;
	}

	public function setNumerosTmpProcesamiento($id_proceso, $numeros)
	{
		$sql = "CALL split_numeros('".$numeros."', ',', ".$id_proceso.")";
		Yii::app()->db_masivo_premium->createCommand($sql)->execute();

		$sql = "INSERT INTO tmp_procesamiento (id_proceso, numero) SELECT id_proceso, numero FROM splitvalues_numeros WHERE id_proceso = :id_proceso";
		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_STR);
        $sql->execute();
	}

	public function getNumerosValidos($id_proceso)
	{
		$sql = "SELECT COUNT(id_proceso) AS total FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado = 1";
		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_STR);
        $total = $sql->queryRow();

		return $total["total"];
	}

	public function getClientesBCNL($id_usuario)
	{
		//Solo trae los clientes activos YA NO
		$sql = "SELECT c.id_cliente AS id_cliente, c.Des_cliente AS descripcion FROM cliente c "
				//. "INNER JOIN cliente_fechas f ON c.id_cliente = f.id_cliente "
				. "WHERE c.id_cliente IN (".$this->getClienteBCNLHerencia($id_usuario).") " /*AND f.fecha_fin = '0000-00-00'*/ 
				. "ORDER BY c.Des_cliente ASC";

		$model = Yii::app()->db_sms->createCommand($sql)->queryAll();

        return $model;
	}

	public function getClienteCPEI($id_usuario)
	{
		$sql = "SELECT c.id_cliente AS id_cliente, c.Des_cliente AS descripcion FROM cliente c WHERE id_cliente = ".Yii::app()->user->modelSMS()->id_cliente;

		$model = Yii::app()->db_sms->createCommand($sql)->queryAll();

        return $model;
	}

	public function getClientesBCP($id_usuario)
	{
		$sql = "SELECT c.id AS id_cliente, REPLACE(c.descripcion, '@', '') AS descripcion FROM usuario_cliente_operadora u "
                . "INNER JOIN cliente c ON u.id_cliente = c.id "
                . "WHERE u.id_usuario = :id_usuario AND c.onoff = 1 "
                . "ORDER BY c.descripcion ASC";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_STR);

        return $sql->queryAll();
	}

	public function getClienteBCNLHerencia($id_usuario)
	{
		$model_sms = UsuarioSms::model()->findByPk($id_usuario);
		$ids_clientes[] = $model_sms->id_cliente;
        $ids_usuarios[] = $id_usuario;

        $sql = "SELECT GROUP_CONCAT(id_usuario) AS cadena FROM usuario WHERE creado = :id_usuario";
        $sql = Yii::app()->db_sms->createCommand($sql);
        $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_STR);
        $sql = $sql->queryRow();
        
        $cadena = trim(preg_replace('/,{2,}/', ",", $sql["cadena"]), ",");

        while ($cadena != "")
        {
        	$ids_usuarios[] = $cadena;
        	$sql = "SELECT GROUP_CONCAT(id_usuario) AS cadena FROM usuario WHERE creado IN (".$cadena.")";
            $sql = Yii::app()->db_sms->createCommand($sql)->queryRow();
            $cadena = trim(preg_replace('/,{2,}/', ",", $sql["cadena"]), ",");
        }

        $ids_usuarios = implode(",", $ids_usuarios);
        $ids_usuarios = trim(preg_replace('/,{2,}/', ",", $ids_usuarios), ",");

        $sql = "SELECT DISTINCT GROUP_CONCAT(id_cliente) AS clientes FROM cliente WHERE creado IN(".$ids_usuarios.")";
        $sql = Yii::app()->db_sms->createCommand($sql)->queryRow();

        $ids_clientes[] = $sql["clientes"];
		$ids_clientes = implode(",", $ids_clientes);
        $ids_clientes = trim(preg_replace('/,{2,}/', ",", $ids_clientes), ",");        

        if ($ids_clientes != "")
        	return $ids_clientes;
        else return "null";
	}

	public function getUsuariosBCNLHerencia($id_usuario)
	{
		$model_sms = UsuarioSms::model()->findByPk($id_usuario);
        $ids_usuarios[] = $id_usuario;

        $sql = "SELECT GROUP_CONCAT(id_usuario) AS cadena FROM usuario WHERE creado = :id_usuario";
        $sql = Yii::app()->db_sms->createCommand($sql);
        $sql->bindParam(":id_usuario", $id_usuario, PDO::PARAM_STR);
        $sql = $sql->queryRow();
        
        $cadena = trim(preg_replace('/,{2,}/', ",", $sql["cadena"]), ",");

        while ($cadena != "")
        {
        	$ids_usuarios[] = $cadena;
        	$sql = "SELECT GROUP_CONCAT(id_usuario) AS cadena FROM usuario WHERE creado IN (".$cadena.")";
            $sql = Yii::app()->db_sms->createCommand($sql)->queryRow();
            $cadena = trim(preg_replace('/,{2,}/', ",", $sql["cadena"]), ",");
        }

        $ids_usuarios = implode(",", $ids_usuarios);
        $ids_usuarios = trim(preg_replace('/,{2,}/', ",", $ids_usuarios), ",");

        if ($ids_usuarios != "")
        	return $ids_usuarios;
        else return "null";
	}

	public function getUsuariosBCNLHerenciaInversa($id_usuario)
	{
		$model_sms = UsuarioSms::model()->findByPk($id_usuario);
		$ids_usuarios[] = $model_sms->id_usuario;

		$sql = "SELECT id_usuario, creado FROM usuario WHERE id_usuario = ".$model_sms->creado;
        $sql = Yii::app()->db_sms->createCommand($sql)->queryRow();

        while ($sql["id_usuario"] != "") //Goadmin
        {
        	$ids_usuarios[] = $sql["id_usuario"];
        	$sql = "SELECT id_usuario, creado FROM usuario WHERE id_usuario = ".$sql["creado"];
        	$sql = Yii::app()->db_sms->createCommand($sql)->queryRow();
        }

        return implode(",", $ids_usuarios);
	}

	public function clienteIsHipicoLotero($id_cliente)
	{
		$sql = "SELECT COUNT(*) t FROM clientes_tipos AS t, clientes_etiquetas AS e 
				WHERE t.id_cliente = :id_cliente AND t.id_etiqueta=e.id AND (e.etiqueta = 'HIPICO' OR e.etiqueta = 'LOTERO')";
				
		$sql = Yii::app()->db_insignia_admin->createCommand($sql);
        $sql->bindParam(":id_cliente", $id_cliente, PDO::PARAM_STR);
        $sql = $sql->queryRow();

        if ($sql["t"] > 0)
        	return true;
        else return false;
	}

	public function getScClienteBCNL($id_cliente)
	{
		$sql = "SELECT GROUP_CONCAT(DISTINCT(p.id_sc)) AS cadena_sc FROM producto p "
	            . "INNER JOIN cliente c on p.cliente = c.Id_cliente "
	            . "WHERE c.id_cliente = :id_cliente "
	            . "AND p.desc_producto NOT LIKE 'CERRADO%' ";
	    $sql = Yii::app()->db_sms->createCommand($sql);
	    $sql->bindParam(":id_cliente", $id_cliente, PDO::PARAM_STR);
        $sql = $sql->queryRow();
	    $cadena_sc = trim(preg_replace('/,{2,}/', ",", $sql["cadena_sc"]), ",");
	    
	    if ($cadena_sc == "")
	    	$cadena_sc = "null"; //Esto evita que el query explote en caso de no tener productos asociados al cliente

	    $sql = "SELECT GROUP_CONCAT(DISTINCT(sc_id)) AS cadena_sc FROM sc_id WHERE id_sc IN (".$cadena_sc.")";
	    $cadena_sc = Yii::app()->db_sms->createCommand($sql)->queryRow();

	    return $cadena_sc["cadena_sc"];
	}

	public function setLog($descripcion)
	{
		$id_usuario = 0;

		if (isset(Yii::app()->user->id))
			$id_usuario = Yii::app()->user->id;
		
		$model = new Log;
		$model->id_usuario = $id_usuario;
		$model->ip_usuario = Yii::app()->request->userHostAddress;
		$model->ip_servidor = Yii::app()->request->serverName;
		$model->fecha = date("Y-m-d");
		$model->hora = date("H:i:s");
		$model->descripcion = $descripcion;
		$model->controller_action = Yii::app()->request->queryString;
		$model->save();
	}

	public function setNotificacion($id_usuario, $asunto, $mensaje)
	{
		$model = new Notificaciones;
		$model->id_usuario = $id_usuario;
		$model->asunto = $asunto;
		$model->mensaje = $mensaje;
		$model->fecha = date("Y-m-d");
		$model->hora = date("H:i:s");
		$model->estado = 0;
		$model->save();
	}
}

?>