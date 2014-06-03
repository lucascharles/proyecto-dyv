<?
$titulo="Facturaci&oacute;n consumos";
$param = array();
if (!$_REQUEST["procesar"])
{
	include("layout_a.php");
	
	if($_REQUEST["idl"] > '') $_SESSION["idlote_fac"] = $_REQUEST["idl"];
	
	$param = array("titulo"=>$titulo, "id_lote"=>$_SESSION["idlote_fac"]);
	Parametros($param);
	include("layout_c.php"); 
}
else
{
	
	include("libreria.php");
	
	$prg["scripts"][]="trimotion.js";
	include("layout_a.php");

	$param = array("arch_facturacion"=>$_FILES["arch_facturacion"], "id_lote"=>$_POST["id_lote"]);
	
	if($_REQUEST["operacion"] == "preview")
	{
		
		listado($param);
	}
	if($_REQUEST["operacion"] == "generar")
	{
		generar($param);
		redir("TMlotes_facturacion.php");
		exit;
	}
}

function Parametros($param)
{
	echo "<form  id='formularioReportes' name='formu' enctype='multipart/form-data' method='post' action='' target='_self'>";
	inputFormHidden('procesar','1'); 
	inputFormHidden('operacion','preview'); 
	echo "<table id='formulario' width='500'>";
	tituloForm(array('titulo'=>$param["titulo"]) ); 
	inputFormEtiquetado('ARCHIVO','arch_facturacion','file', '','novacio'); 
	inputFormHidden('id_lote',$param["id_lote"]); 
	inputFormBotoneraReportes("./TMlotes_facturacion.php"); 
	echo"</table>";
	echo"</form>";
}

