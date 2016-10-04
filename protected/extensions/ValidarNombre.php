<?php
Class ValidarNombre extends CValidator
{
	public function validateAttribute($object, $attribute)
	{
		$patron = "/^[0-9a-zA-Z\s_.]+$/";

		if (!preg_match($patron, $object->$attribute))
			$this->addError($object, $attribute, "Solo se permiten letras, números, espacios, punto y piso.");
	}
}
?>