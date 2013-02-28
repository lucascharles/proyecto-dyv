<?php
class DocumentosModel extends ModelBase
{
	public function getTiposError()
	{
		$dato = new ErrorCargaCollection();
		$dato->load();
		
		return $dato;
	}
	
	
	public function carga_masiva($archivo, $id_usuario)
	{
		include 'config.php';

		$_FILES['archivo'] = $archivo;
		$error_upload = "";
		// SE CREA CARPETA DONDE SE ALOJA ARCHIVO COMO RESPALDO
		$nombre_carpeta = $dir_uploaded_files."carga".date("YmdHis");
		if(!(is_dir($nombre_carpeta) || is_file(strtoupper($nombre_carpeta))))
		{
			mkdir($nombre_carpeta, 0777);
		}
	
		$max_size = 20000000;
	
		$nombre_archivo = strtolower(str_replace(" ", "_",basename($_FILES['archivo']['name'])));
		$tipo_archivo = $_FILES['archivo']['type'];
		$tamano_archivo = $_FILES['archivo']['size']; 
		$error = $_FILES['archivo']['error'];
		
		$error_upload = "";
		// VALIDACIONES DE TIPO DE ARCHIVO
		if (($nombre_archivo != NULL && $nombre_archivo != "") && strpos($tipo_archivo, "application/vnd.ms-excel") <> false) 
		{
			if($error_upload == "")
			{
				$error_upload = "TYPE";
			}
		}
		
		// VALIDACION TAMAÑO DE ARCHIVO
		if (($nombre_archivo != NULL && $nombre_archivo != "") && $tamano_archivo> $max_size) 
		{
			if($error_upload == "")
			{
				$error_upload = "SIZE";
			}
		}
		
		// UPLOAD DE ARCHIVOS
		if(($nombre_archivo != NULL && $nombre_archivo != "") && $error == UPLOAD_ERR_OK) 
		{
			$uploadOk = move_uploaded_file($_FILES['archivo']['tmp_name'], $nombre_carpeta."/".$nombre_archivo);

			if(!$uploadOk) 
			{
				if($error_upload == "")
				{
					$error_upload = "UPLOAD";
				}
			}
		}
		
		$id_log = 0;
		
		if($error_upload == "")
		{
		
		// CARGAR DOCUMENTOS 
		$fp = fopen ( $nombre_carpeta."/".$nombre_archivo , "r" );
		$i = 0;
		
		while (( $data = fgetcsv ( $fp , 1000 , "," )) !== FALSE ) 
		{ 
			foreach($data as $row) 
			{
				//echo "Campo ".$i.": ".$row."<br>"; 
				if($i>0)
				{
					$arraydatos = explode(";",$row);
					
					$error_rutmandante = array();
					$error_rutdeudor = array();
					$error_monto = array();
					$error_tipodocumento = array();
					$error_banco = array();
					$error_nrodocumento = array();
					$error_ctacte = array();
				
					// VALIDACION RUT MANDANTE
					// cero
					if((int)$arraydatos[0] == 0)
					{
						$error_rutmandante[] = 1;					
					}
					
					// vacio
					if(trim($arraydatos[0]) == "")
					{
						$error_rutmandante[] = 2;
					}
					
					// digito verificador
					if(false)
					{
						$error_rutmandante[] = 3;
					}
				
					// no existe mandante
					$mandante = new Mandantes();
					$mandante->add_filter("rut_mandante","=",trim(substr($arraydatos[0],0,-1)));
					$mandante->add_filter("AND");
					$mandante->add_filter("dv_mandante","=",trim(substr($arraydatos[0],-1)));
					$mandante->load();
					if(is_null($mandante->get_data("id_mandante")))
					{
						$error_rutmandante[] = 4;
					}
					
					
					// VALIDACION RUT DEUDOR
					// cero
					if((int)$arraydatos[1] == 0)
					{
						$error_rutdeudor[] = 5;
					}
					
					// vacio
					if(trim($arraydatos[1]) == "")
					{
						$error_rutdeudor[] = 6;
					}
					
					// digito verificador
					if(false)
					{
						$error_rutdeudor[] = 7;
					}
					
					// no existe deudor
					$deudor = new Deudores();
					$deudor->add_filter("rut_deudor","=",trim(substr($arraydatos[1],0,-1)));
					$deudor->add_filter("AND");
					$deudor->add_filter("dv_deudor","=",trim(substr($arraydatos[1],-1)));
					$deudor->load();
					if(is_null($deudor->get_data("id_deudor")))
					{
						$error_rutdeudor[] = 8;
					}
					
										
					// VALIDACION IMPORTE
					// cero
					if((int)$arraydatos[2] == 0)
					{
						$error_monto[] = 9;
					}
					
					// vacio
					if(trim($arraydatos[2]) == "")
					{
						$error_monto[] = 10;
					}
					
					// valor no numerico
					if(false)
					{
						$error_monto[] = 11;
					}
					
					// VALIDACION TIPO DOCUMENTO
					// vacio
					if(trim($arraydatos[3]) == "")
					{
						$error_tipodocumento[] = 12;
					}
					
					// no existe tipo documento
					$tipodoc = new TipoDocumento();
					$tipodoc->add_filter("tipo_documento","=",strtoupper(trim($arraydatos[3])));
					$tipodoc->load();
					if(is_null($tipodoc->get_data("id_tipo_documento")))
					{
						$error_tipodocumento[] = 13;
					}
					
					// VALIDACION BANCO				
					// vacio
					if(trim($arraydatos[4]) == "")
					{
						$error_banco[] = 14;
						//echo("<br>ERROR banco 2 ");
					}
					
					// no existe banco
					$banco = new Bancos();
					$banco->add_filter("codigo","=",trim($arraydatos[4]));
					$banco->load();
					if(is_null($banco->get_data("id_banco")))
					{
						//echo("<br>ERROR banco 7 ");
						$error_banco[] = 15;
					}

					// VALIDACION NUMERO DOCUMENTO
					// cero
					if((int)$arraydatos[5] == 0)
					{
						$error_nrodocumento[] = 16;					
					}
					
					// vacio
					if(trim($arraydatos[5]) == "")
					{
						$error_nrodocumento[] = 17;
					}
					
					// valor no numerico
					if(false)
					{
						$error_nrodocumento[] = 18;
					}

				// VALIDACION CUENTA CORRIENTE
					// cero
					if((int)$arraydatos[6] == 0)
					{
						$error_ctacte[] = 19;
					}
					
					// vacio
					if(trim($arraydatos[6]) == "")
					{
						$error_ctacte[] = 20;
					}
					
					// valor numerico
					if(false)
					{
						$error_ctacte[] = 21;
					}
					
					if(count($error_rutmandante) == 0 && 
						count($error_rutdeudor) == 0 && 
						count($error_monto) == 0 && 
						count($error_tipodocumento) == 0 && 
						count($error_banco) == 0 && 
						count($error_nrodocumento) == 0 && 
						count($error_ctacte) == 0)
					{	
						// GUARDAR DOCUMENTO
						$datodoc = new Documentos();
						$datodoc->set_data("id_estado_doc",1); // pendiente (hay que parametrizar)
						$datodoc->set_data("id_tipo_doc",$tipodoc->get_data("id_tipo_documento"));
						// $datodoc->set_data("id_causa_protesto",);
						$datodoc->set_data("id_banco",$banco->get_data("id_banco"));				
						$datodoc->set_data("id_mandatario",$mandante->get_data("id_mandante"));						
						$datodoc->set_data("id_deudor",$deudor->get_data("id_deudor"));
						$datodoc->set_data("numero_documento",trim($arraydatos[5]));
						// "numero_siniestro" => array("int"),
						// "fecha_protesto" => array("datetime"),
						// "fecha_siniestro" => array("datetime"),
						$datodoc->set_data("monto",trim($arraydatos[2]));
						$datodoc->set_data("cta_cte",trim($arraydatos[6]));
						// "gastos_protesto" => array("int"),
						//"ns" => array("int"),
						$datodoc->set_data("fecha_creacion",date("d/m/Y H:i:s"));
						$datodoc->set_data("usuario_creacion",$id_usuario);
						//"fecha_modificacion" => array("datetime"),
						//"usuario_modificacion" => array("varchar")
						$datodoc->save();

					}
					else
					{
						if($id_log == 0)
						{
							$logerror = new LogError();
							$logerror->set_data("fecha_hora",date("d/m/Y H:i:s"));
							$logerror->set_data("id_usuario",$id_usuario);
							$logerror->save();
							
							$id_log = getUltimoId(new LogErrorCollection(), "id");
						}
						
						for($j = 0; $j<count($error_rutmandante); $j++)
						{
							$log_e = new Det_LogError_CargaMasiva();
							$log_e->set_data("id_logerror",$id_log);
							$log_e->set_data("id_tipo_error",$error_rutmandante[$j]);
							$log_e->set_data("archivo",$nombre_archivo);
							$log_e->set_data("fila",$i);
							$log_e->save();
						}
						
						for($j = 0; $j<count($error_rutdeudor); $j++)
						{
							$log_e = new Det_LogError_CargaMasiva();
							$log_e->set_data("id_logerror",$id_log);
							$log_e->set_data("id_tipo_error",$error_rutdeudor[$j]);
							$log_e->set_data("archivo",$nombre_archivo);
							$log_e->set_data("fila",$i);
							
							$log_e->save();
						}
						
						for($j = 0; $j<count($error_monto); $j++)
						{
							$log_e = new Det_LogError_CargaMasiva();
							$log_e->set_data("id_logerror",$id_log);
							$log_e->set_data("id_tipo_error",$error_monto[$j]);
							$log_e->set_data("archivo",$nombre_archivo);
							$log_e->set_data("fila",$i);
							$log_e->save();
						}
						
						for($j = 0; $j<count($error_tipodocumento); $j++)
						{
							$log_e = new Det_LogError_CargaMasiva();
							$log_e->set_data("id_logerror",$id_log);
							$log_e->set_data("id_tipo_error",$error_tipodocumento[$j]);
							$log_e->set_data("archivo",$nombre_archivo);
							$log_e->set_data("fila",$i);
							$log_e->save();
						}
						
						for($j = 0; $j<count($error_banco); $j++)
						{
							$log_e = new Det_LogError_CargaMasiva();
							$log_e->set_data("id_logerror",$id_log);
							$log_e->set_data("id_tipo_error",$error_banco[$j]);
							$log_e->set_data("archivo",$nombre_archivo);
							$log_e->set_data("fila",$i);
							$log_e->save();
						}
						
						for($j = 0; $j<count($error_nrodocumento); $j++)
						{
							$log_e = new Det_LogError_CargaMasiva();
							$log_e->set_data("id_logerror",$id_log);
							$log_e->set_data("id_tipo_error",$error_nrodocumento[$j]);
							$log_e->set_data("archivo",$nombre_archivo);
							$log_e->set_data("fila",$i);
							$log_e->save();
						}
						
						for($j = 0; $j<count($error_ctacte); $j++)
						{
							$log_e = new Det_LogError_CargaMasiva();
							$log_e->set_data("id_logerror",$id_log);
							$log_e->set_data("id_tipo_error",$error_ctacte[$j]);
							$log_e->set_data("archivo",$nombre_archivo);
							$log_e->set_data("fila",$i);
							$log_e->save();
						}
					}
				
				}
				$i = $i + 1;
				
			}

		}
		fclose ( $fp );
		}// fin if sin error upload
		else
		{
			if($error_upload == "TYPE")
			{
				$idtipo = 22;
			}
			
			if($error_upload == "SIZE")
			{
				$idtipo = 23;
			}
			
			if($error_upload == "UPLOAD")
			{
				$idtipo = 24;
			}
			
			$logerror = new LogError();
			$logerror->set_data("fecha_hora",date("d/m/Y H:i:s"));
			$logerror->set_data("id_usuario",$id_usuario);
			$logerror->save();
							
			$id_log = getUltimoId(new LogErrorCollection(), "id");

			$log_e = new Det_LogError_CargaMasiva();
			$log_e->set_data("id_logerror",$id_log);
			$log_e->set_data("id_tipo_error",$idtipo);
			$log_e->set_data("archivo",$nombre_archivo);
			$log_e->set_data("fila",0);
			$log_e->save();
		}
		return $id_log;
	}
	
