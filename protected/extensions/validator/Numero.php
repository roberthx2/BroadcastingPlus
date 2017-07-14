<?php

Class Numero extends CValidator
{
	public function validateAttribute($object, $attribute)
	{
		if ($object->$attribute != "")
		{ 
			$patron = "/^[0-9]+$/";

			if (!preg_match($patron, $object->$attribute))
				$this->addError($object, $attribute, "Solo se permiten números");
		}

		if (strlen($object->$attribute) > 10)
		{ 
			$this->addError($object, $attribute, "El número debe ser de 10 digitos");
		}
	}
}

?>