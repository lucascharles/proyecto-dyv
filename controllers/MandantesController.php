<?php
class MandantesController extends ControllerBase
{
    public function editarcontmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$con = new ContactoMandanteModel();
		$con->editarContactoTmp($array["idcon"], $array["contacto"],$array["email"],$array["celular"],$array["telefono"],$array["fax"],$array["observacion"], session_id());
	}
	
	public function getcontmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$con = new ContactoMandanteModel();
		$dato = $con->getContactoTmp($array["idcon"]);
		
		$arrayr = array();
		
		$arrayr[] = $dato->get_data("contacto");
		$arrayr[] = $dato->get_data("email");
		$arrayr[] = $dato->get_data("celular");
		$arrayr[] = $dato->get_data("telefono");
		$arrayr[] = $dato->get_data("fax");
		$arrayr[] = $dato->get_data("observacion");
		
		echo(json_encode($arrayr));		
	}
	
	public function borrartmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$dir = new ContactoMandanteModel();
		$dir->borrardirtmp(session_id());
	}
	
	public function grabarcontmp($array)
	{
		require 'models/ContactoMandanteModel.php';
		$con = new ContactoMandanteModel();
		$con->guardarContactoTmp($array["contacto"],$array["email"],$array["celular"],$array["telefono"],$array["fax"],$array["observacion"], session_id());
	}
	
	public function listar_contmp($array)
    {
		require 'models/ContactoMandanteModel.php';
		$cont = new ContactoMandanteModel();
		$dato = $cont->getListaContactosTmp(session_id());	
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionContactos'] = $dato;
		
		$this->view->show("lista_contactos.php", $data);
	}
	
    public function admin($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("admin_mandantes.php", $data);
	}

	public function grabaEditar($array)
	{
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		$array["session_id"] = session_id();
		$mandantes->editarMandantes($array);			
	}

	public function editar($array)
    {
		require 'models/BancosModel.php';
		require 'models/ModoPagoModel.php';
		require 'models/MandantesModel.php';
		
		$banco = new BancosModel();
		$mandantes = new MandantesModel();
		$modopago = new ModoPagoModel();
		$dato = $mandantes->getMandante($array["idmandantes"], session_id());
		$datomp = $mandantes->getMandanteModoPago($array["idmandantes"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['objMandantes'] = $dato;
		$data['objColMandMp'] = $datomp;
		$data['coleccion_bancos'] = $banco->getListaBancos("");
		$data['coleccion_modopago'] = $modopago->getListaModoPago("");
		
		
		$this->view->show("edita_mandantes.php", $data);
	}
	
	public function alta($array)
    {
		require 'models/BancosModel.php';
		require 'models/ModoPagoModel.php';
		$banco = new BancosModel();
		$modopago = new ModoPagoModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['coleccion_bancos'] = $banco->getListaBancos("");
		$data['coleccion_modopago'] = $modopago->getListaModoPago("");
		
		$this->view->show("alta_mandantes.php", $data);
	}

	public function grabar($array)
    {
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		$array["session_id"] = session_id();
		$mandantes->altaMandantes($array);	
	} 
	
	public function eliminar($array)
    {
	
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		$dato = $mandantes->bajaMandantes($array["idmandantes"]);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionMandantes'] = $dato;
		
		$this->view->show("lista_mandantes.php", $data);
	} 
	
	public function listar_mas_registros($array)
    {
		require 'models/MandantesModel.php';
		require 'models/BancosModel.php';
		$mandantes = new MandantesModel();
		$banco = new BancosModel();
		
		$datob = $banco->getListaBancos("");
		
		$dato = $mandantes->getListaMandantes($array["des_int"],$array["desApel1"],$array["desNomb1"],$array["id_partida"]);
		
		if($dato->get_count() > 0)
		{
			$datoTmp = &$dato->items[($dato->get_count()-1)];
			$datoAux = $mandantes->getListaMandantes($array["des_int"],$array["desApel1"],$array["desNomb1"],$datoTmp->get_data("id_mandante"));
		}
			
		$html = "<table width='100%' cellpadding='2' cellspacing='2' align='center' border='0' bgcolor='#FFFFFF'>";
		
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			
			$html .= "<tr bgcolor='#FFFFFF'>";
			$html .= "<td  class='dato_lista'  width='3%'>";
      
	        if($array["pantalla"] == "pdeudor")
	  		{
	  			$html .= "<input type='button' id='".$datoTmp->get_data("id_mandante")."' name='btnmandante' value='' onclick='selMandDeu(".$datoTmp->get_data("id_mandante").")'>";
        
	  		}
		 	else
	  		{
	  			if($array["pantalla"] == "pdeudor_s")
				{
	  				$html .= "<input type='button' id='".$datoTmp->get_data("id_mandante")."' name='btnmandante' value='' onclick='quitarMandDeu(".$datoTmp->get_data("id_mandante").")'>";
			  	}
				else
				{
					$html .= "<input type='radio' id='".$datoTmp->get_data("id_mandante")."' name='checktipdoc' value='' onclick='seleccionado(".$datoTmp->get_data("id_mandante").")'>";
      			}
      		}
      $html .= "</td>";
      $html .= "<td align='left'  width='17%' class='dato_lista'>".$datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")."</td>";
      $html .= "<td align='left' width='15%' class='dato_lista'>".$datoTmp->get_data("apellido")."</td>";
      $html .= "<td align='left' width='15%' class='dato_lista'>".$datoTmp->get_data("nombre")."</td>";
  	  $html .= "<td align='left' width='15%' class='dato_lista'>";
	  
	  for($i=0; $i<$datob->get_count(); $i++) 
	  {
	  	
	  	$dbTmp = &$datob->items[$i];
		if($dbTmp->get_data("id_banco") == $datoTmp->get_data("banco1"))
		{
	  		$html .= $dbTmp->get_data("banco");
			break;
		}
	  }
	  
      $html .= "</td>";
      $html .= "<td align='left'  width='10%' class='dato_lista'>".$datoTmp->get_data("cuenta_corriente1")."</td>";
      $html .= "<td align='left' width='15%'  class='dato_lista'>"; 
	  for($i=0; $i<$datob->get_count(); $i++) 
	  {
	  	$dbTmp = &$datob->items[$i];
		if($dbTmp->get_data("id_banco") == $datoTmp->get_data("banco2"))
		{
	  		$html .= $dbTmp->get_data("banco");
			break;
		}
	  }
	  
      $html .= "</td>";
      $html .= "<td align='left'  width='10%' class='dato_lista'>".$datoTmp->get_data("cuenta_corriente2")."</td>";
      $html .= "<tr bgcolor='#FFFFFF'>";
      $html .= "<td colspan='19' style='border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC;'></td>";
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
    	$html .= "<td colspan='8' align='center'>";
        $html .= "<div id='btnvermas_".$datoTmp->get_data("id_mandante")."' onclick='verMasRegistros(".$datoTmp->get_data("id_mandante").")' style='cursor:pointer;' >Ver mas </div>";
		$html .= "</td>";
		$html .= "</tr>";
    }
	$html .= "</table>";
	if($cant_datos > 0)
	{
	$html .= "<div  mascom='masdatcom' id='masdatos_".$datoTmp->get_data("id_mandante")."' style='display:none;'>";
    $html .= "</div>";
	}
	echo($html);
	}
	
	public function listar($array)
    {
		require 'models/MandantesModel.php';
		$mandantes = new MandantesModel();
		require 'models/BancosModel.php';
		$banco = new BancosModel();

		$dato = $mandantes->getListaMandantes($array["des_int"],$array["desApel1"],$array["desNomb1"],$array["id_partida"]);
		$datob = $banco->getListaBancos("");

		$datoTmp = &$dato->items[($dato->get_count()-1)];
		$datoAux = $mandantes->getListaMandantes($array["des_int"],$array["desApel1"],$array["desNomb1"],$datoTmp->get_data("id_mandante"));

		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colleccionMandantes'] = $dato;
		$data['colleccionBancos'] = $datob;
		$data['cant_mas'] = $datoAux->get_count();
		
		if($array["pantalla"] == "pdeudor")
		{
			$data['pantalla'] = "pdeudor";
		}
		$this->view->show("lista_mandantes.php", $data);
	}    
	
	public function validarrut($array)
    {
		require 'models/MandantesModel.php';
		$mandante = new MandantesModel();
		$resp = $mandante->valRutMandante($array);
		
		echo($resp);
    }  
	
	public function getDatosMandante($array)
	{
		require 'models/MandantesModel.php';
		$mandante = new MandantesModel();
		$arrayr = array();
		
		$dato = $mandante->getMandanteDatos($array["id_mandante"]);
		$arrayr[] = $dato->get_data("rut_mandante");
		$arrayr[] = $dato->get_data("dv_mandante");
		
		echo(json_encode($arrayr));		
	}
}
?>
