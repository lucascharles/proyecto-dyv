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
		require 'models/DeudoresModel.php';
		require 'models/MandantesModel.php';
		
		$gestiones = new GestionesModel();
		$estges = new DocumentosModel();
		$deudor = new DeudoresModel();
		$mandantes = new MandantesModel();
		
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
		
		$MandantesXDeudor = $mandantes->getMandanteDeudor($iddeudor);
		$cantDemandas = $deudor->getCantFicha($iddeudor);
		
		
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
		$data['tipoGestion'] = $array["tipoGestion"];
		$data['cantidadDemandas'] = $cantDemandas;
		$data['coleccionMandantesDeudor'] = $MandantesXDeudor;
		
		
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
		

		if($array["tipoGestion"] == "D")
		{
			$dato = $gestiones->getListaGestionesDia($array["des_int"]);			
		}
		else
		{
			$dato = $gestiones->getListaGestiones($array["des_int"]);
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
		if($array["tipoGestion"]=="D")
		{
			$dato = $gestiones->getListaGestionesDia($array["des_int"],$array);	
		}
		else
		{
			$dato = $gestiones->getListaGestiones($array["des_int"],$array);
		}
		$cant_datos = 0;
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_gestion");
			
			if($array["tipoGestion"]=="D")
			{
				$datoAux = $gestiones->getListaGestionesDia($array["des_int"],$array);	
			}
			else
			{
				$datoAux = $gestiones->getListaGestiones($array["des_int"],$array);
			}

			$cant_datos = $datoAux->get_count();
		}
		
		

		$data['cant_mas'] = $cant_datos;
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionGestiones'] = $dato;
		
		$this->view->show("lista_gestiones.php", $data);
	} 
	
	
	public function listar_mas_registros($array)
    {
		require 'models/GestionesModel.php';
		$gestiones = new GestionesModel();
		if($array["tipoGestion"]=="D")
		{
			$dato = $gestiones->getListaGestionesDia($array["des_int"],$array);	
		}
		else
		{
			$dato = $gestiones->getListaGestiones($array["des_int"],$array);
		}
		
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$array["id_partida"] = $datoTmp->get_data("id_gestion");
			if($array["tipoGestion"]=="D")
			{
				$datoAux = $gestiones->getListaGestionesDia($array["des_int"],$array);	
			}
			else
			{
				$datoAux = $gestiones->getListaGestiones($array["des_int"],$array);
			}
		}
		
		$html = "<table width='100%' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td width='1%' align='center' height='25'><input type='radio' id='".$datoTmp->get_data("id_gestion")."' name='checktipdoc' value='' onclick='seleccionado(".$datoTmp->get_data("id_gestion").")'></td>";
        	$html .= "<td width='8%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")."</td>";
			$html .= "<td width='8%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")."</td>";
			$html .= "<td width='10%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("primer_apellido")."</td>";
        	$html .= "<td width='10%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("segundo_apellido")."</td>";
        	$html .= "<td width='10%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("primer_nombre")."</td>";
			$html .= "<td width='10%' align='left' class='dato_lista'>&nbsp;&nbsp;".$datoTmp->get_data("segundo_nombre")."</td>";
			$html .= "<td width='10%' align='left' class='dato_lista'>&nbsp;&nbsp;".formatoFecha($datoTmp->get_data("fecha_prox_gestion"),"yyyy-mm-dd","dd/mm/yyyy")."</td>";
			if(trim($datoTmp->get_data("estado"))<>"")
			{
			 $valor = $datoTmp->get_data("estado");
			}
			else
			{
			$valor = "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$html .= "<td width='23%' align='left' class='dato_lista'>&nbsp;&nbsp;".$valor
			."</td>";
			$html .= "</tr>";
			$html .= "<tr bgcolor='#FFFFFF'>";
    		$html .= "<td colspan='10' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
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
    		$html .= "<td colspan='10' align='center'>";
        	$html .= "<div id='btnvermas_".$datoTmp->get_data("id_gestion")."' onclick='verMasRegistros(".$datoTmp->get_data("id_gestion").")' style='cursor:pointer;'>Ver mas </div>";
			$html .= "</td>";
			$html .= "</tr>";
	    }
		
		if($cant_datos > 0)
		{
	    	$html .= "</table>";
			$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_gestion")."' style='display:none;'>";
		    $html .= "</div>";
		}
		
		echo($html);
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
	
	public function listarDocumentoMandante($array)
    {
		require 'models/DocumentosModel.php';
		$documentos = new DocumentosModel();
			
		$dato = $documentos->getListaDocMandanteDeudor($array["iddeudor"],$array["idmandante"]);
		
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
	
	public function gestiona_liquidacion($array)
	{
		require 'models/DeudoresModel.php';
		$deudor = new DeudoresModel();
		$dato = $deudor->getDeudorDatos($array["iddeudor"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['deudor'] = $dato;
		$data['control_volver'] = $array["control_volver"];
		$data['accion_volver'] = $array["accion_volver"];
		$data['param_volver'] = $array["param_volver"];
		$data['val_volver'] = $array["val_volver"];
	
		
		$this->view->show("gestiona_liquidaciones.php", $data);
	}
}
?>