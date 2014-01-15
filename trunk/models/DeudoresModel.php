<?php
class DeudoresModel extends ModelBase
{
	public function recolectarBasuraFichas()
	{
		$dato = new Ficha();
		$dato->add_filter("id_deudor","=",0);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}

	public function getDatosFicha($id_ficha)
	{
		$dato = new Ficha();
		$dato->add_filter("id_ficha","=",$id_ficha);
		$dato->load();
		
		return $dato;
	}

	public function getCantFicha($iddeudor)
	{
		$dato = new FichaCollection();
		$dato->add_filter("id_deudor","=",$iddeudor);
		$dato->load();
		$cantidad = $dato->get_count();		
		return $cantidad;
	}

	public function getTotalDemanda($iddeudor)
	{
		$dato = new FichaCollection();
		$dato->add_filter("id_deudor","=",$iddeudor);
		$dato->load();
		$monto = 0;
		if($dato->get_count()!=0)
		{
			for($j=0; $j<$dato->get_count(); $j++) 
			{
				$datoTmp = &$dato->items[$j];  
				$monto = $monto + $datoTmp->get_data("monto");
			}
		}
				
		return $monto;
	}

	public function getTotalDemandaId($id)
	{
		$dato = new FichaCollection();
		$dato->add_filter("id_ficha","=",$id);
		$dato->load();
		$monto = 0;
		if($dato->get_count()!=0)
		{
			for($j=0; $j<$dato->get_count(); $j++) 
			{
				$datoTmp = &$dato->items[$j];  
				$monto = $monto + $datoTmp->get_data("monto");
			}
		}
				
		return $monto;
	}
	
	public function getCantLiquidaciones($iddeudor)
	{
		$dato = new LiquidacionesCollection();
		$dato->add_filter("id_deudor","=",$iddeudor);
		$dato->load();
		$cantidad = $dato->get_count();		
		return $cantidad;
	}
	
	public function altaFicha($param)
	{
		$deudor = new Deudores();
		$deudor->add_filter("rut_deudor","=",trim($param["txtrut_deudor"]));
//		$deudor->add_filter("AND");
//		$deudor->add_filter("dv_deudor","=",trim($param["txtrut_d_deudor"]));
		$deudor->load();
		
		$mandante = new Mandantes();
		$mandante->add_filter("rut_mandante","=",trim($param["txtrut_mandante"]));
//		$mandante->add_filter("AND");
//		$mandante->add_filter("dv_mandante","=",trim($param["txtrut_d_mandante"]));
		$mandante->load();
				
		$dato = new Ficha();
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			$dato->add_filter("id_ficha","=",$param["id_alta"]);
			$dato->load();
		}
		$dato->set_data("id_deudor",$deudor->get_data("id_deudor"));
		$dato->set_data("id_mandante",$mandante->get_data("id_mandante"));
		$dato->set_data("id_documento",$param["id_doc"]);
		$dato->set_data("monto",$param["txtmonto"]);
		$dato->set_data("abogado",$param["txtabogado"]);
		$dato->set_data("abogado2",$param["txtabogado2"]);
		$dato->set_data("distribucion_corte",formatoFecha($param["txtdist_corte"],"dd/mm/yyyy","yyyy-mm-dd"));
		$dato->set_data("rol",$param["txtrol"]);
		$dato->set_data("juzgado_anexo",$param["txtjuzgadoanexo"]);
		$dato->set_data("aval",$param["txtaval"]);
		$dato->set_data("rut_aval",$param["txtrutaval"]);
		$dato->set_data("tel_aval",$param["txttelaval"]);
		$dato->set_data("domicilio_aval",$param["txtdomicilioaval"]);
		$dato->save();
		
