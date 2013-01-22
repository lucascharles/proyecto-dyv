<?php
class UsuarioController extends ControllerBase
{
	
	public function cambia_clave($array)
	{
		require 'models/UsuarioModel.php';
		
		$usuario = new UsuarioModel();
	
		$dato = $usuario->getUsuario($_SESSION["idusuario"]);
		
		$destino = "cambioclave.php";
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['usuario'] = $dato;
		
		$this->view->show($destino, $data);
	}
    
	public function graba_cambio_clave($array)
	{	
		require 'models/UsuarioModel.php';
		$usuario = new UsuarioModel();
		$usuario->cambiarClave($array["nueva"], $_SESSION["idusuario"]);
	}
	

}
?>