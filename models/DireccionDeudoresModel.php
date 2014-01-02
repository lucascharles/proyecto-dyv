<?php
class DireccionDeudoresModel extends ModelBase
{
	public function getDirActualDeudor($id_deudor)
	{
		$dir_deudor = new Direccion_Deudores();
		
		$dato = new Direccion_DeudoresCollection();
		$dato->add_filter("id_deudor","=",$id_deudor);
		$dato->load();
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];  
			$dir_deudor = $datoTmp;
			break;
		}
		
		return $dir_deudor;
	}
	
	
	public function getDireccionTmp($iddir)
	{
		$dato = new Direccion_DeudoresTmp();
		$dato->add_filter("id_direccion","=",$iddir);
		$dato->load();
				
		return $dato;
	}
	
	public function getDireccion($iddir)
	{
		$dato = new Direccion_Deudores();
		$dato->add_filter("id_direccion","=",$iddir);
		$dato->load();
				
		return $dato;
	}

	public function getListaDireccionesTmp($id_sesion)
	{
		$dato = new Direccion_DeudoresTmpCollection();
		$dato->add_filter("id_sesion","=",$id_sesion);
		$dato->load();
				
		return $dato;
	}

	public function getListaDirecciones($iddeudor)
	{
		$dato = new Direccion_DeudoresCollection();
		$dato->add_filter("id_deudor","=",$iddeudor);
		$dato->load();
				
		return $dato;
	}
	
	
	public function borrardirtmp($id_sesion)
	{
		$dato = new Direccion_DeudoresTmp();
		$dato->add_filter("id_sesion","=",$id_sesion);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
	
	public function guardarDireccionTmp($calle, $numero, $piso, $departamento, $comuna, $ciudad, $otros, $id_sesion,$vigente)
	{
		$dato = new Direccion_DeudoresTmp();
		$dato->set_data("calle",$calle); 
		$dato->set_data("numero",$numero); 
		$dato->set_data("piso",$piso); 
		$dato->set_data("depto",$departamento); 
		$dato->set_data("comuna",$comuna); 
		$dato->set_data("ciudad",$ciudad); 
		$dato->set_data("otros",$otros); 
		$dato->set_data("id_sesion",$id_sesion); 
		$dato->set_data("vigente",$vigente);
		$dato->save();
	}
	
	public function editarDireccionTmp($iddir, $calle, $numero, $piso, $departamento, $comuna, $ciudad, $otros, $id_sesion,$vigente)
	{
		$dato = new Direccion_DeudoresTmp();
		$dato->add_filter("id_direccion","=",$iddir);
		$dato->load();
		$dato->set_data("calle",utf8_decode($calle)); 
		$dato->set_data("numero",$numero); 
		$dato->set_data("piso",$piso); 
		$dato->set_data("depto",$departamento); 
		$dato->set_data("comuna",utf8_decode($comuna)); 
		$dato->set_data("ciudad",utf8_decode($ciudad)); 
		$dato->set_data("otros",utf8_decode($otros)); 
		$dato->set_data("id_sesion",$id_sesion);
		$dato->set_data("vigente",$vigente); 
		$dato->save();
	}
	
}
?>