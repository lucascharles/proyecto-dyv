<?php
class DocumentosController extends ControllerBase
{
    
    //Accion index
    public function admin($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['rutDeudor'] = $array["rutDeudor"];
		
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
		require 'models/MandantesModel.php';
		require 'models/DeudoresModel.php';
		$documentos = new DocumentosModel();		
		$mandantes = new MandantesModel();
		$deudores = new DeudoresModel();
		
		$data['objDocumento'] = $documentos->getDocumento($array["id_documento"]);
		$data['datosDocumento'] = $documentos->getDatoDocumento($array["id_documento"]);
		$data['coleccion_mandantes'] = $mandantes->getListaMandantes("","","",0);
		$data['coleccion_deudores'] = $deudores->getListaDeudores("","","","","",0);
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
		//$data['coleccion_mandantes'] = $documentos->getListaMandantes("");
		//$data['coleccion_deudores'] = $documentos->getListaDeudores("");
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
//		$listadocs = new DocumentosModel();
		
		$docLista = $documentos->bajaDocumentos($array["id_documento"]);

		$listadocs = $documentos->getListaDocumentos2($array);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDatosDocumentos'] = $listadocs;
		
		$this->view->show("lista_documentos.php", $data);
	} 

	public function listarNuevos($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();

		$array["id_partida"] = 0;
		
		//$dato = $documentos->getListaDocumentos("",$array["ident"],$array);
		//$datoTmp = &$dato->items[($dato->get_count()-1)];
		
		$datoDoc = $documentos->getDatoDeudor($array["iddeudor"],$array);
		//echo("<br>cant: ".$datoDoc->get_count());
		if($datoDoc->get_count() > 0)
		{
			$datoTmp = &$datoDoc->items[($datoDoc->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_documento");
		}
		else
		{
			$array["id_partida"] = 0;
		}
		$datoAux = $documentos->getDatoDeudor($array["iddeudor"],$array);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		//$data['colleccionDocumentos'] = $dato;
		$data['colleccionDatosDocumentos'] = $datoDoc;
		$data['cant_mas'] = $datoAux->get_count();
		$data['pantalla'] = "alta";
		$this->view->show("lista_documentos.php", $data);	
	}  
	
	public function listar_mas_registros($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
//		$dato = $documentos->getListaDocumentos("","",$array);
		$dato = $documentos->getListaDocumentos2($array);
		$id_cab = $array["id_partida"];
		if($dato->get_count() > 0)
		{
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		$array["id_partida"] = $datoTmp->get_data("id_documento");
//		$datoAux = $documentos->getListaDocumentos("","",$array);
		$datoAux = $documentos->getListaDocumentos2($array);
		$html = "<table width='1073' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		$html .= "<tr class='' id='cabecera_pag_".$id_cab."' >";
		$html .= "<th align='center' width='3' height='0'></th>";
		$html .= "<th align='center' width='150'><font class='titulolistado'>CORRELATIVO</font></th>";
        $html .= "<th align='center' width='100'><font class='titulolistado'>DEUDOR</font></th>";
		$html .= "<th align='center' width='100'><font class='titulolistado'>MANDANTE</font></th>";
        $html .= "<th align='center' width='100'><font class='titulolistado'>F. PROTESTO</font></th>";
		$html .= "<th align='center' width='100'><font class='titulolistado'>ESTADO</font></th>";
        $html .= "<th align='center' width='100'><font class='titulolistado'>NRO. DOC.</font></th>";
        $html .= "<th align='center' width='90'><font class='titulolistado'>TIPO DOC.</font></th>";
		$html .= "<th align='center' width='80'><font class='titulolistado'>MONTO</font></th>";
        $html .= "<th align='center' width='90'><font class='titulolistado'>BANCO</font></th>";
        $html .= "<th align='center' width='90'><font class='titulolistado'>CTA. CTE.</font></th>";
        $html .= "<th align='center' width='70'><font class='titulolistado'>VENCE</font></th>";
    	$html .= "</tr>";
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td  width='3'>";
			$html .= "<input type='radio' id='".$datoTmp->get_data("id_documento")."' name='checktipdoc' value='' onclick='seleccionado(".$datoTmp->get_data("id_documento").")'>";
			$html .= "</td>";
			$html .= "<td align='left' width='150' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("id_documento"))."</td>";
			$html .= "<td align='left' width='100' class='dato_lista'>&nbsp;&nbsp;".strtoupper(utf8_decode($datoTmp->get_data("ape1_deudor")." ".$datoTmp->get_data("ape2_deudor")." ".$datoTmp->get_data("nom1_deudor")))."</td>";
			$html .= "<td align='left' width='100' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("nombre_mandante"))."</td>";
			$html .= "<td align='left' width='100' class='dato_lista'>&nbsp;&nbsp;".strtoupper(formatoFecha($datoTmp->get_data("fecha_protesto"),"dd-mm-yyyy","dd/mm/yyyy"))."</td>";
			$html .= "<td align='left' width='100' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("id_estado_doc"))."</td>";
			$html .= "<td align='left' width='100' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("numero_documento"))."</td>";
			$html .= "<td align='left' width='90' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("id_tipo_doc"))."</td>";
			$html .= "<td align='left' width='80' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("monto"))."</td>";
			$html .= "<td align='left' width='90' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("id_banco"))."</td>";
			$html .= "<td align='left' width='90' class='dato_lista'>&nbsp;&nbsp;".strtoupper($datoTmp->get_data("cta_cte"))."</td>";
			$html .= "<td align='left' width='70' class='dato_lista'>&nbsp;&nbsp;".strtoupper(formatoFecha($datoTmp->get_data("fecha_recibido"),"yyyy-mm-dd","dd/mm/yyyy"))."</td>";
			$html .= "</tr>";
    		$html .= "<tr bgcolor='#FFFFFF'>";
			$html .= "<td colspan='12' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
			$html .= "</tr>";
		
		}
		
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		
		if($datoAux->get_count() > 0)
		{
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='12' align='center'>";
        	$html .= "<div id='btnvermas_".$datoTmp->get_data("id_documento")."' onclick='verMasRegistros(".$datoTmp->get_data("id_documento").")' style='cursor:pointer;'>Ver mas </div>";
			$html .= "</td>";
			$html .= "</tr>";
	    }
	    $html .= "</table>";
		$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_documento")."' style='display:none;'>";
	    $html .= "</div>";
		
		echo($html);
		
		}
	}
	

	public function listar($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		//$dato = $documentos->getListaDocumentos("","",$array);
		$dato = $documentos->getListaDocumentos2($array);
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_documento");
			$datoAux = $documentos->getListaDocumentos("","",$array);
			$cant_datos = $datoAux->get_count();
		}
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDatosDocumentos'] = $dato;
		$data['cant_mas'] = $cant_datos;
		$data['rutDeudor'] = $array["rutDeudor"];
		
		$this->view->show("lista_documentos.php", $data);
	}    
	
