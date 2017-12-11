<?php

Yii::import('application.extensions.fpdf.fpdf', true);

class PDF extends FPDF
{
	function Header()
	{
	    // Logo
	    //$this->Image(Yii::app()->request->baseUrl.'/img/header.jpg',10,6,30);
	    // Arial bold 15
	    $this->SetFont('Arial','B',12);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(0,10,'INSIGNIA MOBILE COMMUNICATIONS C.A.',0,0,'R');
	    $this->Ln(5);
	    $this->Cell(0,10,'R.I.F. J-31198620-0',0,0,'R');

	    $this->Line(10, 25, 285, 25);
	    // Line break
	    $this->Ln(12);
	}

	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-20);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    $this->Line(10, 278, 200, 278);
	    $this->Cell(0,10,'Avenida 4 Bella Vista Entre Calles 69 y 70 Edificio Lisa Maria',0,0,'C');
	    $this->Ln(4);
	    $this->Cell(0,10,'Piso 2 Oficina 4. Maracaibo Edo. Zulia. Telefax: 0261 7980591',0,0,'C');
	    $this->Ln(4);
	    // Page number
	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	}

	// Cargar los datos MT
	function LoadDataMT($id_fecha, $tipo)
	{
		$criteria=new CDbCriteria;
		$criteria->select = "descripcion, sc, movistar, movilnet, digitel";
		$criteria->compare("id_fecha", $id_fecha);
		$criteria->compare("tipo", $tipo);
		$criteria->order = "descripcion ASC";
		$model = ReporteDetallesMt::model()->findAll($criteria);

	    $data = array();
	    
	    foreach ($model as $value)
		{
			$total = $value["movistar"] + $value["movilnet"] + $value["digitel"];
			$data[] = array($value["descripcion"], $value["sc"], $value["movistar"], $value["movilnet"], $value["digitel"], $total);
		}

	    return $data;
	}

	// Cargar los datos MO
	function LoadDataMO($id_fecha)
	{
		$criteria=new CDbCriteria;
		$criteria->select = "descripcion, sc, total";
		$criteria->order = "descripcion ASC";
		$model = ReporteDetallesMo::model()->findAll($criteria);

	    $data = array();
	    
	    foreach ($model as $value)
		{
			$data[] = array($value["descripcion"], $value["sc"], $value["total"]);
		}

	    return $data;
	}

	// Tabla coloreada
	function FancyTableMT($data)
	{
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(0,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(0,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B', 10);
	    // Cabecera
	    
	    $header = array('Cliente', 'SC', 'Movistar', 'Movilnet', 'Digitel', 'Total');
	    $w = array(110, 30, 30, 30, 30, 30);

	    for($i=0;$i<count($header);$i++)
	    {
	    	if ($i == 0 || $i == 1 || $i == 5)
	    		$this->SetFillColor(160,160,160);
	    	else if ($i == 2)
	    		$this->SetFillColor(51,153,255);
	    	else if ($i == 3)
	    		$this->SetFillColor(255,128,0);
	    	else if ($i == 4)
	    		$this->SetFillColor(255,0,0);

	        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	    }

	    $this->Ln();
	    // Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    // Datos
	    $fill = false;
	    $totales = 0;
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
	        $this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
	        $this->Cell($w[2],6,number_format($row[2],0,',','.'),'LR',0,'C',$fill);
	        $this->Cell($w[3],6,number_format($row[3],0,',','.'),'LR',0,'C',$fill);
	        $this->Cell($w[4],6,number_format($row[4],0,',','.'),'LR',0,'C',$fill);
	        $this->Cell($w[5],6,number_format($row[5],0,',','.'),'LR',0,'C',$fill);
	        $this->Ln();
	        $fill = !$fill;
	        $totales += $row[5]; 
	    }
	    // Línea de cierre
	    $this->Cell(array_sum($w),0,'','T');
	    $this->Ln(5);
	    $this->SetFont('Arial','B', 12);
	    $this->Cell(array_sum($w),6,'Total: '.number_format($totales,0,',','.'), 0, 0, 'R');
	}

	// Tabla coloreada
	function FancyTableMO($data)
	{
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(0,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(0,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B', 10);
	    // Cabecera
	    
	    $header = array('Cliente', 'SC', 'Total');
	    $w = array(150, 40, 40);

	    for($i=0;$i<count($header);$i++)
	    {
	    	$this->SetFillColor(160,160,160);
	        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	    }

	    $this->Ln();
	    // Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    // Datos
	    $fill = false;
	    $totales = 0;
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
	        $this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
	        $this->Cell($w[2],6,number_format($row[2],0,',','.'),'LR',0,'C',$fill);
	        $this->Ln();
	        $fill = !$fill;
	        $totales += $row[2]; 
	    }
	    // Línea de cierre
	    $this->Cell(array_sum($w),0,'','T');
	    $this->Ln(5);
	    $this->SetFont('Arial','B', 12);
	    $this->Cell(array_sum($w),6,'Total: '.number_format($totales,0,',','.'), 0, 0, 'R');
	}
}

?>