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
			$("#txtnombre").val("");
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
		
			var arrayin = new Array(15);
			
			arrayin[0] = document.getElementById("txtrut_mandante");
			arrayin[1] = document.getElementById("txtdv_mandante");
			arrayin[2] = document.getElementById("txtapellido");
			arrayin[3] = document.getElementById("txtnombre");
			arrayin[4] = document.getElementById("txtcalle");
			arrayin[5] = document.getElementById("txtnumero");
			arrayin[6] = document.getElementById("txtpiso");
			arrayin[7] = document.getElementById("txtdpto");
			arrayin[8] = document.getElementById("txtcomuna");
			arrayin[9] = document.getElementById("txtciudad");
			arrayin[10] = document.getElementById("txtregion");
			arrayin[11] = document.getElementById("txtcuenta_corriente1");
			arrayin[12] = document.getElementById("txtcuenta_corriente2");
			arrayin[13] = document.getElementById("txttelefono1");
			arrayin[14] = document.getElementById("txttelefono2");
			
			var arraySel = new Array();
			arraySel[0] = document.getElementById("selbanco1");
			arraySel[0] = document.getElementById("selbanco2");
			
			if(!validarArray(arrayin, arraySel,"N"))
			{
				return false;
			}
				
				
				var datos = "controlador=Mandantes";
				datos += "&accion=grabar";
				
			    datos += "&rut_mandante="+$("#txtrut_mandante").val();
				datos += "&dv_mandante="+$("#txtdv_mandante").val();
				datos += "&apellido="+$("#txtapellido").val();
				datos += "&nombre="+$("#txtnombre").val();
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
<form name="frmliquidacioncarta">
<input  type="hidden" name="id_mandantes" id="id_mandantes" value=""/>
<input  type="hidden" name="id_deudor" id="id_deudor" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
 </table>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th align="right"></th>
    </tr>
 </table>
<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
    <tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" border="0" align="left" >
            	<tr>
					<td align="left" class="etiqueta_form">Honorarios&nbsp;&nbsp;</td>
					<td align="left">
						<input type="text" name="txthonorarios" id="txthonorarios" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" />
        			</td>
        		</tr>
        		<tr>
					<td align="left" class="etiqueta_form">Capital&nbsp;&nbsp;</td>
                    <td align="left">	
                    	<input type="text" name="txtcapital" id="txtcapital" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto"/>
                    </td>        		
        		</tr>
        		<tr>
                    <td align="left" class="etiqueta_form">Interes&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteres" id="txtinteres" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="entero"/>
                        (<input type="radio" turl="S" idmp="" name="rdestatus_repacta" id="rdestatus_repacta" />&nbsp;Repacta&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" turl="S" idmp="" name="rdestatus_no_repacta" id="rdestatus_no_repacta" checked="checked" />&nbsp;No Repacta)
                    </td>
                </tr>
                <tr>
                	<td align="left" class="etiqueta_form">Protesto Banco&nbsp;</td>
                    <td align="left">
                    	<input type="text" name="txtprotestobanco" id="txtprotestobanco" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/>
                    </td>
                </tr>
                
                <tr>
                	<td align="left" class="etiqueta_form">Sub Total&nbsp;</td>
                    <td align="left">
                    	<input type="text" name="txtsubtotal" id="txtsubtotal" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/>
                    </td>
                </tr>
                
             	<tr>
					<td align="left" class="etiqueta_form">Abono&nbsp;&nbsp;</td>
                    <td align="left">	
                    	<input type="text" name="txtabono" id="txtabono" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto"/>
                    </td>        		
        		</tr>
        		
        		<tr>
					<td align="left" class="etiqueta_form">Depsito&nbsp;&nbsp;</td>
                    <td align="left">	
                    	<input type="text" name="txtdeposito" id="txtdeposito" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto"/>
                    </td>        		
        		</tr>
             
             </table>
             
  
        	 <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
            	<tr>
                    
                 	<td align="left" class="etiqueta_form">Saldo&nbsp;&nbsp;
                 				<input type="text" name="txtsaldo" id="txtsaldo" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/></td>
					<td align="left" class="etiqueta_form">IMP&nbsp;&nbsp;
                 				<input type="text" name="txtimp" id="txtimp" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/></td>
					<td align="left" class="etiqueta_form">Total&nbsp;&nbsp;
                 	 			<input type="text" name="txttotal" id="txttotal" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/></td>
				</tr>
			 </table>	
					
			 <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
				<tr>
					<td align="left" class="etiqueta_form">Cuotas&nbsp;&nbsp;
                 				<input type="text" name="txtcuotas" id="txtcuotas" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/></td>

                 	<td align="left" class="etiqueta_form">Cuotas de UF&nbsp;&nbsp;
                 				<input type="text" name="txtcuotasuf" id="txtcuotasuf" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/></td>                                   
                 	
                 	<td align="left" class="etiqueta_form">Valor aprox.&nbsp;&nbsp;
                 	 		<input type="text" name="txtvalorcuota" id="txtvalorcuota" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/></td>                                   
                 				
                </tr>
             </table>
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
 </table>

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