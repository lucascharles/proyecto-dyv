<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
    <script language="javascript">
		$(document).ready(function(){
  			$('form').validator();
		});
		
		function ventanaBusqueda()
		{
			$("#selecMandante").slideDown(1000);	
			document.getElementById("txtrut_m").focus();
			//alert($(document).height());
			setTimeout("window.scrollTo(0,$(document).height())",1000);
			//$(window).scrollTop();
			 //$("html, body").animate({ scrollTop: $(document).height() }, "slow");
  //return false;
		}
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
		
		function cerrarVentMand()
		{
			$("#selecMandante").slideUp(1000);
		}
		function seleccionadoMandante(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosMandante(id);
			cerrarVentMand();
		}
		
		function buscarDatosMandante(id)
		{
			var datos = "controlador=Mandantes";
			datos += "&accion=getDatosMandante";
			datos += "&id_mandante="+id;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{		
						$("#txtrut_mandante").val(res[0]);
						$("#txtdv_mandante").val(res[1]);
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		
		function grabar()
		{
			if(($.trim($("#selGestion").val()) != "")
				&&($.trim($("#txtfechagestion").val()) != "")
				&&($.trim($("#txtcomentarios").val()) != "")
				&&($.trim($("#txtrut_mandante").val()) != "")
				&&($.trim($("#txtfechaproxgestion").val()) != "")
				&&($.trim($("#txtusuario").val()) != ""))
			{
				var datos = "controlador=Gestiones";
				datos += "&accion=grabaEditar";
				datos += "&idgestion="+$("#id_gestion").val();
				datos += "&selGestion="+$("#selGestion").val();
				datos += "&txtfechagestion="+$("#txtfechagestion").val();
				datos += "&txtcomentarios="+$("#txtcomentarios").val();
				datos += "&selMandantes="+$("#id_mandante").val();
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
<div id="selecMandante" style="position:absolute; margin-left:20px; width:95%; margin-top:60%; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#eee" cellpadding="5" cellspacing="5"> 
    	<tr>
        	<td height="" align="right">
            	<div onclick="cerrarVentMand()" style="cursor:pointer; font-weight:bold; color:#000099;"> cerrar </div>
            </td>
        </tr>
        <tr>
        <th align="left">Seleccionar Mandantes</th>
        </tr>
        <tr>
        <td height="10"> </td>
        </tr>
        <tr>
        	<td height="">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr> 
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_m" id="txtrut_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
                     </tr>
                     <tr>
                        
                        <td width="" align="left" height="15"></td>
                      
                    </tr>
                	<tr>
                        
                        <td width="" align="left" class="etiqueta_form">Primer Apellido:</td>
                        <td width="" align="left" class="etiqueta_form">Segundo Apellido:</td>
                        <td width="" align="left" class="etiqueta_form">Primer Nombre:</td>
                        <td width="70" align="left" class="etiqueta_form">Segundo Nombre:</td>
                    </tr>
                    
                    <tr> 
                        
                        
                        <td align="left"><input type="text" name="txtPrimerApel" id="txtPrimerApel"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsapellido_m" id="txtsapellido_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>  
                        <td align="left"><input type="text" name="txtPrimerNomb" id="txtPrimerNomb"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
                        <td align="left"><input type="text" name="txtsnombre_m" id="txtsnombre_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
        <tr>
        <th align="left">Mandantes disponibles</th>
        </tr>
    	<tr>
        	<td height="">
            	
	             <div id="datos" style="">
            	<iframe id="frmmandantes" src="index.php?controlador=Mandantes&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>
                </div>
            </td>
       </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
    </table>
    </td>
</tr>
</table>
</div>
<form name="frmadmgestion">
	<input  type="hidden" name="id_gestion" id="id_gestion" value="<? echo($objGestion->get_data("id_gestion")) ?>"/>
	<input  type="hidden" name="iddireccion" id="iddireccion" value=""/>
    <input  type="hidden" name="id_mandante" id="id_mandante" value=""/>
    
<div id="datos" style="">

  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Deudor - Mandatario</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td height="5">
        </td>
    </tr>
    <tr>
		<td align="right" class="etiqueta_form" width="20">Mandante:</td><td>&nbsp;&nbsp;&nbsp;
			<input type="text" name="txtmandatario" id="txtmandatario" value="<? $var = &$rutMandante; echo($var); ?>" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
        	<input type="text" name="txtmandantenombre" id="txtmandantenombre" value="<? $var = &$nomMandante; echo($var); ?>" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
       	</td>
    </tr>
     <tr>
    	<td height="5">
        </td>
    </tr>
	
    <tr>
		<td align="right" class="etiqueta_form" width="20">Deudor:</td><td>&nbsp;&nbsp;&nbsp;
    		<input type="text" name="txtrutdeudor" id="txtrutdeudor" value="<? $var = &$rutDeudor; echo($var); ?>" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
    		<input type="text" name="txtdeudornombre" id="txtdeudornombre" value="<? $var = &$nomDeudor; echo($var); ?>" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
    	</td>
	</tr>
     <tr>
    	<td height="5">
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
     	<td valign="top" colspan="2">
     		<table width="100%"  align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
					<td height="5" colspan="2"></td>
        		</tr>
				<tr>
					<td align="right" class="etiqueta_form" width="20">&nbsp;Monto(neto):</td><td>&nbsp;&nbsp;&nbsp;
        				<input type="text" name="txtmontodeuda" id="txtmontodeuda" value="<? $var = &$deudaNeta; echo($var); ?>"  class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        			</td>
        		</tr>
                <tr>
					<td height="5" colspan="2"></td>
        		</tr>
        		<tr>
					<td align="right" class="etiqueta_form" width="20">&nbsp;Monto(Mandante):</td><td>&nbsp;&nbsp;&nbsp;
        				<input type="text" name="txtmontodeudaMandante" id="txtmontodeudaMandante" value="<? $var = &$deudaNetaMandante; echo($var); ?>" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>
        			</td>
        		</tr>
        	</table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" height="5" >
        </td>
     </tr>
    <tr>
    	<td align="right" valign="top" >
        
        				<iframe id="frmlistdocumentos" src="index.php?controlador=Gestiones&accion=listarDocumentos&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>&id_partida=0" frameborder="0" align="middle" width="100%" height="120" scrolling="auto"></iframe>
        
        </td>
        <td align="center" width="100">
					<input  type="button" name="btnLiquidacion" id="btnLiquidacion" onclick="verLiquidacion()" class="boton_form" value="Liquidaci&oacute;n" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
			
        </td>
    </tr>
</table>

</div>

<div id="datos" style="">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="center" height="30">&nbsp;Direcciones</th>
        <th></th>
        <th align="center" ></th>
        <th></th>
        <th></th>
    </tr>
 </table>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

    <tr>
		<td >
        	<iframe id="frmdireccion" src="index.php?controlador=Gestiones&accion=listar_dir&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>" frameborder="0" align="middle" width="100%" height="120" scrolling="auto"></iframe>
        </td>
        <td width="100" >
        	&nbsp;
         <input  type="button" name="btngrabardir" id="btngrabardir" onclick="grabarDir()" class="boton_form" value="Grabar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
        </td>
	</tr>
</table>
</div>

<div id="datos" style="">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="center" height="30">&nbsp;Demandas</th>
        <th></th>
        <th align="center"></th>
        <th></th>
        <th></th>
    </tr>
 </table>
<table width="100%" align="center" border="1" cellpadding="0" cellspacing="0">
	<tr>
	     <th></th>
    </tr>
    <tr>
		<td >
            	<iframe id="frmdemandas" src="index.php?controlador=Gestiones&accion=listar_demandas&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>" frameborder="0" align="middle" width="80%" height="120" scrolling="auto"></iframe>
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
        	<iframe id="frmlistagestiones" src="index.php?controlador=Gestiones&accion=listar_bitacora_gestion&idgestion=<? echo($objGestion->get_data("id_gestion")) ?>" frameborder="0" align="middle" width="100%" height="120" scrolling="auto"></iframe>
        </td>
	</tr>
</table>
</div>

<div id="datos">

<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" >
<tr>
        <td colspan="6" height="5">
         </td>
    </tr>   
    <tr>
		<td align="center" class="etiqueta_form">Gestion</td>
        <td> 
        	<select name="selGestion" valida="requerido" tipovalida="texto" id="selGestion" onchange="validarUsuario()" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
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
        <td align="center" class="etiqueta_form">Fecha Gestion</td>
        <td> <input type="text" name="txtfechagestion" id="txtfechagestion" value="<?php echo formatoFecha(date("d-m-Y H:i"),"dd-mm-yyyy","dd/mm/yyyy") ?>" class="input_form_medio" valida="requerido" tipovalida="texto" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>
        </td>
        <td align="center" class="etiqueta_form">Comentarios</td>
        <td> <input type="text" name="txtcomentarios" id="txtcomentarios" value="" class="input_form" valida="requerido" tipovalida="texto" onFocus="fechaGestion(); resaltar(this);" onBlur="noresaltar(this)"/>
        </td>
    </tr>
    <tr>
        <td align="center" class="etiqueta_form">Mandantes</td>
        <td> 
        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="240">
						<input type="text" name="txtrut_mandante" id="txtrut_mandante" class="input_form" />&nbsp;
            			<input type="text" name="txtdv_mandante" id="txtdv_mandante" class="input_form_min" onblur="validarRut('M')" />
                    </td>
                	<td align="left">
			            <img src="images/buscar.png" title="Buscar Mandante" style="cursor:pointer" onclick="ventanaBusqueda()" />
                    </td>
                </tr>
             </table>
        </td>
        <td align="center" class="etiqueta_form">Prox. Gestion</td>
        <td> <input type="text" name="txtfechaproxgestion" id="txtfechaproxgestion" value="<?php echo formatoFecha(date("d-m-Y H:i"),"dd-mm-yyyy","dd/mm/yyyy") ?>" class="input_form_medio" valida="requerido" tipovalida="texto" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>
        </td>
        <td align="center" class="etiqueta_form">Usuario</td>
        <td> <input type="text" name="txtusuario" id="txtusuario" value="" class="input_form_medio" valida="requerido" tipovalida="texto" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
    </tr>   
    <tr>
        <td colspan="6" height="5">
         </td>
    </tr>   
    
</table>
</div>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        <input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()" class="boton_form" value="Grabar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>

    </tr>
</table>

</form>
</body>
</html>