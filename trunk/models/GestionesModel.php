<?php
class GestionesModel extends ModelBase
{
		
	
	public function getListaGestiones($des, $param=array())
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select( " 
					    eg.id_gestion id_gestion,
						  m.rut_mandante rut_mandante,
						  m.dv_mandante dv_mandante,
						  d.rut_deudor rut_deudor,
						  d.dv_deudor dv_deudor,
						  d.primer_apellido primer_apellido,
						  d.segundo_apellido segundo_apellido,
						  d.primer_nombre primer_nombre,
						  d.segundo_nombre segundo_nombre,
						  d.razonsocial razonsocial,
						  eg.fecha_gestion fecha_gestion,
						  MAX(eg.fecha_prox_gestion) fecha_prox_gestion,
						  esg.estado estado,
						  ds.`id_estado_doc` id_estado ");
	$sqlpersonal->set_from( " deudores d, documentos ds LEFT JOIN estados_x_gestion eg ON ds.id_documento = eg.id_documento, mandantes m, estadosgestion esg "); 

	$where = " d.id_deudor = ds.id_deudor				
				AND ds.id_mandatario = m.id_mandante 
				AND esg.id_estado = ds.id_estado_doc
 				AND d.activo = 'S' 
  				AND m.activo = 'S' 
  				AND ds.activo = 'S'"; 
	
	if(trim($param["rut_d"]) <> "")
	{
		$where .= " and d.rut_deudor like '".trim($param["rut_d"])."%'";
	}
	if(trim($param["nombre_deudor"]) <> "")
	{
		$where .= " and (d.primer_nombre like '".trim($param["nombre_deudor"])."%' ";
		$where .= " OR d.segundo_nombre like '".trim($param["nombre_deudor"])."%' ";
		$where .= " OR d.primer_apellido like '".trim($param["nombre_deudor"])."%' ";
		$where .= " OR d.segundo_apellido like '".trim($param["nombre_deudor"])."%' )";	
	}
	if(trim($param["rut_m"]) <> "")
	{
		$where .= " and m.rut_mandante like '".trim($param["rut_m"])."%'";
	}
	if(trim($param["id_estado"]) <> "")
	{
		$where .= " and g.estado = ".trim($param["id_estado"]);
	}

	$where = $where ." GROUP BY  ds.id_estado_doc , ds.id_mandatario, d.id_deudor  ORDER BY m.rut_mandante, eg.fecha_prox_gestion DESC, eg.id_gestion ";
	
	$sqlpersonal->set_where( $where );
	$sqlpersonal->set_limit(0,30); // PARA MYSQL
    $sqlpersonal->load();

    return $sqlpersonal;		
	}

	public function getListaGestionesDia($des, $param=array())
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select( " 
						  A.id_gestion id_gestion,  A.rut_mandante rut_mandante,  A.dv_mandante dv_mandante,  A.rut_deudor rut_deudor,
						  A.dv_deudor dv_deudor,  A.primer_apellido primer_apellido,  A.segundo_apellido segundo_apellido,  A.primer_nombre primer_nombre,
						  A.segundo_nombre segundo_nombre,  A.razonsocial razonsocial, A.fecha_gestion fecha_gestion,  A.fecha_prox_gestion fecha_prox_gestion,  A.estado estado,  A.id_estado id_estado 
						     ");
	$sqlpersonal->set_from( " gestiones_dia A ");

	$where = " A.fecha_prox_gestion <= CURDATE() AND A.id_estado NOT IN ( 2,3,4,5,13 ) ";
			
	
	if(trim($param["rut_d"]) <> "")
	{
		$where .= " and A.rut_deudor like '".trim($param["rut_d"])."%'";
	}
	
	if(trim($param["nombre_deudor"]) <> "")
	{
		$where .= " and (A.primer_nombre like '".trim($param["nombre_deudor"])."%' ";
		$where .= " OR A.segundo_nombre like '".trim($param["nombre_deudor"])."%' ";
		$where .= " OR A.primer_apellido like '".trim($param["nombre_deudor"])."%' ";
		$where .= " OR A.segundo_apellido like '".trim($param["nombre_deudor"])."%' )";	
	}
	
	if(trim($param["rut_m"]) <> "")
	{
		$where .= " and A.rut_mandante like '".trim($param["rut_m"])."%'";
	}

	if(trim($param["selEstado"]) <> "")
	{
		$where .= " and A.estado = ".trim($param["selEstado"]);
	}
	
//	$where = $where ." GROUP BY ds.id_estado_doc, ds.id_mandatario, d.id_deudor ";
//	$where = $where ." ORDER by m.rut_mandante, eg.fecha_prox_gestion DESC, eg.id_gestion  ";
	
	
	$sqlpersonal->set_where( $where );
//	$sqlpersonal->set_limit(0,30); // PARA MYSQL
    $sqlpersonal->load();

    return $sqlpersonal;	
	
	}
	
public function cuentaGestionesDia()
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select( " count(*) cantidad ");
	$sqlpersonal->set_from( "gestiones_dia A ");
	$where = " A.fecha_prox_gestion <= CURDATE() AND A.id_estado NOT IN (2, 3, 4, 5, 13) ";
	
