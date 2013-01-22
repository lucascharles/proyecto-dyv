<?php
class DocumentosController extends ControllerBase
{
    
    //Accion index
    public function admin($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("admin_documentos.php", $data);
	}

	public function grabaEditar($array)
	{
		require 'models/DocumentosModel.php';

				
		$documentos = new DocumentosModel();
		$documentos->editarDocumentos($array);
			
	}

	public function editar($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
		
		$data['objDocumento'] = $documentos->getDocumento($array["id_documento"]);
		$data['datosDocumento'] = $documentos->getDatoDocumento($array["id_documento"]);
		$data['coleccion_mandantes'] = $documentos->getListaMandantes("");
		$data['coleccion_deudores'] = $documentos->getListaDeudores("");
		$data['coleccion_estadoDoc'] = $documentos->getListaEstadoDoc("");
		$data['coleccion_bancos'] = $documentos->getListaBancos("");
		$data['coleccion_tipoDoc'] = $documentos->getListaTipoDoc("");
		$data['coleccion_causalProtesta'] = $documentos->getListaCausalProtesta("");
		    
    	$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		
		$this->view->show("edita_documento.php", $data);
	}
	
	public function alta($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
		$data['coleccion_mandantes'] = $documentos->getListaMandantes("");
		$data['coleccion_deudores'] = $documentos->getListaDeudores("");
		$data['coleccion_estadoDoc'] = $documentos->getListaEstadoDoc("");
		$data['coleccion_bancos'] = $documentos->getListaBancos("");
		$data['coleccion_tipoDoc'] = $documentos->getListaTipoDoc("");
		$data['coleccion_causalProtesta'] = $documentos->getListaCausalProtesta("");
		    
    	$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("alta_documentos.php", $data);
		
	}

	public function grabar($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
		$documentos->altaDocumentos($array);	
	} 
	
	public function eliminar($array)
    {
	
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
		$dato = $documentos->bajaDocumentos($array["iddocumentos"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDocumentos'] = $dato;
		
		$this->view->show("lista_documentos.php", $data);
	} 

	public function listarNuevos($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentos("");
		$datoDoc = $documentos->getDatoDeudor($array["iddeudor"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDocumentos'] = $dato;
		$data['colleccionDatosDocumentos'] = $datoDoc;
		
		$this->view->show("lista_documentos.php", $data);
	}  
	
	public function listar($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentos("");
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDatosDocumentos'] = $dato;
		
		$this->view->show("lista_documentos.php", $data);
	}    
	
	public function listarcartas($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentosCartas("");
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionCartasDocumentos'] = $dato;
		//$data['iddocumento'] = $iddoc;
				
		$this->view->show("lista_cartas_documentos.php", $data);
	}
  
	public function enviarcarta($array)
	{
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
									
		$dato = $documentos->getListaDocumentosCartas("");
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionCartasDocumentos'] = $dato;
		$data['iddocumento'] = $iddoc;
		
		
		$this->view->show("enviar_cartas_documentos.php", $data);	
	}
	
	public function generarcarta($array)
	{
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
		
		for ($i = 1; $i <= count($array); $i++) {
    		$datotmp = $documentos->generarCarta($array["arr".$i]);
    		
		}
		
		
		
		$dato = $documentos->getListaDocumentosCartas("");		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionCartasDocumentos'] = $dato;
		$data['iddocumento'] = $iddoc;
		
		
		$this->view->show("lista_cartas_documentos.php", $data);	
	}
	
	public function marcardocs($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentosCartas("");		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionCartasDocumentos'] = $dato;
		$data['iddesde'] = $array[desde];
		$data['idhasta'] = $array[hasta];
		
		
		$this->view->show("lista_cartas_documentos.php", $data);
	}  
	
 	public function fichas($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("alta_ficha.php", $data);
	}
	
	public function cargam($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("admin_carga_masiva.php", $data);
	}  
	
	
	public function cargam_upload($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "index.php";
		$data['controler'] = "Documentos";
		$data['action'] = "cargar_archivo";
		
		$this->view->show("carga_masiva.php", $data);
	}  
	
	public function cargar_archivo($array)
	{
		//echo("<br>parametro_controller: ".$array["arch_upload"]["txtarchivo"]);
		require 'models/DocumentosModel.php';
		$doc = new DocumentosModel();
		$id_log = $doc->carga_masiva($array["arch_upload"]["txtarchivo"], $_SESSION["idusuario"] );
		$data['logerror'] = $doc->getLogError($id_log);
		$data['logerror_det'] = $doc->getLogErrorDetalle($id_log);
		
		$this->view->show("log_error_carga.php", $data);
	}
	
}
?>