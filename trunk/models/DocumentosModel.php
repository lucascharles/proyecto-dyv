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
		if($nombre_archivo != NULL && $nombre_archivo != "") 
		{
			if($tipo_archivo <> "application/vnd.ms-excel")
			{
				if($error_upload == "")
				{
					$error_upload = "TYPE";
				}
			}
		}
		
		// VALIDACION TAMAÑO DE ARCHIVO
		if (($nombre_archivo != NULL && $nombre_archivo != "") && $tamano_archivo > $max_size) 
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
//				echo "Campo ".$i.": ".$row."<br>"; 
				if($i>0)
				{
					$arraydatos = explode(";",$row);
					
					$error_rutmandante = array();
					$error_rutdeudor = array();
					$error_monto = array();
					$error_tipodocumento = array();
					$error_banco = array();
					$error_nrodocumento = array();
					$error_fax = array();
					$error_telefono_casa = array();
					$error_telefono_cel = array();
				
					// VALIDACION RUT MANDANTE
					// cero
					if((int)$arraydatos[14] == 0)
					{
						$error_rutmandante[] = 1;					
					}
					
					// vacio
					if(trim($arraydatos[14]) == "")
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
					//echo("rut_mandante 14".$arraydatos[14]);
					$mandante->add_filter("rut_mandante","=",trim(substr($arraydatos[14],0,-1)));
					$mandante->load();
					if(is_null($mandante->get_data("id_mandante")))
					{
						
						//crear Mandante nuevo
					  	$mandante_new = new Mandantes();
						$mandante_new->set_data("rut_mandante",trim(substr($arraydatos[14],0,-1)));
						$mandante_new->set_data("dv_mandante",trim(substr($arraydatos[14],-1)));
					  	$mandante_new->set_data("activo","S");
					 	$mandante_new->save();
//					 	$error_rutmandante[] = 4;
						$mandante->load();
						
					}
					$idMandante = $mandante->get_data("id_mandante");
					
					// VALIDACION RUT DEUDOR
					// cero
					if((int)$arraydatos[0] == 0)
					{
						$error_rutdeudor[] = 5;
					}
					
					// vacio
					if(trim($arraydatos[0]) == "")
					{
						$error_rutdeudor[] = 6;
					}
					
					// digito verificador
					if(false)
					{
						$error_rutdeudor[] = 7;
					}
					
					//valida Telefono casa deudor
					if($arraydatos[10] == 0 || trim($arraydatos[10]) == "" )
					{
						$error_telefono_casa[] = 1;
						$telefono_casa = NULL;					
					}
					else
					{
						$telefono_casa = $arraydatos[10]; 
					}
					
					//valida Telefono celular deudor
					if($arraydatos[11] == 0 || trim($arraydatos[11]) == "" )
					{
						$error_celular[] = 1;
						$telefono_cel = NULL;					
					}
					else
					{
						$telefono_cel = $arraydatos[11]; 
					}
					
					//valida Telefono fax deudor
					if($arraydatos[12] == 0 || trim($arraydatos[12]) == "" )
					{
						$error_fax[] = 1;
						$fax = NULL;					
					}
					else
					{
						$fax = $arraydatos[12];
					}
					
					
					// no existe deudor
					$deudor = new Deudores();
					$deudor->add_filter("rut_deudor","=",trim(substr($arraydatos[0],0,-1)));
					$deudor->load();
					if(is_null($deudor->get_data("id_deudor")))
					{
						//se crea el deudor nuevo
						$deudor_new = new Deudores();
						$deudor_new->set_data("rut_deudor",trim(substr($arraydatos[0],0,-1)));
						$deudor_new->set_data("dv_deudor","'".trim(substr($arraydatos[0],-1))."'");
					  	$deudor_new->set_data("primer_apellido",trim($arraydatos[1]));
					  	$deudor_new->set_data("segundo_apellido",trim($arraydatos[2]));
						$deudor_new->set_data("primer_nombre",trim($arraydatos[3]));
					  	$deudor_new->set_data("segundo_nombre",trim($arraydatos[4]));
					  	$deudor_new->set_data("celular",$telefono_cel);
					  	$deudor_new->set_data("telefono_fijo",$telefono_casa);
					  	$deudor_new->set_data("fax",$fax);
					  	$deudor_new->set_data("id_mandante",$mandante->get_data("id_mandante"));
						$deudor_new->set_data("activo","S");
					 	$deudor_new->save();
						
					 	//vuelve a consultar el deudor para recuperar datos
					 	$deudor->load();
					 	$idDeudor = $deudor->get_data("id_deudor");
					 	
					 	//registra direccion del deudor
					 	$dirdeu = new Direccion_Deudores();
						$dirdeu->set_data("id_deudor",$deudor->get_data("id_deudor"));
						$dirdeu->set_data("calle", trim($arraydatos[5]));
						$dirdeu->set_data("numero", trim($arraydatos[6]));
						$dirdeu->set_data("depto", trim($arraydatos[7]));
						$dirdeu->set_data("comuna", trim($arraydatos[8]));
						$dirdeu->set_data("ciudad", trim($arraydatos[9]));
						$dirdeu->save();
					 	
					 	//asocia deudor con mandante si no existe la relacion
					 	
						$DM = new Deudor_Mandante();
						$DM->add_filter("id_deudor","=",$deudor->get_data("id_deudor"));
						$DM->add_filter("AND");
						$DM->add_filter("id_mandante","=",$mandante->get_data("id_mandante"));
						$DM->load();

						if(is_null($DM->get_data("id"))){
						 	$deu_mand = new Deudor_Mandante();
							$deu_mand->set_data("id_deudor", $deudor->get_data("id_deudor"));
							$deu_mand->set_data("id_mandante", $mandante->get_data("id_mandante"));
							$deu_mand->save();
						}
					 }
					 
					$idDeudor = $deudor->get_data("id_deudor");
					 	
				 	//se calcula fecha para la proxima gestion
				 	$fechaHoy = date("Y-m-d");
					$dias = 5;
					$calculoHoy = strtotime("$fechaHoy +0 days");
					$calculoFuturo = strtotime("$fechaHoy +$dias days");

				 	//se crea el registro de gestion para el deudor	
					$DG = new Gestiones();
					$DG->add_filter("id_deudor","=",$deudor->get_data("id_deudor"));
					$DG->add_filter("AND");
					$DG->add_filter("id_mandante","=",$mandante->get_data("id_mandante"));
					$DG->load();
					
					if(is_null($DG->get_data("id_gestion"))){
						
				 		$datoG = new Gestiones();
				  		$datoG->set_data("id_deudor",$deudor->get_data("id_deudor"));
			      		$datoG->set_data("id_mandante",$mandante->get_data("id_mandante"));
			      		$datoG->set_data("fecha_gestion",date("Y-m-d"));
			      		$datoG->set_data("nota_gestion","Inicia Gestion");
			      		$datoG->set_data("fecha_prox_gestion",date("Y-m-d", $calculoFuturo));
			      		$datoG->set_data("activo","S");
			      		$datoG->set_data("usuario_modificacion",$_SESSION["idusuario"]);
			      		$datoG->set_data("fecha_modificacion",date("Y-m-d"));
			      		$datoG->set_data("usuario_creacion",$_SESSION["idusuario"]);
			      		$datoG->set_data("fecha_creacion",date("Y-m-d"));      	
			      		$datoG->set_data("estado","PENDIENTE DE ENVIAR CARTA");
			      		$datoG->save();
					} 	
					// VALIDACION IMPORTE
					// vacio
					if(trim($arraydatos[15]) == "")
					{
						$error_monto[] = 10;
						$monto_doc = 0;
					}
					else
					{
						$monto_doc = $arraydatos[15];
					}
					// valor no numerico
					if(false)
					{
						$error_monto[] = 11;
						$monto_doc = 0;
					}
					
					// VALIDACION TIPO DOCUMENTO
					// vacio
					if(trim($arraydatos[17]) == "")
					{
						$error_tipodocumento[] = 12;
					}
					
					// no existe tipo documento
					$tipodoc = new TipoDocumento();
					$tipodoc->add_filter("tipo_documento","=",strtoupper(trim($arraydatos[17])));
					$tipodoc->load();
					if(is_null($tipodoc->get_data("id_tipo_documento")))
					{
						$error_tipodocumento[] = 13;
						$idTipoDoc = 6; //Tipo de Doc = OTRO (6)
					}
					else
					{
						$idTipoDoc = $tipodoc->get_data("id_tipo_documento");
					}
					
					// VALIDACION BANCO				
					// vacio
					if(trim($arraydatos[18]) == "")
					{
						$error_banco[] = 14;
						$banco_default = 0;
					}
					
					// no existe banco
					$banco = new Bancos();
					$banco->add_filter("codigo","=",trim($arraydatos[18]));
					$banco->load();
					$banco_default = $banco->get_data("id_banco");
					if(is_null($banco->get_data("id_banco")))
					{
						//echo("<br>ERROR banco 7 ");
						$error_banco[] = 15;
						$banco_default = 0;
					}

					// VALIDACION NUMERO DOCUMENTO
					// cero
					if((int)$arraydatos[19] == 0)
					{
						$nrodocumento = NULL;					
					}
					else
					{
						$nrodocumento =trim($arraydatos[19]);
					}
					
					
					// vacio
					if(trim($arraydatos[19]) == "")
					{
						$nrodocumento = NULL;
					}
					else
					{
						$nrodocumento =trim($arraydatos[19]);
					}
					
					// valor no numerico
					if(false)
					{
						$error_nrodocumento[] = 18;
					}
					
				// VALIDACION CUENTA CORRIENTE, puede no existir la cuenta 
					// cero
					if((int)$arraydatos[20] == 0)
					{
						$cta_cte = NULL;
					}
					else
					{
						$cta_cte =trim($arraydatos[20]);
					}
					
					
					// vacio
					if(trim($arraydatos[20]) == "")
					{
						$cta_cte = NULL;
					}
					else
					{
						$cta_cte =trim($arraydatos[20]);
					}
					
					//Validacion de fecha de protesto
					
					if(trim($arraydatos[22]) != "")
					{
						$fecha_protesto =trim($arraydatos[22]);
					}
					
					//Validacion de causal de protesto
					if(trim($arraydatos[23]) == "")
					{
						$causal_protesto = 13;
					}
					else
					{
						$datoCausal = new CausalProtesta();
				        $datoCausal->add_filter("causal","like",trim($arraydatos[23])."%");
				    	$datoCausal->load();
						$causal_protesto = $datoCausal->get_data("id_causal");
					}

					//Validacion de gatos de protesto
					if(trim($arraydatos[24]) == "")
					{
						$gastos_protesto = 0;
					}
					else
					{
						$gasto_protesto =trim($arraydatos[24]);
					}
					
					if(count($error_rutmandante) == 0 && 
						count($error_rutdeudor) == 0 )
					{	
						// GUARDAR DOCUMENTO
						$datodoc = new Documentos();
						$datodoc->set_data("id_estado_doc",999); // pendiente de enviar carta(hay que parametrizar)
						$datodoc->set_data("id_tipo_doc",$idTipoDoc);
						$datodoc->set_data("id_banco",$banco_default);				
						$datodoc->set_data("id_mandatario",$idMandante);						
						$datodoc->set_data("id_deudor",$idDeudor);
						$datodoc->set_data("numero_documento",$nrodocumento);
						$datodoc->set_data("monto",$monto_doc);
						$datodoc->set_data("cta_cte",$cta_cte);
						$datodoc->set_data("fecha_siniestro",date("Y-m-d"));
						
						$date = new DateTime($fecha_protesto);
						$fechaProtesto = $date->format('Y-m-d'); 
						$datodoc->set_data("fecha_protesto",$fechaProtesto);

						$datodoc->set_data("id_causa_protesto",$causal_protesto);
						$datodoc->set_data("gastos_protesto",$gasto_protesto);
						$datodoc->set_data("activo","S");
						$datodoc->set_data("fecha_creacion",date("Y-m-d"));
						$datodoc->set_data("usuario_creacion",$id_usuario);
						
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
				}//If i>0
				$i = $i + 1;
			}//Foreach
		}//While

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
      $dato->set_data("id_estado_doc",999); //por defecto se crean en estado 'PENDIENTE DE ENVIAR CARTA'
      
      $dato->set_data("numero_documento",$array["txtnrodoc"]);
      $dato->set_data("id_tipo_doc",$array["selTipoDoc"]);
	  $dato->set_data("fecha_siniestro",date('Y-m-d', strtotime($array["txtfechaRecibido"])));
      $dato->set_data("monto",$array["txtmonto"]);
      if($array["selBancos"] != "")
      {
      	$dato->set_data("id_banco",$array["selBancos"]);
      }
      else
      {
      	$dato->set_data("id_banco",0);
      }
      $dato->set_data("cta_cte",$array["txtctacte"]);
      $dato->set_data("fecha_protesto",date('Y-m-d', strtotime($array["txtfechaprotesto"])));
      $dato->set_data("id_causa_protesto",$array["selCausalProtesta"]);
      $dato->set_data("cta_cte",$array["txtctacte"]);
      $dato->set_data("gastos_protesto",$array["gastos_protesto"]);
      $dato->set_data("ns",$array["ns"]);
      $dato->set_data("fecha_creacion",date('Y-m-d', strtotime($array["txtfechaRecibido"])));
      $dato->set_data("usuario_creacion",$array["usuario_creacion"]);
      $dato->set_data("fecha_modificacion",date('Y-m-d', strtotime($array["txtfechaRecibido"])));
      $dato->set_data("usuario_modificacion",$array["usuario_modificacion"]);
      
      $dato->set_data("activo","S");		
	  $dato->save();
	  
	  $dato2 = new GestionesCollection();
      $dato2->add_filter("id_deudor","=",$array["deudor"]);
      $dato2->add_filter("AND");
      $dato2->add_filter("id_mandante","=",$array["mandante"]);
      $dato2->add_filter("AND");
      $dato2->add_filter("activo","=","S");
	  $dato2->load();
	  
	  if($dato2->get_count() == 0)
	  {
	  	$fechaHoy = date("Y-m-d");
		$dias = 3;

		$calculoHoy = strtotime("$fechaHoy +0 days");
		$calculoFuturo = strtotime("$fechaHoy +$dias days");
	  	
	  	
	  	$dato3 = new Gestiones();
	  	$dato3->set_data("id_deudor",$array["deudor"]);
      	$dato3->set_data("id_mandante",$array["mandante"]);
      	$dato3->set_data("fecha_gestion",date("Y-m-d"));      	
      	$dato3->set_data("nota_gestion","Inicia Gestion");
	    $dato3->set_data("fecha_prox_gestion",date("Y-m-d", $calculoFuturo));
      	$dato3->set_data("activo","S");
//      	$dato3->set_data("usuario_modificacion",$_SESSION["idusuario"]);
      	$dato3->set_data("fecha_modificacion",date("Y-m-d"));
//      	$dato3->set_data("usuario_creacion",$_SESSION["idusuario"]);
      	$dato3->set_data("fecha_creacion",date("Y-m-d"));      	
      	$dato3->set_data("estado","GESTION");
      
      	$dato3->save();
	  }
	  else
	  {
	  	$dato3 = new Gestiones();
	  	$dato3->set_data("id_deudor",$array["deudor"]);
      	$dato3->set_data("id_mandante",$array["mandante"]);
      	$dato3->set_data("nota_gestion","Inicia Gestion");
      	$dato3->save();
	  }
	 
	}
	
	public function getListaDocumentos($des, $idd='',$array='')
	{
	
		include("config.php");
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select(" d.id_documento id_documento, c.banco id_banco, dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor, 
							  		dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,
									m.nombre nombre_mandante, ed.estado id_estado_doc, td.tipo_documento id_tipo_doc,
									d.numero_documento numero_documento,d.fecha_protesto fecha_siniestro, d.cta_cte cta_cte,d.monto monto,
									d.fecha_siniestro fecha_recibido"); 
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
		
//		$sqlpersonal->set_top(10); // PARA SQLSERVER 
//		$sqlpersonal->set_limit(0,10); // PARA MYSQL
		
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
	
	public function getListaDocumentosGestion($des, $idd='',$array='')
	{
	
		include("config.php");
	
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select(" d.id_documento id_documento, c.banco id_banco, dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor,
							  		dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,
									m.nombre nombre_mandante, ed.estado id_estado_doc, td.tipo_documento id_tipo_doc,
									d.numero_documento numero_documento,d.fecha_protesto fecha_protesto, d.cta_cte cta_cte,d.monto monto , d.fecha_siniestro fecha_recibido");
		$sqlpersonal->set_from(" documentos d left join bancos c on d.id_banco = c.id_banco,
	 								deudores dd,
	 								mandantes m,
	 								estadodocumentos ed,
	 								tipodocumento td");
		$where = " d.id_deudor = dd.id_deudor
				and m.id_mandante = d.id_mandatario
				and d.id_estado_doc = ed.id_estado_doc
				and d.id_tipo_doc = td.id_tipo_documento
				and ed.estado not in ('RECUPERADO','CASTIGADO')
				and d.activo = 'S' ";
	
		$where .= " and d.id_documento > ".$array["id_partida"];
	
		//		$sqlpersonal->set_top(10); // PARA SQLSERVER
		//		$sqlpersonal->set_limit(0,10); // PARA MYSQL
	
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
	
	public function getListaDocumentos2($array)
	{
	
		include("config.php");
	
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select(" d.id_documento id_documento, c.banco id_banco, dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor,
							  		dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,
									m.nombre nombre_mandante, ed.estado id_estado_doc, td.tipo_documento id_tipo_doc,
									d.numero_documento numero_documento,d.fecha_protesto fecha_siniestro, d.cta_cte cta_cte,d.monto monto, d.fecha_siniestro fecha_recibido ");
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
	
		//		$sqlpersonal->set_top(10); // PARA SQLSERVER
		//		$sqlpersonal->set_limit(0,10); // PARA MYSQL
	
		if(count($array) > 0)
		{
			if(trim($array["des_int"]) <> "")
			{
				$where .= " and dd.rut_deudor like '".trim($array["des_int"])."%'";
			}

			if(trim($array["rutmandante"]) <> "")
			{
				$where .= " and m.rut_mandante like '".trim($array["rutmandante"])."%'";
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
	
	
	public function getListaDocumentosCartas($array)
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlselect = "d.id_documento id_documento, c.banco id_banco, dd.primer_apellido ape1_deudor, dd.segundo_apellido ape2_deudor, 
							  		dd.primer_nombre nom1_deudor, dd.segundo_nombre nom2_deudor,dd.rut_deudor rut_deudor, dd.dv_deudor dv_deudor,
									m.nombre nombre_mandante, ed.estado id_estado_doc, td.tipo_documento id_tipo_doc,
									d.numero_documento numero_documento,d.fecha_siniestro fecha_siniestro, d.cta_cte cta_cte,d.monto monto";
	$sqlfrom = " documentos d, 
	 								bancos c,
	 								deudores dd,
	 								mandantes m,
	 								estadodocumentos ed,
	 								tipodocumento td ";
	$sqlwhere = " d.id_banco = c.id_banco
								and  d.id_deudor = dd.id_deudor
								and m.id_mandante = d.id_mandatario
								and d.id_estado_doc = ed.id_estado_doc
								and d.id_tipo_doc = td.id_tipo_documento
								and d.activo = 'S'							
								and upper(ed.estado) like 'PENDIENTE DE ENVIAR CARTA%' ";
	if($array["rutdeudor"] != ""){
		$sqlwhere = $sqlwhere. "and dd.rut_deudor like '".$array["rutdeudor"]."%'";
	}
	
	$sqlwhere = $sqlwhere . " order by d.id_documento asc ";
	
	
	$sqlpersonal->set_select($sqlselect ); 
	$sqlpersonal->set_from($sqlfrom);
	$sqlpersonal->set_where($sqlwhere);
	
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
	
	public function getListaEstadoGestion($des)
	{
    	$dato = new EstadosGestionCollection();
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
	
	public function getDatoDeudor($iddeudor, $array='')
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
										d.numero_documento numero_documento,d.fecha_protesto fecha_protesto,d.cta_cte cta_cte,d.monto monto, d.fecha_siniestro fecha_recibido "); 
		  $sqlpersonal->set_from(" documentos d left join bancos c on d.id_banco = c.id_banco,
		 								deudores dd,
		 								mandantes m,
		 								estadodocumentos ed,
		 								tipodocumento td");
	    
		  $where = "   d.id_deudor = dd.id_deudor
									and m.id_mandante = d.id_mandatario
									and d.id_estado_doc = ed.id_estado_doc
									and d.id_tipo_doc = td.id_tipo_documento
									and d.activo = 'S'
									and d.id_deudor = ".$var_id;
		$where .= " and d.id_documento > ".$array["id_partida"];
									
		$sqlpersonal->set_where($where);
		
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
		
	
	public function getTotalMontoDoc($idd='')
	{
	
		include("config.php");
		
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select(" SUM(d.monto) monto"); 
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
		$where .= " and d.id_deudor = ".$idd;

		$sqlpersonal->set_where($where);
	
    	$sqlpersonal->load();

    	return $sqlpersonal;	
	
	}
	
	
	public function generarCartaPdf($listaIdDocs)
	{

		require_once('fpdf/fpdf.php');
		require_once('FPDI/fpdf_tpl.php');
		require_once('FPDI/fpdi.php');
   
		$pdf = new FPDI();
		$pagecount = $pdf->setSourceFile('views/templateCarta.pdf');
		$tplIdx = $pdf->importPage(1); 
	
		//ordena los datos por deudor para generar carta
		$docCartas = new Documentos();
		$listaDoc = $this->getDocEnviar($listaIdDocs);
		$idDeudorAnt = 0;
		$delta = 5;
		for($i=0; $i<$listaDoc->get_count(); $i++) 
		  {
		  	$deudorTmp = &$listaDoc->items[$i];
		  	 
			if($idDeudorAnt != $deudorTmp->get_data("id_deudor"))
			{
				//identifica el deudor para nueva carta
				$idDeudorAnt = $deudorTmp->get_data("id_deudor");	

				//nueva carta pdf para un deudor
				$pdf->AddPage();
				$pdf->useTemplate($tplIdx); 
				$pdf->SetFont('Arial'); 
				$pdf->SetTextColor(255,0,0); 
				
				//datos cabecera de la carta
				$direccionDyV = 'Direccion del deudor';
				$fechaActual = date('d-m-Y');
				$nombreDeudor = 'Pepe Perez';
				$direccionDeudor = 'Av. providencia 1121 of.6';
				$mandante = "Empresa X";
				
				$pdf->SetXY(10, 50); 
				$pdf->Write(0, $direccionDyV); 
				$pdf->SetXY(10, 55); 
				$pdf->Write(0, $fechaActual);
				$pdf->SetXY(10, 60); 
				$pdf->Write(0, $nombreDeudor);
				$pdf->SetXY(10, 65); 
				$pdf->Write(0, $direccionDeudor);
				$pdf->SetXY(10, 70); 
				$pdf->Write(0, $mandante);
				$pdf->SetXY(10, 75); 
				$pdf->Write(0, "Nos ha encargado la cobranza de los siguientes documentos:");
				$pdf->SetXY(10, 80); 
				$pdf->Write(0, "Rut: ".$rutDeudor);
			}
			$pdf->SetXY(10, 90+$delta); 
			$pdf->Write(0, $deudorTmp->get_data("tipo_documento")." N°:".$deudorTmp->get_data("numero_documento")
							." ".$deudorTmp->get_data("estado")." Protestado el:".$deudorTmp->get_data("fecha_protesto")
							." por ".$deudorTmp->get_data("monto"));
		  }
		
		$rutDeudor = '55555-2';
		
		
		//obtiene
		
		$pdf->Output("carta_".$rutDeudor.".pdf","D");
		
		return 0;
		
	}

	public function getDocEnviar($array)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
		$sqlpersonal->set_select(" d.id_deudor id_deudor,
									dd.rut_deudor rut_deudor,
									dd.dv_deudor dv_deudor,
									dd.primer_nombre primer_nombre_deudor,
									dd.segundo_nombre segundo_nombre_deudor,
									dd.primer_apellido primer_apellido_deudor,
									dd.segundo_apellido segundo_apellido_deudor,
									dds.calle calle,
									dds.numero numero,
									dds.piso piso,
									dds.depto depto,
									dds.comuna comuna,
									dds.ciudad ciudad,
									m.nombre nombre_mandante,
									m.apellido apellido_mandante,
									d.id_documento id_documento, td.tipo_documento tipo_documento,
									d.numero_documento numero_documento,ed.estado estado,
									d.fecha_protesto fecha_protesto,
									d.fecha_siniestro fecha_siniestro,
									d.fecha_creacion fecha_creacion, 
									d.monto monto "); 
	  	$sqlpersonal->set_from(" documentos d ,tipodocumento td, estadodocumentos ed,
        						 mandantes m, deudores dd, direccion_deudores dds ");
      	$sqlpersonal->set_where(" d.id_tipo_doc = td.id_tipo_documento
							and   d.id_estado_doc = ed.id_estado_doc
							and   d.id_deudor = dd.id_deudor
							and   d.id_mandatario = m.id_mandante
							and   dd.id_deudor = dds.id_deudor
							and   d.id_documento in ".$array.
							" order by id_deudor ");
	
    	$sqlpersonal->load();

    	return $sqlpersonal;	
	}
	
	public function getDocLiquidar($id_deudor)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
		$sqlpersonal->set_select(" d.id_deudor id_deudor,
									d.id_documento id_documento, 
									td.tipo_documento tipo_documento,
									d.numero_documento numero_documento,
									ed.estado estado,
									d.fecha_protesto fecha_protesto,
									d.fecha_siniestro fecha_siniestro,
									d.fecha_creacion fecha_creacion, 
									d.monto monto "); 
	  	$sqlpersonal->set_from(" documentos d ,tipodocumento td, estadodocumentos ed ");
      	$sqlpersonal->set_where(" d.id_tipo_doc = td.id_tipo_documento
							and   d.id_estado_doc = ed.id_estado_doc
							and   d.id_deudor = ".$id_deudor.
							" order by id_deudor ");
	
    	$sqlpersonal->load();

    	return $sqlpersonal;
	}
	
	public function getBancoDocumento($array)
	{
		include("config.php");

		$doc = new Documentos();
		$doc->add_filter("id_documento","=",$array["id_doc"]);
		$doc->load();
		
		$banco = new Bancos();
		$banco->add_filter("id_banco","=",$doc->get_data("id_banco"));
		$banco->load();
		
		return $banco;
	}
	
}
?>