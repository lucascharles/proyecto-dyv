<?php
class PermisoModel extends ModelBase
{

	public function getModulos()
	{
    	$dato = new ModuloCollection();
	    $dato->load();
       
	    return $dato;
	}
	
	public function getOpcionModulo($array)
	{

		$dato = new OpcionMenuCollection();
		$dato->add_filter("id_modulo","=",$array["id_modulo"]);
		$dato->load();
		
		return $dato;
	}

	public function getOpcionModuloTmp($array)
	{

		include("config.php");

		$select = " o.id id, o.nombre nombre "; 
 		$from = " opcionmenu o, opcionpermisotmp tmp ";
   		$where = " o.id = tmp.id_opcionmenu ";
		$where .= " and tmp.id_sesion = '".$array["session_id"]."'";
				
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}
	
	public function agregarOpcionMenuTmp($array)
	{
		$datoB = new OpcionPermisoTmpCollection();
		$datoB->add_filter("id_sesion","=",$array["session_id"]);
		$datoB->add_filter("AND");
		$datoB->add_filter("id_opcionmenu","=",$array["idopcion"]);
		$datoB->load();
		
		if($datoB->get_count() == 0)
		{
			$dato = new OpcionPermisoTmp();
			$dato->set_data("id_sesion",$array["session_id"]);
			$dato->set_data("id_opcionmenu",$array["idopcion"]);
			$dato->save();
		}
	}
	
