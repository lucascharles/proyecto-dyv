<?php
class DeudoresController extends ControllerBase
{
   	
    public function admin($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("admin_deudores.php", $data);
	}
	 public function ficha_documentos($array)
	{
		require 'models/DocumentosModel.php';
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$documentos = new DocumentosModel();
		
		
		if($array["tipoperacion"] == "A")
		{
			$dato = $documentos->getListaDocumentos("",$array["ident"]);
		}
		
		if($array["tipoperacion"] == "M")
		{
			$datodeudor = $deudor->getDeudorFicha($array["ident"]);	
			$dato = $documentos->getListaDocumentos("",$datodeudor->get_data("id_deudor"));
		}
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDoc'] = $dato;
		
		$this->view->show("deudor_ficha_documentos.php", $data);
	}
	
	public function ficha_receptor($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$idrecp = 0;
		if($array["tipoperacion"] == "M")
		{
			$datorecep = $deudor->getReceptor($array["ident"]);
			$idrecp = $array["ident"];
			$data['receptor'] = $datorecep;
		}
						
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['tipoperacion'] = $array["tipoperacion"];
		$data['colGastosReceptor'] = $deudor->getGastosReceptor($idrecp);
		
		$this->view->show("deudor_ficha_receptor.php", $data);
	}
	
	public function ficha_martillero($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$idmart = 0;
		
		if($array["tipoperacion"] == "M")
		{
			$datorecep = $deudor->getReceptor($array["ident"]);
			$idmart = $array["ident"];
			$data['receptor'] = $datorecep;
		}
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colGastosMarillero'] = $deudor->getGastosMartillero($idmart);
				
		$this->view->show("deudor_ficha_martillero.php", $data);
	}
	
	public function ficha_consignacion($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$idcon = 0;
		
		if($array["tipoperacion"] == "M")
		{
			$datorecep = $deudor->getReceptor($array["ident"]);
			$idcon = $array["ident"];
			$data['receptor'] = $datorecep;
		}
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colGastosConsignacion'] = $deudor->getGastosConsignacion($idcon);
				
		$this->view->show("deudor_ficha_consigancion.php", $data);
	}
	
	public function ficha_gastos($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$idgasto = 0;
		
		if($array["tipoperacion"] == "M")
		{
			$datorecep = $deudor->getReceptor($array["ident"]);
			$idgasto = $array["ident"];
			$data['receptor'] = $datorecep;
		}
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colGastosGastos'] = $deudor->getGastosGastos($idgasto);
		
				
		$this->view->show("deudor_ficha_gastos.php", $data);
	}
	
	public function deudor_ficha($array)
    {
		require 'models/DeudoresModel.php';
		require 'models/MandantesModel.php';
		$deudor = new DeudoresModel();
		$mandate = new MandantesModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['ident'] = $array["id"];
		$data['tipoperacion'] = $array["tipope"];
		
		if($array["tipope"] == "M")
		{
			$datodeudor = $deudor->getDeudorFicha($array["id"]);	
		}	
		
		if($array["tipope"] == "A")
		{
			$datodeudor = $deudor->getDeudorDatos($array["id"]);	
		}	
		
		$datomandante = $mandate->getMandanteDatos($datodeudor->get_data("id_mandante"));
		$data['deudor'] = $datodeudor;
		$data['mandante'] = $datomandante;
		
		
		$this->view->show("deudor_ficha.php", $data);
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