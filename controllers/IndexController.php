<?php
class IndexController extends ControllerBase
{
    //Accion index
    public function index($array)
    {
		//Pasamos a la vista toda la información que se desea representar
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['accion_form'] = "index.php?controlador=Index&accion=valid_login";
		
		//Finalmente presentamos nuestra plantilla
		$this->view->show("login.php", $data);
    }
	
	public function valid_login($array)
	{
		// SE INCLUYE MODELO USUARIO 
		require 'models/UsuarioModel.php';
		
		// SE CREA UNA INSTACIA DEL MODELO USUARIO 
		$usuario = new UsuarioModel();
	
		// VALIDAMOS USUARIO Y CLAVE CONTRA LA BASE DE DATOS
		$resp = $usuario->validarUsuario($array["usrLogin"], $array["passLogin"]);
		
		//Pasamos a la vista toda la información que se desea representar
		if($resp == false)
		{
			$destino = "login.php";
			$data['nom_sistema'] = "SISTEMA DyV";
			$data['accion_form'] = "index.php?controlador=Index&accion=valid_login";
		}
		else
		{
			$destino = "menu.php";
			$data['nom_sistema'] = "SISTEMA DyV";
			$perm = $usuario->getPermisosMenu($array["usrLogin"]);
			$data['arrayObjPermisos'] = $perm;
			$_SESSION["idusuario"] = $array["usrLogin"];
			
			$perfil = $usuario->getPerfilUsuario($array["usrLogin"]);

			if($perfil->get_count() > 0)
			{
				$perfilusuario = $perfil->items[0];
				$_SESSION["perfil"] = $perfilusuario->get_data("perfil"); 
			}
			
			
		}
		
		//Finalmente presentamos nuestra plantilla
		$this->view->show($destino, $data);
	}
    
	public function logoff($array)
	{
		session_destroy();
	}
	
    public function testView()
    {
        $vars['nombre'] = "Federico";
        $vars['lugar'] = $this->getLugar();
        $this->view->show("test.php", $vars);
    }
    
    private function getLugar()
    {
        return "Buenos Aires, Argentina";
    }
}
?>