	$sqlpersonal->set_where( $where );
	
    $sqlpersonal->load();

    return $sqlpersonal;	
	
	}
	
	public function cuentaGestionesTotal()
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select( " count(*) cantidad ");
	$sqlpersonal->set_from( " gestiones g, deudores d, mandantes m ");
	$where = " g.id_deudor = d.id_deudor
	  	   and g.id_mandante = m.id_mandante
		   and g.activo = 'S'
		   and d.id_deudor in (select d1.id_deudor from documentos d1 where d1.id_deudor = d.id_deudor and d1.id_estado_doc not in( 0 )) ";
	
	$sqlpersonal->set_where( $where );
	
    $sqlpersonal->load();

    return $sqlpersonal;	
	
	}
	
	public function getGestion($idgestion)
	{
		
		$dato = new Gestiones();
		$dato->add_filter("id_gestion","=",$idgestion);
		$dato->load();
		
		return $dato;
	}
	
	public function getListaDirecciones($iddeudor)
	{
		$dato = new Direccion_Deudores();
		$dato->add_filter("id_deudor","=",$iddeudor);
		$dato->load();
		
		return $dato;
	
	}
	
	public function getListaDirecc($iddeudor)
	{
		$dato = new Direccion_DeudoresCollection();
		$dato->add_filter("id_deudor","=",$iddeudor);
		$dato->load();
		
		return $dato;
	
	}
	
	public function getDetalleDocs()
	{
	
		include("config.php");
	
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
		$sqlpersonal->set_select(" td.tipo_documento documento, ed.estado estado,COUNT(d.id_documento) cantidad, SUM(d.monto) monto "); 
	  	$sqlpersonal->set_from(" documentos d,tipodocumento td, estadodocumentos ed ");
	  	$sqlpersonal->set_where(" d.id_tipo_doc = td.id_tipo_documento
								AND d.id_estado_doc = ed.id_estado_doc
								AND d.activo = 'S'
								GROUP BY td.tipo_documento, ed.estado ");
	
    	$sqlpersonal->load();

    	return $sqlpersonal;
	}
	
	
	public function getDetalleGestion($iddeudor,$idmandante,$iddocumento,$idgestion,$idestadoges,$arrdoc)
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select(" g.id_deudor id_deudor,
	   						   d.rut_deudor rut_deudor,
	   						   d.dv_deudor dv_deudor,
	   						   g.id_mandante id_mandante,
	   						   m.rut_mandante rut_mandante,
	   						   m.dv_mandante dv_mandante,
	   						   eg.fecha_gestion fecha_gestion,
	   						   eg.fecha_prox_gestion fecha_prox_gestion,
	   						   ed.estado estado,
	   						   eg.notas notas,
	   						   eg.usuario usuario "); 
	  $sqlpersonal->set_from(" estados_x_gestion eg, gestiones g, mandantes m, deudores d, estadosgestion ed ");
	  $vwhere = " eg.id_gestion = g.id_gestion
								and	g.id_mandante = m.id_mandante
								and	g.id_deudor = d.id_deudor
								and eg.id_estado = ed.id_estado
								and g.id_deudor= ".$iddeudor 
	  						 ." and g.id_mandante = " .$idmandante 
	  						 ." and eg.id_estado in (" .$idestadoges .")". 
	  						  " and eg.id_documento in (SELECT DISTINCT id_documento FROM estados_x_gestion WHERE id_gestion = ".$idgestion." AND id_estado = " .$idestadoges .")";
	  						  
	  						 if($iddocumento != ""){
	  						 	$vwhere = $vwhere ." and (eg.id_documento = " .$iddocumento." or eg.id_documento = 0)";
	  						 }
							 if($arrdoc != ""){
							 	$lista= str_replace(' ',',',trim($arrdoc)); 
	  						 	$vwhere = $vwhere ." and eg.id_documento in (" .$lista.")";
	  						 }
	  						 $vwhere = $vwhere ." GROUP BY notas ";
	  						 $vwhere = $vwhere ." order by eg.fecha_gestion desc ";
	  						 	
	  $sqlpersonal->set_where($vwhere);
	
    $sqlpersonal->load();

    return $sqlpersonal;

	}
	
	
	public function getUltimaGestion($idgestion)
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select(" max(eg.id)id ,esg.estado estado, esg.id_estado id_estado"); 
	  $sqlpersonal->set_from(" gestiones g, estados_x_gestion eg, estadosgestion esg ");
	  $sqlpersonal->set_where(" g.id_gestion = eg.id_gestion 
							and eg.id_estado = esg.id_estado 
	  						and eg.id_gestion = " .$idgestion
	  					 ." group by esg.estado, esg.id_estado");
	
    $sqlpersonal->load();

    return $sqlpersonal;

	}
	
	public function getEstadoGestion($idestado)
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select(" esg.id_estado id_estado ,esg.estado estado"); 
	  $sqlpersonal->set_from(" estadosgestion esg ");
	  $sqlpersonal->set_where(" esg.id_estado = " .$idestado);
	
    $sqlpersonal->load();

    return $sqlpersonal;

	}
	
	
	public function getListaMandantes($param)
	{
		$dato = new MandantesCollection();
		$dato->add_filter("activo","=","S");
		if(trim($param) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("id_deudor","=",$param);
		}
				
		$dato->load();
		
		return $dato;
	}
	
	public function editarGestiones($array)
	{
	  $dato = new Estados_x_Gestion();
	  $datoGes = new Gestiones();
	  
	  for ($i = 1; $i <= count($array); $i++) {
					
		  if($array["iddocumento".$i] != "")
		  {
			  $dato->set_data("id_gestion",$array["idgestion"]);
			  $dato->set_data("id_estado",$array["selGestion"]);
			  $dato->set_data("id_mandante",$array["selMandantes"]);
			  $dato->set_data("id_documento",$array["iddocumento".$i]);
			  
//			  $dato->set_data("fecha_gestion",$array["txtfechagestion"]);
			  $dateges = str_replace('/', '-',$array["txtfechagestion"]); 
			  $dato->set_data("fecha_gestion",date('Y-m-d', strtotime($dateges)));
			  
			  
			  $date = str_replace('/', '-',$array["txtfechaproxgestion"]); 
			  $dato->set_data("fecha_prox_gestion",date('Y-m-d', strtotime($date)));
			  
			  $dato->set_data("notas",$array["txtcomentarios"]);
			  $dato->set_data("usuario",$array["txtusuario"]);
			  
			  $dato->save();
		  }
	  }
	  $datoGes->add_filter("id_gestion","=",$array["idgestion"]);
	  $datoGes->load();
	  
	  $date = str_replace('/', '-',$array["txtfechaproxgestion"]); 
	  $datoGes->set_data("fecha_prox_gestion",date('Y-m-d', strtotime($date)));
	  
	  $datoGes->set_data("estado",$array["selGestion"]);
	  $datoGes->save();
	  
	  
	  for ($i = 1; $i <= count($array); $i++) {
					
		  if($array["iddocumento".$i] != "")
		  {
		  	$documento = new Documentos();
		  	$documento->add_filter("id_documento","=",$array["iddocumento".$i]);
		  	$documento->load();
		  	$documento->set_data("id_estado_doc",$array["selGestion"]);
		  	$documento->save();
		  }
	  }
	  
	}
	
	public function cambiarEstadoDocGestion($array)
	{
	//modifica estado de documento si la gestion es una DEMANDA, CASTIGO o RECUPERO
	  if($array["iddocumento"] != "")
	  {
	  	$documento = new Documentos();
	  	$documento->add_filter("id_documento","=",$array["iddocumento"]);
	  	$documento->load();
	  	$documento->set_data("id_estado_doc",$array["selGestion"]);
	  	$documento->save();
	  }
	}
	
	public function getCabeceraGestion($idgestion)
	{
	
		include("config.php");
	
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		
		$sqlpersonal->set_select(" d.id_deudor id_deudor,
								   m.id_mandante id_mandante,
								   d.rut_deudor rut_deudor,
								   d.dv_deudor dv_deudor,
								   d.razonsocial razonsocial,
								   d.primer_apellido primer_apellido,
								   d.segundo_apellido segundo_apellido,
								   d.primer_nombre primer_nombre,
								   d.segundo_nombre segundo_nombre,
								   d.celular celular,
								   d.telefono_fijo telefono_fijo,
								   d.email email,
								   m.rut_mandante rut_mandante,
								   m.dv_mandante dv_mandante,
								   m.nombre nombre_mandante,
								   m.apellido apellido_mandante,
								   g.estado estado "); 
		  $sqlpersonal->set_from(" gestiones g LEFT JOIN mandantes m ON g.id_mandante = m.id_mandante, deudores d ");
		  $sqlpersonal->set_where(" g.id_deudor = d.id_deudor
		  							and d.activo = 'S'
									and  g.id_gestion = ". $idgestion );
											
	    $sqlpersonal->load();
	
	    return $sqlpersonal;

	}

	public function getDeudaNeta($iddeudor)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		
		$sqlpersonal->set_select(" sum(monto) monto "); 
		$sqlpersonal->set_from(" documentos ");
		$where = "id_deudor = ". $iddeudor;
		$where = $where . "	and activo = 'S' ";
		$where = $where . "	and id_estado_doc not in(
						select id_estado_doc 
						from estadodocumentos 
						where activo = 'S' 
						and estado in ('RECUPERADO','ABONO')
						)";
		$sqlpersonal->set_where($where);
											
	    $sqlpersonal->load();
	
	    return $sqlpersonal;
	}

