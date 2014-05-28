<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo $nom_sistema ?></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
		<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="js/funciones.js" type="text/javascript"></script>
    <script language="javascript">	
		function salir()
		{
			window.close();
		}
		
		function validarFormulario()
		{
			if($.trim($("#arch_facturacion").val()) == "")
			{
				$("#mensaje").text("Debe ingresar un archivo.");
				setTimeout("$('#mensaje').text('')",3000);
				return false;
			}
			document.formu.submit();
		}
		
		function generar()
		{
			document.formu.submit();
		}
		
		function mostrarErrores(errores)
		{
			if(errores.length > 0)
			{ 
				var texto = "Los siguientes registros possen error:<br><br>";
				var cont = 0;
				var salto = "";
				for(var i=0; i<errores.length; i++)
				{
					salto = "";
					cont++;
					if(cont == 8)
					{
						salto = "<br>";
						cont = 0;
					}
					texto+= " "+errores[i]+" -"+salto;
				}
				$("#info_errores").html(texto);
			}
			
		}
	</script>
</head>
<body>
<table border="0" align="center" width="100%" height="70" cellpadding="0" cellspacing="0" class="cabecera" >
        	<tr>
            	<td height="66" align="left" valign="bottom">
                	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                    	<tr>
                        	<td>
                			<font class="tituloSistema"><?php echo $nom_sistema ?></font>
                    		</td>
                            <td align="right">
                            <!--<div class="userlogin" onClick="cambiarClave()">	<? //echo($_SESSION["idusuario"]) ?></div>--->
                            </td>
                            <td align="right" width="25">
                            <!--
                            <div style="cursor:pointer; position:relative; margin-right:10px;" onClick="salirSistema()">
                            	<img src="images/salir.png" title="Salir" alt="Salir">
                            </div>
                            -->
                            </td>
                    	</tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td height="4" align="left" valign="bottom">
                
                </td>
            </tr>
        </table>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
            <tr>
                <th align="left" height="30">&nbsp;Carga Masiva</th>
                <th></th>
                <th></th>
            </tr>
         </table>
 	</td>
</tr>
<tr>
	<td valign="middle" height="25">
         <span id="mensaje" ></span>
	</td>
</tr>
<tr>
	<td>  
 <div id="datos" style="">
 <?
if (!$_REQUEST["procesar"])
{
	Parametros($param);
}
else
{
	//include("includes/funciones/funciones.php");
	$param = array("arch_facturacion"=>$_FILES["arch_facturacion"]);
	
	if($_REQUEST["operacion"] == "preview")
	{
		listado($param);
	}
	if($_REQUEST["operacion"] == "generar")
	{
		generar($param);
	}
}
?>
</div>
	</td>
</tr>
</table>
</body>
</html>
<?

function generar($param)
{
	//$file1 = $param["arch_facturacion"]['tmp_name'];
	$file1 = "tmp/".$_SESSION["arch_facturacion_aplicado"];
	
	$lines = file($file1);
	$existe = false;
	$cant = 0;
	foreach($lines as $line_num => $line)
	{
	  	 $campos = explode(";", $line);

		// VALIDACIONES 
		$ok = true;
		if(false) 
		{
			$errores[] = $campos[0];  	
			$ok = false;
		}
		
		// SE INSERTAN REGISTROS VALIDADOS OK
		if($ok == true)
		{
			$sql = " INSERT INTO tabla_final_proceso (dato_1, dato_2, dato_3, dato_4, dato_5, session_id) " ;
			$sql .= " VALUES ";
			$sql .= " ('".$campos[0]."', '".$campos[1]."', '".$campos[2]."', '".$campos[3]."', '".$campos[4]."', '".session_id()."') " ;
			//echo("<br>sql: ".$sql);
			//consulta($sql);
			$cant ++;
		}
	} // FIN FOR
	
	// SE BORRA ARCHIVO DE DIRECTORIO TEMPORAL
	unlink($file1);
	
	?>
     <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
     <tr>
     	<th>
        	SE REALIZO LA CARGA MASIVA
        </th>
     </tr>
     <tr>
     <td style="border-bottom:solid; border-bottom-width:1px; border-bottom-color:#666666;" height="10"></td>
     	
     </tr>
     <tr>
     	<td align="left" valign="middle" height="15">
        Cantidad de registros generados: <?=$cant?>
        </td>
     </tr>
      <tr>
     <td style="border-bottom:solid; border-bottom-width:1px; border-bottom-color:#666666;" height="10"></td>
     	
     </tr>
     <tr>
     	<td align="center" valign="middle" height="15">
        
        </td>
     </tr>
       <tr>
     	<td align="center" valign="middle" height="25">
		<input type='button' value='Aceptar' onClick='salir()' class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
        </td>
     </tr>
     <tr>
     	<td align="center" valign="middle" height="15">
      
        </td>
     </tr>
     </table>
    <?
}

