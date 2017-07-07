<?php 

class Levenshtein extends CApplicationComponent
{
	# MAIN
	public function run($sms)
	{
		$criteria = new CDbcriteria;
		$criteria->select = "valor";
		$criteria->compare('propiedad', 'levenshtein_porcentaje');
		$levenshtein = ConfiguracionSistema::model()->find($criteria);

	    $a = $this->levenshteinFunction($sms, $levenshtein->valor);
	    $words = $this->deleteDuplicates($a['coincidencias']);

	    $return = array();

	    if($a['return'] == 1)
	    {
	        // echo 'NO PASA EL MENSAJE, CONTIENE PALABRAS OBSCENAS :( <br>';
	        // echo 'PALABRAS OBSCENAS DEL SMS: '.$words.'<br>';   
	        $return = 1;
	    }
	    else if($a['return'] == 0)
	    {
	        // echo 'PASA EL MENSAJE, NO CONTIENE PALABRAS OBSCENAS :) <br>';   
	        $return = 0;
	    }

	    return array(
	        'return' => $return,
	        'words'  => $words
	    );
	}

	# ALGORITMO DE LEVENSHTEIN
	private function levenshteinAlgorithm($s1,$s2)
	{
	    $l1 = strlen($s1);                   
	    $l2 = strlen($s2);                   
	    $dis = range(0,$l2);                 

	    for($x=1;$x<=$l1;$x++)
	    {
	        $dis_new[0]=$x;

	        for($y=1;$y<=$l2;$y++)
	        {
	            $c = ($s1[$x-1] == $s2[$y-1])?0:1;
	            $dis_new[$y] = min($dis[$y]+1,$dis_new[$y-1]+1,$dis[$y-1]+$c);   
	        }

	    	$dis = $dis_new;              
	  	} 

	  	return $dis[$l2];
	}

	# FUNCIÓN PARA OBTENER LAS PALABRAS DE LA CADENA
	private function getSMSWords($sms)
	{
	    $cleanString = str_replace(array('.', ',', '-', '&'), ' ' , $sms);
	    $arrayString = explode(' ', $sms);

	    return $arrayString;
	}


	# FUNCIÓN PARA EJECUTAR QUERIES
	private function runQuery($db, $query, $return)
	{
	    $stmt = $db->prepare($query);

	    if($stmt != null)
	    	$stmt->execute();

	    if ($return == "rows") 
	    	return $stmt->fetchAll();
	    elseif ($return == "count")
	     	return $stmt->rowCount();
	}

	# FUNCIÓN PARA LIMPIAR CADENA
	private function sanitizeString($string)
	{
	    $arr = array(
	        "4" => "a",
	        "3" => "e",
	        "1" => "i",
	        "0" => "o");

	    $wholeString = strtr($string,$arr);

	    $wholeCleanedString = str_replace(array('.', ',', '-', '&'), ' ' , $wholeString);

	    return $wholeCleanedString;
	}

	# FUNCIÓN PARA FILTRAR LAS PALABRAS DE LA CADENA DEL SMS
	private function filterSMS($sms, $_perc)
	{   
	    $return = 0;

	    $coincidencias = array();
	    $cadena = $this->sanitizeString($sms);
	    $cadena = strtolower($cadena);

	    $arregloCadena = explode(' ', $cadena);

	    $sql = "SELECT palabra FROM palabras_obscenas";
        $palabras = Yii::app()->db->createCommand($sql)->queryAll();

	    foreach ($arregloCadena as $value) 
	    {
	        foreach ($palabras as $p) 
	        {
	            $distance  = $this->levenshteinAlgorithm($value, $p['palabra']);
	            $sizeValue = strlen($value);
	            $sizeP     = strlen($p['palabra']);
	            $perc = "";

	            if($sizeValue < $sizeP)
	            {
	                $perc = ($sizeP - $distance) / $sizeP;
	                $perc = round($perc * 100, 2);
	            }
	            else if($sizeValue > $sizeP)
	            {
	                $perc = ($sizeValue - $distance) / $sizeValue;
	                $perc = round($perc * 100, 2);
	            }
	            else if($sizeValue == $sizeP)
	            {
	                $perc = ($sizeP - $distance) / $sizeValue;
	                $perc = round($perc * 100, 2);
	            }

	            if($perc > $_perc)
	            {
	                array_push($coincidencias, array(
	                            'palabraSMS'   => $value,
	                            'palabraBD'    => $p['palabra'],
	                            'coincidencia' => $perc.'%'
	                    )
	                );
	                
	                $return = 1;                
	            }
	        }
	    }

	    return array(
	        'return'        => $return,
	        'coincidencias' => $coincidencias
	    );
	}

	# FUNCIÓN QUE LLAMA AL ALGORITMO DE LEVENSHTEIN A PARTIR DE LA FUNCIÓN filterSMS
	private function levenshteinFunction($sms, $perc)
	{
	    $f = "";

	    if ($perc > 100) 
	    	$f = 'ERROR, EL PARAMETRO PORCENTAJE NO PUEDE SER MAYOR A 100';

	    else if ($perc < 0) 
	    	$f = 'ERROR, EL PARAMETRO PORCENTAJE NO PUEDE SER NEGATIVO';

	    else $f = $this->filterSMS($sms, $perc);

	    return $f;
	}

	# FUNCIÓN PARA BORRAR PALABRAS DUPLICADAS EN EL ARRAY FINAL DE PALABRAS OBSCENAS
	private function deleteDuplicates($array)
	{
	    $arr = array();

	    for ($i=0; $i < count($array); $i++) 
	    {
	        array_push($arr, $array[$i]['palabraSMS']);
	    }

	    $words = implode(array_unique($arr), ', ');

	    return $words;
	}
}