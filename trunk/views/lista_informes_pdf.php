<?
	require('fpdf/fpdf.php');

	$pdf=new FPDF('L', 'mm', 'dv');
	
	$header=array('Mandatario','Rut Deudor','Deudor','Tipo Doc.','Nro. Doc.','Monto','Demanda','Juzgado','Rol');
	$pdf->SetFont('Arial','B',10);
	$pdf->AddPage();
	$pdf->SetY(5);
	$pdf->SetX(5);
	$pdf->SetMargins(5,5,5);
	    
	for($i=0; $i < count($header); $i++)
	{
		$pdf->Cell(30,7,$header[$i],1);
	}
	
	for($j=0; $j<$colleccionInformes->get_count(); $j++) 
	{
		$datoTmp = &$colleccionInformes->items[$j];
		$pdf->Ln();
    	$pdf->Cell(30,5,$datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante"),1);
      	$pdf->Cell(30,5,$datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor"),1);
		$pdf->Cell(80,5,utf8_decode($datoTmp->get_data("razon_social"))." ".utf8_decode($datoTmp->get_data("primer_apellido"))." ".utf8_decode($datoTmp->get_data("segundo_apellido"))." ".utf8_decode($datoTmp->get_data("primer_nombre"))." ".utf8_decode($datoTmp->get_data("segundo_nombre")),1);
		$pdf->Cell(30,5,$datoTmp->get_data("tipo_documento"),1);
		$pdf->Cell(30,5,$datoTmp->get_data("numero_documento"),1);
		$pdf->Cell(30,5,$datoTmp->get_data("monto"),1);
		$pdf->Cell(30,5,$datoTmp->get_data("numero_ficha"),1);
		$pdf->Cell(50,5,$datoTmp->get_data("juzgado"),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("rol")),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("fecha_prox_gestion")),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("notas")),1);
		
	}
	$pdf->Output("listado_informes.pdf","D");
   
	
?>
