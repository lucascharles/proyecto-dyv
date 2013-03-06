<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
	<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script language="javascript">
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
						$("#mensaje").slideDown();
						setTimeout("limpiarMensaje()",3000);
						
					}
				});
		}
		
		function seleccionadoMandante(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosMandante(id);
			cerrarVentMand();
		}
		
		function mostrar(obj)
		{
			var url = "index.php?controlador=Mandantes&accion=listar";
			url += "&des_int="+$("#txtrut_m").val();
			url += "&desApel1="+$("#txtPrimerApel").val();
			url += "&desApel2="+$("#txtsapellido_m").val();
			url += "&desNomb1="+$("#txtPrimerNomb").val();
			url += "&desNomb2="+$("#txtsnombre_m").val();
			url += "&id_partida=0";
			
			document.getElementById("frmmandantes").src = url;
		}
		
		function ventanaBusqueda(op)
		{
			$("#selecMandante").slideDown(1000);	
			document.getElementById("txtrut_m").focus();
		}
		
		function cerrarVentMand()
		{
			$("#selecMandante").slideUp(1000);
		}
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
		
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			var url = "index.php?controlador=TipoDocumento&accion=listar";
			document.getElementById("frmlisttipdoc").src = url;
		}
		
		function buscar()
		{
			if($.trim($("#id_mandante").val()) == "")
			{
				$("#mensaje").text("Debe ingresar un mandante.");
				$("#mensaje").slideDown();
				setTimeout("limpiarMensaje()",3000);				
			}
			var url = "index.php?controlador=Informes&accion=listar&tipoInforme="+document.getElementById("selTipoInforme").value+"&idmandante="+document.getElementById("id_mandante").value;
				url = url+"&tipoDoc="+document.getElementById("selTipoDoc").value
			document.getElementById("frmlistinforme").src = url;
		}
/*
		function marcartodo()
		{

			var url = "index.php?controlador=Informes&accion=marcar&tipoInforme="+document.getElementById("selTipoInforme").value+"&idmandante="+document.getElementById("id_mandante").value;
			url = url+"&tipoDoc="+document.getElementById("selTipoDoc").value
			document.getElementById("frmlistinforme").src = url;
		}

		function desmarcartodo()
		{

			var url = "index.php?controlador=Informes&accion=listar&tipoInforme="+document.getElementById("selTipoInforme").value+"&idmandante="+document.getElementById("id_mandante").value;
			url = url+"&tipoDoc="+document.getElementById("selTipoDoc").value
			document.getElementById("frmlistinforme").src = url;
		}
*/
		
		function salir()
		{
			$("#pagina").load('views/defaultl.php');
		}
		
	</script>
</head>
<body>
<div id="selecMandante" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
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
<form name="frmadminformes">
<input  type="hidden" name="id_tipoinforme" id="id_tipoinforme" value=""/>
<input grabar="S" type="hidden" name="id_mandante" id="id_mandante" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Informes</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="datos" style="">

<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" >
    <tr></tr>
    <tr class="cabecera_listado" >
    	
		<th align="center"><font class="titulolistado">Tipo de Informe</font></th>
        <th align="center"><font class="titulolistado">Mandatario</font></th>
        <th align="center"><font class="titulolistado">Tipo Documento</font></th>
    </tr>
   
    <tr>
        <td > 
        	<select name="selTipoInforme" valida="requerido" tipovalida="texto" id="selTipoInforme"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
     			<option value="Judicial"><?print utf8_encode("Judicial")?></option>
     			<option value="Prejudicial"><?print utf8_encode("Prejudicial")?></option>
			</select>
        </td>
        
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

        <td> 
                        <select name="selTipoDoc" valida="requerido" tipovalida="texto" id="selTipoDoc" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
                            <option value=""><? print utf8_encode("----Seleccione----") ?></option>
                            <?
                                for($j=0; $j<$coleccion_tipoDoc->get_count(); $j++)
                                {
                                    $datoTmp = &$coleccion_tipoDoc->items[$j];
                                    echo("<option value=".$datoTmp->get_data("id_tipo_documento").">".utf8_encode($datoTmp->get_data("tipo_documento"))."</option>");           
                                }
                            ?>
                        </select>       
        </td> 
        
        <td>
        <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
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
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="100%">
	 
        	<iframe id="frmlistinforme" src="index.php?controlador=Informes&accion=listar&tipoInforme="+document.getElementById("selTipoInforme").value width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        	
        </td>
        <td width="">
        	<!--
        	<div style="position:relative; margin-left:10px;">
                  <input  type="button" name="btnmarcartodo" id="btnmarcartodo" onclick="marcartodo()"  value="Todos" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
                  <input  type="button" name="btndesmarcartodo" id="btndesmarcartodo" onclick="desmarcartodo()"  value="Ninguno" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
                  <input  type="button" name="btngenerar" id="btngenerar" onclick="generar()"  value="Generar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            </div>
            -->
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;&nbsp;
         </td>
    </tr>
     <tr>
		<td colspan="3"  height="10">
        
         </td>
    </tr>
</table>
</div>

</form>
</body>
</html>