	public function listarDocDeudor($array)
	{
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentos("",$array["idd"],$array);
	
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_documento");
			$datoAux = $documentos->getListaDocumentos("","",$array);
			$cant_datos = $datoAux->get_count();
		}
	
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDatosDocumentos'] = $dato;
		$data['cant_mas'] = $cant_datos = 0;
	
		$this->view->show("lista_documentos.php", $data);
	}
	
	
	public function listarcartas($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocumentosCartas($array);
		
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
		$docCartas = new DocumentosModel();
		

		$listaIdDocs = " ( ";
		for ($i = 1; $i <= count($array); $i++) {
			//cambia estado de los documentos a carta enviada
			$datotmp = $documentos->generarCarta($array["arr".$i]);
			
    		//genera lista de Ids para generar cartas
    		$listaIdDocs = $listaIdDocs . $array["arr".$i];
			$x = $i + 1;
    		if($array["arr".$x] != ""){
    			$listaIdDocs = $listaIdDocs . ",";
    		}
		}
		$listaIdDocs =  $listaIdDocs . $array["arr".$i]. " ) ";
		$docCartas = new DocumentosModel();
		$listaDoc = $docCartas->getDocEnviar($listaIdDocs);
		
			$data['nom_sistema'] = "SISTEMA DyV";
			$data['accion_form'] = "";
			$data['colleccionDocumentos'] = $listaDoc;
			$this->view->show("carta_pdf.php", $data);

		//refresca la pagina
		$dato = $documentos->getListaDocumentosCartas("");		
		$data['colleccionCartasDocumentos'] = $dato;
		$data['iddocumento'] = $iddoc;
		
		$this->view->show("lista_cartas_documentos.php", $data);	
	}
	
	
	public function generarCartaPdf($array)
    {
		require 'models/InformesModel.php';
				
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("carta_pdf.php", $data);
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
	
	public function get_datos_banco($array)
	{
		require 'models/DocumentosModel.php';
		$doc = new DocumentosModel();
		
		$banco = $doc->getBancoDocumento($array);
				
		if(!is_null($banco))
		{
			echo($banco->get_data("banco"));
		}
		else
		{
			echo("");
		}
	}
	
	
}
?>