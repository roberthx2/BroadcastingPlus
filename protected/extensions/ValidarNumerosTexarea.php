<?php
Class ValidarNumerosTexarea extends CValidator
{
	public function validateAttribute($object, $attribute)
	{
		$patron = "/^[0-9\s,]+$/";

		if (!preg_match($patron, $object->$attribute))
			$this->addError($object, $attribute, "Solo se permiten números y coma (,)");
	}
}
?>