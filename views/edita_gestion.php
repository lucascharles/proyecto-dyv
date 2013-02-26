<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
    <script language="javascript">
		$(document).ready(function(){
  			$('form').validator();
			document.getElementById("txtdestipdoc").focus()
		});
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			document.getElementById("txtdestipdoc").focus()
			$(document.getElementById("txtdestipdoc")).removeClass('notFilled');
		}
		
		function salir()
		{
			$("#pagina").load('views/admin_tipodocumento.php');
		}
		
		function grabar()
		{
			if(($.trim($("#selGestion").val()) != "")
				&&($.trim($("#txtfechagestion").val()) != "")
				&&($.trim($("#txtcomentarios").val()) != "")
				&&($.trim($("#selMandantes").val()) != "")
				&&($.trim($("#txtfechaproxgestion").val()) != "")
				&&($.trim($("#txtusuario").val()) != ""))
			{
				var datos = "controlador=Gestiones";
				datos += "&accion=grabaEditar";
				datos += "&idgestion="+$("#id_gestion").val();
				datos += "&selGestion="+$("#selGestion").val();
				datos += "&txtfechagestion="+$("#txtfechagestion").val();
				datos += "&txtcomentarios="+$("#txtcomentarios").val();
				datos += "&selMandantes="+$("#selMandantes").val();
				datos += "&txtfechaproxgestion="+$("#txtfechaproxgestion").val();
				datos += "&txtusuario="+$("#txtusuario").val();

				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{						
						document.getElementById("frmlistagestiones").src="index.php?controlador=Gestiones&accion=listar_bitacora_gestion&iddeudor="+$("#id_gestion").val();
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
							}
		}

		function grabarDir()
		{
			if($.trim($("#iddireccion").val()) != "")
			{
				var datos = "controlador=Gestiones";
				datos += "&accion=grabaEditarDir";
				datos += "&iddireccion="+$("#idgestion").val();

				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{						
						document.getElementById("frmdireccion").src="index.php?controlador=Gestiones&accion=grabarDir&iddireccion="+$("#iddireccion").val();
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
							}
		}
		function fechaGestion(){
			document.getElementById("txtfechagestion").value = "<?php echo date("d-m-Y H:i"); ?>";
		}


		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}

		function seleccionado_dir(id)
		{
			document.getElementById("iddireccion").value = id;
		}
		
	</script>
</head>
<body>
<form name="frmadmgestion">
	<input  type="hidden" name="id_gestion" id="id_gestion" value="<? echo($objGestion->get_data("id_gestion")) ?>"/>
	<input  type="hidden" name="iddireccion" id="iddireccion" value=""/>
<div id="datos" style="">

  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Deudor - Mandatario</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr></tr>
    <tr>
		<td align="right" class="etiqueta_form" width="20">Mandante:</td><td>&nbsp;&nbsp;&nbsp;
			<input type="text" name="txtmandatario" id="txtmandatario" value="<? $var = &$rutMandante; echo($var); ?>" size="10" />&nbsp;
        	<input type="text" name="txtmandantenombre" id="txtmandantenombre" value="<? $var = &$nomMandante; echo($var); ?>" size="40"/>&nbsp;
       	</td>
    </tr>
	
    <tr>
		<td align="right" class="etiqueta_form" width="20">Deudor:</td><td>&nbsp;&nbsp;&nbsp;
    		<input type="text" name="txtrutdeudor" id="txtrutdeudor" value="<? $var = &$rutDeudor; echo($var); ?>" size="10" />&nbsp;
    		<input type="text" name="txtdeudornombre" id="txtdeudornombre" value="<? $var = &$nomDeudor; echo($var); ?>" size="40" />
    	</td>
	</tr>
    <tr>
        <td colspan="3">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
</table>
</div>


<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Deuda Neta</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<table width="100%" height="120" align="center" border="0" cellpadding="0" cellspacing="0">
     <tr>
     	<td>
     		<table>
				<tr>
					<td align="right" class="etiqueta_form" width="20">Monto(neto):</td><td>&nbsp;&nbsp;&nbsp;
        				<input type="text" name="txtmontodeuda" id="txtmontodeuda" value="<? $var = &$deudaNeta; echo($var); ?>" size="20" />
        			</td>
        		</tr>
        		<tr>
					<td align="right" class="etiqueta_form" width="20">Monto(Mandante):</td><td>&nbsp;&nbsp;&nbsp;
        				<input type="text" name="txtmontodeudaMandante" id="txtmontodeudaMandante" value="<? $var = &$deudaNetaMandante; echo($var); ?>" size="20" />
        			</td>
        		</tr>
        	</table>
        </td>
        <td >
        	<table>
        		
        		<tr>
        				<iframe id="frmlistdocumentos" src="index.php?controlador=Gestiones&accion=listarDocumentos&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>" frameborder="0" align="middle" width="80%" height="75" scrolling="auto"></iframe>
        		</tr>

        	</table>
        </td>
        <td align="left" >
			<table>
        		<tr>
					<input  type="button" name="btnLiquidacion" id="btnLiquidacion" onclick="verLiquidacion()" class="boton_form" value="Liquidacion" style=""/>
				</tr>
			</table>
        </td>
    </tr>
</table>

</div>

<div id="datos" style="">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="center" height="30">&nbsp;Direcciones</th>
        <th></th>
        <th align="center" height="30">&nbsp;&nbsp;&nbsp;&nbsp;Demandas</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
	     <th></th>
    </tr>
    <tr>
		<td >
        	<iframe id="frmdireccion" src="index.php?controlador=Gestiones&accion=listar_dir&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>" frameborder="0" align="middle" width="80%" height="75" scrolling="auto"></iframe>
         <input  type="button" name="btngrabardir" id="btngrabardir" onclick="grabarDir()" class="boton_form" value="Grabar" style=""/>
        </td>
        <td >
        	<iframe id="frmdemandas" src="index.php?controlador=Gestiones&accion=listar_demandas&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>" frameborder="0" align="middle" width="80%" height="75" scrolling="auto"></iframe>
        </td>
	</tr>
</table>
</div>

<div id="datos" style="">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Gestiones</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    </tr>
    <tr>
		<td >
        	<iframe id="frmlistagestiones" src="index.php?controlador=Gestiones&accion=listar_bitacora_gestion&idgestion=<? echo($objGestion->get_data("id_gestion")) ?>" frameborder="0" align="middle" width="100%" height="100" scrolling="auto"></iframe>
        </td>
	</tr>
</table>


<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
    <tr></tr>
    <tr class="cabecera_listado" >
    	
		<th align="center"><font class="titulolistado">Gestion</font></th>
        <th align="center"><font class="titulolistado">Fecha Gestion</font></th>
        <th align="center"><font class="titulolistado">Comentarios</font></th>
        <th align="center"><font class="titulolistado">Mandantes</font></th>
        <th align="center"><font class="titulolistado">Prox. Gestion</font></th>
        <th align="center"><font class="titulolistado">Usuario</font></th>
        <th align="center"><font class="titulolistado"></font></th>
    </tr>
   
    <tr>
        <td> 
        	<select name="selGestion" valida="requerido" tipovalida="texto" id="selGestion" onchange="validarUsuario()" >
     			<option value=""> ----Seleccione----</option>
        		<?
			        for($j=0; $j<$coleccionEstadoGestion->get_count(); $j++)
			        {
			            $datoTmp = &$coleccionEstadoGestion->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_estado_doc").">".utf8_encode($datoTmp->get_data("estado"))."</option>");           
			        }
    			?>
			</select>
        </td>
        
        <td> <input type="text" name="txtfechagestion" id="txtfechagestion" value="<?php echo date("d-m-Y H:i"); ?>" size="18" valida="requerido" tipovalida="texto"/><span id="msj_error_txtdestipdoc" class="msjdato_incomp"></span></td>
        
        <td> <input type="text" name="txtcomentarios" id="txtcomentarios" value="" onfocus="fechaGestion()" size="70" valida="requerido" tipovalida="texto"/><span id="msj_error_txtdestipdoc" class="msjdato_incomp"></span></td>
        
        <td> 
        	<select name="selMandantes" valida="requerido" tipovalida="texto" id="selMandantes" onchange="validarUsuario()" >
     			<option value=""> ----Seleccione----</option>
        		<?
			        for($j=0; $j<$coleccionMandantes->get_count(); $j++)
			        {
			            $datoTmp = &$coleccionMandantes->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_mandante").">".utf8_encode($datoTmp->get_data("rut_mandante"))."</option>");           
			        }
    			?>
			</select>
        </td>
        <td> <input type="text" name="txtfechaproxgestion" id="txtfechaproxgestion" value="<?php echo date("d-m-Y H:i"); ?>" size="18" valida="requerido" tipovalida="texto"/><span id="msj_error_txtdestipdoc" class="msjdato_incomp"></span></td>
        
        <td> <input type="text" name="txtusuario" id="txtusuario" value="" size="18" valida="requerido" tipovalida="texto"/><span id="msj_error_txtdestipdoc" class="msjdato_incomp"></span></td>
        
        <td> <input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()" class="boton_form" value="Grabar" style=""/></td>
        <td> </td>
    </tr>
    <tr>
        <td colspan="3">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
</table>
</div>



<div style="position:relative; margin-top:10px;">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <!-- 
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()"  value="Grabar" style=""/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiar()"value="Limpiar" style="" />
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"value="Cancelar" style="" />
         </td>
         -->
    </tr>
</table>
</div>
</form>
</body>
</html>