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
				$model->fecha = date("Y-m-d");
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

	public function setNumerosPersonalizadosTmpProcesamiento($id_proceso, $numeros)
	{
		$numeros = implode(", ", $numeros);
		$numeros = str_replace("#id_proceso#", $id_proceso, $numeros);
		$sql = "INSERT INTO tmp_procesamiento (id_proceso, numero, mensaje) VALUES ".$numeros;
		$sql = Yii::app()->db_masivo_premium->createCommand($sql)->execute();
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
        $sql = "SELECT GROUP_CONCAT(DISTINCT id_cliente_sms) AS ids_clientes FROM clientes_bcp "
        		. "WHERE id_cliente_sms IN (".$this->getClienteBCNLHerencia($id_usuario).")";
       	$sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

       	$ids_clientes = ($sql["ids_clientes"] == "") ? "null" : $sql["ids_clientes"];
        
		$sql = "SELECT c.id_cliente AS id_cliente, c.Des_cliente AS descripcion FROM cliente c "
				. "WHERE c.id_cliente IN (".$ids_clientes.") " 
				. "ORDER BY c.Des_cliente ASC";        

        $model = Yii::app()->db_sms->createCommand($sql)->queryAll();

        return $model;
	}

	public function getClienteBCPHostgator()
	{
		if (Yii::app()->user->isAdmin())
		{
			$sql = "SELECT GROUP_CONCAT(DISTINCT id) AS id_clientes FROM cliente"; 
		}
		else
		{
			$sql = "SELECT GROUP_CONCAT(DISTINCT cb.id_cliente_bcp) AS id_clientes FROM usuario_clientes_bcp uc
				INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
				INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
				WHERE uc.id_usuario = ".Yii::app()->user->id." AND c.onoff = 1";
		}

		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

		$resultado = ($sql["id_clientes"] == "") ? "null" : $sql["id_clientes"];

        return $resultado;
	}

	public function getClienteBCPHostgatorForClienteSMS($id_cliente_sms)
	{
		if (Yii::app()->user->isAdmin())
		{
			$sql = "SELECT GROUP_CONCAT(DISTINCT id) AS id_clientes FROM cliente WHERE id_cliente_sms = ".$id_cliente_sms; 
		}
		else
		{
			$sql = "SELECT GROUP_CONCAT(DISTINCT cb.id_cliente_bcp) AS id_clientes FROM usuario_clientes_bcp uc
				INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
				INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
				WHERE uc.id_usuario = ".Yii::app()->user->id." AND cb.id_cliente_sms = ".$id_cliente_sms." AND c.onoff = 1";
		}

		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

		$resultado = ($sql["id_clientes"] == "") ? "null" : $sql["id_clientes"];

        return $resultado;
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

	public function getScClienteBCP($id_cliente_sms)
	{
		if (Yii::app()->user->isAdmin())
		{
			$sql = "SELECT DISTINCT c.sc FROM clientes_bcp cb 
				INNER JOIN cliente c ON cb.id_cliente_bcp = c.id 
				WHERE cb.id_cliente_sms = :id_cliente_sms AND cb.alfanumerico = 0 AND c.onoff = 1"; 
		}
		else
		{
			$cadena_sc = Yii::app()->Funciones->limpiarNumerosTexarea(Yii::app()->user->getCadenaSc());
			$cadena_sc = ($cadena_sc == "") ? "null" : $cadena_sc;

			$criteria = new CDbCriteria;
			$criteria->select = "GROUP_CONCAT(DISTINCT sc_id) AS sc_id";
			$criteria->addInCondition("id_sc", explode(",", $cadena_sc));
			$sc_id = ScId::model()->find($criteria);
			$cadena_sc = ($sc_id->sc_id == "") ? "null" : $sc_id->sc_id;

			$sql = "SELECT DISTINCT c.sc FROM usuario_clientes_bcp uc
				INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
				INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
				WHERE uc.id_usuario = ".Yii::app()->user->id." AND cb.id_cliente_sms = :id_cliente_sms AND cb.alfanumerico = 0 AND c.sc IN (".$cadena_sc.") AND c.onoff = 1";
		}

		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_cliente_sms", $id_cliente_sms, PDO::PARAM_INT);
        $sql = $sql->queryAll();

        return $sql;
	}

	public function getScOperadorasBCP($id_cliente_sms, $sc)
	{
		if (Yii::app()->user->isAdmin())
		{
			/*$sql = "SELECT c.sc, id_operadora, alfanumerico FROM clientes_bcp cb 
					INNER JOIN cliente c ON cb.id_cliente_bcp = c.id 
					WHERE cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1";*/

			$sql = "SELECT t.* FROM (
					SELECT c.id, c.sc, id_operadora, alfanumerico FROM clientes_bcp cb 
					INNER JOIN cliente c ON cb.id_cliente_bcp = c.id 
					WHERE cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1) AS t
					INNER JOIN operadora_cliente oc ON t.id = oc.id_cliente AND t.id_operadora = oc.id_op
					GROUP BY oc.id_op, alfanumerico";
		}
		else
		{
			/*$sql = "SELECT c.sc, id_operadora, alfanumerico FROM usuario_clientes_bcp uc
					INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
					INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
					WHERE uc.id_usuario = ".Yii::app()->user->id." AND cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1";*/

			$sql = "SELECT t.* FROM (
					SELECT c.id, c.sc, cb.id_operadora, alfanumerico FROM usuario_clientes_bcp uc
					INNER JOIN clientes_bcp cb ON uc.id_cliente_bcp = cb.id
					INNER JOIN cliente c ON cb.id_cliente_bcp = c.id
					WHERE uc.id_usuario = ".Yii::app()->user->id." AND cb.id_cliente_sms = :id_cliente_sms AND cb.sc = :sc AND c.onoff = 1) AS t
					INNER JOIN operadora_cliente oc ON t.id = oc.id_cliente AND t.id_operadora = oc.id_op
					GROUP BY oc.id_op, alfanumerico";
		}

		$sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
        $sql->bindParam(":id_cliente_sms", $id_cliente_sms, PDO::PARAM_INT);
        $sql->bindParam(":sc", $sc, PDO::PARAM_INT);
        $sql = $sql->queryAll();

        return $sql;
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
		$model->controller_action = "r=".Yii::app()->controller->id."/".Yii::app()->controller->action->id;
		//Yii::app()->request->queryString; //No funciona para url encriptadas
		$model->save();
	}

	public function setNotificacion($id_usuario, $id_usuario_creador, $asunto, $mensaje)
	{
		$model = new Notificaciones;
		$model->id_usuario = $id_usuario;
		$model->id_usuario_creador = $id_usuario_creador;
		$model->asunto = $asunto;
		$model->mensaje = $mensaje;
		$model->fecha = date("Y-m-d");
		$model->hora = date("H:i:s");
		$model->estado = 0;
		$model->save();
	}

	public function getNumerosValidosPorOperadoraBCP($id_proceso)
    {
    	$objeto = array();

        $sql = "SELECT o.descripcion, id_operadora_bcnl, COUNT(id) AS total FROM tmp_procesamiento t "
                . "INNER JOIN ("
                    . "SELECT descripcion, id_operadora_bcnl FROM operadoras_relacion GROUP BY id_operadora_bcnl"
                . ") o ON o.id_operadora_bcnl = t.id_operadora "
                . "WHERE t.id_proceso = ".$id_proceso." AND t.estado = 1 "
                . "GROUP BY t.id_operadora";
        $sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();
        
        foreach($sql as $value)
        {
            $objeto[$value["id_operadora_bcnl"]] = array("nombre"=>$value["descripcion"], "total"=>$value["total"]);
        }
        
        return $objeto;
    }

    public function getScNumerico($id_cliente)
    {
        $sql = "SELECT CASE 
                    WHEN c.sc NOT REGEXP '[a-zA-Z]+' 
                    THEN c.sc 
                    ELSE (SELECT cc.sc FROM cliente cc WHERE cc.id = c.id_cliente_sc_numerico) END AS sc FROM cliente c 
                    WHERE c.id = ".$id_cliente;
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

        return $sql["sc"];
    }

    public function getIntervalMinute()
    {
        $dia_semana = date("w", strtotime(date("Y-m-d")));
        $hora_ini = date("H:i:s");
        $interval_minute["interval_minute"] = 1;
        $interval_minute["hora_ini"] = date("H:i");
        $interval_minute["hora_fin"] = date('H:i' , strtotime('+1 hours', strtotime(date("H:i"))));

        $dia_activo = ConfiguracionReservacionPorDia::model()->COUNT("id_dia=:id_dia AND estado = 1", array(":id_dia"=>$dia_semana));

        if ($dia_activo > 0)
        {
            $criteria = new CDbCriteria;
            $criteria->select = "propiedad, valor";
            $criteria->addInCondition("propiedad", array('intervalo_reservacion', 'hora_inicio_bcp', 'hora_fin_reservacion'));
            $resultado = ConfiguracionSistema::model()->findAll($criteria);

            foreach ($resultado as $value)
            {
                if ($value["propiedad"] == 'intervalo_reservacion')
                    $intervalo_reservacion = $value["valor"];
                else if ($value["propiedad"] == 'hora_inicio_bcp')
                    $hora_ini_reservacion = $value["valor"];
                else if ($value["propiedad"] == 'hora_fin_reservacion')
                    $hora_fin_reservacion = $value["valor"];
            }
            
            if ( strtotime($hora_ini) >= strtotime($hora_ini_reservacion) && strtotime($hora_ini) <= strtotime($hora_fin_reservacion) ) 
            {
				$interval_minute["interval_minute"] = (int)$intervalo_reservacion;
				$resultado = $this->getTimeSlot($hora_ini);
				$interval_minute["hora_ini"] = $resultado["hora_ini"];
				$interval_minute["hora_fin"] = $resultado["hora_fin"];
            } 
        }

        return $interval_minute;
    }

    public function getTimeSlot($hora_actual)
    {
        $criteria = new CDbCriteria;
        $criteria->select = "propiedad, valor";
        $criteria->addInCondition("propiedad", array('intervalo_reservacion', 'hora_inicio_bcp'));
        $resultado = ConfiguracionSistema::model()->findAll($criteria);
        
        foreach ($resultado as $value)
        {
            if ($value["propiedad"] == 'intervalo_reservacion')
                $intervalo = $value["valor"];
            else if ($value["propiedad"] == 'hora_inicio_bcp')
                $hora_ini = $value["valor"];
        }
        
        $hora_fin = date("H:i:00", strtotime ( +$intervalo.'minute' , strtotime ( $hora_ini ) ));
        return $this->getTimeSlotPrivate($hora_actual, $hora_ini, $hora_fin, $intervalo);
    }
    
    private function getTimeSlotPrivate($hora_actual, $hora_ini, $hora_fin, $intervalo)
    {
        if ( strtotime($hora_actual) >= strtotime($hora_ini) && strtotime($hora_actual) < strtotime($hora_fin) )
        {
            $objeto = array("hora_ini"=>$hora_ini, "hora_fin"=>$hora_fin);
            return $objeto;
        }
        else
        {
            $hora_ini = $hora_fin;
            $hora_fin = date("H:i:00", strtotime ( +$intervalo.'minute' , strtotime ( $hora_fin ) ));
            return $this->getTimeSlotPrivate($hora_actual, $hora_ini, $hora_fin, $intervalo);
        
        }
    }

    public function getMinDateHistorial()
    {
    	$model = ConfiguracionSistema::model()->find("propiedad=:propiedad", array(":propiedad"=>"max_mes_consultas_historial"));
    
    	return date('Y-m-d' , strtotime(-$model->valor.' month', strtotime(date("Y-m-d"))));
    }
}

?>