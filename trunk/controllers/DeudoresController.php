<?php
class DeudoresController extends ControllerBase
{

	public function recolectarBasura($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		
		$deudor->recolectarBasuraFichas();
	}
	
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
			$dato = $documentos->getListaDocumentos("",$array["ident"],$array);
		}
		
		if($array["tipoperacion"] == "M")
		{
			$datodeudor = $deudor->getDeudorFicha($array["ident"]);	
			$dato = $documentos->getListaDocumentos("",$datodeudor->get_data("id_deudor"),$array);
		}
		
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			if($array["tipoperacion"] == "A")
			{
				$iddeudor = $array["ident"];
			}
			
			if($array["tipoperacion"] == "M")
			{
				$iddeudor = $datodeudor->get_data("id_deudor");
			}
			
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_documento");
			$datoAux = $documentos->getListaDocumentos("",$iddeudor,$array);	
			$cant_datos = $datoAux->get_count();
		}
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDoc'] = $dato;
		$data['cant_mas'] = $cant_datos;
		
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
			$data['receptor'] = $datorecep;
			$idrecp = $datorecep->get_data("id_receptor");
		}
		

		if($array["tipoperacion"] == "A")
		{
			if($array["id_alta"] > 0)
			{
				$datorecep = $deudor->getReceptor($array["id_alta"]);
				$data['receptor'] = $datorecep;
				$idrecp = $datorecep->get_data("id_receptor");
			}
		}
						
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['tipoperacion'] = $array["tipoperacion"];
		$data['ident'] = $array["ident"];
		$data['id_alta'] = $array["id_alta"];
		
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
			$datomart = $deudor->getMartillero($array["ident"]);
			$data['martillero'] = $datomart;
			$idmart = $datomart->get_data("id_martillero");
		}
		
		if($array["tipoperacion"] == "A")
		{
			if($array["id_alta"] > 0)
			{
				$datomart = $deudor->getMartillero($array["id_alta"]);
				$data['martillero'] = $datomart;
				$idmart = $datomart->get_data("id_martillero");
			}
		}
						
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['tipoperacion'] = $array["tipoperacion"];
		$data['ident'] = $array["ident"];
		$data['id_alta'] = $array["id_alta"];
		
		$data['colGastosMartillero'] = $deudor->getGastosMartillero($idmart);
						
		$this->view->show("deudor_ficha_martillero.php", $data);
	}
	
	public function ficha_consignacion($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$idconsig = 0;
		
		if($array["tipoperacion"] == "M")
		{
			$datoconsig = $deudor->getConsignacion($array["ident"]);
			$data['consignacion'] = $datoconsig;
			$idconsig = $datoconsig->get_data("id_consignacion");
		}
		
		if($array["tipoperacion"] == "A")
		{
			if($array["id_alta"] > 0)
			{
				$datoconsig = $deudor->getConsignacion($array["id_alta"]);
				$data['consignacion'] = $datoconsig;
				$idconsig = $datoconsig->get_data("id_consignacion");
			}
		}
						
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['tipoperacion'] = $array["tipoperacion"];
		$data['ident'] = $array["ident"];
		$data['id_alta'] = $array["id_alta"];
		
		$data['colGastosConsignacion'] = $deudor->getGastosConsignacion($idconsig);
									
		$this->view->show("deudor_ficha_consignacion.php", $data);
	}
	
	public function ficha_gastos($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$idficha = $array["id_alta"];
		
		if($array["tipoperacion"] == "M")
		{
			$datorecep = $deudor->getReceptor($array["ident"]);
			$data['receptor'] = $datorecep;
		}
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colGastosGastos'] = $deudor->getGastosGastos($idficha);
		
				
		$this->view->show("deudor_ficha_gastos.php", $data);
	}
	
	public function deudor_ficha($array)
    {
		require 'models/DeudoresModel.php';
		require 'models/MandantesModel.php';
		require 'models/JuzgadoModel.php';
		require 'models/JuzgadoComunaModel.php';
		require 'models/DocumentosModel.php';
		require 'models/DireccionDeudoresModel.php';
		
		$deudor = new DeudoresModel();
		$mandate = new MandantesModel();
		$juzgado = new JuzgadoModel();
		$jcomuna = new JuzgadoComunaModel();
		$documentos = new DocumentosModel();
		$direcciones = new DireccionDeudoresModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		
		$data['tipoperacion'] = $array["tipope"];
		$data['coleccion_juzgado'] = $juzgado->getListaJuzgados();
		$data['coleccion_jcomuna'] = $jcomuna->getListaJuzgadosComuna();
		
		$datodeudor = $deudor->getDeudorFicha($array["id"]);
		if($array["tipope"] == "M")
		{
			$data['ficha'] = $deudor->getDatosFicha($array["id"]);
			$data['nro'] = $array["id"];		
		}	
		
		if($array["tipope"] == "A")
		{
			$datodeudor = $deudor->getDeudorDatos($array["id"]);
			$data['nro'] = "";
		}	
		
		$datomandante = $mandate->getMandanteDatos($datodeudor->get_data("id_mandante"));

		$datodocumento = $documentos->getDatoDocumento($array["id_doc"]);
		
		$datodir = $direcciones->getDirActualDeudor($datodeudor->get_data("id_deudor"));

		$data['ident'] = $array["id"];
		$data['deudor'] = $datodeudor;
		$data['mandante'] = $datomandante;
		$data['documento'] = $datodocumento;
		$data['direccion'] = $datodir;
		$data['idGes'] = $array["idGes"];
		$data['idestadoges'] = $array["idestadoges"];
		if($array["idGes"]==""){
			$data['origen'] = "admin_fichas";
		}
		else
		{
			$data['origen'] = "gestiones";
		}
		
		$this->view->show("deudor_ficha.php", $data);
	}
	
	public function ficha_ddaejecutiva($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$iddemanda = 0;
		
		if($array["tipoperacion"] == "M")
		{
			$datodemanda = $deudor->getDdaEjecutiva($array["ident"]);
			$data['demandaejec'] = $datodemanda;
			$iddemanda = $datodemanda->get_data("id_dda_ejecutiva");
		}
		
		if($array["tipoperacion"] == "A")
		{
			if($array["id_alta"] > 0)
			{
				$datodemanda = $deudor->getDdaEjecutiva($array["id_alta"]);
				$data['demandaejec'] = $datodemanda;
				$iddemanda = $datodemanda->get_data("id_dda_ejecutiva");
			}
		}
						
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['tipoperacion'] = $array["tipoperacion"];
		$data['ident'] = $array["ident"];
		$data['id_alta'] = $array["id_alta"];
		$data['nomreceptor'] = $datodemanda->get_data("nombre_receptor");
		$data['emailreceptor'] = $datodemanda->get_data("email_receptor");
		$data['fonoreceptor'] = $datodemanda->get_data("fono_receptor");
		$data['certificado'] = (trim($datodemanda->get_data("certificado")) <> "0000-00-00") ? $datodemanda->get_data("certificado") : "";
		$data['ddaejec'] = (trim($datodemanda->get_data("dda_ejecutiva")) <> "0000-00-00") ? $datodemanda->get_data("dda_ejecutiva") : "";
		$data['mandamiento'] = (trim($datodemanda->get_data("mandamiento")) <> "0000-00-00") ? $datodemanda->get_data("mandamiento") : "";
		$data['encargado'] = (trim($datodemanda->get_data("encargado_receptor")) <> "0000-00-00") ? $datodemanda->get_data("encargado_receptor") : "";
		$data['busqueda'] = (trim($datodemanda->get_data("fecha_busqueda")) <> "0000-00-00") ? $datodemanda->get_data("fecha_busqueda") : "";
		$data['notificacion'] = (trim($datodemanda->get_data("notificacion")) <> "0000-00-00") ? $datodemanda->get_data("notificacion") : "";
		$data['gasto'] = (trim($datodemanda->get_data("gasto")) <> "0000-00-00") ? $datodemanda->get_data("gasto") : "";
								
		$this->view->show("deudor_ficha_ddaejec.php", $data);
	}
	
	public function grabarReceptorA($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		
		$id = $deudor->altaReceptorFicha($array);
		
		echo($id);
	}
	
	public function editarReceptor($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		
		$id = $deudor->altaReceptorFicha($array);
		
		echo($id);
	}
	
	public function grabarReceptorM($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		if($array["tipoperacion"] == "A")
		{
			$id = $deudor->altaReceptorFicha($array);
					
			echo($id);
		}
	}
	
	public function grabarConsignacionA($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		if($array["tipoperacion"] == "A")
		{
			$id = $deudor->altaConsignacionFicha($array);
					
			echo($id);
		}
	}
	
	public function editarConsignacion($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		$id = $deudor->altaConsignacionFicha($array);
		
		echo($id);
	}
	
	public function grabarConsignacionM($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		if($array["tipoperacion"] == "A")
		{
			$id = $deudor->altaConsignacionFicha($array);
					
			echo($id);
		}
	}
	
	public function grabarfichadeudor($array)
	{
		if($array["tipoperacion"] == "A")
		{
			require 'models/DeudoresModel.php';
			$deudor = new DeudoresModel();
			
			$id = $deudor->altaFicha($array);
			
			echo($id);
		}
	}
	
	public function modificarfichadeudor($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		
		$id = $deudor->altaFicha($array);
		
		echo($id);
	}
	
	public function grabarMartilleroA($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		if($array["tipoperacion"] == "A")
		{
			$id = $deudor->altaMartilleroFicha($array);
					
			echo($id);
		}
	}
	
	public function editarMartillero($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		
		$id = $deudor->altaMartilleroFicha($array);
					
		echo($id);
	}
	
	public function grabarMartilleroM($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		if($array["tipoperacion"] == "A")
		{
			$id = $deudor->altaMartilleroFicha($array);
					
			echo($id);
		}
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
	
	public function listar_mas_registros($array)
    {
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"],$array["id_partida"]);	
		
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$datoAux = $deudor->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"],$datoTmp->get_data("id_deudor"));
		}
		
		
		$html = "<table width='100%' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td width='3%' align='center' height='25'><input type='radio' id='".$datoTmp->get_data("id_deudor")."' name='checktipdoc' value='' onclick='seleccionado(".$datoTmp->get_data("id_deudor").")'></td>";
        	$html .= "<td width='17%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("rut_deudor")."</td>";
        	$html .= "<td width='17%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("razonsocial")."</td>";
			$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("primer_apellido")."</td>";
			$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("segundo_apellido")."</td>";
        	$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("primer_nombre")."</td>";
        	$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("segundo_nombre")."</td>";
			$html .= "</tr>";
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='6' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
			$html .= "</tr>";
		}
		
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$cant_datos = $datoAux->get_count();
		}
		
		if($cant_datos > 0)
		{
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='6' align='center'>";
        	$html .= "<div id='btnvermas_".$datoTmp->get_data("id_deudor")."' onclick='verMasRegistros(".$datoTmp->get_data("id_deudor").")' style='cursor:pointer;'>Ver mas </div>";
			$html .= "</td>";
			$html .= "</tr>";
	    }
		
		if($cant_datos > 0)
		{
	    	$html .= "</table>";
			$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_deudor")."' style='display:none;'>";
		    $html .= "</div>";
		}
		
		echo($html);
	}
	
	
	
	public function listar($array)
    {
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"],$array["id_partida"]);	
		
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$datoAux = $deudor->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"],$datoTmp->get_data("id_deudor"));	
			$cant_datos = $datoAux->get_count();
		}

			
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDeudores'] = $dato;
		$data['cant_mas'] = $cant_datos;
		
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
		require 'models/DocumentosModel.php';
    	require 'models/DireccionDeudoresModel.php';
		$dir = new DireccionDeudoresModel();
		$dato = $dir->getListaDireccionesTmp(session_id());	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDeudores'] = $dato;
		
		if($array["generacarta"] == "S")		
		{
			$documentos = new DocumentosModel;
			$listaDoc = $documentos->getDocEnviarDeudor($array["iddeudor"]);
			/*
			$listaIdDocs = " ( ";
			for($i=0; $i<$listaDoc->get_count(); $i++) 
	  			{
	  				$deudorTmp = &$listaDoc->items[$i];
    				$listaIdDocs = $listaIdDocs . $deudorTmp->get_data("id_deudor") .",";
    			}
    		$listaIdDocs = $listaIdDocs . " 0) ";
		
    		$docCartas = new DocumentosModel();
			$listaDocumentosDeudor = $docCartas->getDocEnviar($listaIdDocs);
    		*/
			$data['nom_sistema'] = "SISTEMA DyV";
			$data['accion_form'] = "";
			$data['colleccionDocumentos'] = $listaDoc;// $listaDocumentosDeudor;
			$this->view->show("carta_pdf.php", $data);
		}
		
		$this->view->show("lista_direcciones.php", $data);
	}   
	
	public function alta($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$data["origen_l"] = $array["origen_l"];
		
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
		$data['control_volver'] = $array["control_volver"];
		$data['accion_volver'] = $array["accion_volver"];
		$data['param_volver'] = $array["param_volver"];
		$data['val_volver'] = $array["val_volver"];
		$data['estadoGes'] = $array["estadoGes"];
		
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
	
	public function admin_fichas($array)
    {

		
		$data['nom_sistema'] = "SISTEMA DyV";
		
    	
		$this->view->show("admin_fichas.php", $data);
	}
	                
	public function listar_mas_registros_fichas($array)
    {
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getTodasFichas($array);
		
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_ficha");
			$datoAux = $deudor->getTodasFichas($array);
		}
		
		$html = "<table width='100%' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td width='1%' align='center' height='25'><input type='radio' id='".$datoTmp->get_data("id_ficha")."' name='checktipdoc' value='' onclick='seleccionado(".$datoTmp->get_data("id_ficha").")'></td>";
        	$html .= "<td width='9%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_ficha")."</td>";
			$html .= "<td width='12%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")."</td>";
			$html .= "<td width='28%' align='left' class='dato_lista'>&nbsp;&nbsp;".utf8_decode($datoTmp->get_data("d_primer_apellido")." ".$datoTmp->get_data("d_segundo_apellido")." ".$datoTmp->get_data("d_primer_nombre")." ".$datoTmp->get_data("d_segundo_nombre"))."</td>";
        	$html .= "<td width='14%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")."</td>";
        	$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("nombre")."</td>";
			$html .= "<td width='16%' align='left' class='dato_lista'>&nbsp;&nbsp;".formatoFecha($datoTmp->get_data("ingreso"),"yyyy-mm-dd","dd/mm/yyyy")."</td>";
			$html .= "</tr>";
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='7' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
			$html .= "</tr>";
		}
		
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$cant_datos = $datoAux->get_count();
		}
		
		if($cant_datos > 0)
		{
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='6' align='center'>";
        	$html .= "<div id='btnvermas_".$datoTmp->get_data("id_ficha")."' onclick='verMasRegistros(".$datoTmp->get_data("id_ficha").")' style='cursor:pointer;'>Ver mas </div>";
			$html .= "</td>";
			$html .= "</tr>";
	    }
		
		if($cant_datos > 0)
		{
	    	$html .= "</table>";
			$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_ficha")."' style='display:none;'>";
		    $html .= "</div>";
		}
		
		echo($html);
	}
	
	public function listar_fichas($array)
	{
    	require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getTodasFichas($array);
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_ficha");
			$datoAux = $deudor->getTodasFichas($array);
			$cant_datos = $datoAux->get_count();
		}
		$data['objTodasFichas'] = $dato;
		$data['cant_mas'] = $cant_datos;

		$this->view->show("lista_fichas.php", $data);
	}
	
	public function editar_ficha($array)
    {
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getDeudor($array["iddeudor"], session_id());
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['objDeudor'] = $dato;
		
		
		$this->view->show("edita_deudores.php", $data);
    }
	
	public function validarrut($array)
    {
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$resp = $deudor->valRutDeudor($array);
		
		echo($resp);
    }
	
	public function getDatosDeudor($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$arrayr = array();
		
		$dato = $deudor->getDeudorDatos($array["id_deudor"]);
		$arrayr[] = $dato->get_data("rut_deudor");
		$arrayr[] = $dato->get_data("dv_deudor");
		$arrayr[] = $dato->get_data("primer_apellido");
		$arrayr[] = $dato->get_data("segundo_apellido");
		$arrayr[] = $dato->get_data("primer_nombre");
		$arrayr[] = $dato->get_data("segundo_nombre");
				
		echo(json_encode($arrayr));		
	}
	
	public function listar_mas_fichadoc($array)
    {
		require 'models/DocumentosModel.php';
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$documentos = new DocumentosModel();
		
		if($array["tipoperacion"] == "A")
		{
			$dato = $documentos->getListaDocumentos("",$array["ident"],$array);
		}
		
		if($array["tipoperacion"] == "M")
		{
			$datodeudor = $deudor->getDeudorFicha($array["ident"]);	
			$dato = $documentos->getListaDocumentos("",$datodeudor->get_data("id_deudor"),$array);
		}
		
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			if($array["tipoperacion"] == "A")
			{
				$iddeudor = $array["ident"];
			}
			
			if($array["tipoperacion"] == "M")
			{
				$iddeudor = $datodeudor->get_data("id_deudor");
			}
			
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_documento");
			$datoAux = $documentos->getListaDocumentos("",$iddeudor,$array);	
			$cant_datos = $datoAux->get_count();
		}
		
		$html = "<table width='100%' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
			$html .= "	<td width='2%'></td>";		
			$html .= "	<td align='left' width='17%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_documento")."</td>";
			$html .= "	<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("ape1_deudor")." ".$datoTmp->get_data("ape2_deudor").$datoTmp->get_data("nom1_deudor")."</td>";
			$html .= "	<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("nombre_mandante")."</td>";
			$html .= "	<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".formatoFecha($datoTmp->get_data("fecha_siniestro"),"dd-mm-yyyy","dd/mm/yyyy")."</td>";
			$html .= "	<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_estado_doc")."</td>";
			$html .= "	<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("numero_documento")."</td>";
			$html .= "	<td align='left' width='8%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_tipo_doc")."</td>";
			$html .= "	<td align='left' width='5%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("monto")."</td>";
			$html .= "	<td align='left' width='10%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("id_banco")."</td>";
			$html .= "	<td align='left' width='8%' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("cta_cte")."</td>";
			$html .= "</tr>";
            $html .= "<tr bgcolor='#FFFFFF'>";
            $html .= "  <td colspan='11' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
            $html .= "</tr>";
		}
	
		if($cant_datos > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
		}
		
		if($cant_datos > 0)
		{
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='11' align='center'>";
        	$html .= "<div id='btnvermas_".$datoTmp->get_data("id_documento")."' onclick='verMasRegistros(".$datoTmp->get_data("id_documento").")' style='cursor:pointer;'>Ver mas </div>";
			$html .= "</td>";
			$html .= "</tr>";
	    }
		
		if($cant_datos > 0)
		{
	    	$html .= "</table>";
			$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_documento")."' style='display:none;'>";
		    $html .= "</div>";
		}
		
		echo($html);
	}
	
	public function buscar_total($array)
    {
		require 'models/DocumentosModel.php';
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$documentos = new DocumentosModel();
		
		if($array["tipoperacion"] == "A")
		{
			$dato = $documentos->getTotalMontoDoc($array["ident"]);
		}
		
		if($array["tipoperacion"] == "M")
		{
			$datodeudor = $deudor->getDeudorFicha($array["ident"]);	
			$dato = $documentos->getTotalMontoDoc($datodeudor->get_data("id_deudor"));
		}
		
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		$imp_total = $datoTmp->get_data("monto");
		echo($imp_total);
	}
	
	public function admin_liquidaciones($array)
    {
		require 'models/DeudoresModel.php';
		
    	$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		if($array["iddeudor"] != "")
		{
			$id = $array["iddeudor"];
			$deudor = new DeudoresModel();
			$data['deudor'] = $deudor->getDeudorDatos($id);
		}
		$this->view->show("admin_liquidaciones.php", $data);
	}
	
	public function listar_liquidaciones($array)
    {
		require 'models/LiquidacionesModel.php';
		$liquidaciones = new LiquidacionesModel();
		$dato = $liquidaciones->getLiquidacionesDeudor($array);
				
		$data['colleccionLiquidaciones'] = $dato;

		$this->view->show("lista_liquidaciones.php", $data);
	}
	
	public function nueva_liquidacion($array)
    {
		require 'models/DeudoresModel.php';
		require 'models/MandantesModel.php';
		require 'models/DocumentosModel.php';
		require 'models/ParametrosModel.php';
	
		$deudores = new DeudoresModel();
		$mandate = new MandantesModel();
		$documentos = new DocumentosModel();
		$parametros = new ParametrosModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['ident'] = $array["id"];
		$data['tipoperacion'] = $array["tipope"];
		$datodeudor = $deudores->getDeudorDatos($array["id"]);	
		
		$datomandante = $mandate->getMandanteDatos($datodeudor->get_data("id_mandante"));

		$datodocumento = $documentos->getDatoDocumento($array["id_doc"]);
		
		$data['iddeudor'] = $array["id"];
		$data['deudor'] = $datodeudor;
		$data['mandante'] = $datomandante;
		$data['documento'] = $datodocumento;
		$data['valoruf'] = $parametros->getParametro(array("nom_param"=>"valor_uf"));// 22700;  		//crear metodo en la base para este parametro
		$data['interes_base'] = $parametros->getParametro(array("nom_param"=>"interes_diario_normal")); //"2";    //crear metodo en la base para este parametro
		$data['interes_simulacion'] = $parametros->getParametro(array("nom_param"=>"interes_simulacion")); //"1.5";    //crear metodo en la base para este parametro	
		$data['cuotas_simulacion'] = $parametros->getParametro(array("nom_param"=>"cuotas_simulacion")); //"2";    //crear metodo en la base para este parametro
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( '+30 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'd/m/Y' , $nuevafecha );
		$data['fecha_pago'] = $nuevafecha ;
		
		
		$data['idestadoges'] = $array["idestadoges"];
		$data['control_volver'] = $array["control_volver"];
		$data['accion_volver'] = $array["accion_volver"];
		$data['param_volver'] = $array["param_volver"];
		$data['val_volver'] = $array["val_volver"];
		$this->view->show("deudor_liquidacion.php", $data);
	}
	
	public function edita_liquidacion($array)
    {
		require 'models/DeudoresModel.php';
		require 'models/MandantesModel.php';
		require 'models/DocumentosModel.php';
		require 'models/ParametrosModel.php';
		require 'models/LiquidacionesModel.php';
		
	
		$deudores = new DeudoresModel();
		$mandate = new MandantesModel();
		$documentos = new DocumentosModel();
		$parametros = new ParametrosModel();
		$liquidacion = new LiquidacionesModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		
		$data['tipoperacion'] = $array["tipope"];
		$data['liquidacion'] = $liquidacion->getLiquidacion($array["id"]);
		$array["id_liquidacion"] = $array["id"];
		$data['doc_simulacion'] = $deudores->getDocSimulacionLiquidacion($array);
		$datodeudor = $deudores->getDeudorDatos($data['liquidacion']->get_data("id_deudor"));	
		//$datomandante = $mandate->getMandanteDatos($data['liquidacion']->get_data("id_mandante"));

		//$datodocumento = $documentos->getDatoDocumento($array["id_doc"]);
			
		$data['deudor'] = $datodeudor;
		//$data['mandante'] = $datomandante;
		//$data['documento'] = $datodocumento;
		$data['valoruf'] = $parametros->getParametro("valor_uf");// 22700;  		//crear metodo en la base para este parametro
		$data['interes_base'] = $parametros->getParametro("interes_diario_normal"); //"2";    //crear metodo en la base para este parametro
		
		$data['control_volver'] = $array["control_volver"];
		$data['accion_volver'] = $array["accion_volver"];
		$data['param_volver'] = $array["param_volver"];
		$data['val_volver'] = $array["val_volver"];
				
		$this->view->show("deudor_liquidacion_edita.php", $data);
	}
	
	public function modifica_liquidacion($array)
    {
		require 'models/DeudoresModel.php';
		require 'models/MandantesModel.php';
		require 'models/DocumentosModel.php';
		require 'models/LiquidacionesModel.php';
		
		$deudores = new DeudoresModel();
		$mandate = new MandantesModel();
		$documentos = new DocumentosModel();
		$liquidaciones = new LiquidacionesModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
//		$data['ident'] = $array["id"];
//		$data['tipoperacion'] = $array["tipope"];

		$datodeudor = $deudores->getDeudorDatos($array["id"]);	
		$datoliquidacion = $liquidaciones->getLiquidacion($array["id"]);
		
		$datomandante = $mandate->getMandanteDatos($datodeudor->get_data("id_mandante"));

		$datodocumento = $documentos->getDatoDocumento($array["id_doc"]);
		
		$data['deudor'] = $datodeudor;
		$data['mandante'] = $datomandante;
		$data['documento'] = $datodocumento;
		$data['valoruf'] = 22700;  //crear metodo en la base para este parametro
		$data['interes_base'] = "1.5";  //crear metodo en la base para este parametro
		$data['liquidacion'] = datoliquidacion;		
		$this->view->show("deudor_liquidacion.php", $data);
	}
	
	
	public function liquidacion_simulacion($array) // ???
	{
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();

		$data['nom_sistema'] = "SISTEMA DyV";
		$data['iddeudor'] = $array["iddeudor"];
		
		$this->view->show("deudor_liquidacion_simulacion.php", $data);
	}
	
	public function liquidacion_documentos($array)
	{
		require 'models/DocumentosModel.php';
		require 'models/DeudoresModel.php';
		$documentos = new DocumentosModel();
		$deudores = new DeudoresModel();
	
		$dato = $documentos->getDocLiquidar($array["iddeudor"]);
		$dato_deu = $deudores->getDeudorDatos($array["iddeudor"]);
	
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDoc'] = $dato;
		$data['idddeudor'] = $array["iddeudor"];
		$data['idmandante'] = $dato_deu->get_data("id_mandante");
		if($array["id_liquidacion"] <> 0)
		{
			//$data['simulacion'] = $deudores->getSimulacionLiquidacion($array);
		
			$data['doc_simulacion'] = $deudores->getDocSimulacionLiquidacion($array);
		}
		else
		{
			$data['simulacion'] = null;
			$data['doc_simulacion'] = null;
		}
		
		$data['id_liquidacion'] = $array["id_liquidacion"];
		$this->view->show("deudor_liquidacion_documentos.php", $data);
	}
	
	public function liquidacion_carta($array)
	{
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();

		$dato = $documentos->getDocLiquidar($array["iddeudor"]);
		  
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDoc'] = $dato;
		$data['capital'] = $array["capital"];
		
		$this->view->show("deudor_liquidacion_carta.php", $data);
	}
	
	public function liquidacion_calculadora($array)
	{
		//require 'models/DocumentosModel.php';
		//$documentos = new DocumentosModel();

		//$dato = $documentos->getDocLiquidar($array["iddeudor"]);  
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDoc'] = $dato;
		
		$this->view->show("deudor_liquidacion_calculadora.php", $data);
	}
	
	public function calcular($array)
	{
		require 'models/LiquidacionesModel.php';
		$liqui = new LiquidacionesModel();

		$data['array_pagos'] = $liqui->getCalculoPrestamo($array);  
		
		$this->view->show("lista_liquidaciones_calculos.php", $data);
	}
	
	public function grabarSimulacion($array)
	{
		require 'models/DeudoresModel.php';
		
		$doc = new DeudoresModel();
		$array["id_usuario"] = $_SESSION["idusuario"];
		
		$id_liq = $doc->grabarSimulacionDeudor($array);
		
		echo($id_liq);
	}	
	
	public function grabarLiquidacion($array)
	{
		require 'models/DeudoresModel.php';
		
		$deudor = new DeudoresModel();
		$array["id_usuario"] = $_SESSION["idusuario"];
		$deudor->grabarLiquidacion($array);
	}	
	
	public function grabar_editaLiquidacion($array)
	{
		require 'models/DeudoresModel.php';
		
		$deudor = new DeudoresModel();
		$array["id_usuario"] = $_SESSION["idusuario"];
		$deudor->grabar_editaLiquidacion($array);
	}
	
	public function grabarDDaEjecA($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		if($array["tipoperacion"] == "A")
		{
			$id = $deudor->altaDdaEjecFicha($array);
				
			echo($id);
		}
	}
	
	public function editarDDaEjec($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		$id = $deudor->altaDdaEjecFicha($array);
	
		echo($id);
	}
	
	public function grabarDDaEjecM($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
			
		if($array["tipoperacion"] == "A")
		{
			$id = $deudor->altaDdaEjecFicha($array);
				
			echo($id);
		}
	}
	
}
?>