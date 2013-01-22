<?php
class ContactoMandanteModel extends ModelBase
{
	
	public function getContactoTmp($idcon)
	{
		$dato = new Contacto_MandantesTmp();
		$dato->add_filter("id_contacto","=",$idcon);
		$dato->load();
				
		return $dato;
	}

	public function getListaContactosTmp($id_sesion)
	{
		$dato = new Contacto_MandantesTmpCollection();
		$dato->add_filter("id_sesion","=",$id_sesion);
		$dato->load();
				
		return $dato;
	}
	
	
	public function borrardirtmp($id_sesion)
	{
		$dato = new Contacto_MandantesTmpCollection();
		$dato->add_filter("id_sesion","=",$id_sesion);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}

	public function guardarContactoTmp($contacto, $email, $celular, $telefono, $fax, $observacion, $id_sesion)
	{
		$dato = new Contacto_MandantesTmp();
		$dato->set_data("contacto",$contacto); 
		$dato->set_data("email",$email); 
		$dato->set_data("celular",$celular); 
		$dato->set_data("telefono",$telefono); 
		$dato->set_data("fax",$fax); 
		$dato->set_data("observacion",$observacion); 
		$dato->set_data("id_sesion",$id_sesion); 
		$dato->save();
	}
	
	public function editarContactoTmp($idcon, $contacto, $email, $celular, $telefono, $fax, $observacion, $id_sesion)
	{
		$dato = new Contacto_MandantesTmp();
		$dato->add_filter("id_contacto","=",$idcon);
		$dato->load();
		$dato->set_data("contacto",$contacto); 
		$dato->set_data("email",$email); 
		$dato->set_data("celular",$celular); 
		$dato->set_data("telefono",$telefono); 
		$dato->set_data("fax",$fax); 
		$dato->set_data("observacion",$observacion); 
		$dato->set_data("id_sesion",$id_sesion); 
		$dato->save();
	}
		
}
?>