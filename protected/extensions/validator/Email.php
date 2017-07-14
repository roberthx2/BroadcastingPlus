<?php

Class Email extends CValidator
{
	public function validateAttribute($object, $attribute)
	{
		if ($object->$attribute != "")
		{ 
			$patron = "/^[_A-Za-z0-9-+]+(\\.[_A-Za-z0-9-+]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/";

			if (!preg_match($patron, $object->$attribute))
				$this->addError($object, $attribute, "Correo incorrecto");
		}
	}
}

?>