<?php

class Filtros extends CApplicationComponent
{
	private function getOperadorasBCNL()
	{
		$criteria = new CDbCriteria();
		$criteria->select = "id_operadora_bcnl AS id_operadora, prefijo, descripcion";
		$criteria->group = "prefijo";
		$criteria->order = "id_operadora_bcnl ASC";

		return OperadorasRelacion::model()->findAll($criteria);
	}

	//COMENTADO POR CAMBIO DE VERSION
	/*private function getOperadorasBCP($digitel_alf)
	{
		if ($digitel_alf)
			$digitel = 5;
		else $digitel = 6;

		$criteria = new CDbCriteria;
		$criteria->select = "id_operadora_bcp AS id_operadora, prefijo, descripcion";
		$criteria->addCondition("id_operadora_bcp != :id_operadora_bcp");
		$criteria->order = "id_operadora_bcp ASC";
		$criteria->params = array(":id_operadora_bcp"=>$digitel);

		return OperadorasRelacion::model()->findAll($criteria);
	}*/

	public function getOperPrefijoBCP()
	{
		$criteria = new CDbCriteria;
		$criteria->select = "id_operadora_bcp, prefijo";
		$criteria->compare("alfanumerico", 0);
		$criteria->order = "id_operadora_bcp ASC";
	}