	public function getLogError($id_log)
	{
		$dato = new LogError();
		$dato->add_filter("id","=",$id_log);
		$dato->load();
		
		return $dato;
	}
	
	public function getLogErrorDetalle($id_log)
	{
		$dato = new Det_LogError_CargaMasivaCollection();
		$dato->add_filter("id_logerror","=",$id_log);
		$dato->load();
		
		return $dato;
	}
	
	public function getTipoDoc($id)
	{
		$dato = new TipoDocumento();
		$dato->add_filter("id_tipo_documento","=",$id);
		$dato->load();
		
		return $dato;
	}
	
	public function altaTipoDoc($des)
	{
		$datoe = new TipoDocumento();
		$datoe->set_data("tipo_documento",$des);
		$datoe->set_data("activo","S");
		$datoe->save();
	}
	
	
	public function getListaTipoDoc($des)
	{
		$dato = new TipoDocumentoCollection();
		$dato->add_filter("activo","=","S");
		if(trim($des) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("tipo_documento","like",trim($des)."%");
		}
		
		$dato->load();
		
		return $dato;
	}
	
	
	public function bajaTipoDoc($id, $des)
	{
		$datoe = new TipoDocumento();
		$datoe->add_filter("id_tipo_documento","=",$id);
		$datoe->load();
		$datoe->set_data("activo","N");
		$datoe->save();
		
		$dato = new TipoDocumentoCollection();
		$dato->add_filter("activo","=","S");
		if(trim($array["des_int"]) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("tipo_documento","like",trim($des)."%");
		}
		$dato->load();
		
		return $dato;
	}
	
	
	public function editarDocumentos($array)
	{
	  $dato = new Documentos();
	  $dato->add_filter("id_documento","=",$array["iddocumento"]);
	  $dato->load();
		
	  $dato->set_data("id_estado_doc",$array["selEstadoDoc"]);
      $dato->set_data("id_tipo_doc",$array["selTipoDoc"]);
      $dato->set_data("id_causa_protesto",$array["selCausalProtesta"]);
      $dato->set_data("id_banco",$array["selBancos"]);
      $dato->set_data("id_mandatario",$array["mandante"]);
      $dato->set_data("id_deudor",$array["deudor"]);
      $dato->set_data("numero_documento",$array["txtnrodoc"]);
      $dato->set_data("fecha_protesto",$array["txtfechaprotesto"]);
      $dato->set_data("monto",$array["txtmonto"]);
      $dato->set_data("cta_cte",$array["txtctacte"]);
	  $dato->save();
	}

