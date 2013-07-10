<?php
class UsuarioModel extends ModelBase
{

	public function getUsuario($id_usuario)
	{
		$dato = new Usuarios();
		$dato->add_filter("id_usuario","=",$id_usuario);
		$dato->load();
		
		return $dato;
	}
	
	
	public function cambiarClave($nueva, $id_usuario)
	{
		$dato = new Usuarios();
		$dato->add_filter("id_usuario","=",$id_usuario);
		$dato->load();
		$dato->set_data("clave",$nueva);
		$dato->save();
	}
	
	public function getPermisosMenu($id_usuario)
	{
		$arrayperm = array();
		
		$dato = new Usuario_permisoCollection();
		$dato->add_filter("id_usuario","=",$id_usuario);
		$dato->load();
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$datoop = new Opcion_permisoCollection();
			$datoop->add_filter("id_permiso","=",$datoTmp->get_data("id_permiso"));
			$datoop->load();
			
			for($k=0; $k<$datoop->get_count(); $k++) 
			{
				$datoopTmp = &$datoop->items[$k];
				//echo("<br> id_opcion: ".$datoopTmp->get_data("id_opcion"));
				$arrayperm[] = $datoopTmp->get_data("id_opcion");
			}
		}
		
		
		//echo("<br>perm: ".json_encode($arrayperm));
		$arraymenu = array();
		
		$datom = new ModuloCollection();
		$datom->load();
		for($h=0; $h<$datom->get_count(); $h++) 
		{	
			$datomTmp = &$datom->items[$h];
			
			$arrayopcion = array();
			$datoom = new OpcionmenuCollection();
			$datoom->add_filter("id_modulo","=",$datomTmp->get_data("id"));
			$datoom->load();
			$existe = 0;
			
			for($i=0; $i<$datoom->get_count(); $i++) 
			{	
				$datoomTmp = &$datoom->items[$i];
				
				if(in_array($datoomTmp->get_data("id"),$arrayperm))
				{
					$existe = $existe + 1;
					$arraydetop = array();
					$arraydetop[] = $datoomTmp->get_data("id");
					$arraydetop[] = $datoomTmp->get_data("nombre");
					$arraydetop[] = $datoomTmp->get_data("acceso","N");
					$arrayopcion[] = $arraydetop;
				}
			}
			
			if($existe > 0)
			{
				$arraymodulo = array();
				$arraymodulo[] = $datomTmp->get_data("id");
				$arraymodulo[] = $datomTmp->get_data("nombre");
				$arraymodulo[] = $arrayopcion;
				/*
				echo("<br>nombre_modulo: ".$datomTmp->get_data("nombre"));
				echo("<br>".json_encode($arrayopcion));
				echo("<br>".json_encode($arraymodulo));
				*/
				$arraymenu[] = $arraymodulo;
				//echo("<br>".json_encode($arraymenu));
			}
		}
		//echo("<br><br><br>");
		//echo("<br>".json_encode($arraymenu));
		return $arraymenu;
	}
	
	public function validarUsuario($id_usuario, $clave)
	{
		$resp = false; 
		
		$oUsuario = new Usuarios();
		$oUsuario->add_filter("id_usuario","=",$id_usuario);
		$oUsuario->add_filter("AND");
		$oUsuario->add_filter("clave","=",$clave);
		$oUsuario->add_filter("AND");
		$oUsuario->add_filter("activo","=","S");
		$oUsuario->load();
	
		if(!is_null($oUsuario->get_data("nom_usuario")))
		{
			$_SESSION['idusuario'] = $oUsuario->get_data("id_usuario");
			// $ir = "menu.php";
			$resp = true; 
		}
		
		return $resp;

	}
	
	public function getDatosUsuario($array)
	{
		$dato = new Usuarios();
		$dato->add_filter("id_usuario","=",$array["idusuario"]);
		$dato->load();
		
		return $dato;
	}
}
?>