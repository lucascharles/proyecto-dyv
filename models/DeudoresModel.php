<?php
class DeudoresModel extends ModelBase
{

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
	
	public function getListaDeudores($rut,$p_ape,$s_ape,$p_nom,$s_nom)
	{
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
	
}
?>