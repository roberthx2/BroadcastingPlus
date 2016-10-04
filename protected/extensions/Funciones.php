<?php

class Funciones extends CApplicationComponent
{
	public function limpiarNumerosTexarea($cadena)
	{
		return trim(preg_replace('/,{2,}/', ",", str_replace(' ', "", $cadena)), ",");
	}

	public function limpiarNombre($cadena)
	{
		return strtoupper(trim(preg_replace('/\s{2,}/', " ", $cadena)));
	}

	public function obtenerNumeroProceso()
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
				$model->save();
				$valido = false;
			}
			
		} while ($valido);

		return $proceso;
	}

	public function operadorasBCNL()
	{
		$criteria = new CDbCriteria();
		$criteria->select = "id_operadora_bcnl AS id_operadora, prefijo";
		$criteria->group = "prefijo";
		$criteria->order = "id_operadora_bcnl ASC";

		return OperadorasRelacion::model()->findAll($criteria);
	}

	public function operadorasBCP($digitel_alf)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "id_operadora_bcp AS id_operadora, prefijo";
		$criteria->addCondition("id_operadora_bcp != ".$digitel);
		$criteria->order = "id_operadora_bcp ASC";

		return OperadorasRelacion::model()->findAll($criteria);
	}

	public function updateOperadoraTblProcesamiento($id_proceso, $operadoras)
	{
		foreach ($operadoras as $value)
		{
			$sql = "UPDATE tmp_procesamiento SET id_operadora = ".$value["id_operadora"]." WHERE id_proceso = ".$id_proceso." AND numero REGEXP '^".$value["prefijo"]."' AND LENGTH(numero) = 10";
            Yii::app()->db_masivo_premium->createCommand($sql)->execute();
		}
	}
}

?>