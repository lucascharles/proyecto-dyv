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
		$data['ident'] = $array["id"];
		$data['tipoperacion'] = $array["tipope"];
		$data['coleccion_juzgado'] = $juzgado->getListaJuzgados();
		$data['coleccion_jcomuna'] = $jcomuna->getListaJuzgadosComuna();
		
		if($array["tipope"] == "M")
		{
			$datodeudor = $deudor->getDeudorFicha($array["id"]);
			$data['ficha'] = $deudor->getDatosFicha($array["id"]);		
		}	
		
		if($array["tipope"] == "A")
		{
			$datodeudor = $deudor->getDeudorDatos($array["id"]);	
		}	
		
		$datomandante = $mandate->getMandanteDatos($datodeudor->get_data("id_mandante"));

		$datodocumento = $documentos->getDatoDocumento($array["id_doc"]);
		
		$datodir = $direcciones->getDirActualDeudor($datodeudor->get_data("id_deudor"));
		
		$data['deudor'] = $datodeudor;
		$data['mandante'] = $datomandante;
		$data['documento'] = $datodocumento;
		$data['direccion'] = $datodir;
		
		$this->view->show("deudor_ficha.php", $data);
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
		//echo("cant: ".$dato->get_count());
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		$datoAux = $deudor->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"],$datoTmp->get_data("id_deudor"));
		
		
		$html = "<table width='100%' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td width='3%' align='center' height='25'><input type='radio' id='".$datoTmp->get_data("id_deudor")."' name='checktipdoc' value='' onclick='seleccionado(".$datoTmp->get_data("id_deudor").")'></td>";
        	$html .= "<td width='17%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("rut_deudor")."</td>";
			$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("primer_apellido")."</td>";
			$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("segundo_apellido")."</td>";
        	$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("primer_nombre")."</td>";
        	$html .= "<td width='20%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("segundo_nombre")."</td>";
			$html .= "</tr>";
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='6' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
			$html .= "</tr>";
		}
		
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		
		if($datoAux->get_count() > 0)
		{
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='6' align='center'>";
        	$html .= "<div id='btnvermas_".$datoTmp->get_data("id_deudor")."' onclick='verMasRegistros(".$datoTmp->get_data("id_deudor").")' style='cursor:pointer;'>Ver mas </div>";
			$html .= "</td>";
			$html .= "</tr>";
	    }
	    $html .= "</table>";
		$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_deudor")."' style='display:none;'>";
	    $html .= "</div>";
		
		echo($html);
	}
	
	public function listar($array)
    {
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"],$array["id_partida"]);	
		$datoTmp = &$dato->items[($dato->get_count()-1)];
		$datoAux = $deudor->getListaDeudores($array["rut"],$array["p_ape"],$array["s_ape"],$array["p_nom"],$array["s_nom"],$datoTmp->get_data("id_deudor"));
			
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionDeudores'] = $dato;
		$data['cant_mas'] = $datoAux->get_count();
		
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
	
	public function admin_fichas($array)
    {

		
		$data['nom_sistema'] = "SISTEMA DyV";
		
    	
		$this->view->show("admin_fichas.php", $data);
	}
	
	public function listar_fichas($array)
	{
    	require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getTodasFichas($array["rutdeudor"]);
				
		$data['objTodasFichas'] = $dato;

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
}
?>