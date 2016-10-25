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

	public function limpiarMensaje($sms)
    {
        $sms = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $sms
        );

        $sms = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $sms
        );

        $sms = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $sms
        );

        $sms = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $sms
        );

        $sms = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $sms
        );

        $sms = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $sms
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $sms = str_replace(
            array("¨", "º", "~", "|","·","¿","^", "`","´"),'',$sms);
        
        //Elimina multiples espacios en blanco
        return trim(preg_replace('/\s{2,}/', " ", $sms));
    }

	public function getColorOperadoraBCNL($id_operadora)
	{
		if ($id_operadora == 2) //Movistar
			$color = "#5bc0de";
		else if ($id_operadora == 3) //Movilnet
			$color = "#f0ad4e";
		else if ($id_operadora == 4) //Digitel
			$color = "#d9534f";
		else $color = "#999";

		return $color;
	}

	public function getColorOperadoraBCP($id_operadora)
	{
		if ($id_operadora == 1 || $id_operadora == 2) //Movistar
			$color = "#5bc0de";
		else if ($id_operadora == 3 || $id_operadora == 4) //Movilnet
			$color = "#f0ad4e";
		else if ($id_operadora == 5 || $id_operadora == 6) //Digitel
			$color = "#d9534f";
		else $color = "#999";

		return $color;
	}

	public function getColorValidoInvalido($id_estado)
	{
		if ($id_estado == 1) //Valido
			$color = "#5cb85c";
		else $color = "#d9534f"; //Invalido

		return $color;
	}
}

?>