		$docficha = new Documento_Ficha();
		$arrdocs = explode(",",$param["listdocs"]);
		
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			$id = $param["id_alta"];
		
//			for($j=0; $j<count($arrdocs); $j++) 	//graba relacion documento_ficha		
//			{
//				$docficha->set_data("id_ficha",$id);
//				$docficha->set_data("id_documento",$arrdocs[$j]);
//				$docficha->save();
//			}
		}
		else
		{
			$id = getUltimoId(new FichaCollection(), "id_ficha");
			
			for($j=0; $j<count($arrdocs); $j++) 	//graba relacion documento_ficha		
			{
				$docficha->set_data("id_ficha",$id);
				$docficha->set_data("id_documento",$arrdocs[$j]);
				$docficha->save();
			}
			
		}
		
		

		return $id;
	}
	
	public function altaReceptorFicha($param)
	{
		$resp = 0;
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			// graba receptor y devuelve id ficha
			$resp = $param["id_alta"];
			
			$val = new Receptor_FichaCollection();
			$val->add_filter("id_ficha","=",$resp);
			$val->load();
			
			$dator = new Receptor_Ficha();
			
			if($val->get_count() > 0)
			{
				$dator->add_filter("id_ficha","=",$resp);
				$dator->load();
				$id_receptor = $dator->get_data("id_receptor");
			}	
			
			$dator->set_data("id_ficha",$resp);
			$dator->set_data("fecha_mandamiento",formatoFecha($param["txtfecha_mandamiento"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("fecha_providencia",formatoFecha($param["txtfecha_providencia"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("receptor",$param["txtreceptor"]);
			$dator->set_data("receptor2",$param["txtnombreceptor2"]);
			$dator->set_data("receptor3",$param["txtnombrereceptor3"]);
			$dator->set_data("receptor3",$param["txtnombrereceptor3"]);
			$dator->set_data("busqueda",$param["txtbusqueda"]);
			$dator->set_data("notificacion",$param["txtnotificacion"]);
			$dator->set_data("notificacion_2",$param["txtnotificacion_2"]);
			$dator->set_data("notificacion_3",$param["txtnotificacion_3"]);
			$dator->set_data("fecha_domicilio",formatoFecha($param["txtfecha_domicilio"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("fecha_domicilio_1",formatoFecha($param["txtfecha_domicilio_1"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("entrega_receptor_1",$param["txtentrega_receptor_1"]);
			$dator->set_data("entrega_receptor_2",$param["txtentrega_receptor_2"]);
			$dator->set_data("entrega_receptor_3",$param["txtentrega_receptor_3"]);
			$dator->set_data("entrega_receptor_4",$param["txtentrega_receptor_4"]);
			$dator->set_data("notificacion_1",$param["txtnotificacion_1"]);
			$dator->set_data("fecha_embargo_fp",formatoFecha($param["txtfecha_embargo_fp"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("fecha_oficio",formatoFecha($param["txtfecha_oficio"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("fecha_traba_emb",formatoFecha($param["txtfecha_traba_emb"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("fono_receptor",$param["txtfono_receptor"]);
			$dator->set_data("fono_receptor2",$param["txtfono_receptor2"]);
			$dator->set_data("fono_receptor3",$param["txtemailtel_recep3"]);
			$dator->set_data("resultado_busqueda",$param["txtresultado_busqueda"]);
			$dator->set_data("resultado_notificacion_1",$param["txtresultado_notificacion_1"]);
			$dator->set_data("resultado_notificacion_2",$param["txtresultado_notificacion_2"]);
			$dator->set_data("resultado_notificacion_3",$param["txtresultado_notificacion_3"]);
			
			$dator->set_data("providencia_1",$param["txtprovidencia_1"]);
			$dator->set_data("providencia_2",$param["txtprovidencia_2"]);
			$dator->set_data("providencia_3",$param["txtprovidencia_3"]);
			$dator->set_data("fecha_busqueda_2",formatoFecha($param["txtfecha_busqueda_2"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dator->set_data("busqueda_3",$param["txtbusqueda_3"]);
			$dator->set_data("embargo",$param["txtembargo"]);
			$dator->set_data("articulo_431044",$param["txtarticulo_431044"]);
			
			$dator->set_data("notificacion_ficha",$param["txtnotificacion_ficha"]);
			$dator->set_data("citacion",$param["txtcitacion"]);
			$dator->set_data("resultado_busqueda_2",$param["txtresultado_busqueda_2"]);
			$dator->set_data("resultado_busqueda_3",$param["txtresultado_busqueda_3"]);
			
			
			$dator->save();		
			
			if($val->get_count() == 0)
			{
				$id_receptor = getUltimoId(new Receptor_FichaCollection(), "id_receptor");
			}	
			
			$colGastoReceptor = $this->getGastosReceptor(0);
			
			for($j=0; $j<$colGastoReceptor->get_count(); $j++) 
			{
				$datoTmp = &$colGastoReceptor->items[$j];  
				
				$imp = 0;
				if(trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]) <> "")
				{
					$imp = trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]);
				}
				$gastos_rf = new Gastos_Receptor_Ficha();
				if($val->get_count() > 0)
				{
					$gastos_rf->add_filter("id_ficha","=",$resp);
					$gastos_rf->add_filter("AND");
					$gastos_rf->add_filter("id_receptor","=",$id_receptor);
					$gastos_rf->add_filter("AND");
					$gastos_rf->add_filter("id_gasto","=",$datoTmp->get_data("id_gasto"));
					$gastos_rf->load();
				}
				$gastos_rf->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
				$gastos_rf->set_data("id_receptor",$id_receptor);
				$gastos_rf->set_data("id_ficha",$resp);
				$gastos_rf->set_data("importe",$imp);
				$gastos_rf->save();
				
				$gasto_ficha = new Gastos_Ficha();
				if($val->get_count() > 0)
				{
					$gasto_ficha->add_filter("id_ficha","=",$resp);
					$gasto_ficha->add_filter("AND");
					$gasto_ficha->add_filter("id_gasto","=",$datoTmp->get_data("id_gasto"));
					$gasto_ficha->load();
				}
				$gasto_ficha->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
				$gasto_ficha->set_data("id_ficha",$resp);
				$gasto_ficha->set_data("importe",$imp);
				$gasto_ficha->save();
				
			}
			
			$ultid_ficha = $resp;
		}
		else
		{
			// graba ficha, receptor y devuelve id ficha
			
			$datof = new Ficha();
			$datof->set_data("id_deudor",0);
			$datof->save();
			
			$ultid_ficha = getUltimoId(new FichaCollection(), "id_ficha");
			
			$dator = new Receptor_Ficha();
			$dator->set_data("id_ficha",$ultid_ficha);
			$dator->set_data("fecha_mandamiento",$param["txtfecha_mandamiento"]);
			$dator->set_data("receptor",$param["txtreceptor"]);
			$dator->set_data("busqueda",$param["txtbusqueda"]);
			$dator->set_data("notificacion",$param["txtnotificacion"]);
			$dator->set_data("notificacion_2",$param["txtnotificacion_2"]);
			$dator->set_data("notificacion_3",$param["txtnotificacion_3"]);
			$dator->set_data("fecha_domicilio",$param["txtfecha_domicilio"]);
			$dator->set_data("fecha_domicilio_1",$param["txtfecha_domicilio_1"]);
			$dator->set_data("entrega_receptor_1",$param["txtentrega_receptor_1"]);
			$dator->set_data("entrega_receptor_2",$param["txtentrega_receptor_2"]);
			$dator->set_data("entrega_receptor_3",$param["txtentrega_receptor_3"]);
			$dator->set_data("entrega_receptor_4",$param["txtentrega_receptor_4"]);
			$dator->set_data("notificacion_1",$param["txtnotificacion_1"]);
			$dator->set_data("fecha_embargo_fp",$param["txtfecha_embargo_fp"]);
			$dator->set_data("fecha_oficio",$param["txtfecha_oficio"]);
			$dator->set_data("fecha_traba_emb",$param["txtfecha_traba_emb"]);
			$dator->set_data("fono_receptor",$param["txtfono_receptor"]);
			$dator->set_data("fono_receptor2",$param["txtfono_receptor2"]);
			$dator->set_data("fono_receptor3",$param["txtemailtel_recep3"]);
			$dator->set_data("resultado_busqueda",$param["txtresultado_busqueda"]);
			$dator->set_data("resultado_notificacion_1",$param["txtresultado_busqueda"]);
			$dator->set_data("resultado_notificacion_2",$param["txtresultado_notificacion_2"]);
			$dator->set_data("resultado_notificacion_3",$param["txtresultado_notificacion_3"]);
			$dator->set_data("providencia_1",$param["txtprovidencia_1"]);
			$dator->set_data("providencia_2",$param["txtprovidencia_2"]);
			$dator->set_data("providencia_3",$param["txtprovidencia_3"]);
			$dator->set_data("fecha_busqueda_2",$param["txtfecha_busqueda_2"]);
			$dator->set_data("busqueda_3",$param["txtbusqueda_3"]);
			$dator->set_data("embargo",$param["txtembargo"]);
			$dator->set_data("articulo_431044",$param["txtarticulo_431044"]);
			$dator->set_data("notificacion_ficha",$param["txtnotificacion_ficha"]);
			$dator->set_data("citacion",$param["txtcitacion"]);
			$dator->set_data("resultado_busqueda_2",$param["txtresultado_busqueda_2"]);
			$dator->set_data("resultado_busqueda_3",$param["txtresultado_busqueda_3"]);
			$dator->save();
			
			$ultid_recep = getUltimoId(new Receptor_FichaCollection(), "id_receptor");
			
			$colGastoRecept = $this->getGastosReceptor(0);
			
			for($j=0; $j<$colGastoRecept->get_count(); $j++) 
			{
				$datoTmp = &$colGastoRecept->items[$j];  
				
				$imp = 0;
				if(trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]) <> "")
				{
					$imp = trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]);
				}
				$gastos_rf = new Gastos_Receptor_Ficha();
				$gastos_rf->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
				$gastos_rf->set_data("id_receptor",$ultid_recep);
				$gastos_rf->set_data("id_ficha",$ultid_ficha);
				$gastos_rf->set_data("importe",$imp);
				$gastos_rf->save();
				
				$gasto_ficha = new Gastos_Ficha();
				$gasto_ficha->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
				$gasto_ficha->set_data("id_ficha",$ultid_ficha);
				$gasto_ficha->set_data("importe",$imp);
				$gasto_ficha->save();
			}
		}
		
		return $ultid_ficha;
	}
	
	public function altaConsignacionFicha($param)
	{
		$resp = 0;
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			// graba receptor y devuelve id ficha
			$resp = $param["id_alta"];
			
			$val = new Consignacion_FichaCollection();
			$val->add_filter("id_ficha","=",$resp);
			$val->load();
			
			$datoc = new Consignacion_Ficha();
			//echo("<br>liqu: ".$param["txtliquidacosta"]."<br>");
			if($val->get_count() > 0)
			{
				$datoc->add_filter("id_ficha","=",$resp);
				$datoc->load();
				$id_consig = $datoc->get_data("id_consignacion");
			}	
			$datoc->set_data("id_ficha",$resp);
			$datoc->set_data("consignacion",$param["txtconsignacion"]);
			$abono1 = (trim($param["txtabono_1"]) <> "") ? $param["txtabono_1"] : NULL;
			$datoc->set_data("abono_1",$abono1);
			$abono2 = (trim($param["txtabono_2"]) <> "") ? $param["txtabono_2"] : NULL;
			$datoc->set_data("abono_2",$abono2);
			$abono3 = (trim($param["txtabono_3"]) <> "") ? $param["txtabono_3"] : NULL;
			$datoc->set_data("abono_3",$abono3);
			$abono4 = (trim($param["txtabono_4"]) <> "") ? $param["txtabono_4"] : NULL;
			$datoc->set_data("abono_4",$abono4);
			$pagocliente = (trim($param["txtpago_cliente"]) <> "") ? $param["txtpago_cliente"] : NULL;
			$datoc->set_data("pago_cliente",$pagocliente);
			$girocheque1 = (trim($param["txtgirecheque"]) <> "") ? $param["txtgirecheque"] : NULL;
			$datoc->set_data("giro_cheque_1",$girocheque1 );
			$entregacheque = (trim($param["txtentrega_cheque"]) <> "") ? $param["txtentrega_cheque"] : NULL;
			$datoc->set_data("entrega_cheque",$entregacheque);
			$costasprocesales = (trim($param["txtcostas_procesales"]) <> "") ? $param["txtcostas_procesales"] : NULL;
			$datoc->set_data("costas_procesales",$costasprocesales);
			$pagocostas = (trim($param["txtpago_costas"]) <> "") ? $param["txtpago_costas"] : NULL;
			$datoc->set_data("pago_costas",$pagocostas);
			$entregacheque1 = (trim($param["txtentrega_cheque_1"]) <> "") ? $param["txtentrega_cheque_1"] : NULL;
			$datoc->set_data("entrega_cheque_1",$entregacheque1);
			$devoluciondocumento = (trim($param["txtdevolucion_documento"]) <> "") ? $param["txtdevolucion_documento"] : NULL;
			$datoc->set_data("devolucion_documento",$devoluciondocumento);
			$entregadocumento = (trim($param["txtentrega_documento"]) <> "") ? $param["txtentrega_documento"] : NULL;
			$datoc->set_data("entrega_documento",$entregadocumento);
			$montoconsignacion = (trim($param["txtmonto_consignacion"]) <> "") ? $param["txtmonto_consignacion"] : NULL;
			$datoc->set_data("monto_consignacion",$montoconsignacion);
			$monto1 = (trim($param["txtmonto_1"]) <> "") ? $param["txtmonto_1"] : NULL;
			$datoc->set_data("monto_1",$monto1 );
			$monto2 = (trim($param["txtmonto_2"]) <> "") ? $param["txtmonto_2"] : NULL;
			$datoc->set_data("monto_2",$monto2);
			$monto3 = (trim($param["txtmonto_3"]) <> "") ? $param["txtmonto_3"] : NULL;
			$datoc->set_data("monto_3",$monto3);
			$monto4 = (trim($param["txtmonto_4"]) <> "") ? $param["txtmonto_4"] : NULL;
			$datoc->set_data("monto_4",$monto4);
			$pagodyv = (trim($param["txtpago_dyv"]) <> "") ? $param["txtpago_dyv"] : NULL;
			$datoc->set_data("pago_dyv",$pagodyv);
			$providencia1 = (trim($param["txtprovidencia"]) <> "") ? $param["txtprovidencia"] : NULL;
			$datoc->set_data("providencia_1",$providencia1);
			//$providencia2 = (trim($param["txtprovidencia_2"]) <> "") ? $param["txtprovidencia_2"] : NULL;
			//$datoc->set_data("providencia_2",$providencia2);
			$girocheque2 = (trim($param["txtgiro_cheque_2"]) <> "") ? $param["txtgiro_cheque_2"] : NULL;
			$datoc->set_data("giro_cheque_2",$girocheque2);
			$providencia3 = (trim($param["txtprovidencia_3"]) <> "") ? $param["txtprovidencia_3"] : NULL;
			$datoc->set_data("providencia_3",$providencia3);
			$rendicioncliente = (trim($param["txtrendicion_cliente"]) <> "") ? $param["txtrendicion_cliente"] : NULL;
			$datoc->set_data("rendicion_cliente",$rendicioncliente);
			$abogado = (trim($param["txtabogado"]) <> "") ? $param["txtabogado"] : NULL;
			$datoc->set_data("abogado",$abogado);
			$liquidacosta = (trim($param["txtliquidacosta"]) <> "") ? $param["txtliquidacosta"] : NULL;
			$datoc->set_data("liquidacosta",$liquidacosta);
			$email = (trim($param["txtemail"]) <> "") ? $param["txtemail"] : NULL;
			$datoc->set_data("email",$email);
			$gasto = (trim($param["txtgasto"]) <> "") ? $param["txtgasto"] : NULL;
			$datoc->set_data("gasto",$gasto);
			$datoc->save();		
			
			if($val->get_count() == 0)
			{
				$id_consig = getUltimoId(new Consignacion_FichaCollection(), "id_consignacion");
			}	
			
			$gasto_ficha = new Gastos_Ficha();
			if($val->get_count() > 0)
			{
				$gasto_ficha->add_filter("id_ficha","=",$resp);
				$gasto_ficha->add_filter("AND");
				$gasto_ficha->add_filter("id_gasto","=",12); // gasto consignacion
				$gasto_ficha->load();
			}
			
			$gasto_ficha->set_data("id_gasto",12);
			$gasto_ficha->set_data("id_ficha",$resp);
			$gasto_ficha->set_data("importe",$gasto);
			$gasto_ficha->save();
			
			$ultid_ficha = $resp;	
		}
		else
		{
			// graba ficha, receptor y devuelve id ficha
			
			$datof = new Ficha();
			$datof->set_data("id_deudor",0);
			$datof->save();
			
			$ultid_ficha = getUltimoId(new FichaCollection(), "id_ficha");
			
			$datoc = new Consignacion_Ficha();
			$datoc->set_data("id_ficha",$ultid_ficha);
			$datoc->set_data("consignacion",$param["txtconsignacion"]);
			$abono1 = (trim($param["txtabono_1"]) <> "") ? $param["txtabono_1"] : NULL;
			$datoc->set_data("abono_1",$abono1);
			$abono2 = (trim($param["txtabono_2"]) <> "") ? $param["txtabono_2"] : NULL;
			$datoc->set_data("abono_2",$abono2);
			$abono3 = (trim($param["txtabono_3"]) <> "") ? $param["txtabono_3"] : NULL;
			$datoc->set_data("abono_3",$abono3);
			$abono4 = (trim($param["txtabono_4"]) <> "") ? $param["txtabono_4"] : NULL;
			$datoc->set_data("abono_4",$abono4);
			$pagocliente = (trim($param["txtpago_cliente"]) <> "") ? $param["txtpago_cliente"] : NULL;
			$datoc->set_data("pago_cliente",$pagocliente);
			$girocheque1 = (trim($param["txtgirecheque"]) <> "") ? $param["txtgirecheque"] : NULL;
			$datoc->set_data("giro_cheque_1",$girocheque1 );
			$entregacheque = (trim($param["txtentrega_cheque"]) <> "") ? $param["txtentrega_cheque"] : NULL;
			$datoc->set_data("entrega_cheque",$entregacheque);
			$costasprocesales = (trim($param["txtcostas_procesales"]) <> "") ? $param["txtcostas_procesales"] : NULL;
			$datoc->set_data("costas_procesales",$costasprocesales);
			$pagocostas = (trim($param["txtpago_costas"]) <> "") ? $param["txtpago_costas"] : NULL;
			$datoc->set_data("pago_costas",$pagocostas);
			$entregacheque1 = (trim($param["txtentrega_cheque_1"]) <> "") ? $param["txtentrega_cheque_1"] : NULL;
			$datoc->set_data("entrega_cheque_1",$entregacheque1);
			$devoluciondocumento = (trim($param["txtdevolucion_documento"]) <> "") ? $param["txtdevolucion_documento"] : NULL;
			$datoc->set_data("devolucion_documento",$devoluciondocumento);
			$entregadocumento = (trim($param["txtentrega_documento"]) <> "") ? $param["txtentrega_documento"] : NULL;
			$datoc->set_data("entrega_documento",$entregadocumento);
			$montoconsignacion = (trim($param["txtmonto_consignacion"]) <> "") ? $param["txtmonto_consignacion"] : NULL;
			$datoc->set_data("monto_consignacion",$montoconsignacion);
			$monto1 = (trim($param["txtmonto_1"]) <> "") ? $param["txtmonto_1"] : NULL;
			$datoc->set_data("monto_1",$monto1 );
			$monto2 = (trim($param["txtmonto_2"]) <> "") ? $param["txtmonto_2"] : NULL;
			$datoc->set_data("monto_2",$monto2);
			$monto3 = (trim($param["txtmonto_3"]) <> "") ? $param["txtmonto_3"] : NULL;
			$datoc->set_data("monto_3",$monto3);
			$monto4 = (trim($param["txtmonto_4"]) <> "") ? $param["txtmonto_4"] : NULL;
			$datoc->set_data("monto_4",$monto4);
			$pagodyv = (trim($param["txtpago_dyv"]) <> "") ? $param["txtpago_dyv"] : NULL;
			$datoc->set_data("pago_dyv",$pagodyv);
			$providencia1 = (trim($param["txtprovidencia"]) <> "") ? $param["txtprovidencia"] : NULL;
			$datoc->set_data("providencia_1",$providencia1);
			//$providencia2 = (trim($param["txtprovidencia_2"]) <> "") ? $param["txtprovidencia_2"] : NULL;
			//$datoc->set_data("providencia_2",$providencia2);
			$girocheque2 = (trim($param["txtgiro_cheque_2"]) <> "") ? $param["txtgiro_cheque_2"] : NULL;
			$datoc->set_data("giro_cheque_2",$girocheque2);
			$providencia3 = (trim($param["txtprovidencia_3"]) <> "") ? $param["txtprovidencia_3"] : NULL;
			$datoc->set_data("providencia_3",$providencia3);
			$rendicioncliente = (trim($param["txtrendicion_cliente"]) <> "") ? $param["txtrendicion_cliente"] : NULL;
			$datoc->set_data("rendicion_cliente",$rendicioncliente);
			$abogado = (trim($param["txtabogado"]) <> "") ? $param["txtabogado"] : NULL;
			$datoc->set_data("abogado",$abogado);
			$liquidacosta = (trim($param["txtliquidacosta"]) <> "") ? $param["txtliquidacosta"] : NULL;
			$datoc->set_data("liquidacosta",$liquidacosta);
			$email = (trim($param["txtemail"]) <> "") ? $param["txtemail"] : NULL;
			$datoc->set_data("email",$email);
			$gasto = (trim($param["txtgasto"]) <> "") ? $param["txtgasto"] : NULL;
			$datoc->set_data("gasto",$gasto);
			$datoc->save();
			
			$ultid_consig = getUltimoId(new Consignacion_FichaCollection(), "id_consignacion");

			$gasto_ficha = new Gastos_Ficha();
			$gasto_ficha->set_data("id_gasto",12);
			$gasto_ficha->set_data("id_ficha",$ultid_ficha);
			$gasto_ficha->set_data("importe",$gasto);
			$gasto_ficha->save();

		}
		
		return $ultid_ficha;
	}
	

	public function altaMartilleroFicha($param)
	{
		$resp = 0;
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			// graba receptor y devuelve id ficha
			$resp = $param["id_alta"];
						
			$val = new Martillero_FichaCollection();
			$val->add_filter("id_ficha","=",$resp);
			$val->load();
			
			$datom = new Martillero_Ficha();
			
			if($val->get_count() > 0)
			{
				$datom->add_filter("id_ficha","=",$resp);
				$datom->load();
				$id_mart = $datom->get_data("id_martillero");
			}	
			
			$datom->set_data("id_ficha",$resp);
			$datom->set_data("embargomartillero",$param["txtembargomartillero"]);
			$datom->set_data("aceptacion_cargo",formatoFecha($param["txtaceptacion_cargo"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datom->set_data("providencia",$param["txtprovidencia"]);
			$datom->set_data("resultado",$param["txtresultado"]);
			$datom->set_data("oficio",$param["txtoficio"]);
			$datom->set_data("receptor",$param["txtreceptor"]);
			$datom->set_data("emailreceptor",$param["txtemailreceptor"]);
			$datom->set_data("embargo_1",$param["txtembargo"]);
			
			$datom->set_data("entrega_receptor",formatoFecha($param["txtentrega_receptor"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datom->set_data("receptor2",$param["txtreceptor2"]);
			$datom->set_data("emailreceptor2",$param["txtemailreceptor2"]);
			$datom->set_data("embargo2",$param["txtembargo2"]);
			$datom->set_data("def2",$param["txtdef2"]);
			$datom->set_data("def3",$param["txtdef3"]);
			$datom->set_data("martillero",$param["txtmartillero"]);
			$datom->set_data("emailmartillero",$param["txtemailmartillero"]);
			$datom->set_data("notificacion",$param["txtnotificacionmartillero"]);
			$datom->set_data("retiro_especies",$param["txtretiro_especies"]);
			$datom->set_data("fecha_remate",formatoFecha($param["txtfecha_remate"],"dd/mm/yyyy","yyyy-mm-dd"));
			
			$datom->set_data("ingreso",formatoFecha($param["txtingreso"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datom->set_data("providencia1",$param["txtprovidencia1"]);
			$datom->set_data("resultado1",$param["txtresultado1"]);
			$datom->set_data("oficio1",$param["txtoficio1"]);
			$datom->set_data("receptor1",$param["txtreceptor1"]);
			$datom->set_data("emailreceptor1",$param["txtemailreceptor1"]);
			$datom->set_data("embargo1",$param["txtembargo1"]);
			$datom->set_data("oposicion_retiro",$param["txtoposicion_retiro"]);
			$datom->set_data("gasto",$param["txtgasto"]);
			
			$datom->save();	
			
			if($val->get_count() == 0)
			{
				$id_mart = getUltimoId(new Martillero_FichaCollection(), "id_martillero");
			}	
			
			$gasto_ficha = new Gastos_Ficha();
			if($val->get_count() > 0)
			{
				$gasto_ficha->add_filter("id_ficha","=",$resp);
				$gasto_ficha->add_filter("AND");
				$gasto_ficha->add_filter("id_gasto","=",11);// gasto martillero
				$gasto_ficha->load();
			}
			$gasto_ficha->set_data("id_gasto",11);
			$gasto_ficha->set_data("id_ficha",$resp);
			$gasto_ficha->set_data("importe",$param["txtgasto"]);
			$gasto_ficha->save();
			
			
			$ultid_ficha = $resp;	
		}
		else
		{
			// graba ficha, receptor y devuelve id ficha
			
			$datof = new Ficha();
			$datof->set_data("id_deudor",0);
			$datof->save();
			
			$ultid_ficha = getUltimoId(new FichaCollection(), "id_ficha");
			//echo("<br> txtprovidencia1: ".$param["txtprovidencia1"]."<br>");
			$datom = new Martillero_Ficha();
			$datom->set_data("id_ficha",$ultid_ficha);
			$datom->set_data("embargomartillero",$param["txtembargomartillero"]);
			$datom->set_data("aceptacion_cargo",formatoFecha($param["txtaceptacion_cargo"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datom->set_data("providencia",$param["txtprovidencia"]);
			$datom->set_data("resultado",$param["txtresultado"]);
			$datom->set_data("oficio",$param["txtoficio"]);
			$datom->set_data("receptor",$param["txtreceptor"]);
			$datom->set_data("emailreceptor",$param["txtemailreceptor"]);
			$datom->set_data("embargo_1",$param["txtembargo"]);
			
			$datom->set_data("entrega_receptor",formatoFecha($param["txtentrega_receptor"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datom->set_data("receptor2",$param["txtreceptor2"]);
			$datom->set_data("emailreceptor2",$param["txtemailreceptor2"]);
			$datom->set_data("embargo2",$param["txtembargo2"]);
			$datom->set_data("def2",$param["txtdef2"]);
			$datom->set_data("def3",$param["txtdef3"]);
			$datom->set_data("martillero",$param["txtmartillero"]);
			$datom->set_data("emailmartillero",$param["txtemailmartillero"]);
			$datom->set_data("notificacion",$param["txtnotificacionmartillero"]);
			$datom->set_data("retiro_especies",$param["txtretiro_especies"]);
			$datom->set_data("fecha_remate",formatoFecha($param["txtfecha_remate"],"dd/mm/yyyy","yyyy-mm-dd"));
			
			$datom->set_data("ingreso",formatoFecha($param["txtingreso"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datom->set_data("providencia1",$param["txtprovidencia1"]);
			$datom->set_data("resultado1",$param["txtresultado1"]);
			$datom->set_data("oficio1",$param["txtoficio1"]);
			$datom->set_data("receptor1",$param["txtreceptor1"]);
			$datom->set_data("emailreceptor1",$param["txtemailreceptor1"]);
			$datom->set_data("embargo1",$param["txtembargo1"]);
			$datom->set_data("oposicion_retiro",$param["txtoposicion_retiro"]);
			$datom->set_data("gasto",$param["txtgasto"]);
			
			$ultid_mart = getUltimoId(new Martillero_FichaCollection(), "id_martillero");

			$gasto_ficha = new Gastos_Ficha();
			$gasto_ficha->set_data("id_gasto",11); // gasto martillero
			$gasto_ficha->set_data("id_ficha",$ultid_ficha);
			$gasto_ficha->set_data("importe",$param["txtgasto"]);
			$gasto_ficha->save();			
		}
		
		return $ultid_ficha;
	}
	
	public function getReceptor($idd)
	{
		$dato = new Receptor_Ficha();
		$dato->add_filter("id_ficha","=",$idd);
		$dato->load();
		
		return $dato;
	}
	
	public function getMartillero($idd)
	{
		$dato = new Martillero_Ficha();
		$dato->add_filter("id_ficha","=",$idd);
		$dato->load();
		
		return $dato;
	}
	
	public function getConsignacion($idd)
	{
		$dato = new Consignacion_Ficha();
		$dato->add_filter("id_ficha","=",$idd);
		$dato->load();
		
		return $dato;
	}
	
	public function getGastosReceptor($id_receptor)
	{
		
		include("config.php");

		if($id_receptor <> 0)
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, gr.importe importe"; 
	 		$from = " gastos g, gastos_receptor_ficha gr ";
    		$where = " g.id_gasto = gr.id_gasto and gr.id_receptor = ".$id_receptor;
		}
		else
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, '' importe "; 
	 		$from = " gastos g ";
    		$where = " g.id_gasto in (1,2,3,4,5,6,7,8,9) ";
		}
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	
	public function getGastosMartillero($id_martillero)
	{
		
		include("config.php");

		if($id_martillero <> 0)
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, gm.importe importe"; 
	 		$from = " gastos g, gastos_martillero_ficha gm ";
    		$where = " g.id_gasto = gm.id_gasto and gm.id_martillero = ".$id_martillero;
		}
		else
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, '' importe "; 
	 		$from = " gastos g ";
    		$where = " g.id_gasto in (10,11,12) ";
		}
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	
	public function getGastosConsignacion($id_consignacion)
	{
		
		include("config.php");

		if($id_consignacion <> 0)
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, gc.importe importe"; 
	 		$from = " gastos g, gastos_consignacion_ficha gc ";
    		$where = " g.id_gasto = gc.id_gasto and gc.id_consignacion = ".$id_consignacion;
		}
		else
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, '' importe "; 
	 		$from = " gastos g ";
    		$where = " g.id_gasto in (13) ";
		}
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	
	public function getGastosGastos($id_ficha)
	{
		
		include("config.php");

		if($id_ficha <> 0)
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, gf.importe importe, g.rep rep, g.orden orden"; 
	 		$from = " gastos g, gastos_ficha gf ";
    		$where = " g.id_gasto = gf.id_gasto and gf.id_ficha = ".$id_ficha." union select g.id_gasto id_gasto, g.gasto gasto, 0 importe, g.rep rep,g.orden orden
from gastos g 
where g.id_gasto not in (select id_gasto from gastos_ficha where id_ficha = ".$id_ficha.")
ORDER BY orden ASC ";
		}
		else
		{
			$select = " g.id_gasto id_gasto, g.gasto gasto, '' importe, g.rep rep, g.orden orden "; 
	 		$from = " gastos g ";
    		$where = " g.id_gasto > 0 ORDER BY orden ASC ";
		}
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	

	
	
	public function getDeudorFicha($idf)
	{
		$dato = new Ficha();
		$dato->add_filter("id_ficha","=",$idf);
		$dato->load();
		
		$datod = new Deudores();
		$datod->add_filter("id_deudor","=",$dato->get_data("id_deudor"));
		$datod->load();
		
		return $datod;
	}

	public function editarDeudor($arrayParam)
	{
		// DATOS DEL DEUDOR
		$dato = new Deudores();
		$dato->add_filter("id_deudor","=",$arrayParam["iddeudor"]);
		$dato->load();
		$dato->set_data("rut_deudor",(int)($arrayParam["rut"])); 
		$dato->set_data("rut_deudor_s",$arrayParam["rut"].$arrayParam["rut_d"]);
		$dato->set_data("dv_deudor",$arrayParam["rut_d"]);
		$dato->set_data("razonsocial",$arrayParam["razonsocial"]);
		$dato->set_data("primer_nombre",$arrayParam["pnombre"]);
		$dato->set_data("segundo_nombre",$arrayParam["snombre"]);
		$dato->set_data("primer_apellido",$arrayParam["papellido"]);
		$dato->set_data("segundo_apellido",$arrayParam["sapellido"]);
		$dato->set_data("razonsocial",utf8_decode($arrayParam["razonsocial"]));
		$dato->set_data("primer_nombre",utf8_decode($arrayParam["pnombre"]));
		$dato->set_data("segundo_nombre",utf8_decode($arrayParam["snombre"]));
		$dato->set_data("primer_apellido",utf8_decode($arrayParam["papellido"]));
		$dato->set_data("segundo_apellido",utf8_decode($arrayParam["sapellido"]));
//		$dato->set_data("comentario",$arrayParam["pnombre"]);
		$dato->set_data("celular",$arrayParam["celular"]);
		$dato->set_data("telefono_fijo",$arrayParam["telefono"]);
		$dato->set_data("email",$arrayParam["email"]);
		$dato->set_data("tipo",$arrayParam["tipo"]);
		$dato->set_data("rep_legal",$arrayParam["rep_legal"]);
		
		$dato->set_data("activo","S");
		$dato->save();
		
		$id_deudor = $arrayParam["iddeudor"];
		
		// DIRECIONES DEL DEUDOR
		$dirb = new Direccion_Deudores();
		$dirb->add_filter("id_deudor","=",$id_deudor);
		$dirb->load();
		$dirb->mark_deleted();
		$dirb->save();
					
		$dir = new Direccion_DeudoresTmpCollection();
		$dir->add_filter("id_sesion","=",$arrayParam["session_id"]);
		$dir->load();
		
		for($j=0; $j<$dir->get_count(); $j++) 
		{
			$datoTmp = &$dir->items[$j];
			
			$dirdeu = new Direccion_Deudores();
			$dirdeu->set_data("id_deudor",$id_deudor);
			$dirdeu->set_data("calle", $datoTmp->get_data("calle"));
			$dirdeu->set_data("numero", $datoTmp->get_data("numero"));
			$dirdeu->set_data("piso", $datoTmp->get_data("piso"));
			$dirdeu->set_data("depto", $datoTmp->get_data("depto"));
			$dirdeu->set_data("comuna", $datoTmp->get_data("comuna"));
			$dirdeu->set_data("ciudad", $datoTmp->get_data("ciudad"));
			$dirdeu->set_data("otros", $datoTmp->get_data("otros"));
			$dirdeu->set_data("vigente", $datoTmp->get_data("vigente"));
			/*
			if($arrayParam["id_dir"] == $datoTmp->get_data("id_direccion"))
			{
				$dirdeu->set_data("vigente", $arrayParam["vigente"]);	
			}
			else
			{
				$dirdeu->set_data("vigente", "N");
			}
			*/
			
			$dirdeu->save();
		}
		
		$dir->mark_deleted();
		$dir->save();
		
		// MANDANTES DEL DEUDOR
		$mandeub = new Deudor_MandanteCollection();
		$mandeub->add_filter("id_deudor","=",$id_deudor);
		$mandeub->load();
		$mandeub->mark_deleted();
		$mandeub->save();
		
		$mand = new Deudor_MandanteTmpCollection();
		$mand->add_filter("id_sesion","=",$arrayParam["session_id"]);
		$mand->load();
		
		for($j=0; $j<$mand->get_count(); $j++) 
		{
			$datoTmp = &$mand->items[$j];
			
			$mandeu = new Deudor_Mandante();
			$mandeu->set_data("id_deudor",$id_deudor);
			$mandeu->set_data("id_mandante", $datoTmp->get_data("id_mandante"));
			$mandeu->save();
		}
		
		$mand->mark_deleted();
		$mand->save();
	}

	public function getDeudorDatos($id)
	{
		$dato = new Deudores();
		$dato->add_filter("id_deudor","=",$id);
		$dato->load();
		return $dato;
	}
	
	public function getDeudor($id, $id_sesion)
	{
		$dato = new Deudores();
		$dato->add_filter("id_deudor","=",$id);
		$dato->load();
		
		// LLENAR TABLA TEMPORAL CON DIRECIONES DEL DEUDOR 
		$dirdel = new Direccion_DeudoresTmpCollection(); // (revisar delete sobre colleccion u objeto)
		$dirdel->add_filter("id_sesion","=",$id_sesion);
		$dirdel->load();
		$dirdel->mark_deleted();
		$dirdel->save();
		
		$dir= new Direccion_DeudoresCollection();
		$dir->add_filter("id_deudor","=",$id);
		$dir->load();
		
		for($j=0; $j<$dir->get_count(); $j++) 
		{
			$datoTmp = &$dir->items[$j];
			
			$dirdeu = new Direccion_DeudoresTmp();
			$dirdeu->set_data("id_deudor",$id);
			$dirdeu->set_data("calle", $datoTmp->get_data("calle"));
			$dirdeu->set_data("numero", $datoTmp->get_data("numero"));
			$dirdeu->set_data("piso", $datoTmp->get_data("piso"));
			$dirdeu->set_data("depto", $datoTmp->get_data("depto"));
			$dirdeu->set_data("comuna", $datoTmp->get_data("comuna"));
			$dirdeu->set_data("ciudad", $datoTmp->get_data("ciudad"));
			$dirdeu->set_data("otros", $datoTmp->get_data("otros"));
			$dirdeu->set_data("vigente", $datoTmp->get_data("vigente"));
			$dirdeu->set_data("id_sesion", $id_sesion);
			$dirdeu->save();
		}
		
		// LLENAR TABLA TEMPORAL CON MANDANTES DEL DEUDOR 
		$dmtmp = new Deudor_MandanteTmpCollection(); // (revisar delete sobre colleccion u objeto)
		$dmtmp->add_filter("id_sesion","=",$id_sesion);
		$dmtmp->load();
		$dmtmp->mark_deleted();
		$dmtmp->save();
		
		$deumand = new Deudor_MandanteCollection();
		$deumand->add_filter("id_deudor","=",$id);
		$deumand->load();
		
		for($j=0; $j<$deumand->get_count(); $j++) 
		{
			$datoTmp = &$deumand->items[$j];
			
			$mandeu = new Deudor_MandanteTmp();
			$mandeu->set_data("id_mandante", $datoTmp->get_data("id_mandante"));
			$mandeu->set_data("id_sesion", $id_sesion);
			$mandeu->save();
		}
		
		return $dato;
	}
	
	public function bajaDeudor($id, $rut,$p_ape,$s_ape,$p_nom,$s_nom)
	{
		$datoe = new Deudores();
		$datoe->add_filter("id_deudor","=",$id);
		$datoe->load();
		$datoe->set_data("activo","N");
		$datoe->save();
		
		$dato = new DeudoresCollection();
		$dato->add_filter("activo","=","S");
		
		if($rut <> "" && $rut <> 0)
		{
			$dato->add_filter("AND");
			$dato->add_filter("rut_deudor_s","like",trim($rut)."%");
		}
		
		
		if(trim($p_ape) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("primer_apellido","like",trim($p_ape)."%");
		}
		if(trim($s_ape) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("segundo_apellido","like",trim($s_ape)."%");
		}
		if(trim($p_nom) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("primer_nombre","like",trim($p_nom)."%");
		}
		if(trim($s_nom) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("segundo_nombre","like",trim($s_nom)."%");
		}

		$dato->load();
		
		return $dato;
	}

	public function guardarDeudor($arrayParam)
	{
		// DATOS DEL DEUDOR
		$dato = new Deudores();
		$dato->set_data("rut_deudor",(int)($arrayParam["rut"])); 
		$dato->set_data("rut_deudor_s",$arrayParam["rut"].$arrayParam["rut_d"]);
		$dato->set_data("dv_deudor",$arrayParam["rut_d"]);
		$dato->set_data("razonsocial",utf8_decode($arrayParam["razonsocial"]));
		$dato->set_data("primer_nombre",utf8_decode($arrayParam["papellido"]));
		$dato->set_data("segundo_nombre",utf8_decode($arrayParam["sapellido"]));
		$dato->set_data("primer_apellido",utf8_decode($arrayParam["pnombre"]));
		$dato->set_data("segundo_apellido",utf8_decode($arrayParam["snombre"]));
		$dato->set_data("comentario",utf8_decode($arrayParam["pnombre"]));
		$dato->set_data("celular",utf8_decode($arrayParam["celular"]));
		$dato->set_data("telefono_fijo",utf8_decode($arrayParam["telefono"]));
		$dato->set_data("email",utf8_decode($arrayParam["email"]));
		$dato->set_data("tipo",utf8_decode($arrayParam["tipo"]));
		$dato->set_data("rep_legal",utf8_decode($arrayParam["rep_legal"]));
		$dato->set_data("activo","S");
		$dato->set_data("id_mandante",$arrayParam["idmandante"]);
		$dato->save();
		
		$id_deudor = getUltimoId(new DeudoresCollection(), "id_deudor");
		
		// DIRECCIONES DEL DEUDOR
		$dir= new Direccion_DeudoresTmpCollection();
		$dir->add_filter("id_sesion","=",$arrayParam["session_id"]);
		$dir->load();
		
		for($j=0; $j<$dir->get_count(); $j++) 
		{
			$datoTmp = &$dir->items[$j];
			
			$dirdeu = new Direccion_Deudores();
			$dirdeu->set_data("id_deudor",$id_deudor);
			$dirdeu->set_data("calle", $datoTmp->get_data("calle"));
			$dirdeu->set_data("numero", $datoTmp->get_data("numero"));
			$dirdeu->set_data("piso", $datoTmp->get_data("piso"));
			$dirdeu->set_data("depto", $datoTmp->get_data("depto"));
			$dirdeu->set_data("comuna", $datoTmp->get_data("comuna"));
			$dirdeu->set_data("ciudad", $datoTmp->get_data("ciudad"));
			$dirdeu->set_data("otros", $datoTmp->get_data("otros"));
			$dirdeu->save();
		}
		
		$dir->mark_deleted();
		$dir->save();
		
		// MANDANTES DEL DEUDOR
		$mand = new Deudor_MandanteTmpCollection();
		$mand->add_filter("id_sesion","=",$arrayParam["session_id"]);
		$mand->load();
		
		for($j=0; $j<$mand->get_count(); $j++) 
		{
			$datoTmp = &$mand->items[$j];
			
			$mandeu = new Deudor_Mandante();
			$mandeu->set_data("id_deudor",$id_deudor);
			$mandeu->set_data("id_mandante", $datoTmp->get_data("id_mandante"));
			$mandeu->save();
		}
		
		$mand->mark_deleted();
		$mand->save();
		
	}
	
	public function getListaDeudores($rut,$p_ape,$s_ape,$p_nom,$s_nom,$id_partida)
	{
		$dato = new DeudoresCollection();
		$dato->add_filter("activo","=","S");
		$dato->add_filter("AND");
		$dato->add_filter("id_deudor",">",$id_partida);
		
		if($rut <> "" && $rut <> 0)
		{
			$dato->add_filter("AND");
			$dato->add_filter("rut_deudor","like","'".trim($rut)."%'");
		}
		
		if(trim($p_ape) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("primer_apellido","like",trim($p_ape)."%");
		}
		if(trim($s_ape) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("segundo_apellido","like",trim($s_ape)."%");
		}
		if(trim($p_nom) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("primer_nombre","like",trim($p_nom)."%");
		}
		if(trim($s_nom) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("segundo_nombre","like",trim($s_nom)."%");
		}

		$dato->add_filter("order by primer_apellido, primer_nombre, rut_deudor asc ");
		
//		$dato->add_top(3);      //es para sqlserver
		$dato->add_limit(0,30);  //es para mysql
		$dato->load();
	
		return $dato;
	}
		
	public function borrarmandantetmp($id_sesion)
	{
		$dato = new Deudor_MandanteTmp();
		$dato->add_filter("id_sesion","=",$id_sesion);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
	public function getListaMandantesSesion($idsession)
	{
		$dato = new Deudor_MandanteTmpCollection();
		$dato->add_filter("id_sesion","=",$idsession);
		$dato->load();
		
		$where = "(";
		$mand = "";
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			if($mand == "")
			{
				$mand .= $datoTmp->get_data("id_mandante");
			}
			else
			{
				$mand .= ", ".$datoTmp->get_data("id_mandante");
			}
		}
		
		$where .= $mand.")";
		
		$mandante = new MandantesCollection();
		if($mand <> "")
		{
			$mandante->add_filter("id_mandante","IN",$where);
			$mandante->load();
		}
		
		return $mandante;
	}
	
	public function agregaMandanteTmp($id,$ids)
	{
		$control = new Deudor_MandanteTmpCollection();
		$control->add_filter("id_sesion","=",$ids);
		$control->add_filter("AND");
		$control->add_filter("id_mandante","=",$id);
		$control->load();
		
		if($control->get_count() == 0)
		{
			$dato = new Deudor_MandanteTmp();
			$dato->set_data("id_sesion",$ids);
			$dato->set_data("id_mandante",$id);
			$dato->save();
		}
	}
	
	public function quitarMandanteTmp($id,$ids)
	{
		$dato = new Deudor_MandanteTmp();
		$dato->add_filter("id_sesion","=",$ids);
		$dato->add_filter("AND");
		$dato->add_filter("id_mandante","=",$id);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
	public function lista_demandas($iddeudor)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
		$sqlpersonal->set_select( "   juzgado_anexo juzgado,
									  f.rol rol,
									  f.id_ficha ficha,
									  f.ingreso fecha,
									  f.monto monto,
									  f.aval aval  ");
		$sqlpersonal->set_from( " ficha f ");
		$sqlpersonal->set_where( " f.id_deudor = ".$iddeudor);
	
    	$sqlpersonal->load();

    	return $sqlpersonal;	
	}
	
	public function getTodasFichas($array)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	    $rutdeudor = $array["rutdeudor"];
		$sqlpersonal->set_select( " f.id_ficha id_ficha,
	   		   d.rut_deudor rut_deudor,d.dv_deudor dv_deudor,
	           d.primer_nombre d_primer_nombre, d.segundo_nombre d_segundo_nombre,
	    	   d.primer_apellido d_primer_apellido, d.segundo_apellido d_segundo_apellido,
	   		   m.rut_mandante rut_mandante,m.dv_mandante dv_mandante,
	   		   m.nombre nombre,
	   		   f.ingreso ingreso");
		$sqlpersonal->set_from(" ficha f, deudores d, mandantes m ");
		
		$where = " f.id_deudor = d.id_deudor and f.id_mandante = m.id_mandante  ";
		if($rutdeudor != "")
		{
			$where = $where." and d.rut_deudor LIKE '".$array["rutdeudor"]."%'";
		}
		
		$where .= " and f.id_ficha > ".$array["id_partida"];
		
		$sqlpersonal->set_where($where);
		$sqlpersonal->set_limit(0,30); // PARA MYSQL
    	$sqlpersonal->load();

    	return $sqlpersonal;	
	}
	
	public function valRutDeudor($array)
    {
		$resp = 0; 
		
		if($array["tipoval"] == "EXISTE")
		{
			$dato = new Deudores();
			$dato->add_filter("activo","=","S");
			$dato->add_filter("AND");
			$dato->add_filter("rut_deudor","=",$array["rut"]);
			$dato->add_filter("AND");
			$dato->add_filter("dv_deudor","=",$array["dv"]);
			$dato->load();
			
			if(!is_null($dato->get_data("id_deudor")))
			{
				$resp = $dato->get_data("id_deudor");
			}
		}
		
		echo($resp);
    }
	
	public function grabarSimulacionDeudor($array)
	{
		if($array["id_liquidacion"] == 0)
		{
			$dato_liq = new Liquidaciones();
			$dato_liq->set_data("id_deudor",$array["id_deudor"]);
			$dato_liq->set_data("id_mandante",$array["id_mandante"]);
			$dato_liq->set_data("fecha_creacion",date("Y-m-d H:i:s"));
			$dato_liq->set_data("usuario_creacion",$array["id_usuario"]);
			$dato_liq->save();
			$id_liq = getUltimoId(new LiquidacionesCollection(),"id_liquidacion");
			
			$dato = new Liquidacion_simulacion();
			$dato->set_data("id_liquidacion",$id_liq);
			$dato->set_data("id_deudor",$array["id_deudor"]);
			$dato->set_data("protesto",$array["txtprotesto"]);
			$dato->set_data("monto",$array["txtmonto"]);
			$dato->set_data("total",$array["txttotal"]);
			$dato->set_data("fecha_venc",formatoFecha($array["txtfechavenc"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dato->set_data("diasatraso",$array["txtdiasatraso"]);
			$dato->set_data("interes_diario",$array["txtinteresdiario"]);
			$dato->set_data("interes_acumulado",$array["txtinteresacumulado"]);
			$dato->save();
		
			$id_sim = getUltimoId(new Liquidacion_simulacionCollection(),"id");
		
			$array_doc = explode(",",$array["docs"]);
			for($i=0; $i<count($array_doc); $i++)
			{
				$doc_sim = new Liquidacion_simulacion_doc();
				$doc_sim->set_data("id_liquidacion_simulacion",$id_sim);
				$doc_sim->set_data("id_documento",$array_doc[$i]);
				$doc_sim->save();
			}		
		}
		else
		{
			$id_liq = $array["id_liquidacion"];
			
			$dato_liq = new Liquidaciones();
			$dato_liq->add_filter("id_liquidacion","=",$id_liq);
			$dato_liq->load();
			
			
			$dato = new Liquidacion_simulacion();
			$dato->add_filter("id_liquidacion","=",$array["id_liquidacion"]);
			$dato->load();
			
			if(is_null($dato->get_data("id")))
			{		
				$dato_new = new Liquidacion_simulacion();
				$dato_new->set_data("id_liquidacion",$array["id_liquidacion"]);
				$dato_new->set_data("id_deudor",$array["id_deudor"]);
				$dato_new->set_data("protesto",$array["txtprotesto"]);
				$dato_new->set_data("monto",$array["txtmonto"]);
				$dato_new->set_data("total",$array["txttotal"]);
				$dato_new->set_data("fecha_venc",formatoFecha($array["txtfechavenc"],"dd/mm/yyyy","yyyy-mm-dd"));
				$dato_new->set_data("diasatraso",$array["txtdiasatraso"]);
				$dato_new->set_data("interes_diario",$array["txtinteresdiario"]);
				$dato_new->set_data("interes_acumulado",$array["txtinteresacumulado"]);
				$dato_new->save();
						
				$id_sim = getUltimoId(new Liquidacion_simulacionCollection(),"id");
		
				$array_doc = explode(",",$array["docs"]);
				for($i=0; $i<count($array_doc); $i++)
				{
					$doc_sim = new Liquidacion_simulacion_doc();
					$doc_sim->set_data("id_liquidacion_simulacion",$id_sim);
					$doc_sim->set_data("id_documento",$array_doc[$i]);
					$doc_sim->save();
				}
			}
			else
			{
				$dato_liq->set_data("fecha_modificacion",date("Y-m-d H:i:s"));
				$dato_liq->set_data("usuario_modificacion",$array["id_usuario"]);
				$dato_liq->save();
				
				$dato->set_data("id_deudor",$array["id_deudor"]);
				$dato->set_data("protesto",$array["txtprotesto"]);
				$dato->set_data("monto",$array["txtmonto"]);
				$dato->set_data("total",$array["txttotal"]);
				$dato->set_data("fecha_venc",formatoFecha($array["txtfechavenc"],"dd/mm/yyyy","yyyy-mm-dd"));
				$dato->set_data("diasatraso",$array["txtdiasatraso"]);
				$dato->set_data("interes_diario",$array["txtinteresdiario"]);
				$dato->set_data("interes_acumulado",$array["txtinteresacumulado"]);
				$dato->save();
				
				$doc_sim_del = new Liquidacion_simulacion_doc();
				$doc_sim_del->add_filter("id_liquidacion_simulacion","=",$dato->get_data("id"));
				$doc_sim_del->load();
				$doc_sim_del->mark_deleted();
				$doc_sim_del->save();
				
				$array_doc = explode(",",$array["docs"]);
				for($i=0; $i<count($array_doc); $i++)
				{
					$doc_sim = new Liquidacion_simulacion_doc();
					$doc_sim->set_data("id_liquidacion_simulacion",$dato->get_data("id"));
					$doc_sim->set_data("id_documento",$array_doc[$i]);
					$doc_sim->save();
				}
			}
		}
		
		return $id_liq;
	}
	
	public function getSimulacionLiquidacion($array)
	{
		$dato = new Liquidacion_simulacion();
		$dato->add_filter("id_liquidacion","=",$array["id_liquidacion"]);
		$dato->load();
		
		return $dato;
	}
	
	public function getDocSimulacionLiquidacion($array)
	{	
		
		$col = new Liquidacion_simulacion_docCollection();
		$col->add_filter("id_liquidacion_simulacion","=",$array["id_liquidacion"]);
		$col->load();
		
		return $col;
	}
	
	public function grabarLiquidacion($array)
	{
		$deudor = new Deudores();
		$deudor->add_filter("id_deudor","=",$array["deudor"]);
		$deudor->load();
		
		$dato = new Liquidaciones();
		$dato->set_data("id_deudor",$array["deudor"]);
		$dato->set_data("id_mandante",$deudor->get_data("id_mandante"));
		$dato->set_data("interes",$array["interes"]);
//		$dato->set_data("valor_uf",$array["valoruf"]);
		
		$dato->set_data("fecha_simulacion",formatoFecha($array["fechasimulacion"],"dd/mm/yyyy","yyyy-mm-dd"));
		$dato->set_data("capital",$array["capital"]);
		$dato->set_data("capital_pagado",$array["capitalpagado"]);
		$dato->set_data("protesto",$array["protesto"]);
		$dato->set_data("fecha_venc",formatoFecha($array["fechavenc"],"dd/mm/yyyy","yyyy-mm-dd"));
		$dato->set_data("dias_atraso",$array["diasatraso"]);
		$dato->set_data("interes_diario",$array["interesdiario"]);
		$dato->set_data("interes_acumulado",$array["interesacumulado"]);
		$dato->set_data("honorarios_dyv",$array["honoraiorsdyv"]);
		$dato->set_data("total_simulacion",$array["total"]);
		$dato->set_data("repacta",$array["repacta"]);
		
		if($array["repacta"] == "S")
		{
			$dato->set_data("importe_prestamo",$array["importeprestamo"]);
			$dato->set_data("interes_mensual",$array["interesmensual"]);
			$dato->set_data("cuotas",$array["cuotas"]);
			$dato->set_data("fecha_calculo",formatoFecha($array["fechacalculo"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dato->set_data("fecha_pago",formatoFecha($array["fechapago"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dato->set_data("imp",$array["imp"]);
			$dato->set_data("pago_mensual",$array["pagomensual"]);
			$dato->set_data("costo_total",$array["costototal"]);
		}
	
			$dato->set_data("fecha_creacion",date("Y-m-d"));
			$dato->set_data("usuario_creacion",$array["id_usuario"]);
		$dato->save();	
		
		$id_new = getUltimoId(new LiquidacionesCollection(), "id_liquidacion");
		
		$arraydoc = explode(",",$array["docs"]);
		for($i=0; $i<count($arraydoc); $i++)
		{
			$doc_sim = new Liquidacion_simulacion_doc();
			$doc_sim->set_data("id_liquidacion_simulacion",$id_new);
			$doc_sim->set_data("id_documento",$arraydoc[$i]);
			$doc_sim->save();
		}
	}
	
	public function grabar_editaLiquidacion($array)
	{
		$deudor = new Deudores();
		$deudor->add_filter("id_deudor","=",$array["deudor"]);
		$deudor->load();
		
		$dato = new Liquidaciones();
		$dato->add_filter("id_liquidacion","=",$array["id_liquidacion"]);
		$dato->load();
		$dato->set_data("id_mandante",$deudor->get_data("id_mandante"));
		$dato->set_data("interes",$array["interes"]);
//		$dato->set_data("valor_uf",$array["valoruf"]);
		$dato->set_data("fecha_simulacion",formatoFecha($array["fechasimulacion"],"dd/mm/yyyy","yyyy-mm-dd"));
		$dato->set_data("capital",$array["capital"]);
		$dato->set_data("capital_pagado",$array["capitalpagado"]);
		$dato->set_data("protesto",$array["protesto"]);
//		$dato->set_data("fecha_venc",formatoFecha($array["fechavenc"],"dd/mm/yyyy","yyyy-mm-dd"));
//		$dato->set_data("dias_atraso",$array["diasatraso"]);
//		$dato->set_data("interes_diario",$array["interesdiario"]);
		$dato->set_data("interes_acumulado",$array["interesacumulado"]);
		$dato->set_data("costas_procesales",$array["costasprocesales"]);		
		$dato->set_data("honorarios_dyv",$array["honoraiorsdyv"]);
		$dato->set_data("total_simulacion",$array["total"]);
		$dato->set_data("repacta",$array["repacta"]);
		if($array["repacta"] == "S")
		{
			$dato->set_data("importe_prestamo",$array["importeprestamo"]);
			$dato->set_data("interes_mensual",$array["interesmensual"]);
			$dato->set_data("cuotas",$array["cuotas"]);
			$dato->set_data("fecha_calculo",formatoFecha($array["fechacalculo"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dato->set_data("fecha_pago",formatoFecha($array["fechapago"],"dd/mm/yyyy","yyyy-mm-dd"));
			$dato->set_data("imp",$array["imp"]);
			$dato->set_data("pago_mensual",$array["pagomensual"]);
			$dato->set_data("costo_total",$array["costototal"]);
		}
		$dato->set_data("fecha_modificacion",date("Y-m-d"));
		$dato->set_data("usuario_modificacion",$array["id_usuario"]);
		$dato->save();	
		
		$doc_del = new Liquidacion_simulacion_doc();
		$doc_del->add_filter("id_liquidacion_simulacion","=",$array["id_liquidacion"]);
		$doc_del->load();
		$doc_del->mark_deleted();
		$doc_del->save();
		
		$arraydoc = explode(",",$array["docs"]);
		for($i=0; $i<count($arraydoc); $i++)
		{
			$doc_sim = new Liquidacion_simulacion_doc();
			$doc_sim->set_data("id_liquidacion_simulacion",$array["id_liquidacion"]);
			$doc_sim->set_data("id_documento",$arraydoc[$i]);
			$doc_sim->save();
		}
	}
	
	public function altaDDAEjec($param)
	{
		$resp = 0;
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			// graba receptor y devuelve id ficha
			$resp = $param["id_alta"];
				
			$val = new DemandaEjecutiva();
			$val->add_filter("id_ficha","=",$resp);
			$val->load();
				
			$datoc = new Consignacion_Ficha();
				
			if($val->get_count() > 0)
			{
				$datoc->add_filter("id_ficha","=",$resp);
				$datoc->load();
				$id_consig = $datoc->get_data("id_demanda_ejecutiva");
			}
				
			$datoc->set_data("id_ficha",$resp);
			$datoc->set_data("nombre_receptor",$param["txtconsignacion"]);
			$datoc->set_data("email_receptor",$param["txtabono_1"]);
			$datoc->set_data("fono_receptor",$param["txtabono_2"]);
			$datoc->set_data("certificado",$param["txtabono_3"]);
			$datoc->set_data("abono_4",$param["txtabono_4"]);
			$datoc->set_data("mandamiento",$param["txtpago_cliente"]);
			$datoc->set_data("fecha_busqueda",$param["txtgiro_cheque_1"]);
			$datoc->set_data("dda_ejecutiva",$param["txtentrega_cheque"]);
			$datoc->set_data("encargado_receptor",$param["txtcostas_procesales"]);
			$datoc->set_data("notificacion",$param["txtpago_costas"]);
		//	$datoc->set_data("usuario",$param["txtentrega_cheque_1"]);
		//	$datoc->set_data("fecha_modificacion",$param["txtdevolucion_documento"]);
			
			
			
			$datoc->save();
				
			if($val->get_count() == 0)
			{
				$id_consig = getUltimoId(new DemandaEjecutivaCollection(), "id_demanda_ejecutiva");
			}
				
			$colGastoConsignacion = $this->getGastosConsignacion(0);
				
			for($j=0; $j<$colGastoConsignacion->get_count(); $j++)
			{
			$datoTmp = &$colGastoConsignacion->items[$j];
	
			$imp = 0;
			if(trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]) <> "")
			{
			$imp = trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]);
			}
			$gastos_cf = new Gastos_Consignacion_Ficha();
			if($val->get_count() > 0)
			{
			$gastos_cf->add_filter("id_ficha","=",$resp);
			$gastos_cf->add_filter("AND");
			$gastos_cf->add_filter("id_consignacion","=",$id_consig);
			$gastos_cf->add_filter("AND");
			$gastos_cf->add_filter("id_gasto","=",$datoTmp->get_data("id_gasto"));
					$gastos_cf->load();
			}
					$gastos_cf->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
					$gastos_cf->set_data("id_consignacion",$id_consig);
					$gastos_cf->set_data("id_ficha",$resp);
					$gastos_cf->set_data("importe",$imp);
					$gastos_cf->save();
	
					$gasto_ficha = new Gastos_Ficha();
					if($val->get_count() > 0)
					{
					$gasto_ficha->add_filter("id_ficha","=",$resp);
						$gasto_ficha->add_filter("AND");
						$gasto_ficha->add_filter("id_gasto","=",$datoTmp->get_data("id_gasto"));
						$gasto_ficha->load();
					}
					$gasto_ficha->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
					$gasto_ficha->set_data("id_ficha",$resp);
					$gasto_ficha->set_data("importe",$imp);
					$gasto_ficha->save();
			}
				
			$ultid_ficha = $resp;
			}
			else
			{
			// graba ficha, receptor y devuelve id ficha
				
			$datof = new Ficha();
						$datof->set_data("id_deudor",0);
						$datof->save();
							
						$ultid_ficha = getUltimoId(new FichaCollection(), "id_ficha");
							
						$datoc = new Consignacion_Ficha();
						$datoc->set_data("id_ficha",$ultid_ficha);
						$datoc->set_data("consignacion",$param["txtconsignacion"]);
			$datoc->set_data("abono_1",$param["txtabono_1"]);
				$datoc->set_data("abono_2",$param["txtabono_2"]);
				$datoc->set_data("abono_3",$param["txtabono_3"]);
				$datoc->set_data("abono_4",$param["txtabono_4"]);
				$datoc->set_data("pago_cliente",$param["txtpago_cliente"]);
			$datoc->set_data("giro_cheque_1",$param["txtgiro_cheque_1"]);
			$datoc->set_data("entrega_cheque",$param["txtentrega_cheque"]);
			$datoc->set_data("costas_procesales",$param["txtcostas_procesales"]);
						$datoc->set_data("pago_costas",$param["txtpago_costas"]);
			$datoc->set_data("entrega_cheque_1",$param["txtentrega_cheque_1"]);
						$datoc->set_data("devolucion_documento",$param["txtdevolucion_documento"]);
						$datoc->set_data("entrega_documento",$param["txtentrega_documento"]);
						$datoc->set_data("monto_consignacion",$param["txtmonto_consignacion"]);
						$datoc->set_data("monto_1",$param["txtmonto_1"]);
								$datoc->set_data("monto_2",$param["txtmonto_2"]);
								$datoc->set_data("monto_3",$param["txtmonto_3"]);
								$datoc->set_data("monto_4",$param["txtmonto_4"]);
			$datoc->set_data("pago_dyv",$param["txtpago_dyv"]);
			$datoc->set_data("providencia_1",$param["txtprovidencia_1"]);
			$datoc->set_data("providencia_2",$param["txtprovidencia_2"]);
			$datoc->set_data("giro_cheque_2",$param["txtgiro_cheque_2"]);
			$datoc->set_data("providencia_3",$param["txtprovidencia_3"]);
			$datoc->set_data("rendicion_cliente",$param["txtrendicion_cliente"]);
			$datoc->save();
					
				$ultid_consig = getUltimoId(new Consignacion_FichaCollection(), "id_consignacion");
	
			$colGastoConsignacion = $this->getGastosConsignacion(0);
					
				for($j=0; $j<$colGastoConsignacion->get_count(); $j++)
				{
				$datoTmp = &$colGastoConsignacion->items[$j];
	
				$imp = 0;
			if(trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]) <> "")
				{
					$imp = trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]);
			}
			$gastos_mf = new Gastos_Consignacion_Ficha();
			$gastos_mf->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
			$gastos_mf->set_data("id_consignacion",$ultid_consig);
				$gastos_mf->set_data("id_ficha",$ultid_ficha);
					$gastos_mf->set_data("importe",$imp);
					$gastos_mf->save();
	
					$gasto_ficha = new Gastos_Ficha();
			$gasto_ficha->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
					$gasto_ficha->set_data("id_ficha",$ultid_ficha);
					$gasto_ficha->set_data("importe",$imp);
					$gasto_ficha->save();
			}
				}
	
			return $ultid_ficha;
		}
	
	public function getDdaEjecutiva($idd)
	{
		$dato = new DemandaEjecutiva();
		$dato->add_filter("id_ficha","=",$idd);
		$dato->load();
		
		return $dato;
	}
	
	
	public function altaDdaEjecFicha($param)
	{
		$resp = 0;
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			// graba demanda y devuelve id ficha
			$resp = $param["id_alta"];
				
			$val = new DemandaEjecutivaCollection();
			$val->add_filter("id_ficha","=",$resp);
			$val->load();
				
			$datoc = new DemandaEjecutiva();
			
			if($val->get_count() > 0)
			{
				$datoc->add_filter("id_ficha","=",$resp);
				$datoc->load();
				$id_consig = $datoc->get_data("id_dda_ejecutiva");
			}
				
			$datoc->set_data("id_ficha",$resp);
			$datoc->set_data("nombre_receptor",$param["txtnomreceptor"]);
			$datoc->set_data("email_receptor",$param["txtemailreceptor"]);
			$datoc->set_data("fono_receptor",$param["txtfonoreceptor"]);
			$datoc->set_data("certificado",formatoFecha($param["txtcertificado"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("mandamiento",formatoFecha($param["txtmandamiento"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("fecha_busqueda",formatoFecha($param["txtbusqueda"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("dda_ejecutiva",formatoFecha($param["txtddaejec"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("encargado_receptor",formatoFecha($param["txtencargado"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("notificacion",formatoFecha($param["txtnotificacion"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("usuario",$param["idusuario"]);
			$datoc->set_data("gasto",$param["txtgasto"]);
			$datoc->save();
			
			$gasto_ficha = new Gastos_Ficha();
			if($val->get_count() > 0)
			{
				$gasto_ficha->add_filter("id_ficha","=",$resp);
				$gasto_ficha->add_filter("AND");
				$gasto_ficha->add_filter("id_gasto","=",10); // Gasto Demanda ejecutiva
				$gasto_ficha->load();
			}
			$gasto_ficha->set_data("id_gasto",10);
			$gasto_ficha->set_data("id_ficha",$resp);
			$gasto_ficha->set_data("importe",$param["txtgasto"]);
			$gasto_ficha->save();

			$ultid_ficha = $resp;
		}
		else
		{
			// graba ficha, demanda y devuelve id ficha
				
			$datof = new Ficha();
			$datof->set_data("id_deudor",0);
			$datof->save();
							
			$ultid_ficha = getUltimoId(new FichaCollection(), "id_ficha");
							
			$datoc = new DemandaEjecutiva();
				
			$datoc->set_data("id_ficha",$ultid_ficha);
			$datoc->set_data("nombre_receptor",$param["txtnomreceptor"]);
			$datoc->set_data("email_receptor",$param["txtemailreceptor"]);
			$datoc->set_data("fono_receptor",$param["txtfonoreceptor"]);
			$datoc->set_data("certificado",formatoFecha($param["txtcertificado"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("mandamiento",formatoFecha($param["txtmandamiento"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("fecha_busqueda",formatoFecha($param["txtbusqueda"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("dda_ejecutiva",formatoFecha($param["txtddaejec"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("encargado_receptor",formatoFecha($param["txtencargado"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("notificacion",formatoFecha($param["txtnotificacion"],"dd/mm/yyyy","yyyy-mm-dd"));
			$datoc->set_data("usuario",$param["idusuario"]);
			$datoc->set_data("gasto",$param["txtgasto"]);
			$datoc->save();
			
			$gasto_ficha = new Gastos_Ficha();
			$gasto_ficha->set_data("id_gasto",10);
			$gasto_ficha->set_data("id_ficha",$ultid_ficha);
			$gasto_ficha->set_data("importe",$param["txtgasto"]);
			$gasto_ficha->save();
					
			$ultid_consig = getUltimoId(new DemandaEjecutivaCollection(), "id_dda_ejecutiva");

			}
	
			return $ultid_ficha;
		}
	
	public function getGastosficha($idficha)
	{
		
		include("config.php");

		
		$select = " sum(gf.importe) total_gastos "; 
 		$from = " gastos_ficha gf ";
    	$where = " gf.id_ficha = ".$idficha;
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	
	public function getGastosfichadeudor($iddeudor)
	{
		
		include("config.php");
		
		$select = " SUM(gf.importe) total_gastos "; 
 		$from = " gastos_ficha gf, ficha f ";
    	$where = " gf.id_ficha = f.id_ficha and f.id_deudor =".$iddeudor;
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	
	public function getRolDemanda($iddeudor)
	{
		
		include("config.php");

		
		$select = " MIN(id_ficha) idficha, rol rol, juzgado_anexo juzgado_anexo, aval aval "; 
 		$from = " ficha f ";
    	$where = " id_deudor = ".$iddeudor;
    	$where = $where . " GROUP BY rol ";
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	
	public function eliminaFicha($id)
	{
		$dato = new Ficha();
		$dato->add_filter("id_ficha","=",$id);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
	public function eliminaFichaDoc($id)
	{
		$dato = new Documento_Ficha();
		$dato->add_filter("id_ficha","=",$id);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
}
?>