	private function updateOperadoraTblProcesamiento($id_proceso, $operadoras)
	{
		foreach ($operadoras as $value)
		{
			$sql = "UPDATE tmp_procesamiento SET id_operadora = ".$value["id_operadora"]." WHERE id_proceso = :id_proceso AND numero REGEXP '^".$value["prefijo"]."' AND LENGTH(numero) = 10";
			$sql = Yii::app()->db_masivo_premium->createCommand($sql);
        	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
        	$sql->execute();
		}

		$sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND id_operadora IS NULL";
		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
    	$id = $sql->queryRow();

    	if ($id["ids"] != "")
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 2 WHERE id IN(".$id["ids"].")";
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}
	}

	//$tipo = 1 (BCNL) / 2 (BCP).... $alfanumerico (DIGITEL) = true / false
	public function filtrarInvalidosPorOperadora($id_proceso)
	{
		$operadoras = $this->getOperadorasBCNL();

		$this->updateOperadoraTblProcesamiento($id_proceso, $operadoras);
	}

	public function filtrarDuplicados($id_proceso)
	{
		//NO USE CRITERIA PORQUE NO QUISO FUNCIONAR :@
		$sql = "SELECT COUNT(numero) - 1 AS total, GROUP_CONCAT(id) AS ids
				FROM tmp_procesamiento 
				WHERE id_proceso = :id_proceso  
				GROUP BY numero
				HAVING total > 0";

		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
    	$model = $sql->queryAll();
				
		foreach ($model as $value)
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 3 WHERE id IN (".$value["ids"].") LIMIT ".$value["total"];
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}
	}

	public function filtrarAceptados($id_proceso)
	{
		$sql = "UPDATE tmp_procesamiento SET estado = 1 WHERE id_proceso = :id_proceso AND estado IS NULL";
		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
    	$sql->execute();
	}

	public function filtrarOperadoraPermitida($id_proceso, $operadorasPermitidas)
	{
		$sql = "UPDATE tmp_procesamiento SET estado = 6 WHERE id_proceso = :id_proceso AND estado IS NULL AND id_operadora NOT IN (".$operadorasPermitidas.")";
		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
    	$sql->execute();	
	}

	public function filtrarExentos($id_proceso, $tipo, $operadorasPermitidas)
	{
		//FALTA EL FILTRO DE EXENTOS DE F1

		$this->fltrarExentosF2($id_proceso, $tipo, $operadorasPermitidas);
	}

	private function fltrarExentosF2($id_proceso, $tipo, $operadorasPermitidas)
	{
		//TIPO = 1 BCNL / CPEI
		//TIPO = 2 BCP

		if ($tipo == 1)
		{
			//Exentos cortos
			$sql = "SELECT GROUP_CONCAT(CONCAT('^', numero) SEPARATOR '|') AS regexp_ex FROM tmp_exentos WHERE tipo = 2";
        	$regexp_exentos = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

        	$sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND numero_btl IS NULL AND ( numero REGEXP ('".$regexp_exentos['regexp_ex']."') OR numero IN (SELECT numero FROM tmp_exentos WHERE tipo = 1) )";
		}
		else if ($tipo == 2)
		{
			//Exentos cortos
			$sql = "SELECT GROUP_CONCAT(CONCAT('^', numero) SEPARATOR '|') AS regexp_ex FROM tmp_exentos WHERE id_operadora IN (".$operadorasPermitidas.") AND tipo = 2";
        	$regexp_exentos = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

        	$sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND numero_btl IS NULL AND ( numero REGEXP ('".$regexp_exentos['regexp_ex']."') OR numero IN (SELECT numero FROM tmp_exentos WHERE id_operadora IN (".$operadorasPermitidas.") AND tipo = 1) )";
		}
		
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
    	$id = $sql->queryRow();

    	if ($id["ids"] != "")
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 4 WHERE id IN(".$id["ids"].")";
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}
	}

	/*private function fltrarExentosF2($id_proceso)
	{
		$sql = "SELECT GROUP_CONCAT(CONCAT('^', SUBSTRING(e.numero, 2)) SEPARATOR '|') AS regexp_ex FROM exentos e WHERE LENGTH(numero) < 11";
        $regexp_exentos = Yii::app()->db->createCommand($sql)->queryRow();

        $sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND numero_btl IS NULL AND ( numero REGEXP ('".$regexp_exentos['regexp_ex']."') OR numero IN (SELECT SUBSTRING(numero, 2) AS numero FROM insignia_masivo.exentos WHERE LENGTH(numero) = 11) )";
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_STR);
    	$id = $sql->queryRow();

    	if ($id["ids"] != "")
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 4 WHERE id IN(".$id["ids"].")";
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}
	}*/

	public function filtrarSmsXNumero($id_proceso, $tipo, $operadorasPermitidas)
	{
		//TIPO = 1 BCNL / CPEI
		//TIPO = 2 BCP

		if ($tipo == 1)
		{
			$sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND numero_btl IS NULL AND numero NOT IN (SELECT numero FROM tmp_smsxnumero)";
		}
		else if ($tipo == 2)
		{
			$sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND numero_btl IS NULL AND numero NOT IN (SELECT numero FROM tmp_smsxnumero WHERE id_operadora IN(".$operadorasPermitidas."))";
		}

		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
		$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
		$id = $sql->queryRow();

		if ($id["ids"] != "")
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 5 WHERE id IN(".$id["ids"].")";
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}
	}

	public function filtrarPorCargaDiaria($id_proceso, $sc, $fecha, $operadorasPermitidas)
	{
		//Obtengo el numero del dia de la semana para la fecha en que sera enviada la promocion
        $dia_semana = date("w", strtotime($fecha));

        $sql = "SELECT cantidad FROM configuracion_sms_por_dia WHERE id_dia = ".$dia_semana;
        $cant_sms = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

        //Obtengo la cadena de numeros cargados para el dia en que se enviara la promocion.
        //Solo los numeros cuya operadora este permitida para el envio y que exedan el maximo permitido por dia.
        $sql = "SELECT GROUP_CONCAT(numero) AS numeros FROM ("
                . "SELECT numero FROM tmp_numeros_cargados_por_dia "
                . "WHERE fecha = '".$fecha."' AND sc = ".$sc." AND id_operadora IN(".$operadorasPermitidas.") "
                . "GROUP BY numero HAVING COUNT(id) >= ".$cant_sms["cantidad"].") AS tabla";
        $numeros_cargados = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

        //En caso de ser la primera promocion no existiran numeros para el dia
        if ($numeros_cargados["numeros"] != "") 
        {
            $numeros_cargados = '"'.str_replace(',', '","', $numeros_cargados["numeros"]).'"';
            
            $sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND numero IN (".$numeros_cargados.")";
            $sql = Yii::app()->db_masivo_premium->createCommand($sql);
			$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
			$id = $sql->queryRow();
        }

        if (isset($id) && $id["ids"] != "")
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 9 WHERE id IN(".$id["ids"].")";
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}	
	}

	public function filtrarCupo($id_proceso, $cupo)
	{
		$sql = "SELECT id FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL LIMIT ".$cupo.", 999999"; //Se utiliza un numero lo suficientemente grande para el limite superior
		$sql = Yii::app()->db_masivo_premium->createCommand($sql);
		$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_STR);
		$sql = $sql->queryAll();

		$ids = array();
            
        foreach ($sql as $value)
        {
            $ids[] = $value["id"];
        }
        
        $ids = implode(",", $ids);

        if ($ids != "")
        {
        	$sql = "UPDATE tmp_procesamiento SET estado = 7 WHERE id IN (".$ids.")";
        	Yii::app()->db_masivo_premium->createCommand($sql)->execute();
        }
	}

	public function filtrarPorcentajeOperadora($id_proceso, $id_cliente)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "valor";
		$criteria->compare("propiedad","id_operadora_base_bcnl");
		$resultado = ConfiguracionSistema::model()->find($criteria);

		$model_porcentaje = ConfiguracionEnviosUsuario::model()->findAll("id_usuario = ".Yii::app()->user->id);

		if ($model_porcentaje == null)
		{
			$sql = "SELECT t.id_etiqueta AS tipo FROM clientes_tipos t, clientes_etiquetas e WHERE t.id_cliente = ".$id_cliente." AND t.id_etiqueta=e.id";
			$tipo = Yii::app()->db_insignia_admin->createCommand($sql)->queryRow();

			$model_porcentaje = ConfiguracionEnviosTipoCliente::model()->findAll("id_etiqueta_cliente = ".$tipo["tipo"]);
		}

		$count_num_oper_base = TmpProcesamiento::model()->count("id_proceso=:id_proceso AND estado IS NULL AND id_operadora=:id_operadora", array("id_proceso" => $id_proceso, "id_operadora" => $resultado->valor));

		$operadoas = $this->getOperadorasBCNL();
		$ids = array();

		foreach ($model_porcentaje as $value)
		{	
			//Si es diferente a la operadora base y es menor al 100% permitido realiza el filtrado  
			if ( $value["id_operadora"] != $resultado->valor /*&& $value["porcentaje"] < 100 */) 
			{
				$max_x_oper = floor(($count_num_oper_base * $value["porcentaje"]) / 100);

				$sql = "SELECT id FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado IS NULL AND id_operadora = ".$value["id_operadora"]." LIMIT ".$max_x_oper.", 9999999";
	            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();
            
		        foreach ($sql as $key)
		        {
		            $ids[] = $key["id"];
		        }
			}
		}

		$ids = implode(",", $ids);

        if ($ids != "")
        {
        	$sql = "UPDATE tmp_procesamiento SET estado = 8 WHERE id IN (".$ids.")";
        	Yii::app()->db_masivo_premium->createCommand($sql)->execute();
        }
	}

	public function filtrarPorcentaje($id_proceso, $porcentaje)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "id_operadora, COUNT(*) AS buscar";
		$criteria->compare("id_proceso", $id_proceso);
		$criteria->group = "id_operadora";

		$model = TmpProcesamiento::model()->findAll($criteria);

		foreach ($model as $value)
		{
			$limite_inferior = floor($value->buscar * $porcentaje);

			$sql = "SELECT id FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND id_operadora = ".$value->id_operadora." LIMIT ".$limite_inferior.", 999999";

			$sql = Yii::app()->db_masivo_premium->createCommand($sql);
	    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
	    	$sql = $sql->queryAll();

	    	$ids = array();

	    	foreach ($sql as $value)
	        {
	            $ids[] = $value["id"];
	        }
	        
	        $ids = implode(",", $ids);

	    	if ($ids != "")
			{
				$sql = "UPDATE tmp_procesamiento SET estado = 10 WHERE id IN(".$ids.")";
				Yii::app()->db_masivo_premium->createCommand($sql)->execute();
			}
		}
	}

	public function filtrarOperadoraHabilitada($id_proceso)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(id_operadora) AS id_operadora";
		$criteria->compare("estado", 1);

		$model = OperadorasActivas::model()->find($criteria);
		$ids_operadoras = ($model->id_operadora == "") ? "0" : $model->id_operadora;

		$sql = "UPDATE tmp_procesamiento SET estado = 11 WHERE id_proceso = ".$id_proceso." AND id_operadora NOT IN (".$ids_operadoras.")";
		Yii::app()->db_masivo_premium->createCommand($sql)->execute();
	}

	//Aplica solo para al agregar numeros a las listas de exentos por ususario
	public function filtrarNumerosAdministrativos($id_proceso)
	{
        $sql = "SELECT GROUP_CONCAT(id) AS ids FROM tmp_procesamiento WHERE id_proceso = :id_proceso AND estado IS NULL AND numero IN (SELECT numero FROM contactos_administrativos WHERE estado = 1)";
		
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
    	$sql->bindParam(":id_proceso", $id_proceso, PDO::PARAM_INT);
    	$id = $sql->queryRow();

    	if ($id["ids"] != "")
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 10 WHERE id IN(".$id["ids"].")";
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}	
	}
}

?>