<?php
class InformesController extends ControllerBase
{
    //Accion index
    public function admin($array)
    {
		require 'models/MandantesModel.php';
		require 'models/InformesModel.php';
		require 'models/DocumentosModel.php';
		
				
		$mandantes = new MandantesModel();
		$dato = $mandantes->getListaMandantes("","","",0);
		
		$documentos = new DocumentosModel();	
		$dataTipoDoc = $documentos->getListaTipoDoc("");

		$informe = new InformesModel();
		$tipoinforme= " in (0)";
		$mandante = "0";
		$idtipodoc = 0;
		$datainforme = $informe->listar_informe($tipoinforme,$mandante,$idtipodoc);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		//$data['colleccionMandantes'] = $dato;
		$data['colleccionInformes'] = $datainforme;
		$data['coleccion_tipoDoc'] = $dataTipoDoc;
		$this->view->show("informes.php", $data);
	}

	public function listar($array)
    {
		require 'models/InformesModel.php';
				
		$informe = new InformesModel();
		if($array['tipoInforme'] == "Judicial")
		{
			$tipoInforme= " in (7) ";
		}else{
			$tipoInforme= " not in (7,2) "; //demanda-recuperado
		}
			
		if($array['idmandante'] == ""){
			$idmandante = 0;
		}else{
			$idmandante = $array['idmandante'];
		}
		
    	if($array['tipoDoc'] == ""){
			$idtipodoc = 0;
		}else{
			$idtipodoc = $array['tipoDoc'];
		}
		$dato = $informe->listar_informe($tipoInforme,$idmandante,$idtipodoc);

		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['colleccionInformes'] = $dato;
		
		$this->view->show("lista_informes.php", $data);
	}    
	
	
	public function generarExcel($array)
    {
		require 'models/InformesModel.php';
				
		$informe = new InformesModel();
		if($array['tipoInforme'] == "Judicial")
		{
			$tipoInforme= " in (7) ";
		}else{
			$tipoInforme= " not in (7,2) "; //demanda-recuperado
		}
			
		if($array['idmandante'] == ""){
			$idmandante = 0;
		}else{
			$idmandante = $array['idmandante'];
		}
		
    	if($array['tipoDoc'] == ""){
			$idtipodoc = 0;
		}else{
			$idtipodoc = $array['tipoDoc'];
		}
		
		$dato = $informe->listar_informe($tipoInforme,$idmandante,$idtipodoc, $array['iddocs']);

		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['colleccionInformes'] = $dato;
		
		$this->view->show("lista_informes_excel.php", $data);
	}
	
	public function marcar($array)
    {
		require 'models/InformesModel.php';
				
		$informe = new InformesModel();
		if($array['tipoInforme'] == "Judicial")
		{
			$tipoInforme= " in (7) ";
		}else{
			$tipoInforme= " not in (7,2) "; //demanda-recuperado
		}
			
		if($array['idmandante'] == ""){
			$idmandante = 0;
		}else{
			$idmandante = $array['idmandante'];
		}
		
    	if($array['tipoDoc'] == ""){
			$idtipodoc = 0;
		}else{
			$idtipodoc = $array['tipoDoc'];
		}
		
		$dato = $informe->listar_informe($tipoInforme,$idmandante,$idtipodoc);

		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['colleccionInformes'] = $dato;
		$data['marcartodo']="S";
		
		$this->view->show("lista_informes.php", $data);
	}

	public function desmarcar($array)
    {
		require 'models/InformesModel.php';
				
		$informe = new InformesModel();
		if($array['tipoInforme'] == "Judicial")
		{
			$tipoInforme= " in (7) ";
		}else{
			$tipoInforme= " not in (7,2) "; //demanda-recuperado
		}
			
		if($array['idmandante'] == ""){
			$idmandante = 0;
		}else{
			$idmandante = $array['idmandante'];
		}
		$dato = $informe->listar_informe($tipoInforme,$idmandante);

		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "";
		$data['colleccionInformes'] = $dato;
		$data['marcartodo']="N";
		
		$this->view->show("lista_informes.php", $data);
	}
	
}
?>