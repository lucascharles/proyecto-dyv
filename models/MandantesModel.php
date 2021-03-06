<?php
class MandantesModel extends ModelBase
{
	public function getMandanteDatos($id)
	{
		$dato = new Mandantes();
		$dato->add_filter("id_mandante","=",$id);
		$dato->load();
		
		return $dato;
	}

	public function getMandanteByRut($rut)
	{
		$dato = new Mandantes();
		$dato->add_filter("rut_mandante","=",$rut);
		$dato->add_filter("AND");
		$dato->add_filter("activo","=","S");
		$dato->load();
		
		return $dato;
	}
	
	public function editarMandantes($array)
	{
		// INFORMACION MANDANTE
	  	$dato = new Mandantes();
		$dato->add_filter("id_mandante","=",$array["id_mandante"]);
		$dato->load();
		$dato->set_data("rut_mandante",$array["rut_mandante"]);
		$dato->set_data("dv_mandante",$array["dv_mandante"]);
		$dato->set_data("apellido",$array["apellido"]);
		$dato->set_data("nombre",$array["nombre"]);
		$dato->set_data("calle",$array["calle"]);
		$dato->set_data("numero",$array["numero"]);
		$dato->set_data("piso",$array["piso"]);
		$dato->set_data("dpto",$array["dpto"]);
		$dato->set_data("comuna",$array["comuna"]);
		$dato->set_data("ciudad",$array["ciudad"]);
		$dato->set_data("region",$array["region"]);
		$dato->set_data("cuenta_corriente1",$array["cuenta_corriente1"]);
		$dato->set_data("banco1",$array["banco1"]);
		$dato->set_data("cuenta_corriente2",$array["cuenta_corriente2"]);
		$dato->set_data("banco2",$array["banco2"]);
		$dato->set_data("rep_legal1",$array["rep_legal1"]);
		$dato->set_data("rep_legal2",$array["rep_legal2"]);
	  	$dato->set_data("activo","S");
	 	$dato->save();
			
		// INFORMACION CONTACTOS
		//$id_mandante = getUltimoId(new MandantesCollection(), "id_mandante");
		$conb = new Contacto_Mandantes();
		$conb->add_filter("id_mandante","=",$array["id_mandante"]);
		$conb->load();
		$conb->mark_deleted();
		$conb->save();
		
		$con = new Contacto_MandantesTmpCollection();
		$con->add_filter("id_sesion","=",$array["session_id"]);
		$con->load();
		
		for($j=0; $j<$con->get_count(); $j++) 
		{
			$datoTmp = &$con->items[$j];
				
			$conmand = new Contacto_Mandantes();
			$conmand->set_data("id_mandante",$array["id_mandante"]);
			$conmand->set_data("contacto", $datoTmp->get_data("contacto"));
			$conmand->set_data("email", $datoTmp->get_data("email"));
			$conmand->set_data("celular", $datoTmp->get_data("celular"));
			$conmand->set_data("telefono", $datoTmp->get_data("telefono"));
			$conmand->set_data("fax", $datoTmp->get_data("fax"));
			$conmand->set_data("observacion", $datoTmp->get_data("observacion"));
			$conmand->save();
		}
		
		$con->mark_deleted();
		$con->save();
		
		// INFORMACION MODO DE PAGO
		$mpcol = new ModoPagoCollection();
	    $mpcol->add_filter("activo","=","S");
    	$mpcol->load();
		
		for($i=0; $i<$mpcol->get_count(); $i++)
		{
			$mdTmp = &$mpcol->items[$i];
			
			$mpmand = new MandanteModoPago();
			$mpmand->add_filter("id_mandante","=",$array["id_mandante"]);
			$mpmand->add_filter("AND");
			$mpmand->add_filter("id_modo_pago","=",$mdTmp->get_data("id_modo_pago"));
			$mpmand->load();
			$mpmand->set_data("porcentaje",$array["porcentaje_".$mdTmp->get_data("id_modo_pago")]);
			$mpmand->set_data("operacion",$array["operacion_".$mdTmp->get_data("id_modo_pago")]);
			$mpmand->set_data("estatus",$array["estatus_".$mdTmp->get_data("id_modo_pago")]);
			$mpmand->save();
		}
	}
	
