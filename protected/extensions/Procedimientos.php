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

		$sql = "INSERT INTO tmp_procesamiento (id_proceso, numero) SELECT id_proceso, numero FROM splitvalues_numeros WHERE id_proceso = ".$id_proceso;
		Yii::app()->db_masivo_premium->createCommand($sql)->execute();
	}

	public function getNumerosValidos($id_proceso)
	{
		$sql = "SELECT COUNT(id_proceso) AS total FROM tmp_procesamiento WHERE id_proceso = ".$id_proceso." AND estado = 1";
		$total = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		return $total["total"];
	}
}

?>