function listado($param)
{

	$file1 = $param["arch_facturacion"]['tmp_name'];
	$id_ctacte = 0;
	$lines = file($file1);
	$faltantes = array();
	
	if (is_uploaded_file($param["arch_facturacion"]['tmp_name'])) 
	{ 
		$nombre_archivo = $param["arch_facturacion"]['name']; 
		$tipo_archivo = $param["arch_facturacion"]['type']; 
		$tamano_archivo = $param["arch_facturacion"]['size']; 
		
		$extension_archivo=strrchr($nombre_archivo,'.');
		
		$destino = "tmp/".$nombre_archivo;
		
		$ext=strrchr($destino,'.');
		
		 if (move_uploaded_file($param["arch_facturacion"]['tmp_name'], $destino))
		 {
		  
			 $subio = true;
		 }
		 else
		 { 
			 $subio = false;
		 } 
		  
		  $_SESSION["arch_facturacion_aplicado"] = $nombre_archivo;
    } 
	else
	{
		  $subio = true; 
	}

	$ha_procesado_archivo = false;

	if($subio) 
	{ 
		if ($ext <> '.txt')
		{ 
			$errores_al_subir .=" Formato de archivo incorrecto, debe ser txt"; 
			$subio=false;
		}
	} 
	else 
	{ 
		$errores_al_subir.= "No se logró subir el Archivo"; 
	}
	
	?>
	<table width="90%"  id="formulario" >
    <form  name='formu' enctype='multipart/form-data' method='post' action='' target='_self'>
    <?
    inputFormHidden('procesar','1'); 
	inputFormHidden('operacion','generar');
	inputFormHidden('id_lote',$param["id_lote"]);
	tituloForm(array('titulo'=>"VISTA PREVIA FACTURACI&Oacute;N CONSUMO") ) ;
	labelTabla(2, "Archivo seleccionado:&nbsp;".$_SESSION["arch_facturacion_aplicado"], 25);
	trtd("", "height='5'");
	trtd("", "id='info_faltantes'");
	lineaSeparador(2);
	
	if(!$subio)
	{
		trtd("", "height='10'");
		labelTabla(2, "ERROR:&nbsp;".$errores_al_subir, 25);
	}

	inputFormBotonera( $parametros = array('dondeIrAlSalir'=>"TMfacturacion_consumo.php"  ,  'accionSalir'=>"salirAmenu", 'texto' => "Generar" )); 
    ?>
    </form>
    </table>
    
    <br />
    <?
    if(!$subio)
	{
		exit();
	}
	?>
   <table width="90%" border="1" align="center" cellpadding="2" cellspacing="2" class="DetallePagos" >
	<tr height="25">
	  <th class=listadoTitulo>Nro</th>
      <th class=listadoTitulo>C&oacute;digo</th>
	  <th class=listadoTitulo>Cliente</th>
	  <th class=listadoTitulo>Neto</th>
      <th class=listadoTitulo>Iva</th>
      <th class=listadoTitulo>Total</th>
	  <th class=listadoTitulo>&nbsp;</th>
	</tr>
	<?
	$cant = 0;
	$total = 0;
	$existe = false;
	foreach($lines as $line_num => $line)
	{
	  	$campos = explode("|", $line);

		// HEADER
		if($campos[0] == "H")
		{
			if($cant > 0 && $existe == true)
			{
				$tipo_fac = "B";
				if($id_sitiva == 1)
				{
					$tipo_fac = "A";
				}
				
				// en el archivo de texto viene atoooooooooodo SIN IVA
				$alicuota = 0;
				$iva = 0;


//				$iva = ($imp_fac * $alicuota) / 100;			
				$total = $total + $imp_fac;
				$importe = $imp_fac + $iva;
				
				$rsUpd["id_ctacte_mae"] = $id_ctacte;
				$rsUpd["codigocta"] = $idcliente;
				$rsUpd["titular"] = $titular; 	
				$rsUpd["neto"] = ($imp_fac+$neto);
//				$rsUpd["iva"] = ($iva+$iva1); 	
				$rsUpd["importe"] = ($importe+$importe_a); 	
				$rsUpd["id_lotes_facturacion"] = $param["id_lote"];
				$rsUpd["fecha"] = date("d/m/Y");
				$rsUpd["factura"] = $tipo_fac; 
				$rsUpd["id_session"] = session_id();
				//actualizar_tabla("tmp_facturacion_consumo",0,'','','','',$rsUpd);

				$imp_fac = 0;
			}
		
			$idcliente = $campos[5];

			$idsql;// = ejecuta_consulta("SELECT", "ctacte_mae", " codigocta = '".$idcliente."'");
			$existe = false;
			//if(mysql_num_rows($idsql)>0) 
			if(false) 
			{
				$cant++; 
				$existe = true;
				while($row = mysql_fetch_array($idsql))
				{
					$id_ctacte = $row['id'];
					$titular = $row['titular'];
					$id_sitiva = $row['id_sitiva'];
					
					$campos = "id, importe, iva1, neto ";
					$tabla = "ctacte_mov";
					$where = " id_ctacte = ".$id_ctacte; 
					//$where = " id_ctacte = 9938238"; 
					$where .= " and id_lotes_facturacion = ".$param["id_lote"]; 
			
					$rs_comp;// = ejecuta_consulta("SELECT_RS", $tabla, $where, $campos);
					$importe_a = $rs_comp["neto"];
			// solo tomo el valor neto , cuando busco el abono en la cta cte
//					$iva1 = $rs_comp["iva1"];
					$neto = $rs_comp["neto"];
				}
			} 
			else
			{
				$faltantes[] = $idcliente;
			}
		} 
		    
		// DETAIL
		if($campos[0] == "D")
		{
			if($campos[1] <> "PY ABONO")
			{
				$val3 = str_replace(",", ".", $campos[6]);
				if($val3 == NULL) { $val3 = 0;}
				$imp_fac = $imp_fac + $val3;
			}
		} 
  
	} // FIN FOR
	$tablas = "tmp_facturacion_consumo";
	$where = " id_lotes_facturacion = ".$param["id_lote"];
	$where .= " AND id_session = '".session_id()."'";
	$where .= " ORDER BY factura, titular ";
	$idsql; // = ejecuta_consulta("SELECT", $tablas, $where);
	$cant = 0; 
	$factura = "";
	//while($row = mysql_fetch_array($idsql))
	while(false)
	{
		$cant++; 
		if($factura <> $row["factura"])
		{
			$factura = $row["factura"];
	?>
    	<tr height="25">
                  <td colspan="7"><h2>Factuas&nbsp;<?=$row["factura"]?></h2></td>
		</tr>
    <?
		}
	?>			
    		<tr height="25">
                  <td><?=$cant?></td>
                  <td><?=$row["codigocta"]?></td>
                  <td><?=$row["titular"]?></td>
                  <td><?=conDecimales($row["neto"])?></td>
                  <td><?=($row["iva"] > 0) ? conDecimales($row["iva"]) : ""?></td>
                  <td><?=conDecimales($row["importe"])?></td>
                  <td>&nbsp;</td>
			</tr>
    <?
	}
	
	?>
    <tr height="20">
	  <th  align="right" colspan="4"class=listadoTitulo>Importe Total:</th>
	  <th align="right"  class=listadoTitulo id="totdeuda"><? con_decimales($total);?></th>
	  <th align="center" class=listadoTitulo colspan="2">&nbsp;</th>
	</tr>
    <tr height="20">
	  <th  align="right" colspan="4"class=listadoTitulo>Cantidad Total de Registros Válidos:</th>
	  <th align="right"  class=listadoTitulo id="totdeuda"><?=$cant?></th>
	  <th align="center" class=listadoTitulo colspan="2">&nbsp;</th>
	</tr>
    </table>
    <script language="javascript">
		
		mostrarFaltantes(<?=json_encode($faltantes)?>);
		
	</script>
    <?
	
	$where = " id_lotes_facturacion = ".$param["id_lote"];
	$where .= " AND id_session = '".session_id()."'";
	//ejecuta_consulta("DELETE", "tmp_facturacion_consumo", $where);
}

