<?php
class PermisoController extends ControllerBase
{
    public function alta_permiso($array)
    {
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colModulo'] = $permiso->getModulos();
		
		$this->view->show("alta_permiso.php", $data);
	}

	public function listar_opcionesmodulo($array)
    {
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colOpcionModulo'] = $permiso->getOpcionModulo($array);
		
		$this->view->show("lista_opcion_modulo.php", $data);
	}
	
	public function listar_opcionesmodulotmp($array)
    {
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['detalle'] = $array["detalle"];
		$array["session_id"] = session_id();
		$data['colOpcionModulo'] = $permiso->getOpcionModuloTmp($array);
		
		
		$this->view->show("lista_opcion_modulotmp.php", $data);
	}
	
	public function agregarOcionTmp($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$data['colOpcionModulo'] = $permiso->agregarOpcionMenuTmp($array);
	}
		
	public function quitarOcionTmp($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$data['colOpcionModulo'] = $permiso->quitarOpcionMenuTmp($array);
	}
	
	public function borrarTmpOpcion($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$permiso->borrarTmpOpcionMenu($array);
	}

	public function grabar_alta_permiso($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$permiso->grabar_alta($array);
	}
	
	public function listar_permisos($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$data["pantalla"] = $array["pantalla"];
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colPermiso'] = $permiso->getPermisos();
		
		$this->view->show("lista_permisos.php", $data);
	}
	
	public function admin_permiso($array)
    {
	
		$data['nom_sistema'] = "SISTEMA DyV";
		
		$this->view->show("admin_permiso.php", $data);
	}
	
	public function eliminar($array)
    {	
		require 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		$dato = $permiso->bajaPermiso($array);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['colPermiso'] = $dato;
		
		$this->view->show("lista_permisos.php", $data);
	}
	
	public function editar($array)
    {	
		require 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		$array["session_id"] = session_id();
		$dato = $permiso->getDatosPermiso($array);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['datPermiso'] = $dato;
		$data['colModulo'] = $permiso->getModulos();
		
		$this->view->show("edita_permiso.php", $data);
	}
	
	public function grabar_editar_permiso($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$permiso->grabar_editar($array);
	}
	
	public function detalle($array)
    {	
		require 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		$array["session_id"] = session_id();
		$dato = $permiso->getDatosPermiso($array);
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$data['datPermiso'] = $dato;
		//$data['colModulo'] = $permiso->getModulos();
		
		$this->view->show("detalle_permiso.php", $data);
	}
	
	public function asignar($array)
    {		
		$this->view->show("asignar_permiso.php", $data);
	}

	public function agregarPermisoTmp($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$data['colPermisosUsu'] = $permiso->agregarPermisoUsuTmp($array);
	}
	
	public function listar_permisostmp($array)
    {
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$data['nom_sistema'] = "SISTEMA DyV";
		$array["session_id"] = session_id();
		$data['colPermiso'] = $permiso->getPermisosTmp($array);
		
		
		$this->view->show("lista_permisostmp.php", $data);
	}
	
	public function borrarTmpAsignar($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$permiso->borrarTmpPermisosAsignar($array);
	}
	
	public function quitarPermisoTmp($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$data['colPermiso'] = $permiso->quitarPermisoUsuTmp($array);
	}
	
	public function grabar_asignar_permiso($array)
	{
		include 'models/PermisoModel.php';
		$permiso = new PermisoModel();
		
		$array["session_id"] = session_id();
		$permiso->grabar_asignar_permiso_usu($array);
	}

	public function datos_usuario($array)
	{
		require 'models/UsuarioModel.php';
		include 'models/PermisoModel.php';
		
		$usuario = new UsuarioModel();
		$dato = $usuario->getDatosUsuario($array);
		
		$array["session_id"] = session_id();
		$permiso = new PermisoModel();
		//echo("<br>llenartmp_permisosusu");
		$permiso->llenartmp_permisosusu($array);
		
		$resp = array();
		$resp[] = $dato->get_data("nom_usuario");
		$resp[] = $dato->get_data("ape_usuario");
		
		echo(json_encode($resp));
		
	}
}
?>