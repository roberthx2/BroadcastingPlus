<?php
Class ValidarOperadora extends CValidator
{
	public function validateAttribute($object, $attribute)
	{
		$bandera = true;

		$criteria = new CDbCriteria();
		$criteria->select = "id_operadora_bcnl AS id_operadora, prefijo, descripcion";
		$criteria->group = "prefijo";
		$criteria->order = "id_operadora_bcnl ASC";

		$model_operadora = OperadorasRelacion::model()->findAll($criteria);

		foreach ($model_operadora as $value)
		{
			$patron = "/^".$value["prefijo"]."/";

			if (preg_match($patron, $object->$attribute))
			{
				$bandera = false;
				break;
			}
		}

		if ($bandera)
			$this->addError($object, $attribute, "Número invalido");
	}
}
?>