<?php
class GestionesController extends ControllerBase
{
    //Accion index
    public function admin($array)
    {
		require 'models/GestionesModel.php';
    	$gestiones = new GestionesModel();
    	$cantidad = $gestiones->cuentaGestionesDia();
    	$cuenta = $cantidad->items[0];
		$cant = $cuenta->get_data("cantidad");
		
    	$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['tipoGestion'] = "D";
		$data['cantGestion'] = $cant;
		
		$this->view->show("admin_gestiones.php", $data);
	}

	public function admin_grales($array)
    {
		require 'models/GestionesModel.php';
    	$gestiones = new GestionesModel();
    	$cantidad = $gestiones->cuentaGestionesTotal();
    	$cuenta = $cantidad->items[0];
		$cant = $cuenta->get_data("cantidad");
    	
    	$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['tipoGestion'] = "";
		$data['cantGestion'] = $cant;
		
		$this->view->show("admin_gestiones.php", $data);
	}
	
	public function gestionar($array)
    {
		require 'models/GestionesModel.php';
		require 'models/DocumentosModel.php';
		
		$gestiones = new GestionesModel();
		$estges = new DocumentosModel();
		
		$cabecera = $gestiones->getCabeceraGestion($array["idgestion"]);
		$cab = $cabecera->items[0];
		$rutDeudor = $cab->get_data("rut_deudor")."-".$cab->get_data("dv_deudor");
		$nomDeudor = $cab->get_data("primer_apellido")." ".$cab->get_data("segundo_apellido")." ".$cab->get_data("primer_nombre");
		$rutMandante = $cab->get_data("rut_mandante")."-".$cab->get_data("dv_mandante");
		$rutMand = $cab->get_data("rut_mandante");
		$rutDvMand = $cab->get_data("dv_mandante");
		$nomMandante = $cab->get_data("nombre_mandante");
		
		$iddeudor = $cab->get_data("id_deudor");
		$idmandante = $cab->get_data("id_mandante");
		$celDeudor = $cab->get_data("celular");
		$telDeudor = $cab->get_data("telefono_fijo"); 
		$emailDeudor = $cab->get_data("email");
		
		$datoDeuda = $gestiones->getDeudaNeta($iddeudor);
		$monto = $datoDeuda->items[0];
		$deuda = $monto->get_data("monto");
		
		$datoDeudaMandante = $gestiones->getDeudaNetaMandante($iddeudor,$idmandante);
		$montoMandante = $datoDeudaMandante->items[0];
		$deudaMandante = $montoMandante->get_data("monto");
		
		$dato = $gestiones->getGestion($array["idgestion"]);
		$datoEg = $estges->getListaEstadoGestion(""); 
		$datoM = $gestiones->getListaMandantes($array["iddeudor"]);
		
		
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['objGestion'] = $dato;
		$data['coleccionEstadoGestion'] = $datoEg;
		$data['coleccionMandantes'] = $datoM;
		$data['rutDeudor'] = $rutDeudor;
		$data['nomDeudor'] = $nomDeudor;
		$data['celDeudor'] = $celDeudor;
		$data['telDeudor'] = $telDeudor;
		$data['emailDeudor'] = $emailDeudor;
		
		$data['rutMand'] = $rutMand;
		$data['rutDvMand'] = $rutDvMand;
		$data['rutMandante'] = $rutMandante;
		$data['idMandante'] = $idmandante;
		$data['nomMandante'] = $nomMandante;
		$data['deudaNeta'] = $deuda;
		$data['deudaNetaMandante'] = $deudaMandante;
		
		
		$ultimaGestion = $gestiones->getUltimaGestion($array["idgestion"]);
		
		if($ultimaGestion->get_count() > 0)
		{
			$ultGes = $ultimaGestion->items[0];
			$data['idUltimaGestion'] = $ultGes->get_data("id_estado");
			$data['estadoUltimaGestion'] = $ultGes->get_data("estado");
		}
		else
		{
			$data['idUltimaGestion'] = 1;
			$data['estadoUltimaGestion'] = "EXISTENCIA"; 
		}
		
		$this->view->show("edita_gestion.php", $data);
	}
	
	
	public function listar($array)
    {
		require 'models/GestionesModel.php';
		$gestiones = new GestionesModel();
		$dato = $gestiones->getListaGestiones($array["des_int"]);

		if($array["tipoGestion"] == "D")
		{
			$dato = $gestiones->getListaGestionesDia($array["des_int"]);			
		}
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionGestiones'] = $dato;
		
		$this->view->show("lista_gestiones.php", $data);
	}    
  
	public function listardirecciones($array)
    {
		require 'models/GestionesModel.php';
		
		$gestiones = new GestionesModel();
		$dato = $gestiones->getListaDirecciones($array["iddeudor"]);

		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDirecciones'] = $dato;
		
		$this->view->show("lista_direcciones_gestion.php", $data);
	}  

	
	public function listar_dir($array)
    {
		require 'models/DireccionDeudoresModel.php';
		$dir = new DireccionDeudoresModel();
		$dato = $dir->getListaDirecciones($array["iddeudor"]);	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDirecciones'] = $dato;
		
		$this->view->show("lista_direcciones_gestion.php", $data);
	}

	public function listar_demandas($array)
    {
		require 'models/DeudoresModel.php';
		$dir = new DeudoresModel();
		$dato = $dir->lista_demandas($array["iddeudor"]);	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDemandas'] = $dato;
		
		$this->view->show("lista_demandas.php", $data);
	}
	
	public function listar_bitacora_gestion($array)
    {
		require 'models/GestionesModel.php';
		
		$ges = new GestionesModel();
		
		$cabecera = $ges->getCabeceraGestion($array["idgestion"]);
		$dato = $cabecera->items[0];
		$iddeudor = $dato->get_data("id_deudor");
		$idmandante = $dato->get_data("id_mandante");
		$dato = $ges->getDetalleGestion($iddeudor,$idmandante);	
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionBitacoraGestion'] = $dato;
		$data['colleccionCabeceraGestion'] = $cabecera;
		
		$this->view->show("lista_bitacora_gestion.php", $data);
	}
	
	public function grabaEditar($array)
	{
		require 'models/GestionesModel.php';

				
		$gestiones = new GestionesModel();
		$gestiones->editarGestiones($array);
			
	}

	public function grabarDir($array)
	{
		require 'models/GestionesModel.php';

				
		$gestiones = new GestionesModel();
		$gestiones->grabarDireccion($array);
			
	}
	
	public function listarGestiones($array)
    {
		require 'models/GestionesModel.php';
		$gestiones = new GestionesModel();
//		if()
//		{
//			$dato = $gestiones->getListaGestionesDia($array["des_int"]);	
//		}
		
		
		$dato = $gestiones->getListaGestiones($array["des_int"]);
		
		

		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionGestiones'] = $dato;
		
		$this->view->show("lista_gestiones.php", $data);
	} 
	
	public function listarDocumentos($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentosGestion("", $array["iddeudor"],$array);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDatosDocumentos'] = $dato;
		
		$this->view->show("lista_documentos.php", $data);
	}

	public function getMandantesDeudor($array)
    {
		require 'models/GestionesModel.php';
		$gestiones = new GestionesModel();
		$dato = $gestiones->getMandantesDeudor($array["iddeudor"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionMandantesDeudor'] = $dato;
		
		$this->view->show("lista_mandantesDeudor.php", $data);
	}    
	
}
?>