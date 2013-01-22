<?php
	
	//$db = new mysql_db($config->get('dbhost'), $config->get('dbuser'),  $config->get('dbpass'), $config->get('dbname'), false);
	$db = new mssql_db($config->get('dbhost'), $config->get('dbuser'),  $config->get('dbpass'), $config->get('dbname'), false);
	
	
	add_database($db, $db_name);
	//add_database($db, $config->get('dbname'));
	
	// CLASES MODELO DE NEGOCIO
	class MandanteModoPago extends BusinessObject
	{
		function MandanteModoPago()
		{
			$this->table_name = "MandanteModoPago";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_mandante" => array("int"),
					"id_modo_pago" => array("int"),
					"porcentaje" => array("decimal"),
					"operacion" => array("decimal"),
					"estatus" => array("char")
				);
			parent::BusinessObject();
		}
	}
	
	class MandanteModoPagoCollection extends BusinessObjectCollection
	{
		function MandanteModoPagoCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new MandanteModoPago();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
			
	class Bancos extends BusinessObject
	{
		function Bancos()
		{
			$this->table_name = "Bancos";
			$this->field_metadata = array(
					"id_banco" => array("int"),
					"banco" => array("varchar"),
					"codigo" => array("varchar"),
					"activo" => array("char")
				);
			parent::BusinessObject();
		}
	}
	
	class BancosCollection extends BusinessObjectCollection
	{
		function BancosCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Bancos();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class CausalProtesta extends BusinessObject
	{
		function CausalProtesta()
		{
			$this->table_name = "CausalProtesta";
			$this->field_metadata = array(
					"id_causal" => array("int"),
					"causal" => array("varchar"),
					"activo" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class CausalProtestaCollection extends BusinessObjectCollection
	{
		function CausalProtestaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new CausalProtesta();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Deudores extends BusinessObject
	{
		function Deudores()
		{
			$this->table_name = "Deudores";
			$this->field_metadata = array(
					"id_deudor" => array("int"),
					"rut_deudor" => array("numeric"),
					"rut_deudor_s" => array("varchar"),
					"dv_deudor" => array("numeric"),
					"primer_nombre" => array("varchar"),
					"segundo_nombre" => array("varchar"),
					"primer_apellido" => array("varchar"),
					"segundo_apellido" => array("varchar"),
					"comentario" => array("varchar"),
					"celular" => array("numeric"),
					"telefono_fijo" => array("numeric"),
					"fax" => array(" numeric"),
					"id_mandante" => array("numeric"),
					"tipo" => array("char"),
					"razonsocial" => array("varchar"),
					"email" => array("varchar"),
					"activo" => array("char")
				);
			parent::BusinessObject();
		}
	}
	
	class DeudoresCollection extends BusinessObjectCollection
	{
		function DeudoresCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Deudores();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Deudor_Mandante extends BusinessObject
	{
		function Deudor_Mandante()
		{
			$this->table_name = "Deudor_Mandante";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_deudor" => array("int"),
					"id_mandante" => array("int")
				);
			parent::BusinessObject();
		}
	}
	
	class Deudor_MandanteCollection extends BusinessObjectCollection
	{
		function Deudor_MandanteCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Deudor_Mandante();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Deudor_MandanteTmp extends BusinessObject
	{
		function Deudor_MandanteTmp()
		{
			$this->table_name = "Deudor_MandanteTmp";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_sesion" => array("varchar"),
					"id_mandante" => array("int")
				);
			parent::BusinessObject();
		}
	}
	
	class Deudor_MandanteTmpCollection extends BusinessObjectCollection
	{
		function Deudor_MandanteTmpCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Deudor_MandanteTmp();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Direccion_Deudores extends BusinessObject
	{
		function Direccion_Deudores()
		{
			$this->table_name = "Direccion_Deudores";
			$this->field_metadata = array(
					"id_direccion" => array("int"), 
					"id_deudor" => array("int"),
					"calle" => array("varchar"),
					"numero" => array("varchar"),
					"piso" => array("varchar"),
					"depto" => array("varchar"),
					"comuna" => array("varchar"),
					"ciudad" => array("varchar"),
					"otros" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class Direccion_DeudoresCollection extends BusinessObjectCollection
	{
		function Direccion_DeudoresCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Direccion_Deudores();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	

	class Contacto_MandantesTmp extends BusinessObject
	{
		function Contacto_MandantesTmp()
		{
			$this->table_name = "Contacto_Mandantes_Tmp";
			$this->field_metadata = array(
					"id_contacto" => array("int"), 
					"id_mandante" => array("int"),
					"contacto" => array("varchar"),
					"email" => array("varchar"),
					"celular" => array("varchar"),
					"telefono" => array("varchar"),
					"fax" => array("varchar"),
					"observacion" => array("varchar"),
					"id_sesion" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class Contacto_MandantesTmpCollection extends BusinessObjectCollection
	{
		function Contacto_MandantesTmpCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Contacto_MandantesTmp();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Contacto_Mandantes extends BusinessObject
	{
		function Contacto_Mandantes()
		{
			$this->table_name = "Contacto_Mandantes";
			$this->field_metadata = array(
					"id_contacto" => array("int"), 
					"id_mandante" => array("int"),
					"contacto" => array("varchar"),
					"email" => array("varchar"),
					"celular" => array("varchar"),
					"telefono" => array("varchar"),
					"fax" => array("varchar"),
					"observacion" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class Contacto_MandantesCollection extends BusinessObjectCollection
	{
		function Contacto_MandantesCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Contacto_Mandantes();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Direccion_DeudoresTmp extends BusinessObject
	{
		function Direccion_DeudoresTmp()
		{
			$this->table_name = "Direccion_Deudores_tmp";
			$this->field_metadata = array(
					"id_direccion" => array("int"), 
					"id_deudor" => array("int"),
					"calle" => array("varchar"),
					"numero" => array("varchar"),
					"piso" => array("varchar"),
					"depto" => array("varchar"),
					"comuna" => array("varchar"),
					"ciudad" => array("varchar"),
					"otros" => array("varchar"),
					"id_sesion" => array("varchar")
					
				);
			parent::BusinessObject();
		}
	}
	
	class Direccion_DeudoresTmpCollection extends BusinessObjectCollection
	{
		function Direccion_DeudoresTmpCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Direccion_DeudoresTmp();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Documentos extends BusinessObject
	{
		function Documentos()
		{
			$this->table_name = "Documentos";
			$this->field_metadata = array(
					"id_documento" => array("int"),
					"id_estado_doc" => array("int"),
					"id_tipo_doc" => array("int"),
					"id_causa_protesto" => array("int"),
					"id_banco" => array("int"),
					"id_mandatario" => array("int"),
					"id_deudor" => array("int"),
					"numero_documento" => array("int"),
					"numero_siniestro" => array("int"),
					"fecha_protesto" => array("datetime"),
					"fecha_siniestro" => array("datetime"),
					"monto" => array("decimal"),
					"cta_cte" => array("varchar"),
					"gastos_protesto" => array("int"),
					"ns" => array("int"),
					"fecha_creacion" => array("datetime"),
					"usuario_creacion" => array("varchar"),
					"fecha_modificacion" => array("datetime"),
					"usuario_modificacion" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class DocumentosCollection extends BusinessObjectCollection
	{
		function DocumentosCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Documentos();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class EstadoDocumentos extends BusinessObject
	{
		function EstadoDocumentos()
		{
			$this->table_name = "EstadoDocumentos";
			$this->field_metadata = array(
					"id_estado_doc" => array("int"),
					"estado" => array("varchar"),
					"codigo" => array("varchar"),
					"activo" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class EstadoDocumentosCollection extends BusinessObjectCollection
	{
		function EstadoDocumentosCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new EstadoDocumentos();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Estados_x_Gestion extends BusinessObject
	{
		function Estados_x_Gestion()
		{
			$this->table_name = "Estados_x_Gestion";
			$this->field_metadata = array(
					"id_gestion" => array("numeric"),
					"id_estado" => array("numeric"),
					"fecha_gestion" => array("datetime"),
					"notas" => array("nvarchar")
				);
			parent::BusinessObject();
		}
	}
	
	class Estados_x_GestionCollection extends BusinessObjectCollection
	{
		function Estados_x_GestionCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Estados_x_Gestion();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}

	class EstadosGestion extends BusinessObject
	{
		function EstadosGestion()
		{
			$this->table_name = "EstadosGestion";
			$this->field_metadata = array(
					"id_estado" => array("numeric"),
					"estado" => array("nvarchar")
				);
			parent::BusinessObject();
		}
	}
	
	class EstadosGestionCollection extends BusinessObjectCollection
	{
		function EstadosGestionCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new EstadosGestion();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Mandantes extends BusinessObject
	{
		function Mandantes()
		{
			$this->table_name = "Mandantes";
			$this->field_metadata = array(
					"id_mandante" => array("int"),
					"rut_mandante" => array("numeric"),
					"dv_mandante" => array("varchar"),
					"nombre" => array("varchar"),
					"apellido" => array("varchar"),
					"calle" => array("varchar"),					
					"comuna" => array("varchar"),
					"ciudad" => array("varchar"),
					"region" => array("varchar"),
					"numero" => array("varchar"),
					"piso" => array("varchar"),
					"dpto" => array("varchar"),
					"cuenta_corriente1" => array("varchar"),
					"banco1" => array("varchar"),
					"cuenta_corriente2" => array("varchar"),
					"banco2" => array("varchar"),
					"activo" => array("char")
					
				);
			parent::BusinessObject();
		}
	}
	
	class MandantesCollection extends BusinessObjectCollection
	{
		function MandantesCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Mandantes();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class ModoPago extends BusinessObject
	{
		function ModoPago()
		{
			$this->table_name = "ModoPago";
			$this->field_metadata = array(
					"id_modo_pago" => array("int"),
					"modo_pago" => array("varchar"),
					"activo" => array("char")
				);
			parent::BusinessObject();
		}
	}
	
	class ModoPagoCollection extends BusinessObjectCollection
	{
		function ModoPagoCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new ModoPago();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class TipoDocumento extends BusinessObject
	{
		function TipoDocumento()
		{
			$this->table_name = "TipoDocumento";
			$this->field_metadata = array(
					"id_tipo_documento" => array("int"),
					"tipo_documento" => array("varchar"),
					"activo" => array("char")
				);
			parent::BusinessObject();
		}
	}
	
	class TipoDocumentoCollection extends BusinessObjectCollection
	{
		function TipoDocumentoCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new TipoDocumento();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	// CLASES DESOPORTE SISTEMA: GESTION PERMISOS
	class Usuarios extends BusinessObject
	{
		function Usuarios()
		{
			$this->table_name = "Usuarios";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_usuario" => array("varchar"),
					"clave" => array("varchar"),
					"nom_usuario" => array("varchar"),
					"ape_usuario" => array("varchar"),
					"activo" => array("char"),
					"fec_alta" => array("datetime"),
				);
			parent::BusinessObject();
		}
	}

	class UsuariosCollection extends BusinessObjectCollection
	{
		function UsuariosCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Usuarios();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Modulo extends BusinessObject
	{
		function Modulo()
		{
			$this->table_name = "Modulo";
			$this->field_metadata = array(
					"id" => array("int"),
					"nombre" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class ModuloCollection extends BusinessObjectCollection
	{
		function ModuloCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Modulo();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Opcionmenu extends BusinessObject
	{
		function Opcionmenu()
		{
			$this->table_name = "Opcionmenu";
			$this->field_metadata = array(
					"id" => array("int"),
					"nombre" => array("varchar"),
					"id_modulo" => array("int"),
					"acceso" => array("varchar")
					
				);
			parent::BusinessObject();
		}
	}
	
	class OpcionmenuCollection extends BusinessObjectCollection
	{
		function OpcionmenuCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Opcionmenu();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Permiso extends BusinessObject
	{
		function Permiso()
		{
			$this->table_name = "Permiso";
			$this->field_metadata = array(
					"id" => array("int"),
					"nombre" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class PermisoCollection extends BusinessObjectCollection
	{
		function PermisoCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Permiso();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}

	class Opcion_permiso extends BusinessObject
	{
		function Opcion_permiso()
		{
			$this->table_name = "Opcion_permiso";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_permiso" => array("int"),
					"id_opcion" => array("int")
				);
			parent::BusinessObject();
		}
	}
	
	class Opcion_permisoCollection extends BusinessObjectCollection
	{
		function Opcion_permisoCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Opcion_permiso();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Usuario_permiso extends BusinessObject
	{
		function Usuario_permiso()
		{
			$this->table_name = "Usuario_permiso";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_permiso" => array("int"),
					"id_usuario" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class Usuario_permisoCollection extends BusinessObjectCollection
	{
		function Usuario_permisoCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Usuario_permiso();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	// CLASES SOPORTE PROCESOS 
	 
	class LogError extends BusinessObject
	{
		function LogError()
		{
			$this->table_name = "LogError";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_usuario" => array("varchar"),
					"fecha_hora" => array("datetime")
				);
			parent::BusinessObject();
		}
	}
	
	class LogErrorCollection extends BusinessObjectCollection
	{
		function LogErrorCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new LogError();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Det_LogError_CargaMasiva extends BusinessObject
	{
		function Det_LogError_CargaMasiva()
		{
			$this->table_name = "Det_LogError_CargaMasiva";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_logerror" => array("int"),
					"id_tipo_error" => array("int"),
					"archivo" => array("varchar"),
					"fila" => array("int")
				);
			parent::BusinessObject();
		}
	}
	
	class Det_LogError_CargaMasivaCollection extends BusinessObjectCollection
	{
		function Det_LogError_CargaMasivaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Det_LogError_CargaMasiva();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	
	// CLASES SOPORTE SQL 
	class SqlPersonalizado extends SqlSoporte
	{
		function SqlPersonalizado($h, $u, $p)
		{
			parent::SqlSoporte($h, $u, $p);
		}
	}
?>