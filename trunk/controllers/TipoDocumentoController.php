<?php
class TipoDocumentoController extends ControllerBase
{
    //Accion index
    public function admin($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("admin_tipodocumento.php", $data);
	}

	public function grabaEditar($array)
	{
		require 'models/TipoDocumentoModel.php';
		$tipdoc = new TipoDocumentoModel();
		$tipdoc->editarTipoDoc($array["idtipdoc"],$array["des_int"]);	
	}

	public function editar($array)
    {
		require 'models/TipoDocumentoModel.php';
		$tipdoc = new TipoDocumentoModel();
		$dato = $tipdoc->getTipoDoc($array["idtipdoc"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['objTipDoc'] = $dato;
		
		$this->view->show("edita_tipodocumento.php", $data);
	}
	
	public function alta($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("alta_tipodocumento.php", $data);
	}

	public function grabar($array)
    {
		require 'models/TipoDocumentoModel.php';
		$tipdoc = new TipoDocumentoModel();
		$tipdoc->altaTipoDoc($array["des_int"]);	
	} 
	
	public function eliminar($array)
    {
	
		require 'models/TipoDocumentoModel.php';
		$tipdoc = new TipoDocumentoModel();
		$dato = $tipdoc->bajaTipoDoc($array["idtipdoc"], $array["des_int"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionTipDoc'] = $dato;
		
		$this->view->show("lista_tipodocumento.php", $data);
	} 
	
	public function listar($array)
    {
		require 'models/TipoDocumentoModel.php';
		$tipdoc = new TipoDocumentoModel();
		$dato = $tipdoc->getListaTipoDoc($array["des_int"]);	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionTipDoc'] = $dato;
		
		$this->view->show("lista_tipodocumento.php", $data);
	}    
  
}
?>