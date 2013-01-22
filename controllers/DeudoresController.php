<?php
class DeudoresController extends ControllerBase
{
    //Accion index
    public function admin($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("admin_deudores.php", $data);
	}
	
	public function grabar($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$array["session_id"] = session_id();
		$deudor->guardarDeudor($array);
	}
	
	public function getdirtmp($array)
	{
		require 'models/DireccionDeudoresModel.php';
		$dir = new DireccionDeudoresModel();
		$dato = $dir->getDireccionTmp($array["iddir"]);
		
		$arrayr = array();
		
		$arrayr[] = $dato->get_data("calle");
		$arrayr[] = $dato->get_data("numero");
		$arrayr[] = $dato->get_data("piso");
		$arrayr[] = $dato->get_data("depto");
		$arrayr[] = $dato->get_data("comuna");
		$arrayr[] = $dato->get_data("ciudad");
		$arrayr[] = $dato->get_data("otros");
		
		echo(json_encode($arrayr));		
	}
	
	public function grabardirtmp($array)
	{
		require 'models/DireccionDeudoresModel.php';
		$dir = new DireccionDeudoresModel();
		$dir->guardarDireccionTmp($array["calle"],$array["numero"],$array["piso"],$array["departamento"],$array["comuna"],$array["ciudad"],$array["otros"], session_id());
	}
	
	public function editardirtmp($array)
	{
		require 'models/DireccionDeudoresModel.php';
		$dir = new DireccionDeudoresModel();
		$dir->editarDireccionTmp($array["iddir"], $array["calle"],$array["numero"],$array["piso"],$array["departamento"],$array["comuna"],$array["ciudad"],$array["otros"], session_id());
	}
	
	public function listar($array)
    {
		require 'models/DeudoresModel.php';
		$tipdoc = new DeudoresModel();
		$dato = $tipdoc->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"]);	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDeudores'] = $dato;
		
		$this->view->show("lista_deudores.php", $data);
	}   
	
	public function borrartmp($array)
	{
		require 'models/DireccionDeudoresModel.php';
		$dir = new DireccionDeudoresModel();
		$dir->borrardirtmp(session_id());
	}
	
	public function borrarMandantetmp($array)
	{
		require 'models/DeudoresModel.php';
		$dir = new DeudoresModel();
		$dir->borrarmandantetmp(session_id());
	}
	
	public function listar_dirtmp($array)
    {
		require 'models/DireccionDeudoresModel.php';
		$dir = new DireccionDeudoresModel();
		$dato = $dir->getListaDireccionesTmp(session_id());	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDeudores'] = $dato;
		
		$this->view->show("lista_direcciones.php", $data);
	}   
	
	public function alta($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("alta_deudores.php", $data);
	}
	
	public function eliminar($array)
    {	
		require 'models/DeudoresModel.php';
		$tipdoc = new DeudoresModel();
		$dato = $tipdoc->bajaDeudor($array["iddeudor"], $array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDeudores'] = $dato;
		
		$this->view->show("lista_deudores.php", $data);
	}
	
	public function editar($array)
    {
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getDeudor($array["iddeudor"], session_id());
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['objDeudor'] = $dato;
		
		$this->view->show("edita_deudores.php", $data);
	}
	
	public function grabaEditar($array)
	{
		require 'models/DeudoresModel.php';
		$tipdoc = new DeudoresModel();
		$array["session_id"] = session_id();
		$tipdoc->editarDeudor($array);	
	}
	
	public function listar_mand_sesion($array)
	{
		require 'models/DeudoresModel.php';
		$deudores = new DeudoresModel();
		$dato = $deudores->getListaMandantesSesion(session_id());
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionMandantes'] = $dato;
		if($array["pantalla"] == "pdeudor_s")
		{
			$data['pantalla'] = "pdeudor_s";
		}

		$this->view->show("lista_mandantes.php", $data);
	}
	
	public function agregarMandSesion($array)
	{
		require 'models/DeudoresModel.php';
		$deudores = new DeudoresModel();
		$dato = $deudores->agregaMandanteTmp($array["idmandante"],session_id());
	}

	public function quitarMandSesion($array)
	{
		require 'models/DeudoresModel.php';
		$deudores = new DeudoresModel();
		$dato = $deudores->quitarMandanteTmp($array["idmandante"],session_id());
	}
	
}
?>