	public function getDocumento($id)
	{
		$dato = new Documentos();
		$dato->add_filter("id_documento","=",$id);
		$dato->load();
		
		return $dato;
	}
	
	public function altaDocumentos($array)
	{
	  $dato = new Documentos();
	  
	  $dato->set_data("id_deudor",$array["deudor"]);
      $dato->set_data("id_mandatario",$array["mandante"]);
      $dato->set_data("fecha_siniestro",$array["txtfechaRecibido"]);
      $dato->set_data("numero_documento",$array["txtnrodoc"]);
      $dato->set_data("id_tipo_doc",$array["selTipoDoc"]);
      $dato->set_data("id_estado_doc",$array["selEstadoDoc"]);
      $dato->set_data("monto",$array["txtmonto"]);
      $dato->set_data("id_banco",$array["selBancos"]);
      $dato->set_data("cta_cte",$array["txtctacte"]);
      $dato->set_data("fecha_protesto",$array["txtfechaprotesto"]);
      $dato->set_data("id_causa_protesta",$array["selCausalProtesta"]);
      $dato->set_data("monto",$array["txtmonto"]);
      $dato->set_data("cta_cte",$array["txtctacte"]);
      $dato->set_data("gastos_protesto",$array["gastos_protesto"]);
      $dato->set_data("ns",$array["ns"]);
      $dato->set_data("fecha_creacion",$array["fecha_creacion"]);
      $dato->set_data("usuario_creacion",$array["usuario_creacion"]);
      $dato->set_data("fecha_modificacion",$array["fecha_modificacion"]);
      $dato->set_data("usuario_modificacion",$array["usuario_modificacion"]);
      $dato->set_data("activo","S");		
	  $dato->save();
	 
	}
	
