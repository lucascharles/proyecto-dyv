<?
	require_once('fpdf/fpdf.php');
	require_once('FPDI/fpdf_tpl.php');
	require_once('FPDI/fpdi.php');
   
	$pdf = new FPDI();
	$pagecount = $pdf->setSourceFile('views/templateCarta.pdf');
	$tplIdx = $pdf->importPage(1); 
	
	
	$idDeudorAnt = 0;
	$delta = 5;
	
	for($i=0; $i<$colleccionDocumentos->get_count(); $i++) 
	  {
	  	$deudorTmp = &$colleccionDocumentos->items[$i];
		//datos cabecera de la carta
		$direccionDyV = 'Av. Providencia 1116 Piso 25 Santiago';
		$fechaActual = date('d-m-Y');
		$nombreDeudor = $deudorTmp->get_data("primer_apellido_deudor")." ".$deudorTmp->get_data("segundo_apellido_deudor")." ".
						$deudorTmp->get_data("primer_nombre_deudor")." ".$deudorTmp->get_data("segundo_nombre_deudor");
		$direccionDeudor = $deudorTmp->get_data("calle")." ".$deudorTmp->get_data("numero")." ".$deudorTmp->get_data("piso") 
							." ".$deudorTmp->get_data("depto")." ".$deudorTmp->get_data("comuna")." ".$deudorTmp->get_data("ciudad");		
		$mandante = $deudorTmp->get_data("nombre_mandante")." ".$deudorTmp->get_data("apellido_mandante");
	  	$rutDeudor = $deudorTmp->get_data("rut_deudor")."-".$deudorTmp->get_data("dv_deudor");
		
		//detalle de la carta
		$tipoDoc = $deudorTmp->get_data("tipo_documento");
		$numDoc = $deudorTmp->get_data("numero_documento");
		$estadoDoc = $deudorTmp->get_data("estado");
		$fechaProtDoc = $deudorTmp->get_data("fecha_protesto");
		$montoDoc = $deudorTmp->get_data("monto");
		
	  	
	  	if($idDeudorAnt != $deudorTmp->get_data("id_deudor"))
		{
			//identifica el deudor para nueva carta
				$idDeudorAnt = $deudorTmp->get_data("id_deudor");	

				//nueva carta pdf para un deudor
				$pdf->AddPage();
				$pdf->useTemplate($tplIdx); 
				$pdf->SetFont('Arial'); 
				$pdf->SetTextColor(0,0,0); 
				
				
				$pdf->SetXY(10, 45); 
				$pdf->Write(0, $direccionDyV); 
				$pdf->SetXY(10, 55); 
				$pdf->Write(0, $fechaActual);
				$pdf->SetXY(10, 60); 
				$pdf->Write(0, $nombreDeudor);
				$pdf->SetXY(10, 65); 
				$pdf->Write(0, $direccionDeudor);
				$pdf->SetXY(10, 70); 
				$pdf->Write(0, $mandante);
				$pdf->SetXY(10, 80); 
				$pdf->Write(0, "Nos ha encargado la cobranza de los siguientes documentos:");
				$pdf->SetXY(10, 85); 
				$pdf->Write(0, "Rut: ".$rutDeudor);
			}
			$pdf->SetXY(10, 95+$delta); 
			$pdf->Write(0, $tipoDoc." N°: ".$numDoc
							." ".$estadoDoc."    Protestado el: ".$fechaProtDoc
							." por $".$montoDoc);
		
		  }
		
		$pdf->Output("carta_".$rutDeudor.".pdf","D");
		
		
?>