	public function getMandante($id, $id_sesion)
	{
		$dato = new Mandantes();
		$dato->add_filter("id_mandante","=",$id);
		$dato->load();
		
		// LLENAR TABLA TEMPORAL CON CONTACTOS DEL MANDANTE
		$dirdel = new Contacto_MandantesTmpCollection(); // (revisar delete sobre colleccion u objeto)
		$dirdel->add_filter("id_sesion","=",$id_sesion);
		$dirdel->load();
		$dirdel->mark_deleted();
		$dirdel->save();
		
		$con= new Contacto_MandantesCollection();
		$con->add_filter("id_mandante","=",$id);
		$con->load();
		
		for($j=0; $j<$con->get_count(); $j++) 
		{
			$datoTmp = &$con->items[$j];
			
			$conmand = new Contacto_MandantesTmp();
			$conmand->set_data("id_mandante",$id);
			$conmand->set_data("contacto", $datoTmp->get_data("contacto"));
			$conmand->set_data("email", $datoTmp->get_data("email"));
			$conmand->set_data("celular", $datoTmp->get_data("celular"));
			$conmand->set_data("telefono", $datoTmp->get_data("telefono"));
			$conmand->set_data("fax", $datoTmp->get_data("fax"));
			$conmand->set_data("observacion", $datoTmp->get_data("observacion"));
			$conmand->set_data("id_sesion", $id_sesion);
			$conmand->save();
		}
		
		return $dato;
	}
	
	public function getMandanteModoPago($id)
	{
		$dato = new MandanteModoPagoCollection();
		$dato->add_filter("id_mandante","=",$id);
		$dato->load();
		
		return $dato;
	}
	
