<?
	require('fpdf/fpdf.php');

	$pdf=new FPDF('L', 'mm', 'dv');
	
	$header=array('Mandatario','Deudor','Siniestro','Expr1','Estado','Monto','Doc','Banco','Num','Causal','Ficha','Nombre','Apellido','Juzgado','Comuna','Rol');
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
      	$pdf->Cell(30,5,$datoTmp->get_data("numero_siniestro"),1);
      	$pdf->Cell(30,5,formatoFecha($datoTmp->get_data("fecha_siniestro"),"yyyy-mm-dd","dd/mm/yyyy"),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("estado")),1);
		$pdf->Cell(30,5,$datoTmp->get_data("monto"),1);
		$pdf->Cell(30,5,$datoTmp->get_data("tipo_documento"),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("banco")),1);
		$pdf->Cell(30,5,$datoTmp->get_data("numero_documento"),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("causal")),1);
		$pdf->Cell(30,5,$datoTmp->get_data("numero_ficha"),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("primer_nombre")),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("primer_apellido")),1);
		$pdf->Cell(30,5,$datoTmp->get_data("juzgado_numero"),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("juzgado_comuna")),1);
		$pdf->Cell(30,5,utf8_decode($datoTmp->get_data("rol")),1);
		
	}
	/*
   		
      	$pdf->Ln();
      	$pdf->Cell(30,5,"linea 1 ",1);
      	$pdf->Cell(30,5,"linea 2",1);
      	$pdf->Cell(30,5,"linea 3",1);
      	$pdf->Cell(30,5,"linea 4",1);
	 */
	$pdf->Output("listado_informes.pdf","D");
   
	
?>
