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
}

?>