//	public function getDeudaNetaMandante($iddeudor,$idmandante,$idestadoges)
//	{
//		include("config.php");
//
//		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
//		
//		$sqlpersonal->set_select(" sum(monto) monto "); 
//		$sqlpersonal->set_from(" documentos d ");
//		$where = " d.activo = 'S' and d.id_deudor = ". $iddeudor;
//		$where = $where ." and d.id_mandatario = ".$idmandante. "	and d.id_estado_doc not in(
//						select id_estado_doc ,
//						from estadodocumentos 
//						where activo = 'S' 
//						and estado in ('RECUPERADO','ABONO')
//						)";
//		$sqlpersonal->set_where($where);
//		
//	    $sqlpersonal->load();
//	
//	    return $sqlpersonal;
//	}
	public function getDeudaNetaMandante($iddeudor,$idmandante,$idestadoges)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		
		$sqlpersonal->set_select(" sum(monto) monto "); 
		$sqlpersonal->set_from(" documentos d ");
		$where = " d.activo = 'S' and d.id_deudor = ". $iddeudor;
		$where = $where ." and d.id_mandatario = ".$idmandante. "	and d.id_estado_doc in(".$idestadoges .",999 )";
		$sqlpersonal->set_where($where);
		
	    $sqlpersonal->load();
	
	    return $sqlpersonal;
	}
	
	public function getMandantesDeudor($iddeudor)
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select(" m.rut_mandante rut_mandante, 
	   						   m.dv_mandante dv_mandante,
	   						   m.nombre nombre,
	   						   m.email email,
	   						   m.telefono1 tel1,
	   						   m.telefono2 tel2 "); 
	  $sqlpersonal->set_from(" mandantes m ");
	  $sqlpersonal->set_where(" id_mandante in(
												select distinct d.id_mandatario
												from documentos d
												where d.activo = 'S'
												and d.id_deudor = ".$iddeudor.")"); 
	
    $sqlpersonal->load();

    return $sqlpersonal;

	}
}
?>