<?php
class MandantesController extends ControllerBase
{
    public function editarcontmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$con = new ContactoMandanteModel();
		$con->editarContactoTmp($array["idcon"], $array["contacto"],$array["email"],$array["celular"],$array["telefono"],$array["fax"],$array["observacion"], session_id());
	}
	
	public function getcontmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$con = new ContactoMandanteModel();
		$dato = $con->getContactoTmp($array["idcon"]);
		
		$arrayr = array();
		
		$arrayr[] = $dato->get_data("contacto");
		$arrayr[] = $dato->get_data("email");
		$arrayr[] = $dato->get_data("celular");
		$arrayr[] = $dato->get_data("telefono");
		$arrayr[] = $dato->get_data("fax");
		$arrayr[] = $dato->get_data("observacion");
		
		echo(json_encode($arrayr));		
	}
	
	public function borrartmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$dir = new ContactoMandanteModel();
		$dir->borrardirtmp(session_id());
	}
	
	public function grabarcontmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$con = new ContactoMandanteModel();
		$con->guardarContactoTmp($array["contacto"],$array["email"],$array["celular"],$array["telefono"],$array["fax"],$array["observacion"], session_id());
	}
	
	public function listar_contmp($array)
    {
		require 'models/ContactoMandanteModel.php';
		$cont = new ContactoMandanteModel();
		$dato = $cont->getListaContactosTmp(session_id());	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionContactos'] = $dato;
		
		$this->view->show("lista_contactos.php", $data);
	}
	
    public function admin($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("admin_mandantes.php", $data);
	}

	public function grabaEditar($array)
	{
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		$array["session_id"] = session_id();
		$mandantes->editarMandantes($array);			
	}

	public function editar($array)
    {
		require 'models/BancosModel.php';
		require 'models/ModoPagoModel.php';
		require 'models/MandantesModel.php';
		
		$banco = new BancosModel();
		$mandantes = new MandantesModel();
		$modopago = new ModoPagoModel();
		$dato = $mandantes->getMandante($array["idmandantes"], session_id());
		$datomp = $mandantes->getMandanteModoPago($array["idmandantes"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['objMandantes'] = $dato;
		$data['objColMandMp'] = $datomp;
		$data['coleccion_bancos'] = $banco->getListaBancos("");
		$data['coleccion_modopago'] = $modopago->getListaModoPago("");
		
		
		$this->view->show("edita_mandantes.php", $data);
	}
	
	public function alta($array)
    {
		require 'models/BancosModel.php';
		require 'models/ModoPagoModel.php';
		$banco = new BancosModel();
		$modopago = new ModoPagoModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['coleccion_bancos'] = $banco->getListaBancos("");
		$data['coleccion_modopago'] = $modopago->getListaModoPago("");
		
		$this->view->show("alta_mandantes.php", $data);
	}

	public function grabar($array)
    {
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		$array["session_id"] = session_id();
		$mandantes->altaMandantes($array);	
	} 
	
	public function eliminar($array)
    {
	
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		$dato = $mandantes->bajaMandantes($array["idmandantes"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionMandantes'] = $dato;
		
		$this->view->show("lista_mandantes.php", $data);
	} 
	
	public function listar($array)
    {
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		require 'models/BancosModel.php';
		$banco = new BancosModel();

		$dato = $mandantes->getListaMandantes($array["des_int"],$array["desApel1"],$array["desNomb1"]);
		$datob = $banco->getListaBancos("");
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionMandantes'] = $dato;
		$data['colleccionBancos'] = $datob;
		
		if($array["pantalla"] == "pdeudor")
		{
			$data['pantalla'] = "pdeudor";
		}
		$this->view->show("lista_mandantes.php", $data);
	}    
  
}
?>
