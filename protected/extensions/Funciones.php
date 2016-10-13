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