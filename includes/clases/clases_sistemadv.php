<?php
	
// $db = new mysql_db($config->get('dbhost'), $config->get('dbuser'),  $config->get('dbpass'), $config->get('dbname'), false);
	$db = new mssql_db($config->get('dbhost'), $config->get('dbuser'),  $config->get('dbpass'), $config->get('dbname'), false);
	
	
	add_database($db, $db_name);
	//add_database($db, $config->get('dbname'));
	
	// CLASES MODELO DE NEGOCIO
	class OpcionPermisoTmp extends BusinessObject
	{
		function OpcionPermisoTmp()
		{
			$this->table_name = "opcionpermisotmp";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_opcionmenu" => array("int"),
					"id_sesion" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class OpcionPermisoTmpCollection extends BusinessObjectCollection
	{
		function OpcionPermisoTmpCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new OpcionPermisoTmp();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Juzgado extends BusinessObject
	{
		function Juzgado()
		{
			$this->table_name = "juzgado";
			$this->field_metadata = array(
					"id_juzgado" => array("int"),
					"descripcion" => array("varchar"),
					"activo" => array("char")
				);
			parent::BusinessObject();
		}
	}
	
	class JuzgadoCollection extends BusinessObjectCollection
	{
		function JuzgadoCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Juzgado();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	
	class JuzgadoComuna extends BusinessObject
	{
		function JuzgadoComuna()
		{
			$this->table_name = "juzgadocomuna";
			$this->field_metadata = array(
					"id_juzgado" => array("int"),
					"descripcion" => array("varchar"),
					"activo" => array("char")
				);
			parent::BusinessObject();
		}
	}
	
	class JuzgadoComunaCollection extends BusinessObjectCollection
	{
		function JuzgadoComunaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new JuzgadoComuna();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Ficha extends BusinessObject
	{
		function Ficha()
		{
			$this->table_name = "ficha";
			$this->field_metadata = array(
					"id_ficha" => array("int"),
					"id_deudor" => array("int"),
					"id_mandante" => array("int"),
					"id_documento" => array("int"),
					"monto" => array("decimal"),
					"abogado" => array("varchar"),
					"firma" => array("varchar"),
					"ingreso" => array("datetime"),
					"providencia" => array("varchar"),
					"distribucion_corte" => array("datetime"),
					"rol" => array("varchar"),
					"id_juzgado" => array("int"),
					"id_juzgado_comuna" => array("int")
				);
			parent::BusinessObject();
		}
	}
	
	class FichaCollection extends BusinessObjectCollection
	{
		function FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}

	
	
	
	class Documento_Ficha extends BusinessObject
	{
		function Documento_Ficha()
		{
			$this->table_name = "documento_ficha";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_ficha" => array("int"),
					"id_documento" => array("int")
				);
			parent::BusinessObject();
		}
	}
	
	class Documento_FichaCollection extends BusinessObjectCollection
	{
		function Documento_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Documento_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
		
	class Receptor_Ficha extends BusinessObject
	{
		function Receptor_Ficha()
		{
			$this->table_name = "receptor_ficha";
			$this->field_metadata = array(
				"id_receptor" => array("int"),
				"id_ficha" => array("int"),
				"fecha_mandamiento" => array("date"),
				"receptor" => array("varchar"),
				"busqueda" => array("varchar"),
				"notificacion" => array("varchar"),
				"notificacion_2" => array("varchar"),
				"notificacion_3" => array("varchar"),
				"fecha_domicilio" => array("date"),
				"fecha_domicilio_1" => array("date"),
				"entrega_receptor_1" => array("varchar"),
				"entrega_receptor_2" => array("varchar"),
				"entrega_receptor_3" => array("varchar"),
				"entrega_receptor_4" => array("varchar"),
				"notificacion_1" => array("varchar"),
				"fecha_embargo_fp" => array("date"),
				"fecha_oficio" => array("date"),
				"fecha_traba_emb" => array("date"),
				"fono_receptor" => array("varchar"),
				"resultado_busqueda" => array("varchar"),
				"resultado_notificacion_1" => array("varchar"),
				"resultado_notificacion_2" => array("varchar"),
				"resultado_notificacion_3" => array("varchar"),
				"providencia_1" => array("varchar"),
				"providencia_2" => array("varchar"),
				"providencia_3" => array("varchar"),
				"fecha_busqueda_2" => array("date"),
				"busqueda_3" => array("varchar"),
				"embargo" => array("varchar"),
				"articulo_431044" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class Receptor_FichaCollection extends BusinessObjectCollection
	{
		function Receptor_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Receptor_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
				
	class Gastos_Receptor_Ficha extends BusinessObject
	{
		function Gastos_Receptor_Ficha()
		{
			$this->table_name = "gastos_receptor_ficha";
			$this->field_metadata = array(
				"id" => array("int"),
				"id_gasto" => array("int"),
				"id_receptor" => array("int"),
				"id_ficha" => array("int"),
				"importe" => array("decimal")
			);
			parent::BusinessObject();
		}
	}
	
	class Gastos_Receptor_FichaCollection extends BusinessObjectCollection
	{
		function Gastos_Receptor_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Gastos_Receptor_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}

	class Gastos extends BusinessObject
	{
		function Gastos()
		{
			$this->table_name = "gastos";
			$this->field_metadata = array(
				"id_gasto" => array("int"),
				"gasto" => array("varchar"),
				"rep" => array("int"),
				"orden" => array("int")
			);
			parent::BusinessObject();
		}
	}
	
	class GastosCollection extends BusinessObjectCollection
	{
		function GastosCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Gastos();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
						
	class Martillero_Ficha extends BusinessObject
	{
		function Martillero_Ficha()
		{
			$this->table_name = "martillero_ficha";
			$this->field_metadata = array(
				"id_martillero" => array("int"),
				"id_ficha" => array("int"),
				"aceptacion_cargo" => array("varchar"),
				"nombre" => array("varchar"),
				"rut_martilero" => array("int"),
				"dv_martillero" => array("int"),
				"notificacion" => array("varchar"),
				"retirio_especies_fp" => array("varchar"),
				"providencia" => array("varchar"),
				"entrega_receptor" => array("varchar"),
				"retiro_especies" => array("varchar"),
				"oposicion_retiro" => array("varchar"),
				"fecha_remate" => array("date")
			);
			parent::BusinessObject();
		}
	}
	
	class Martillero_FichaCollection extends BusinessObjectCollection
	{
		function Martillero_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Martillero_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Gastos_Martillero_Ficha extends BusinessObject
	{
		function Gastos_Martillero_Ficha()
		{
			$this->table_name = "gastos_martillero_ficha";
			$this->field_metadata = array(
				"id" => array("int"),
				"id_gasto" => array("int"),
				"id_martillero" => array("int"),
				"id_ficha" => array("int"),
				"importe" => array("decimal")
			);
			parent::BusinessObject();
		}
	}
	
	class Gastos_Martillero_FichaCollection extends BusinessObjectCollection
	{
		function Gastos_Martillero_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Gastos_Martillero_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
				
	class Consignacion_Ficha extends BusinessObject
	{
		function Consignacion_Ficha()
		{
			$this->table_name = "consignacion_ficha";
			$this->field_metadata = array(			
				"id_consignacion" => array("int"),
				"id_ficha" => array("int"),
				"consignacion" => array("varchar"),
				"abono_1" => array("decimal"),
				"abono_2" => array("decimal"),
				"abono_3" => array("decimal"),
				"abono_4" => array("decimal"),
				"pago_cliente" => array("decimal"),
				"giro_cheque_1" => array("decimal"),
				"giro_cheque_2" => array("decimal"),
				"entrega_cheque" => array("varchar"),
				"costas_procesales" => array("decimal"),
				"pago_costas" => array("decimal"),
				"entrega_cheque_1" => array("varchar"),
				"devolucion_documento" => array("varchar"),
				"entrega_documento" => array("varchar"),
				"monto_consignacion" => array("decimal"),
				"monto_1" => array("decimal"),
				"monto_2" => array("decimal"),
				"monto_3" => array("decimal"),
				"monto_4" => array("decimal"),
				"pago_dyv" => array("decimal"),
				"providencia_1" => array("varchar"),
				"providencia_2" => array("varchar"),
				"providencia_3" => array("varchar"),
				"rendicion_cliente" => array("decimal")
			);
			parent::BusinessObject();
		}
	}
	
	class Consignacion_FichaCollection extends BusinessObjectCollection
	{
		function Consignacion_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Consignacion_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
			
	class Gastos_Consignacion_Ficha extends BusinessObject
	{
		function Gastos_Consignacion_Ficha()
		{
			$this->table_name = "gastos_consignacion_ficha";
			$this->field_metadata = array(			
				"id" => array("int"),
				"id_consignacion" => array("int"),
				"id_gasto" => array("int"),
				"id_ficha" => array("int"),
				"importe" => array("decimal")
			);
			parent::BusinessObject();
		}
	}
	
	class Gastos_Consignacion_FichaCollection extends BusinessObjectCollection
	{
		function Gastos_Consignacion_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Gastos_Consignacion_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
				
	class Gastos_Ficha extends BusinessObject
	{
		function Gastos_Ficha()
		{
			$this->table_name = "gastos_ficha";
			$this->field_metadata = array(						
				"id_ficha" => array("int"),
				"id_gasto" => array("int"),
				"importe" => array("decimal")
			);
			parent::BusinessObject();
		}
	}
	
	class Gastos_FichaCollection extends BusinessObjectCollection
	{
		function Gastos_FichaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Gastos_Ficha();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class ErrorCarga extends BusinessObject
	{
		function ErrorCarga()
		{
			$this->table_name = "errorcarga";
			$this->field_metadata = array(
					"id" => array("int"),
					"error" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class ErrorCargaCollection extends BusinessObjectCollection
	{
		function ErrorCargaCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new ErrorCarga();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class MandanteModoPago extends BusinessObject
	{
		function MandanteModoPago()
		{
			$this->table_name = "mandantemodopago";
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
			$this->table_name = "bancos";
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
			$this->table_name = "causalprotesta";
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
			$this->table_name = "deudores";
			$this->field_metadata = array(
					"id_deudor" => array("int"),
					"rut_deudor" => array("numeric"),
					"rut_deudor_s" => array("varchar"),
					"dv_deudor" => array("varchar"),
					"primer_nombre" => array("varchar"),
					"segundo_nombre" => array("varchar"),
					"primer_apellido" => array("varchar"),
					"segundo_apellido" => array("varchar"),
					"comentario" => array("varchar"),
					"celular" => array("numeric"),
					"telefono_fijo" => array("numeric"),
					"fax" => array(" numeric"),
					"id_mandante" => array("int"),
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
			$this->table_name = "deudor_mandante";
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
			$this->table_name = "deudor_mandantetmp";
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
			$this->table_name = "direccion_deudores";
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
			$this->table_name = "contacto_mandantes_tmp";
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
			$this->table_name = "contacto_mandantes";
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
			$this->table_name = "direccion_deudores_tmp";
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
			$this->table_name = "documentos";
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
					"usuario_modificacion" => array("varchar"),
					"activo" => array("varchar")
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
			$this->table_name = "estadodocumentos";
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
			$this->table_name = "estados_x_gestion";
			$this->field_metadata = array(
					"id_gestion" => array("int"),
					"id_estado" => array("int"),
					"id_mandante" => array("int"),
					"fecha_gestion" => array("datetime"),
					"fecha_prox_gestion" => array("datetime"),
					"notas" => array("varchar"),
					"usuario" => array("varchar")
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
			$this->table_name = "estadosgestion";
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
			$this->table_name = "mandantes";
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
			$this->table_name = "modopago";
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
			$this->table_name = "tipodocumento";
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
			$this->table_name = "usuarios";
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
			$this->table_name = "modulo";
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
			$this->table_name = "opcionmenu";
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
			$this->table_name = "permiso";
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
			$this->table_name = "opcion_permiso";
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
			$this->table_name = "usuario_permiso";
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
	
	class Usuario_permisoTmp extends BusinessObject
	{
		function Usuario_permisoTmp()
		{
			$this->table_name = "usuario_permisotmp";
			$this->field_metadata = array(
					"id" => array("int"),
					"id_permiso" => array("int"),
					"id_usuario" => array("varchar"),
					"id_sesion" => array("varchar")
				);
			parent::BusinessObject();
		}
	}
	
	class Usuario_permisoTmpCollection extends BusinessObjectCollection
	{
		function Usuario_permisoTmpCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Usuario_permisoTmp();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	// CLASES SOPORTE PROCESOS 
	 
	class LogError extends BusinessObject
	{
		function LogError()
		{
			$this->table_name = "logerror";
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
			$this->table_name = "det_logerror_cargamasiva";
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
	
	class Gestiones extends BusinessObject
	{
		function Gestiones()
		{
			$this->table_name = "gestiones";
			$this->field_metadata = array(
					"id_gestion" => array("int"),
					"id_deudor" => array("int"),
					"id_mandante" => array("int"),
					"fecha_gestion" => array("datetime"),
					"nota_gestion" => array("varchar"),
					"fecha_prox_gestion" => array("datetime"),
					"activo" => array("varchar"),
					"usuario_creacion" => array("varchar"),
					"fecha_creacion"  => array("datetime"),
					"usuario_modificacion" => array("varchar"),
					"fecha_modificacion"  => array("datetime")
				);
			parent::BusinessObject();
		}
	}
	
	class GestionesCollection extends BusinessObjectCollection
	{
		function GestionesCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Gestiones();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Liquidaciones extends BusinessObject
	{
		function Liquidaciones()
		{
			$this->table_name = "liquidaciones";
			$this->field_metadata = array(
					"id_liquidacion" => array("int"),
					"id_deudor" => array("int"),
					"id_mandante" => array("int"),
					"interes" => array("decimal"),
					"valor_uf" => array("decimal"),
					"fecha_simulacion" => array("date"),
					"fecha_creacion" => array("date"),
					"usuario_creacion" => array("varchar"),
					"fecha_modificacion" => array("date"),
					"usuario_modificacion" => array("varchar"),
							);
			parent::BusinessObject();
		}
	}
	
	class LiquidacionesCollection extends BusinessObjectCollection
	{
		function LiquidacionesCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Liquidaciones();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
	class Parametros extends BusinessObject
	{
		function Parametros()
		{
			$this->table_name = "parametros";
			$this->field_metadata = array(
					"id_parametro" => array("int"),
					"nombre_parametro" => array("varchar"),
					"valor_parametro" => array("varchar")
							);
			parent::BusinessObject();
		}
	}
	
	class ParametrosCollection extends BusinessObjectCollection
	{
		function ParametrosCollection()
		{
			parent::BusinessObjectCollection();
		}
		
		function create_singular($row) 
		{ 
			$obj = new Parametros();
			$obj->load_from_list($row);
			
			return $obj;
		}
	}
	
?>