	public function getListaDocumentos($des, $idd='',$array)
	{
	
		include("config.php");
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select(" d.id_documento id_documento, c.banco id_banco, dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor, 
							  		dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,
									m.nombre nombre_mandante, ed.estado id_estado_doc, td.tipo_documento id_tipo_doc,
									d.numero_documento numero_documento,d.fecha_siniestro fecha_siniestro, d.cta_cte cta_cte,d.monto monto"); 
	  	$sqlpersonal->set_from(" documentos d, 
	 								bancos c,
	 								deudores dd,
	 								mandantes m,
	 								estadodocumentos ed,
	 								tipodocumento td");
	  	$where = " d.id_banco = c.id_banco
				and  d.id_deudor = dd.id_deudor
				and m.id_mandante = d.id_mandatario
				and d.id_estado_doc = ed.id_estado_doc
				and d.id_tipo_doc = td.id_tipo_documento
				and d.activo = 'S' ";
		
		$where .= " and d.id_documento > ".$array["id_partida"];
		
		$sqlpersonal->set_top(1); // PARA SQLSERVER 
		//$sqlpersonal->set_limit(0,3); // PARA MYSQL
		
		if(count($array) > 0)
		{
			if(trim($array["des_int"]) <> "")
			{
				$where .= " and dd.rut_deudor like '".trim($array["des_int"])."%'";
			}
			
			if(trim($array["desApel1"]) <> "")
			{
				$where .= " and dd.primer_apellido like '".trim($array["desApel1"])."%'";
			}
			
			if(trim($array["desApel2"]) <> "")
			{
				$where .= " and dd.segundo_apellido like '".trim($array["desApel2"])."%'";
			}
			
			if(trim($array["desNomb1"]) <> "")
			{
				$where .= " and dd.primer_nombre like '".trim($array["desNomb1"])."%'";
			}
			
			if(trim($array["desNomb2"]) <> "")
			{
				$where .= " and dd.segundo_nombre like '".trim($array["desNomb2"])."%'";
			}
		}
		
		if($idd > 0 && trim($idd) <> "")
		{
			$where .= " and d.id_deudor = ".$idd;
		}	

		$sqlpersonal->set_where($where);
	
    	$sqlpersonal->load();

    	return $sqlpersonal;	
	
	}
	
	public function getListaDocumentosCartas($des)
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select(" d.id_documento id_documento, c.banco id_banco, dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor, 
							  		dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,
									m.nombre nombre_mandante, ed.estado id_estado_doc, td.tipo_documento id_tipo_doc,
									d.numero_documento numero_documento,d.fecha_siniestro fecha_siniestro, d.cta_cte cta_cte,d.monto monto"); 
	  $sqlpersonal->set_from(" documentos d, 
	 								bancos c,
	 								deudores dd,
	 								mandantes m,
	 								estadodocumentos ed,
	 								tipodocumento td");
    
	  $sqlpersonal->set_where(" d.id_banco = c.id_banco
								and  d.id_deudor = dd.id_deudor
								and m.id_mandante = d.id_mandatario
								and d.id_estado_doc = ed.id_estado_doc
								and d.id_tipo_doc = td.id_tipo_documento
								and d.activo = 'S'
								and upper(ed.estado) like 'PENDIENTE DE ENVIAR CARTA%'  ");
	
    $sqlpersonal->load();

    return $sqlpersonal;	
		
	}
	
	public function bajaDocumentos($id)
	{
		$datoe = new Documentos();
		$datoe->add_filter("id_documento","=",$id);
		$datoe->load();
		$datoe->set_data("activo","N");
		$datoe->save();
		
		$dato = new DocumentosCollection();
		$dato->add_filter("activo","=","S");
		
		$dato->load();
		
		return $dato;
	}
	
	
	public function getListaMandantes($des)
	{
    	$dato = new MandantesCollection();
    	$dato->add_filter("activo","=","S");
    	if(trim($des) <> "")
    	{
        	$dato->add_filter("AND");
        	$dato->add_filter("id_mandantes","=",trim($des));
    	}	
    	$dato->load();       
    	return $dato;
	}
	
	public function getListaDeudores($des)
	{
    	$dato = new DeudoresCollection();
    	$dato->add_filter("activo","=","S");
    	if(trim($des) <> "")
    	{
        	$dato->add_filter("AND");
        	$dato->add_filter("id_deudor","=",trim($des));
    	}	
    	$dato->load();       
    	return $dato;
	}
	
	public function getListaEstadoDoc($des)
	{
    	$dato = new EstadoDocumentosCollection();
    	$dato->add_filter("activo","=","S");
    	if(trim($des) <> "")
    	{
        	$dato->add_filter("AND");
        	$dato->add_filter("id_estado_doc","=",trim($des));
    	}	
    	$dato->load();       
    	return $dato;
	}
	
	public function getListaBancos($des)
	{
    	$dato = new BancosCollection();
    	$dato->add_filter("activo","=","S");
    	if(trim($des) <> "")
    	{
        	$dato->add_filter("AND");
        	$dato->add_filter("banco","like",trim($des)."%");
    	}	
    	$dato->load();       
    	return $dato;
	}


	
	public function getListaCausalProtesta($des)
	{
    	$dato = new CausalProtestaCollection();
    	$dato->add_filter("activo","=","S");
    	if(trim($des) <> "")
    	{
        	$dato->add_filter("AND");
        	$dato->add_filter("causal","like",trim($des)."%");
    	}	
    	$dato->load();       
    	return $dato;
	}
	
	public function getDatoDeudor($iddeudor)
	{
	
		include("config.php");
		
		$var_id = 0;
		if(trim($iddeudor) <> ""){
			$var_id = $iddeudor;
		}
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		
		$sqlpersonal->set_select(" d.id_documento id_documento,c.banco id_banco, dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor, 
								  		dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,
										m.nombre nombre_mandante, ed.estado id_estado, td.tipo_documento id_tipo_doc,
										d.numero_documento numero_documento,d.fecha_siniestro fecha_siniestro,d.cta_cte cta_cte,d.monto monto"); 
		  $sqlpersonal->set_from(" documentos d, 
		 								bancos c,
		 								deudores dd,
		 								mandantes m,
		 								estadodocumentos ed,
		 								tipodocumento td");
	    
		  $sqlpersonal->set_where(" d.id_banco = c.id_banco
									and  d.id_deudor = dd.id_deudor
									and m.id_mandante = d.id_mandatario
									and d.id_estado_doc = ed.id_estado_doc
									and d.id_tipo_doc = td.id_tipo_documento
									and d.activo = 'S'
									and d.id_deudor = ".$var_id);
		
	    $sqlpersonal->load();
	
	    return $sqlpersonal;
	}	

	public function generarCarta($id)
	{
		$datoe = new Documentos();
		$datoe->add_filter("id_documento","=",$id);
		$datoe->load();
		$datoe->set_data("id_estado_doc",1);
		$datoe->save();
		
	}
	

	public function getDatoDocumento($iddocumento)
	{

	include("config.php");
	
	$var_id = 0;
	if(trim($iddocumento) <> ""){
		$var_id = $iddocumento;
	}
	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select(" d.id_documento id_documento,
							   d.id_banco id_banco, c.banco banco, 
							   d.id_deudor id_deudor, dd.rut_deudor rut_deudor, dd.dv_deudor dv_deudor,
							   dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor, 
							   dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,
							   m.id_mandante id_mandante, m.rut_mandante rut_mandante,m.dv_mandante dv_mandante, m.nombre nombre_mandante,  
							   d.id_estado_doc id_estado, ed.estado estado, 
							   d.id_tipo_doc id_tipo_doc, td.tipo_documento tipo_doc,
							   d.id_causa_protesto id_causa_protesto, cp.causal causa_protesto,
							   d.numero_documento numero_documento,d.fecha_siniestro fecha_siniestro,d.cta_cte cta_cte,d.monto monto "); 
	  $sqlpersonal->set_from(" documentos d, 
								bancos c,
								deudores dd,
								mandantes m,
								estadodocumentos ed,
								tipodocumento td,
								causalprotesta cp ");    
	  $sqlpersonal->set_where(" d.id_banco = c.id_banco
								and  d.id_deudor = dd.id_deudor
								and m.id_mandante = d.id_mandatario
								and d.id_estado_doc = ed.id_estado_doc
								and d.id_tipo_doc = td.id_tipo_documento
								and d.id_causa_protesto = cp.id_causal
								and d.activo = 'S'
								and d.id_documento = ".$var_id);
	
    $sqlpersonal->load();

    return $sqlpersonal;
	}
		
}
?>