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

	public function altaFicha($param)
	{
		$deudor = new Deudores();
		$deudor->add_filter("rut_deudor","=",trim($param["txtrut_deudor"]));
		$deudor->add_filter("AND");
		$deudor->add_filter("dv_deudor","=",trim($param["txtrut_d_deudor"]));
		$deudor->load();
		
		$mandante = new Mandantes();
		$mandante->add_filter("rut_mandante","=",trim($param["txtrut_mandante"]));
		$mandante->add_filter("AND");
		$mandante->add_filter("dv_mandante","=",trim($param["txtrut_d_mandante"]));
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
		$dato->set_data("firma",$param["txtfirma"]);
		$dato->set_data("ingreso",$param["txtingreso"]);
		$dato->set_data("providencia",$param["txtprovidencia_1"]);
		$dato->set_data("distribucion_corte",$param["txtdist_corte"]);
		$dato->set_data("rol",$param["txtrol"]);
		$dato->set_data("id_juzgado",$param["selJuzgadoNro"]);
		$dato->set_data("id_juzgado_comuna",$param["selJComuna"]);
		$dato->save();
		
		if($param["id_alta"] <> 0 && trim($param["id_alta"]) <> "")
		{
			$id = $param["id_alta"];
		}
		else
		{
			$id = getUltimoId(new FichaCollection(), "id_ficha");
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
			
			if($val->get_count() > 0)
			{
				$datoc->add_filter("id_ficha","=",$resp);
				$datoc->load();
				$id_consig = $datoc->get_data("id_consignacion");
			}	
			
			$datoc->set_data("id_ficha",$resp);
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
			
			if($val->get_count() == 0)
			{
				$id_consig = getUltimoId(new Consignacion_FichaCollection(), "id_consignacion");
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
			$datom->set_data("aceptacion_cargo",$param["txtaceptacion_cargo"]);
			$datom->set_data("nombre",$param["txtnombre"]);
			$datom->set_data("rut_martilero",$param["txtrut_martilero"]);
			$datom->set_data("dv_martillero",$param["txtdv_martillero"]);
			$datom->set_data("notificacion",$param["txtnotificacion"]);
			$datom->set_data("retirio_especies_fp",$param["txtretirio_especies_fp"]);
			$datom->set_data("providencia",$param["txtprovidencia"]);
			$datom->set_data("entrega_receptor",$param["txtentrega_receptor"]);
			$datom->set_data("retiro_especies",$param["txtretiro_especies"]);
			$datom->set_data("oposicion_retiro",$param["txtoposicion_retiro"]);
			$datom->set_data("fecha_remate",$param["txtfecha_remate"]);
			$datom->save();	
			
			if($val->get_count() == 0)
			{
				$id_mart = getUltimoId(new Martillero_FichaCollection(), "id_martillero");
			}	
			
			$colGastoMartillero = $this->getGastosMartillero(0);
			
			for($j=0; $j<$colGastoMartillero->get_count(); $j++) 
			{
				$datoTmp = &$colGastoMartillero->items[$j];  
				
				$imp = 0;
				if(trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]) <> "")
				{
					$imp = trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]);
				}
				$gastos_mf = new Gastos_Martillero_Ficha();
				if($val->get_count() > 0)
				{
					$gastos_mf->add_filter("id_ficha","=",$resp);
					$gastos_mf->add_filter("AND");
					$gastos_mf->add_filter("id_martillero","=",$id_mart);
					$gastos_mf->add_filter("AND");
					$gastos_mf->add_filter("id_gasto","=",$datoTmp->get_data("id_gasto"));
					$gastos_mf->load();
				}
				$gastos_mf->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
				$gastos_mf->set_data("id_martillero",$id_mart);
				$gastos_mf->set_data("id_ficha",$resp);
				$gastos_mf->set_data("importe",$imp);
				$gastos_mf->save();
				
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
			
			$datom = new Martillero_Ficha();
			$datom->set_data("id_ficha",$ultid_ficha);
			$datom->set_data("aceptacion_cargo",$param["txtaceptacion_cargo"]);
			$datom->set_data("nombre",$param["txtnombre"]);
			$datom->set_data("rut_martilero",$param["txtrut_martilero"]);
			$datom->set_data("dv_martillero",$param["txtdv_martillero"]);
			$datom->set_data("notificacion",$param["txtnotificacion"]);
			$datom->set_data("retirio_especies_fp",$param["txtretirio_especies_fp"]);
			$datom->set_data("providencia",$param["txtprovidencia"]);
			$datom->set_data("entrega_receptor",$param["txtentrega_receptor"]);
			$datom->set_data("retiro_especies",$param["txtretiro_especies"]);
			$datom->set_data("oposicion_retiro",$param["txtoposicion_retiro"]);
			$datom->set_data("fecha_remate",$param["txtfecha_remate"]);
			$datom->save();
			
			$ultid_mart = getUltimoId(new Martillero_FichaCollection(), "id_martillero");

			$colGastoMartillero = $this->getGastosMartillero(0);
			
			for($j=0; $j<$colGastoMartillero->get_count(); $j++) 
			{
				$datoTmp = &$colGastoMartillero->items[$j];  
				
				$imp = 0;
				if(trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]) <> "")
				{
					$imp = trim($param["txtgasto_".$datoTmp->get_data("id_gasto")]);
				}
				$gastos_mf = new Gastos_Martillero_Ficha();
				$gastos_mf->set_data("id_gasto",$datoTmp->get_data("id_gasto"));
				$gastos_mf->set_data("id_martillero",$ultid_mart);
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
		$dato->set_data("primer_nombre",$arrayParam["papellido"]);
		$dato->set_data("segundo_nombre",$arrayParam["sapellido"]);
		$dato->set_data("primer_apellido",$arrayParam["pnombre"]);
		$dato->set_data("segundo_apellido",$arrayParam["snombre"]);
		$dato->set_data("comentario",$arrayParam["pnombre"]);
		$dato->set_data("celular",$arrayParam["celular"]);
		$dato->set_data("telefono_fijo",$arrayParam["telefono"]);
		$dato->set_data("email",$arrayParam["email"]);
		$dato->set_data("tipo",$arrayParam["tipo"]);
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
		$dato->set_data("razonsocial",$arrayParam["razonsocial"]);
		$dato->set_data("primer_nombre",$arrayParam["papellido"]);
		$dato->set_data("segundo_nombre",$arrayParam["sapellido"]);
		$dato->set_data("primer_apellido",$arrayParam["pnombre"]);
		$dato->set_data("segundo_apellido",$arrayParam["snombre"]);
		$dato->set_data("comentario",$arrayParam["pnombre"]);
		$dato->set_data("celular",$arrayParam["celular"]);
		$dato->set_data("telefono_fijo",$arrayParam["telefono"]);
		$dato->set_data("email",$arrayParam["email"]);
		$dato->set_data("tipo",$arrayParam["tipo"]);
		$dato->set_data("activo","S");
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
		$dato->add_top(3);
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
	
		$sqlpersonal->set_select( " juzgado_numero numero,
	   								juzgado_comuna juzgado,
	   								rol rol,
	   								id_ficha ficha,
	   								receptor rep,
	   								ingreso fecha ");
		$sqlpersonal->set_from( " fichas ");
	
		$sqlpersonal->set_where( " id_deudor = ".$iddeudor);
	
    	$sqlpersonal->load();

    	return $sqlpersonal;	
	}
	
	public function getTodasFichas($rutdeudor)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
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
			$where = $where." and d.rut_deudor = ".$rutdeudor;
		}
		$sqlpersonal->set_where($where);
		
    	$sqlpersonal->load();

    	return $sqlpersonal;	
	}
}
?>