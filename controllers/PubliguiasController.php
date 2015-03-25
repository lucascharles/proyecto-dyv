<?php
class PubliguiasController extends ControllerBase
{
    //Accion index
    public function publiguia($array)
    {
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		
		$this->view->show("cargaarchivo.php", $data);
	}

  
}
?>