	public function quitarOpcionMenuTmp($array)
	{
		$dato = new OpcionPermisoTmp();
		$dato->add_filter("id_sesion","=",$array["session_id"]);
		$dato->add_filter("AND");
		$dato->add_filter("id_opcionmenu","=",$array["idopcion"]);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
	public function borrarTmpOpcionMenu($array)
	{
		$dato = new OpcionPermisoTmpCollection();
		$dato->add_filter("id_sesion","=",$array["session_id"]);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}

	
	public function grabar_alta($array)
	{
		$dato = new Permiso();
		$dato->set_data("nombre",$array["nombre"]);
		$dato->save();
		
		$idpermiso = getUltimoId(new PermisoCollection(), "id");
		
		$datocol = new OpcionPermisoTmpCollection();
		$datocol->add_filter("id_sesion","=",$array["session_id"]);
		$datocol->load();
		
		for($j=0; $j<$datocol->get_count(); $j++) 
		{
			$datoTmp = &$datocol->items[$j];  
			$opperm = new Opcion_permiso();
			$opperm->set_data("id_permiso",$idpermiso);
			$opperm->set_data("id_opcion",$datoTmp->get_data("id_opcionmenu"));
			$opperm->save();
		}
	}
	
	public function getPermisos()
	{
		$datocol = new PermisoCollection();
		$datocol->load();
		
		return $datocol;
	}
	
	public function bajaPermiso($array)
	{
		$dato = new Permiso();
		$dato->add_filter("id","=",$array["idpermiso"]);
		$dato->mark_deleted();
		$dato->load();
		$dato->save();
		
		$opperm = new Opcion_permisoCollection();
		$opperm->add_filter("id_permiso","=",$array["idpermiso"]);
		$opperm->mark_deleted();
		$opperm->load();
		$opperm->save();
		
		
		$datocol = new PermisoCollection();
		$datocol->load();
		
		return $datocol;
	}
	
	public function getDatosPermiso($array)
	{
		$dato = new Permiso();
		$dato->add_filter("id","=",$array["idpermiso"]);
		$dato->load();
		
		$datocol = new Opcion_permisoCollection();
		$datocol->add_filter("id_permiso","=",$array["idpermiso"]);
		$datocol->load();
		
		$opcol = new OpcionPermisoTmpCollection();
		$opcol->add_filter("id_sesion","=",$array["session_id"]);
		$opcol->load();
		$opcol->mark_deleted();
		$opcol->save();
		
		for($j=0; $j<$datocol->get_count(); $j++) 
		{
		
			$datoTmp = &$datocol->items[$j];  
			
			$opperm = new OpcionPermisoTmp();
			$opperm->set_data("id_opcionmenu",$datoTmp->get_data("id_opcion"));
			$opperm->set_data("id_sesion",$array["session_id"]);
			$opperm->save();
		}
		
		return $dato;
	}
	
	public function grabar_editar($array)
	{
		$dato = new Permiso();
		$dato->add_filter("id","=",$array["idpermiso"]);
		$dato->load();
		$dato->set_data("nombre",$array["nombre"]);
		$dato->save();
		
		$op = new Opcion_permisoCollection();
		$op->add_filter("id_permiso","=",$array["idpermiso"]);
		$op->load();
		$op->mark_deleted();
		$op->save();
		
		$datocol = new OpcionPermisoTmpCollection();
		$datocol->add_filter("id_sesion","=",$array["session_id"]);
		$datocol->load();
		
		for($j=0; $j<$datocol->get_count(); $j++) 
		{
			$datoTmp = &$datocol->items[$j];  
			$opperm = new Opcion_permiso();
			$opperm->set_data("id_permiso",$array["idpermiso"]);
			$opperm->set_data("id_opcion",$datoTmp->get_data("id_opcionmenu"));
			$opperm->save();
		}
	}
	
	public function agregarPermisoUsuTmp($array)
	{
		$datoB = new Usuario_permisoTmpCollection();
		$datoB->add_filter("id_sesion","=",$array["session_id"]);
		$datoB->add_filter("AND");
		$datoB->add_filter("id_permiso","=",$array["idpermiso"]);
		$datoB->add_filter("AND");
		$datoB->add_filter("id_usuario","=",$array["idusuario"]);
		$datoB->load();
		
		if($datoB->get_count() == 0)
		{
			$dato = new Usuario_permisoTmp();
			$dato->set_data("id_sesion",$array["session_id"]);
			$dato->set_data("id_permiso",$array["idpermiso"]);
			$dato->set_data("id_usuario",$array["idusuario"]);
			$dato->save();
		}
	}
	
	public function getPermisosTmp($array)
	{
		include("config.php");

		$select = " p.id id, p.nombre nombre "; 
 		$from = " permiso p, usuario_permisotmp tmp ";
   		$where = " p.id = tmp.id_permiso ";
		$where .= " and tmp.id_sesion = '".$array["session_id"]."'";
				
		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
		$sqlpersonal->set_select($select);
		$sqlpersonal->set_from($from);
		$sqlpersonal->set_where($where);
    	$sqlpersonal->load();

	    return $sqlpersonal;
	}

	public function borrarTmpPermisosAsignar($array)
	{
		$dato = new Usuario_PermisoTmpCollection();
		$dato->add_filter("id_sesion","=",$array["session_id"]);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
	public function quitarPermisoUsuTmp($array)
	{
		$dato = new Usuario_PermisoTmp();
		$dato->add_filter("id_sesion","=",$array["session_id"]);
		$dato->add_filter("AND");
		$dato->add_filter("id_permiso","=",$array["idpermiso"]);
		$dato->add_filter("AND");
		$dato->add_filter("id_usuario","=",$array["idusuario"]);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
	public function grabar_asignar_permiso_usu($array)
	{
		$dato = new Usuario_PermisoCollection();
		$dato->add_filter("id_usuario","=",$array["idusuario"]);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
			
		$datocol = new Usuario_PermisoTmpCollection();
		$datocol->add_filter("id_sesion","=",$array["session_id"]);
		$datocol->load();
		
		for($j=0; $j<$datocol->get_count(); $j++) 
		{
			$datoTmp = &$datocol->items[$j];  
			$opperm = new Usuario_Permiso();
			$opperm->set_data("id_permiso",$datoTmp->get_data("id_permiso"));
			$opperm->set_data("id_usuario",$array["idusuario"]);
			$opperm->save();
		}
	}
	
	public function llenartmp_permisosusu($array)
	{
		$datocol = new Usuario_PermisoCollection();
		$datocol->add_filter("id_usuario","=",$array["idusuario"]);
		$datocol->load();
		
		$dato = new Usuario_PermisoTmpCollection();
		$dato->add_filter("id_sesion","=",$array["session_id"]);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
		
		//echo("<br>cunt: ".$datocol->get_count());
		
		for($j=0; $j<$datocol->get_count(); $j++) 
		{
			$datoTmp = &$datocol->items[$j];  
			//echo("<br> id_permiso:".$datoTmp->get_data("id_permiso")." / usuario: ".$datoTmp->get_data("id_usuario"));
			
			$datoe = new Usuario_PermisoTmp();
			$datoe->set_data("id_permiso",$datoTmp->get_data("id_permiso"));
			$datoe->set_data("id_usuario",$datoTmp->get_data("id_usuario"));
			$datoe->set_data("id_sesion",$array["session_id"]);
			$datoe->save();
		}
		
	}
}
?>