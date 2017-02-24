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

	public function getUltimoDiaMes($ano, $mes)
	{
		$month = date($mes);
        $year = date($ano);
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
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

	public function getColorLabelEstadoPromocionesBCNL($id_estado)
	{
		$objeto = array();

		if($id_estado == 1)
			$objeto = array('label'=> 'No confirmada', 'background_color' => '#999');
		elseif ($id_estado == 2)
			$objeto = array('label'=> 'Confirmada', 'background_color' => '#337ab7');
		elseif ($id_estado == 3)
			$objeto = array('label'=> 'Enviada', 'background_color' => '#5cb85c');
		elseif ($id_estado == 4)
			$objeto = array('label'=> 'En transito', 'background_color' => '#f0ad4e');
		elseif ($id_estado == 5)
			$objeto = array('label'=> 'Cancelada', 'background_color' => '#d9534f');
		elseif ($id_estado == 6)
			$objeto = array('label'=> 'Incompleta', 'background_color' => '#FC6E51');
		elseif ($id_estado == 7)
			$objeto = array('label'=> 'No enviada', 'background_color' => '#434A54');
		elseif ($id_estado == 8)
			$objeto = array('label'=> 'Enviada y Cancelada', 'background_color' => '#967ADC');

		return $objeto;
	}

	public function getColorLabelEstadoPromocionesBCP($id_estado)
	{
		$objeto = array();

		if($id_estado == 0)
			$objeto = array('label'=> 'No confirmada', 'background_color' => '#999');
		elseif ($id_estado == 1)
			$objeto = array('label'=> 'Enviada', 'background_color' => '#5cb85c');
		elseif ($id_estado == 2)
			$objeto = array('label'=> 'Confirmada', 'background_color' => '#337ab7');
		elseif ($id_estado == 3)
			$objeto = array('label'=> 'Incompleta', 'background_color' => '#FC6E51');
		elseif ($id_estado == 4)
			$objeto = array('label'=> 'Cancelada', 'background_color' => '#d9534f');
		elseif ($id_estado == 5)
			$objeto = array('label'=> 'No enviada', 'background_color' => '#434A54');
		elseif ($id_estado == 6)
			$objeto = array('label'=> 'En transito', 'background_color' => '#f0ad4e');
		elseif ($id_estado == 7)
			$objeto = array('label'=> 'Enviada y Cancelada', 'background_color' => '#967ADC');

		return $objeto;
	}

	public function getColorLabelEstadoDestinatarioBCP($id_estado)
	{
		if($id_estado == 0) //No confirmado
			$color = '#999';
		elseif ($id_estado == 1) //Enviado
			$color ='#5cb85c';
		elseif ($id_estado == 2) //Confirmado
			$color = '#337ab7';
		elseif ($id_estado == 3) //Transito
			$color = '#f0ad4e';
		elseif ($id_estado == 4) //Cancelado
			$color = '#d9534f';
		elseif ($id_estado == 5) //No enviado
			$color = '#434A54';

		return $color;
	}

	public function getColorLabelEstadoDestinatarioBCNL($id_estado)
	{
		if($id_estado == 1) //No confirmado
			$color = '#999';
		elseif ($id_estado == 2) //Confirmado
			$color = '#337ab7';
		elseif ($id_estado == 3) //Enviado
			$color = '#5cb85c';
		elseif ($id_estado == 4) //Transito
			$color = '#f0ad4e';
		elseif ($id_estado == 5) //Cancelado
			$color = '#d9534f';
		elseif ($id_estado == 6 || $id_estado = 7 || $id_estado = 8) //Suspendido por problemas / Fallido / Balanceado
			$color = '#434A54';

		return $color;
	}

	public function getColorLabelEstadoReportes($id_estado)
	{
		if($id_estado == 0) //Cuando el numero de Enviados/No enviados en igual a cero
			$color = '#999';
		elseif($id_estado == 1) //No envidado
			$color = '#d9534f';
		elseif ($id_estado == 2) //Enviado
			$color = '#5cb85c';
		elseif ($id_estado == 3) //Label total 
			$color = '#337ab7';
		return $color;
	}

	public function formatearNumero($numero)
	{
		$numero_tmp = false;

		if (strlen($numero)==10) //Numeros sin cero (416,426,414,424,412)
		{
			if (substr($numero, 0, 2) == "41" || substr($numero, 0, 2) == "42")
			{
				$numero_tmp = $numero;
			}
			else if (substr($numero, 0, 3) == "158") //1581234567
			{
				$numero_tmp = "416".substr($numero, 3);
			}
			else if (substr($numero, 0, 3) == "199") //1991234567
			{
				$numero_tmp = "426".substr($numero, 3);
			}

		}
		else if (strlen($numero) > 10)
		{	//Numeros con cero (0416,0426,0414,0424,0412)
			if (substr($numero, 0, 3) == "041" || substr($numero, 0, 3) == "042")
			{
				$numero_tmp = substr($numero, 1);
			}
			else if (substr($numero, 0, 2) == "58")
			{
				$numero_tmp = substr($numero, 2);
			}
		}

		return $numero_tmp;
	}
}

?>