function generar($param)
{


	$puestoVentaComprobante = valorCampo("sucursales_pvta","ptovta",$_SESSION["id_sucursal_activa"],'id');

	//$file1 = $param["arch_facturacion"]['tmp_name'];
	$file1 = "tmp/".$_SESSION["arch_facturacion_aplicado"];
	
	$id_ctacte = 0;
	
	$lines = file($file1);
	$existe = false;
	foreach($lines as $line_num => $line)
	{
	  	$campos = explode("|", $line);

		
		// HEADER
		if($campos[0] == "H")
		{
			$idcliente = $campos[5];
			$idsql = ejecuta_consulta("SELECT", "ctacte_mae", " codigocta = '".$idcliente."'");
		
			if(mysql_num_rows($idsql)>0) 
			{
				$existe = true;
				while($row = mysql_fetch_array($idsql))
				{
					$id_ctacte = $row['id'];
				}
			} 
			else
			{
				$existe = false;
			}
		} 
		    
		// DETAIL
		if($campos[0] == "D" && $existe == true)
		{
		
// excluye el abono

			if($campos[1] <> "PY ABONO")
			{
				$rs_cn = ejecuta_consulta("SELECT_RS", "concepto_consumo", " codigo = '".$campos[1]."'");
				$idconcepto = $rs_cn["id"];
				
				$val1 = str_replace(",", ".", $campos[4]);
				$val2 = str_replace(",", ".", $campos[5]);
				$val3 = str_replace(",", ".", $campos[6]);
				$val4 = str_replace(",", ".", $campos[7]);
				if($val1 == NULL) { $val1 = 0;}
				if($val2 == NULL) { $val2 = 0;}
				if($val3 == NULL) { $val3 = 0;}
				if($val4 == NULL) { $val4 = 0;}
					
				// INSERTA CONSUMOS
				$rsUpd["id_ctacte_mae"] = $id_ctacte;
				$rsUpd["fecha_carga"] = date("d/m/Y"); 	
				$rsUpd["id_concepto_consumo"] = $idconcepto;
				$rsUpd["fecha_ini"] = $campos[2]; 	
				$rsUpd["fecha_fin"] = $campos[3]; 	
				$rsUpd["llamadas"] = $val1;
				$rsUpd["minutos"] = $val2;
				$rsUpd["valor"] = $val3; 	
				$rsUpd["c4"] = $val4;
				$rsUpd["id_lotes_facturacion"] = $param["id_lote"];
				actualizar_tabla("consumos",0,'','','','',$rsUpd);
			}
		} 
  
	} // FIN FOR
	
	$campos = " nombre ";
	$tabla = "lotes_facturacion";
	$where = " id = ".$param["id_lote"]; 

	$rs_lotefac = ejecuta_consulta("SELECT_RS", $tabla, $where, $campos);
	

// saca el valor de consumos por cta cte
	$campos = " sum(valor) total, id_ctacte_mae ";
	$tabla = "consumos";
	$where = " id_lotes_facturacion = ".$param["id_lote"]; 
	$where .= " Group By id_ctacte_mae "; 
	
	$idsql = ejecuta_consulta("SELECT", $tabla, $where, $campos,1);
		
	$total_consumo = 0;
	$cant_consumo = 0;
	
	while($rs = mysql_fetch_array($idsql))
	{		
		$campos = " cm.envia_factura, cm.fecha_alta, ugs.descripcion as servicio, cm.id_moneda_costo, cm.id_sitiva  ,  ugs.incluye_iva,  ug.alicuota  ";
		$tabla = "ctacte_mae cm ";
		$tabla .= " left join ugestion_mae_servicios ugs on cm.id_ugestion_mae_servicios = ugs.id   ";
		$tabla .= " left join ugestion_mae ug on cm.id_ugestion_mae = ug.id   ";

		$where = " cm.id = ".$rs["id_ctacte_mae"]; 
		$rs_cta = ejecuta_consulta("SELECT_RS", $tabla, $where, $campos);
	
		$ServicioFacturado = $rs_cta["servicio"]." / ".$rs_lotefac["nombre"];
	
		if($rs_cta["fecha_alta"] <> '0000-00-00') // SE GENERA COMPROBANTE SOLO PARA CLIENTES ACTIVOS 
		{

// BUSCA TODOS LOS MOVIMIENTOS DE LOTE 

			$campos = "*";
			$tabla = "ctacte_mov";
			$where = " id_ctacte = ".$rs["id_ctacte_mae"]; 
			$where .= " and id_lotes_facturacion = ".$param["id_lote"]; 
			$where .= " and es_abono = 1 "; 
			
			$rs_comp = ejecuta_consulta("SELECT_RS", $tabla, $where, $campos);
			
			if($rs_comp["id"]  > 0 )
			{
				$NroComprobante = $rs_comp["nrocpb"];
				$tipomov = $rs_comp["id_ctacte_tipomov"]; 
				$letraCpb = $rs_comp["letracpb"];
				$ServicioFacturado = $rs_comp["referencia"];
			}
			else
			{
			  echo "<BR><H1>ERROR - VIENE UN CONSUMO DE UNA CUENTA QUE NO EXISTE O NO ESTA ACTIVA</H1>";
			}		
	
	// importe base del consumo SIN IVA
	
			$importe = $rs["total"];
		
			if($rs["id_moneda_costo"] == 7)
			{
				$importe = $importe * $param["cotizacion"];
			}
			
		// tomo la alicuota del comprobante padre
			$alicuota = $rs_comp["alicuota1"];
			$iva = ($importe * $alicuota) / 100;

			$importe_total = $importe + $iva;
			
			if ($importe_total > 0  )
			{
				$rsUpd=array();
				// INSERTA FACTURA EN LA CUENTA CORRIENTE 
				$rsUpd["id_ctacte"] = $rs["id_ctacte_mae"];
				$rsUpd["id_ctacte_tipomov"] = $tipomov;
				$rsUpd["letracpb"] = $letraCpb; 	
				$rsUpd["referencia"] = $ServicioFacturado; 	
				$rsUpd["nrocpb"] = $NroComprobante; 	
				$rsUpd["puestocpb"] = $puestoVentaComprobante; 	
				$rsUpd["fecha"] = date("d/m/Y");
				$rsUpd["fecha_contable"] = date("d/m/Y");
				$rsUpd["importe"] = $importe_total; 	
				$rsUpd["saldo"] = $importe_total;
				$rsUpd["neto"] = $rs["total"];
				$rsUpd["id_lotes_facturacion"] = $param["id_lote"];
				$rsUpd["iva1"] = $iva;
				$rsUpd["alicuota1"] = $alicuota;


				$id_nuevo_ord = actualizar_tabla("ctacte_mov",0,'','','','',$rsUpd);
				
				$total_consumo = $total_consumo + $importe_total;;
				
				$cant_consumo = $cant_consumo + 1;
				
				// ASOCIA FACTURA A DETALLE DE CONSUMOS
				$where = " id_ctacte_mae = ".$rs["id_ctacte_mae"]." and id_lotes_facturacion = ".$param["id_lote"];
				$campos = " id_ctacte_mov = '".$id_nuevo_ord."'";
				ejecuta_consulta("UPDATE","consumos",$where, $campos);
			}		
		}// fin if fecha alta
	}	
	
	$where = " id = ".$param["id_lote"];
	$campos = " cant = cant + ".$cant_consumo.", ";
	$campos .= " total = total + ".$total_consumo.", ";
	$campos .= " saldo = saldo + ".$total_consumo;
	ejecuta_consulta("UPDATE","lotes_facturacion",$where, $campos);
	
	// SE BORRA ARCHIVO DE DIRECTORIO TEMPORAL
	unlink($file1);
}
?>