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
		$direccionStgoDyV = '11 DE SEPTIEMBRE 1881 of. 2502   PROVIDENCIA - SANTIAGO';
		$direccionValpaDyV = '11 DE SEPTIEMBRE 1881 of. 2502   PROVIDENCIA - SANTIAGO';
		
		
//		$fechaActual = date('dd-mm-YY');
		$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
    	$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
    	$year_now = date ("Y");  
    	$month_now = date ("n");  
    	$day_now = date ("j");  
    	$week_day_now = date ("w");  
    	$fechaActual = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;   
		
		
		
		$nombreDeudor = $deudorTmp->get_data("primer_apellido_deudor")." ".$deudorTmp->get_data("segundo_apellido_deudor")." ".
						$deudorTmp->get_data("primer_nombre_deudor")." ".$deudorTmp->get_data("segundo_nombre_deudor");
		
		if(trim($nombreDeudor) ==""){
			$nombreDeudor = $deudorTmp->get_data("razonsocial");
		}
						
		$direccionDeudor = $deudorTmp->get_data("calle")." ".$deudorTmp->get_data("numero"); 
							
		if($deudorTmp->get_data("depto")!= ""){
			$direccionDeudor = $direccionDeudor ." Dep./Of. ".$deudorTmp->get_data("depto");
		}
			
		
		$comunaDeudor = $deudorTmp->get_data("comuna");		
		$ciudadDeudor = $deudorTmp->get_data("ciudad");
		
		$mandante = $deudorTmp->get_data("nombre_mandante")." ".$deudorTmp->get_data("apellido_mandante")." ".$deudorTmp->get_data("rut_mandante")."-".$deudorTmp->get_data("dv_mandante");
	  	$rutDeudor =   number_format($deudorTmp->get_data("rut_deudor"), 0, '', '.')."-".$deudorTmp->get_data("dv_deudor");
		
		//detalle de la carta
		$tipoDoc = $deudorTmp->get_data("tipo_documento");
		$numDoc = $deudorTmp->get_data("numero_documento");
		$estadoDoc = 'NO PAGADO';//$deudorTmp->get_data("estado");
		
		if($deudorTmp->get_data("fecha_protesto") != ""){
			$fechaProtDoc = $deudorTmp->get_data("fecha_protesto");
		}
		else
		{
			if($deudorTmp->get_data("fecha_siniestro") != ""){
				$fechaProtDoc = $deudorTmp->get_data("fecha_siniestro");
			}
			else
			{
				$fechaProtDoc = $deudorTmp->get_data("fecha_creacion");
			}
		}
		$fecha2 = date("d/m/Y",strtotime($fechaProtDoc));

		$montoDoc = $deudorTmp->get_data("monto");
		
	  	
	  	if($idDeudorAnt != $deudorTmp->get_data("id_deudor"))
		{
			$delta = 5;
			//identifica el deudor para nueva carta
				$idDeudorAnt = $deudorTmp->get_data("id_deudor");	

				//nueva carta pdf para un deudor
				$pdf->AddPage();
				$pdf->useTemplate($tplIdx); 
				$pdf->SetFont('Arial',I,9); 
				$pdf->SetTextColor(0,0,0); 
				
				
//				$pdf->SetXY(10, 45); 
//				$pdf->Write(0, $direccionStgoDyV); 
//				$pdf->SetXY(10, 55);
//				$pdf->Write(0, $direccionValpaDyV); 
				$pdf->SetXY(10, 60); 
				$pdf->Write(0, $fechaActual);

				$pdf->SetFont('Arial',B,10); 
				$pdf->SetXY(10, 70); 
				$pdf->Write(0, "Señor(a)(es):");
				$pdf->SetXY(10, 75); 
				$pdf->Write(0, utf8_decode(strtoupper($nombreDeudor)));
				
				$pdf->SetFont('Arial',I,9);
				$pdf->SetXY(10, 80); 
				$pdf->Write(0, utf8_decode(strtoupper($direccionDeudor)));
				$pdf->SetXY(10, 85); 
				$pdf->Write(0, utf8_decode(strtoupper($comunaDeudor)));
				$pdf->SetXY(10, 90); 
				$pdf->Write(0, utf8_decode(strtoupper($ciudadDeudor)));
				$pdf->SetXY(10, 105); 
				$pdf->Write(0, "Rut: ".$rutDeudor);
				$pdf->SetXY(10, 110); 
				$pdf->Line( 10, 110, 200, 110);
				
				$pdf->SetXY(10, 120); 
				$pdf->Write(0, utf8_decode(strtoupper($mandante)));
				$pdf->SetXY(10, 125); 
				$pdf->Write(0, strtoupper("Nos ha encargado la cobranza de los siguientes documentos:"));
				
			}
			$pdf->SetXY(10, 130+$delta); 
			$pdf->Write(0, $tipoDoc." N°: ".$numDoc
							." ".$estadoDoc."    PROTESTADO EL: ".$fecha2  
							." POR $". number_format($montoDoc, 0, '', '.'));
			$delta = $delta +5;
		  }
		
		$pdf->Output("carta_deudores.pdf","D");
		
		
?>