	public function altaMandantes($array)
	{
		// INFORMACION MANDANTE
	  	$dato = new Mandantes();
		$dato->set_data("rut_mandante",$array["rut_mandante"]);
		$dato->set_data("dv_mandante",$array["dv_mandante"]);
		$dato->set_data("apellido",$array["apellido"]);
		$dato->set_data("nombre",$array["nombre"]);
		$dato->set_data("calle",$array["calle"]);
		$dato->set_data("numero",$array["numero"]);
		$dato->set_data("piso",$array["piso"]);
		$dato->set_data("dpto",$array["dpto"]);
		$dato->set_data("comuna",$array["comuna"]);
		$dato->set_data("ciudad",$array["ciudad"]);
		$dato->set_data("region",$array["region"]);
		$dato->set_data("cuenta_corriente1",$array["cuenta_corriente1"]);
		$dato->set_data("banco1",$array["banco1"]);
		$dato->set_data("cuenta_corriente2",$array["cuenta_corriente2"]);
		$dato->set_data("banco2",$array["banco2"]);
		$dato->set_data("telefono1",$array["telefono1"]);
		$dato->set_data("telefono2",$array["telefono2"]);
		$dato->set_data("rep_legal1",$array["rep_legal1"]);
		$dato->set_data("rep_legal2",$array["rep_legal2"]);
	  	$dato->set_data("activo","S");
	 	$dato->save();
			
		// INFORMACION CONTACTOS
		$id_mandante = getUltimoId(new MandantesCollection(), "id_mandante");
		$con = new Contacto_MandantesTmpCollection();
		$con->add_filter("id_sesion","=",$array["session_id"]);
		$con->load();
		
		for($j=0; $j<$con->get_count(); $j++) 
		{
			$datoTmp = &$con->items[$j];
				
			$conmand = new Contacto_Mandantes();
			$conmand->set_data("id_mandante",$id_mandante);
			$conmand->set_data("contacto", $datoTmp->get_data("contacto"));
			$conmand->set_data("email", $datoTmp->get_data("email"));
			$conmand->set_data("celular", $datoTmp->get_data("celular"));
			$conmand->set_data("telefono", $datoTmp->get_data("telefono"));
			$conmand->set_data("fax", $datoTmp->get_data("fax"));
			$conmand->set_data("observacion", $datoTmp->get_data("observacion"));
			$conmand->save();
		}
		
		$con->mark_deleted();
		$con->save();
		
		// INFORMACION MODO DE PAGO
		$mpcol = new ModoPagoCollection();
	    $mpcol->add_filter("activo","=","S");
    	$mpcol->load();
		
		for($i=0; $i<$mpcol->get_count(); $i++)
		{
			$mdTmp = &$mpcol->items[$i];
			
			$mpmand = new MandanteModoPago();
			$mpmand->set_data("id_mandante",$id_mandante);
			$mpmand->set_data("id_modo_pago",$mdTmp->get_data("id_modo_pago"));
			$mpmand->set_data("porcentaje",$array["porcentaje_".$mdTmp->get_data("id_modo_pago")]);
			$mpmand->set_data("operacion",$array["operacion_".$mdTmp->get_data("id_modo_pago")]);
			$mpmand->set_data("estatus",$array["estatus_".$mdTmp->get_data("id_modo_pago")]);
			$mpmand->save();
		}
	}
	
	
	public function getListaMandantes($des,$desApel1,$desNomb1,$id_partida='0')
	{
		$dato = new MandantesCollection();
		$dato->add_filter("activo","=","S");
		$dato->add_filter("AND");
		$dato->add_filter("id_mandante",">",$id_partida);
		if(trim($des) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("rut_mandante","like","'".trim($des)."%'");
		}
		
		if(trim($desApel1) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("apellido","like",trim($desApel1)."%");
		}
		if(trim($desNomb1) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("nombre","like",trim($desNomb1)."%");
		}		
//		$dato->add_top(3); // PARA SQLSERVER
		$dato->add_limit(0, 30); // PARA MYSQL 
		$dato->load();
		
		return $dato;
	}
	
	
	public function bajaMandantes($id)
	{
		$datoe = new Mandantes();
		$datoe->add_filter("id_mandante","=",$id);
		$datoe->load();
		$datoe->set_data("activo","N");
		$datoe->save();
		
		$dato = new MandantesCollection();
		$dato->add_filter("activo","=","S");
		if(trim($array["des_int"]) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("rut_mandante","like",trim($des)."%");
		}
		$dato->load();
		
		return $dato;
	}
	
	public function valRutMandante($array)
    {
		$resp = 0; 
		
		if($array["tipoval"] == "EXISTE")
		{
			$dato = new Mandantes();
			$dato->add_filter("activo","=","S");
			$dato->add_filter("AND");
			$dato->add_filter("rut_mandante","=",$array["rut"]);
			$dato->add_filter("AND");
			$dato->add_filter("dv_mandante","=",$array["dv"]);
			$dato->load();
			
			if(!is_null($dato->get_data("id_mandante")))
			{
				$resp = $dato->get_data("id_mandante");
			}
		}
		
		echo($resp);
    }
    
    public function getMandanteDeudor($iddeudor)
    {

		include("config.php");
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		
		$sqlselect = "d.id_mandatario id_mandatario, m.nombre nombre, m.rut_mandante rut_mandante, m.dv_mandante dv_mandante, SUM(monto) monto";
		$sqlfrom = " documentos d, mandantes m ";
		$sqlwhere = " d.id_mandatario = m.id_mandante
					  AND d.id_deudor = ". $iddeudor. 
					  " AND d.activo = 'S' AND m.activo = 'S'
					  GROUP BY d.id_mandatario , m.nombre , m.rut_mandante , m.dv_mandante ";
		
		$sqlpersonal->set_select($sqlselect ); 
		$sqlpersonal->set_from($sqlfrom);
		$sqlpersonal->set_where($sqlwhere);
		
	    $sqlpersonal->load();
	
	    return $sqlpersonal;

    }
    
	}
?>