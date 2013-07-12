<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
    <script src="js/funciones.js" type="text/javascript"></script>
    <script language="javascript">
		$(document).ready(function(){
			
  			$('form').validator();
			document.getElementById("txtrut_mandante").focus();
			borrarTemporalContactos();		
		});
		
		function borrarTemporalContactos()
		{
			var datos = "controlador=Mandantes";
				datos += "&accion=borrartmp";
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						document.getElementById("frmcontacto").src="index.php?controlador=Mandantes&accion=listar_contmp";
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
				
		function limpiarAltaMand()
		{
			$("#txtrut_mandante").val("");
			$("#txtdv_mandante").val("");
			$("#txtapellido").val("");
			//$("#txtnombre").val("");
			$("#txtcalle").val("");
			$("#txtnumero").val("");
			$("#txtpiso").val("");
			$("#txtdpto").val("");
			$("#txtcomuna").val("");
			$("#txtciudad").val("");
			$("#txtregion").val("");
			$("#txttelefono1").val("");
			$("#txttelefono2").val("");
			$("#txtcuenta_corriente1").val("");
			document.getElementById("selbanco1").selectedIndex = 0;
			$("#txtcuenta_corriente2").val("");
			document.getElementById("selbanco2").selectedIndex = 0;
		}
		
		
		function salirAltaMand()
		{
			$("#pagina").load('views/admin_mandantes.php');
		}
		
		function grabarAltaMand()
		{
		
			var arrayin = new Array(14);
			
			arrayin[0] = document.getElementById("txtrut_mandante");
			arrayin[1] = document.getElementById("txtdv_mandante");
			arrayin[2] = document.getElementById("txtapellido");
			//arrayin[3] = document.getElementById("txtnombre");
			arrayin[3] = document.getElementById("txtcalle");
			arrayin[4] = document.getElementById("txtnumero");
			arrayin[5] = document.getElementById("txtpiso");
			arrayin[6] = document.getElementById("txtdpto");
			arrayin[7] = document.getElementById("txtcomuna");
			arrayin[8] = document.getElementById("txtciudad");
			arrayin[9] = document.getElementById("txtregion");
			arrayin[10] = document.getElementById("txtcuenta_corriente1");
			arrayin[11] = document.getElementById("txtcuenta_corriente2");
			arrayin[12] = document.getElementById("txttelefono1");
			arrayin[13] = document.getElementById("txttelefono2");
			
			var arraySel = new Array();
			arraySel[0] = document.getElementById("selbanco1");
			arraySel[0] = document.getElementById("selbanco2");
			
//			if(!validarArray(arrayin, arraySel,"N"))
//			{
//				return false;
//			}
				
				
				var datos = "controlador=Mandantes";
				datos += "&accion=grabar";
				
			    datos += "&rut_mandante="+$("#txtrut_mandante").val();
				datos += "&dv_mandante="+$("#txtdv_mandante").val();
				datos += "&apellido="+$("#txtapellido").val();
				//datos += "&nombre="+$("#txtnombre").val();
				datos += "&calle="+$("#txtcalle").val();
				datos += "&numero="+$("#txtnumero").val();
				datos += "&piso="+$("#txtpiso").val();
				datos += "&dpto="+$("#txtdpto").val();
				datos += "&comuna="+$("#txtcomuna").val();
				datos += "&ciudad="+$("#txtciudad").val();
				datos += "&region="+$("#txtregion").val();
				datos += "&cuenta_corriente1="+$("#txtcuenta_corriente1").val();
				datos += "&banco1="+$("#selbanco1").val();
				datos += "&cuenta_corriente2="+$("#txtcuenta_corriente2").val();
				datos += "&banco2="+$("#selbanco2").val();
				datos += "&telefono1="+$("#txttelefono1").val();
				datos += "&telefono2="+$("#txttelefono2").val();
				datos += getDatosModoPago();
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#pagina").load('index.php?controlador=Mandantes&accion=admin');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
			
		}
		
		function getDatosModoPago()
		{
			var url = "";
			var arrayInput = document.getElementsByTagName('input');
			for(var i=0; i<arrayInput.length; i++)
	 		{	 
				if(arrayInput[i].getAttribute('turl') == "S")
				{
					url += "&porcentaje_"+arrayInput[i].getAttribute('idmp')+"="+$("#txtporcentaje_"+arrayInput[i].getAttribute('idmp')).val();
					url += "&operacion_"+arrayInput[i].getAttribute('idmp')+"="+$("#txtoperacion_"+arrayInput[i].getAttribute('idmp')).val();
					if(document.getElementById("rdestatus_c_"+arrayInput[i].getAttribute('idmp')).checked == true)
					{
						url += "&estatus_"+arrayInput[i].getAttribute('idmp')+"=C";
					}
					else
					{
						url += "&estatus_"+arrayInput[i].getAttribute('idmp')+"=NC";
					}				
				}
			}
			
			return url;
		}
				
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
		
		
		// FUNCIONES FORM CONTACTO
		function agregarCon()
		{
			$("#id_con").val("");
			$("#formsoporte").show("slow");
		}
		
		function editarCon()
		{
			if($.trim($("#id_con").val()) == "")
			{
				return false;
			}
			
			var datos = "controlador=Mandantes";
				datos += "&accion=getcontmp";
				datos += "&idcon="+$("#id_con").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{
						document.getElementById("txtcontacto").value = res[0];
						document.getElementById("txtemail").value = res[1];
						document.getElementById("txtcelular").value = res[2];
						document.getElementById("txttelefono").value = res[3];
						document.getElementById("txtfax").value = res[4];
						document.getElementById("txtobservacion").value = res[5];

						$("#formsoporte").show("slow");
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function grabarCon()
		{
			
			var arrayin = new Array(6);
			arrayin[0] = document.getElementById("txtcontacto");
			arrayin[1] = document.getElementById("txtemail");
			arrayin[2] = document.getElementById("txtcelular");
			arrayin[3] = document.getElementById("txttelefono");
			arrayin[4] = document.getElementById("txtfax");
			arrayin[5] = document.getElementById("txtobservacion");

			var arraySel = new Array();
			
			if(!validarArray(arrayin, arraySel,"N"))
			{
				return false;
			}
			
			var datos = "controlador=Mandantes";
			if($.trim($("#id_con").val()) == "")
			{
				datos += "&accion=grabarcontmp";
			}
			else
			{
				datos += "&accion=editarcontmp";
				datos += "&idcon="+$("#id_con").val();
			}
			
			datos += "&contacto="+$("#txtcontacto").val();
			datos += "&email="+$("#txtemail").val();
			datos += "&celular="+$("#txtcelular").val();
			datos += "&telefono="+$("#txttelefono").val();
			datos += "&fax="+$("#txtfax").val();
			datos += "&observacion="+$("#txtobservacion").val();
		
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#formsoporte").hide("slow");
						document.getElementById("frmcontacto").src="index.php?controlador=Mandantes&accion=listar_contmp";
						
						document.getElementById("txtcontacto").value = "";
						document.getElementById("txtemail").value = "";
						document.getElementById("txtcelular").value = "";
						document.getElementById("txttelefono").value = "";
						document.getElementById("txtfax").value = "";
						document.getElementById("txtobservacion").value = "";
			
						$(document.getElementById("txtcontacto")).removeClass('notFilled');
						$(document.getElementById("txtemail")).removeClass('notFilled');
						$(document.getElementById("txtcelular")).removeClass('notFilled');
						$(document.getElementById("txttelefono")).removeClass('notFilled');
						$(document.getElementById("txtfax")).removeClass('notFilled');
						$(document.getElementById("txtobservacion")).removeClass('notFilled');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function salirGCon()
		{
			$("#formsoporte").hide("slow");
			
			document.getElementById("txtcontacto").value = "";
			document.getElementById("txtemail").value = "";
			document.getElementById("txtcelular").value = "";
			document.getElementById("txttelefono").value = "";
			document.getElementById("txtfax").value = "";
			document.getElementById("txtobservacion").value = "";
			
			$(document.getElementById("txtcontacto")).removeClass('notFilled');
			$(document.getElementById("txtemail")).removeClass('notFilled');
			$(document.getElementById("txtcelular")).removeClass('notFilled');
			$(document.getElementById("txttelefono")).removeClass('notFilled');
			$(document.getElementById("txtfax")).removeClass('notFilled');
			$(document.getElementById("txtobservacion")).removeClass('notFilled');
		}
		
		function seleccionado(id)
		{
			
			$("#id_con").val(id);
			
		}
		
	</script>
</head>
<body>
<form name="frmadmmandantes">
<input  type="hidden" name="id_mandantes" id="id_mandantes" value=""/>
<input  type="hidden" name="id_con" id="id_con" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Alta Mandantes</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th align="right"></th>
    </tr>
	<tr>
		<th align="left">Datos del Cliente</th>
        <th></th>
        <th align="right"></th>
    </tr>
 </table>
<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
    <tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
            	<tr>
					<td align="left" class="etiqueta_form">Rut</td>
<!--    				<td align="left" class="etiqueta_form">Apellido</td>-->
<!--    				<td align="left" class="etiqueta_form">Nombre</td>-->
    				<td align="left" class="etiqueta_form">Razon Social</td>
    				<td align="left" class="etiqueta_form">Telefono 1</td>
    				<td align="left" class="etiqueta_form">Telefono 2</td>
        		</tr>
            	<tr>
					<td align="left"><input type="text" name="txtrut_mandante" id="txtrut_mandante" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_mandante','txtdv_mandante')" valida="requerido" tipovalida="entero" />
    	<input type="text" name="txtdv_mandante" id="txtdv_mandante" size="2"  class="input_form_min" valida="requerido" tipovalida="texto" disabled="disabled" />
        			</td>
    				<td align="left"><input type="text" name="txtapellido" id="txtapellido" size="80"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto"/>
                    </td>
                    <td align="left"><input type="text" name="txttelefono1" id="txttelefono1" size="30"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto"/>
                    </td>
                    <td align="left"><input type="text" name="txttelefono2" id="txttelefono2" size="30"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto"/>
                    </td>
<!--    				<td align="left"><input type="text" name="txtnombre" id="txtnombre" size="40"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto"/>-->
<!--                    </td>-->
        		</tr>
             </table>
        </td>
    </tr>		
    <tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
            	<tr>
                    <td align="left" class="etiqueta_form">Calle</td>
                    <td align="left" class="etiqueta_form">Numero</td>
                    <td align="left" class="etiqueta_form">Piso</td>
                    <td align="left" class="etiqueta_form">Dpto</td>
                    <td align="left" class="etiqueta_form">Comuna</td>
                    <td align="left" class="etiqueta_form">Ciudad</td>
                    <td align="left" class="etiqueta_form">Region</td>
                 </tr>
                 <tr>
                    <td><input type="text" name="txtcalle" id="txtcalle" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto"/>
                    </td>
                    <td><input type="text" name="txtnumero" id="txtnumero" size="20" class="input_form_min" tipovalida="entero"/>
                    </td>
                    <td>
                    <input type="text" name="txtpiso" id="txtpiso" size="20"  class="input_form_min" tipovalida="texto"/>
                    </td>
                    <td><input type="text" name="txtdpto" id="txtdpto" size="20"  class="input_form_min" tipovalida="texto"/>
                    </td>                 
                    <td><input type="text" name="txtcomuna" id="txtcomuna" size="40"  class="input_form_medio" tipovalida="texto"/>
                    </td>                   
                    <td><input type="text" name="txtciudad" id="txtciudad" size="40"  class="input_form_medio"  tipovalida="texto"/>
                    </td>
                    <td><input type="text" name="txtregion" id="txtregion" size="40"  class="input_form_medio"  tipovalida="texto"/>
                    </td>
                 </tr>
             </table>
        </td>
    </tr>	
 	<tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
            	<tr>
                    <td width="90" align="left" class="etiqueta_form">Cta.Cte. 1</td>
                    <td width="70" align="left" class="etiqueta_form">Banco1</td>
                    <td width="70" align="left" class="etiqueta_form">Cta.Cte. 2</td>
                    <td width="70" align="left" class="etiqueta_form">Banco2</td>
                 </tr>
                <tr>
                        <td><input type="text" name="txtcuenta_corriente1" id="txtcuenta_corriente1" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/>
                        </td>               
                        <td>
                        <select name="selbanco1" valida="requerido" tipovalida="texto" id="selbanco1" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
	 				    <?
					        for($j=0; $j<$coleccion_bancos->get_count(); $j++)
					        {
            					$datoTmp = &$coleccion_bancos->items[$j];
					            echo("<option value=".$datoTmp->get_data("id_banco").">".utf8_encode($datoTmp->get_data("banco"))."</option>");           
        					}
    					?>
						</select>

                        </td>
                        <td><input type="text" name="txtcuenta_corriente2" id="txtcuenta_corriente2" size="40"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/>
                        </td>
                        <td>
                        <select name="selbanco2" valida="requerido" tipovalida="texto" id="selbanco2" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
	 				    <?
					        for($j=0; $j<$coleccion_bancos->get_count(); $j++)
					        {
            					$datoTmp = &$coleccion_bancos->items[$j];
					            echo("<option value=".$datoTmp->get_data("id_banco").">".utf8_encode($datoTmp->get_data("banco"))."</option>");           
        					}
    					?>
						</select>
                        </td>
            	 </tr>
         	</table>
         </td>
    </tr> 
    <tr>
        <td>
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>    
 </table>
 </div>
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 <tr>
		<th align="left" height="20"></th>
        <th></th>
        <th></th>
    </tr>
	<tr>
		<th align="left">Contacto</th>
        <th></th>
        <th align="right"><input type="button" name="btnagregarcon" id="btnagregarcon" title="Agregar Contacto" value="+" onclick="agregarCon()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'>&nbsp;
        <input type="button" name="btneditarcon" id="btneditarcon" title="Editar Contacto" onclick="editarCon()" value="<>" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'></th>
    </tr>
 </table>
  <div id="formsoporte" style=" display:none">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
			<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
            	<tr>
                	<td class="etiqueta_form">Contacto</td>
                    <td><input type="text" name="txtcontacto" id="txtcontacto" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtcontacto" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">E-mail</td>
                    <td><input type="text" name="txtemail" id="txtemail" size="40" valida="requerido" tipovalida="mail" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtemail" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Celular</td>
                    <td><input type="text" name="txtcelular" id="txtcelular" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtcelular" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Tel&eacute;fono</td>
                    <td><input type="text" name="txttelefono" id="txttelefono" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txttelefono" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Fax</td>
                    <td><input type="text" name="txtfax" id="txtfax" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtfax" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Observaci&oacute;n</td>
                    <td><input type="text" name="txtobservacion" id="txtobservacion" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtobservacion" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                    	<input type="button" name="btnagregarcon" id="btnagregarcon" onclick="grabarCon()" value="Grabar" title="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
                        <input type="button" name="btnsalirgcon" id="btnsalirgcon" onclick="salirGCon()" value="Cancelar" title="Cancelar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
                    </td>
                </tr>
            </table>
         </td>
         <td align="center">

         </td>
    </tr>
</table> 
  </div>
  <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<iframe id="frmcontacto" src="index.php?controlador=Mandantes&accion=listar_contmp" frameborder="0" align="middle" width="100%" height="150" scrolling="auto"></iframe>
         </td>
    </tr>
</table> 
  </div>
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
		<th align="left" colspan="3" height="20"></th>
    </tr>
	<tr>
		<th align="left">Modo de pago del Cliente</th>
        <th></th>
        <th align="right"></th>
    </tr>
 </table>
  <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<table width="80%" align="center" cellpadding="2" cellspacing="2" border="0"> 
            	<tr>
                	<td class="etiqueta_form">% de la Cobranza</td>
                    <td class="etiqueta_form">Base por Operaci&oacute;n</td>
                    <td class="etiqueta_form" colspan="2"></td>                  
                </tr>
                <tr>
                	<td colspan="4" height="10"></td>
                </tr>
            	 <? 
					for($i=0; $i<$coleccion_modopago->get_count(); $i++)
					{
						$mdTmp = &$coleccion_modopago->items[$i];
				 ?>
                 		<tr>
                        	<td class="etiqueta_form">
                            <input type="text" turl="S" valida="requerido" tipovalida="moneda" idmp="<? echo($mdTmp->get_data("id_modo_pago")) ?>" name="txtporcentaje_<? echo($mdTmp->get_data("id_modo_pago")) ?>" id="txtporcentaje_<? echo($mdTmp->get_data("id_modo_pago")) ?>" class="input_form_min">&nbsp;%
                            </td>
                            <td class="etiqueta_form">
                            	<input type="text" turl="S" valida="requerido" tipovalida="moneda" idmp="<? echo($mdTmp->get_data("id_modo_pago")) ?>" name="txtoperacion_<? echo($mdTmp->get_data("id_modo_pago")) ?>" id="txtoperacion_<? echo($mdTmp->get_data("id_modo_pago")) ?>" class="input_form_min">&nbsp;U.F.
                            </td>
                            <td class="etiqueta_form" align="left">
                            	<? echo($mdTmp->get_data("modo_pago")) ?>
                            </td>
                            <td class="etiqueta_form" align="left">
                            	<input type="radio" turl="S" idmp="<? echo($mdTmp->get_data("id_modo_pago")) ?>" name="rdestatus_<? echo($mdTmp->get_data("id_modo_pago")) ?>" id="rdestatus_c_<? echo($mdTmp->get_data("id_modo_pago")) ?>" />&nbsp;Cobrar&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" turl="S" idmp="<? echo($mdTmp->get_data("id_modo_pago")) ?>" name="rdestatus_<? echo($mdTmp->get_data("id_modo_pago")) ?>" id="rdestatus_nc_<? echo($mdTmp->get_data("id_modo_pago")) ?>" checked="checked" />&nbsp;No Cobrar
                            </td>
                        </tr>
                 <?
                 	}
				 ?>
            </table>
         </td>
    </tr>
</table> 
  </div>

 <div style="position:relative; margin-top:10px;">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabarAltaMand()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiarAltaMand()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salirAltaMand()"value="Cancelar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>