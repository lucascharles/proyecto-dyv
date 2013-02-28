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
			
		$dato = $documentos->getListaDocumentos("",$array["ident"]);
		$datoDoc = $documentos->getDatoDeudor($array["iddeudor"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDocumentos'] = $dato;
		$data['colleccionDatosDocumentos'] = $datoDoc;
		
		$this->view->show("lista_documentos.php", $data);
	}  
	
	public function listar_mas_registros($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
		$dato = $documentos->getListaDocumentos("","",$array);

		$datoTmp = &$dato->items[($dato->get_count()-1)];
		$array["id_partida"] = $datoTmp->get_data("id_documento");
		$datoAux = $documentos->getListaDocumentos("","",$array);
		
		$html = "<table width='100%' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td  width='3%'>";
			$html .= "<input type='radio' id='".$datoTmp->get_data("id_documento")."' name='checktipdoc' value='' onclick='seleccionado(".$datoTmp->get_data("id_documento").")'>";
			$html .= "</td>";
			$html .= "<td align='left' width='12%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_documento")."</td>";
			$html .= "<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("ape1_deudor")." ".$datoTmp->get_data("ape2_deudor").$datoTmp->get_data("nom1_deudor")."</td>";
			$html .= "<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("nombre_mandante")."</td>";
			$html .= "<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".formatoFecha($datoTmp->get_data("fecha_siniestro"),"dd-mm-yyyy","dd/mm/yyyy")."</td>";
			$html .= "<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_estado_doc")."</td>";
			$html .= "<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("numero_documento")."</td>";
			$html .= "<td align='left' width='9%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_tipo_doc")."</td>";
			$html .= "<td align='left' width='8%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("monto")."</td>";
			$html .= "<td align='left' width='9%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_banco")."</td>";
			$html .= "<td align='left' width='9%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("cta_cte")."</td>";
			$html .= "</tr>";
    		$html .= "<tr bgcolor='#FFFFFF'>";
			$html .= "<td colspan='11' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
			$html .= "</tr>";
		
		}
		
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		
		if($datoAux->get_count() > 0)
		{
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='11' align='center'>";
        	$html .= "<div id='btnvermas_".$datoTmp->get_data("id_documento")."' onclick='verMasRegistros(".$datoTmp->get_data("id_documento").")' style='cursor:pointer;'>Ver mas </div>";
			$html .= "</td>";
			$html .= "</tr>";
	    }
	    $html .= "</table>";
		$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_documento")."' style='display:none;'>";
	    $html .= "</div>";
		
		echo($html);
	}
	
	public function listar($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentos("","",$array);
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		
		$array["id_partida"] = $datoTmp->get_data("id_documento");
		$datoAux = $documentos->getListaDocumentos("","",$array);
	
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDatosDocumentos'] = $dato;
		$data['cant_mas'] = $datoAux->get_count();
		
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
		$data['coltipoerror'] = $doc->getTiposError();
		
		$this->view->show("log_error_carga.php", $data);
	}
	
}
?>