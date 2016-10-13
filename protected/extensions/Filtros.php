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

	private function getOperadorasBCP($digitel_alf)
	{
		if ($digitel_alf)
			$digitel = 5;
		else $digitel = 6;

		$criteria = new CDbCriteria;
		$criteria->select = "id_operadora_bcp AS id_operadora, prefijo, descripcion";
		$criteria->addCondition("id_operadora_bcp != ".$digitel);
		$criteria->order = "id_operadora_bcp ASC";

		return OperadorasRelacion::model()->findAll($criteria);
	}

	private function updateOperadoraTblProcesamiento($id_proceso, $operadoras)
	{
		foreach ($operadoras as $value)
		{
			$sql = "UPDATE tmp_procesamiento SET id_operadora = ".$value["id_operadora"]." WHERE id_proceso = ".$id_proceso." AND numero REGEXP '^".$value["prefijo"]."' AND LENGTH(numero) = 10";
            Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}

		$sql = "UPDATE tmp_procesamiento SET estado = 2 WHERE id_proceso = ".$id_proceso." AND id_operadora IS NULL";
        Yii::app()->db_masivo_premium->createCommand($sql)->execute();
	}

	//$tipo = 1 (BCNL) / 2 (BCP).... $alfanumerico (DIGITEL) = true / false
	public function filtrarInvalidosPorOperadora($id_proceso, $tipo, $alfnumerico)
	{
		//TIPO = 1 BCNL
		//TIPO = 2 BCP

		if ($tipo == 1)
		{
			$operadoras = $this->getOperadorasBCNL();
		} 
		else if ($tipo == 2)
		{
			$operadoras = $this->getOperadorasBCP($alfnumerico);
		}

		$this->updateOperadoraTblProcesamiento($id_proceso, $operadoras);
	}

	public function filtrarDuplicados($id_proceso)
	{
		//NO USE CRITERIA PORQUE NO QUISO FUNCIONAR :@
		$sql = "SELECT COUNT(numero) - 1 AS total, GROUP_CONCAT(id) AS ids
				FROM tmp_procesamiento 
				WHERE id_proceso = ".$id_proceso." 
				GROUP BY numero
				HAVING total > 0";
				
		$model = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		foreach ($model as $value)
		{
			$sql = "UPDATE tmp_procesamiento SET estado = 3 WHERE id IN (".$value["ids"].") LIMIT ".$value["total"];
			Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}
	}

	public function filtrarAceptados($id_proceso)
	{
		$sql = "UPDATE tmp_procesamiento SET estado = 1 WHERE id_proceso = ".$id_proceso." AND estado IS NULL";
		Yii::app()->db_masivo_premium->createCommand($sql)->execute();
	}
}

?>