<?php
class GestionesModel extends ModelBase
{
		
	
		
	public function getListaGestiones($des)
	{
	
	include("config.php");

	
	$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
	$sqlpersonal->set_select( " g.id_gestion id_gestion,	   
   					  m.rut_mandante rut_mandante,
					  m.dv_mandante dv_mandante,							   
					  d.rut_deudor rut_deudor, 
					  d.dv_deudor dv_deudor,
					  d.primer_apellido primer_apellido, 
					  d.segundo_apellido segundo_apellido,
					  d.primer_nombre primer_nombre,
					  d.segundo_nombre segundo_nombre,
					  g.fecha_gestion fecha_gestion,
					  g.fecha_prox_gestion fecha_prox_gestion,
					  g.estado estado ");
	$sqlpersonal->set_from( " gestiones g, deudores d, mandantes m ");

	$where = " g.id_deudor = d.id_deudor
	  	   and g.id_mandante = m.id_mandante
		   and g.activo = 'S' ";
		
	if($des != ""){
		
		$cond=" and (d.rut_deudor like '".$des ."%' or m.rut_mandante like '".$des."%' )";
		$where = $where . $cond;
	}

	$where = $where ." ORDER by fecha_prox_gestion asc ";
	
	
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
	
	public function getDetalleGestion($iddeudor,$idmandante)
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
	  $sqlpersonal->set_where(" eg.id_gestion = g.id_gestion
								and	  g.id_mandante = m.id_mandante
								and	  g.id_deudor = d.id_deudor
								and   eg.id_estado = ed.id_estado
								and   g.id_deudor= ".$iddeudor 
	  						 ." and g.id_mandante = " .$idmandante
	  						 ." order by eg.fecha_gestion desc ");
	
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
	  
	  $dato->set_data("id_gestion",$array["idgestion"]);
	  $dato->set_data("id_estado",$array["selGestion"]);
	  $dato->set_data("id_mandante",$array["selMandantes"]);
	  $dato->set_data("fecha_gestion",$array["txtfechagestion"]);
	  $dato->set_data("fecha_prox_gestion",$array["txtfechaproxgestion"]);
	  $dato->set_data("notas",$array["txtcomentarios"]);
	  $dato->set_data("usuario",$array["txtusuario"]);
	  
	  $dato->save();

	  $datoGes->add_filter("id_gestion","=",$array["idgestion"]);
	  $datoGes->load();
	  $datoGes->set_data("fecha_prox_gestion",$array["txtfechaproxgestion"]);
	  $datoGes->save();
	  
	}
	
	public function getCabeceraGestion($idgestion)
	{
	
		include("config.php");

	
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		
		$sqlpersonal->set_select(" d.id_deudor id_deudor,
								   m.id_mandante id_mandante,
								   d.rut_deudor rut_deudor,
								   d.dv_deudor dv_deudor,
								   d.primer_apellido primer_apellido,
								   d.segundo_apellido segundo_apellido,
								   d.primer_nombre primer_nombre,
								   d.segundo_nombre segundo_nombre,
								   d.celular celular,
								   d.telefono_fijo telefono_fijo,
								   m.rut_mandante rut_mandante,
								   m.dv_mandante dv_mandante,
								   m.nombre nombre_mandante "); 
		  $sqlpersonal->set_from(" gestiones g, deudores d, mandantes m ");
		  $sqlpersonal->set_where(" g.id_deudor = d.id_deudor
									and  g.id_mandante = m.id_mandante
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

	public function getDeudaNetaMandante($iddeudor,$idmandante)
	{
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		
		$sqlpersonal->set_select(" sum(monto) monto "); 
		$sqlpersonal->set_from(" documentos ");
		$where = "id_deudor = ". $iddeudor;
		$where = $where ." and id_mandatario = ".$idmandante. "	and id_estado_doc not in(
						select id_estado_doc 
						from estadodocumentos 
						where activo = 'S' 
						and estado in ('RECUPERADO','ABONO')
						)";
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