function listado($param)
{
	$file1 = $param["arch_facturacion"]['tmp_name'];
	$lines = file($file1);
	$errores = array();
	
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
			$errores_al_subir .=" Formato de archivo incorrecto, debe ser txt (".$ext.")"; 
			$subio=false;
		}
	} 
	else 
	{ 
		$errores_al_subir.= "No se logró subir el Archivo"; 
	}
	
	?>
	
    <form  name='formu' enctype='multipart/form-data' method='post' action='' target="_self" >
     <input type="hidden" name="procesar" id="procesar" value="1" /> 
	 <input type="hidden" name="operacion" id="operacion" value="generar" /> 
     <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
     <tr>
     	<th>
        	VISTA PREVIA CARGA MASIVA
        </th>
     </tr>
     <tr>
     	<td>
        	<div id="info_errores"></div>
        </td>
     </tr>
     <tr>
     	<td>
        	<?
            if(!$subio)
			{
				echo("ERROR:&nbsp;".$errores_al_subir);
			}
			?>
        </td>
     </tr>
     <tr>
     	<td align="center" valign="middle" height="25">
        	<input type='button' value='Generar ' onClick='generar();' class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' /> 
		<input type='button' value='Salir' onClick='salir()' class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
        </td>
     </tr>
     <tr>
     	<td align="center" valign="middle" height="15">
        
        </td>
     </tr>
     </table>
      
    </form>
    
    
    <br />
    <?
    if(!$subio)
	{
		exit();
	}
	?>
   <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2"  bgcolor="#FFFFFF">
	<tr height="25" class="cabecera_listado">
	  <th ><font class="titulolistado">Nro</font></th>
      <th ><font class="titulolistado">Dato_1</font></th>
	  <th ><font class="titulolistado">Dato_2</font></th>
	  <th ><font class="titulolistado">Dato_3</font></th>
      <th ><font class="titulolistado">Dato_4</font></th>
      <th ><font class="titulolistado">Dato_5</font></th>
	  <th >&nbsp;</th>
	</tr>
	<?
	$cant = 0;
	$existe = false;
	foreach($lines as $line_num => $line)
	{
	  	$campos = explode(";", $line);

		// VALIDACIONES 
		$ok = true;
		if(false) 
		{
			$errores[] = $campos[0];  	
			$ok = false;
		}
		
		// SE INSERTAN REISTROS VALIDADOS OK
		if($ok == true)
		{
			$sql = " INSERT INTO tmp_carga_masiva (dato_1, dato_2, dato_3, dato_4, dato_5, session_id) " ;
			$sql .= " VALUES ";
			$sql .= " ('".$campos[0]."', '".$campos[1]."', '".$campos[2]."', '".$campos[3]."', '".$campos[4]."', '".session_id()."') " ;
			//echo("<br>sql: ".$sql);
			consulta($sql);
		}
		
	} // FIN FOR
	
	$sql = " SELECT dato_1, dato_2, dato_3, dato_4, dato_5 ";
	$sql .= " FROM tmp_carga_masiva ";
	$sql .= " WHERE session_id = '".session_id()."'";
	$sql .= " ORDER BY dato_1 ";
	
	//echo("<br>sql: ".$sql);
	$idsql = consulta($sql);
	
	$cant = 0; 
	
	while($rs = mysql_fetch_array($idsql))
	{
		$cant++; 
	?>
    	<tr height="25">
        	<td><?=$cant?></td>
        	<td><?=$rs["dato_1"]?></td>
            <td><?=$rs["dato_2"]?></td>
            <td><?=$rs["dato_3"]?></td>
            <td><?=$rs["dato_4"]?></td>
            <td><?=$rs["dato_5"]?></td>
            <td>&nbsp;</td>
		</tr>
        <tr bgcolor="#FFFFFF" >
    	<td colspan="7" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
		</tr>
     <?
     }
	 ?>
    <tr height="20">
	  <th  align="right" colspan="4">Cantidad Total de Registros Válidos:</th>
	  <th align="right"  id="totdeuda" colspan="3"><?=$cant?></th>
	</tr>
    </table>
    <script language="javascript">		
		mostrarErrores(<?=json_encode($errores)?>);
	</script>
    <?
	
	$sql = " DELETE FROM tmp_carga_masiva WHERE session_id = '".session_id()."'";
	//echo("<br>sql: ".$sql);
	consulta($sql);
	
}

function Parametros()
{
	?>
	<form name='formu' enctype='multipart/form-data' method='post' action='' target='_self'>
	 <input type="hidden" name="procesar" id="procesar" value="1" /> 
	 <input type="hidden" name="operacion" id="operacion" value="preview" /> 
	 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	    <tr>
		    <td colspan="1" align="right">
        	    ARCHIVO:
        	</td>
			<td colspan="2" align="left">
            <input type='file' id='arch_facturacion' name='arch_facturacion' />			
        </td>
    </tr>
    <tr>
    	<td colspan="3" align="center" valign="middle" height="30">
        <input type='button' value='Aceptar ' onClick='validarFormulario();' class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' /> 
		<input type='button' value='Salir' onClick='salir()' class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
        </td>
    </tr>
    <tr>
    	<td colspan="3" align="center" valign="middle" height="15">
        
        </td>
    </tr>
	</table>
	</form>
	<?
}


?>