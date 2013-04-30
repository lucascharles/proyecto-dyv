<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <!-- LIBRERIA PAR CONTROL DE FECHA -->
    <link rel="stylesheet" media="all" type="text/css" href="css/smoothness/jquery-ui-1.8.17.custom.css" />
    <style type="text/css"> 
			/* css for timepicker */	
			#ui-datepicker-div, .ui-datepicker{ font-size: 80%; }
			.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
			.ui-timepicker-div dl { text-align: left; }
			.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
			.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
			.ui-timepicker-div td { font-size: 90%; }
			.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
	</style>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
  	<script src="js/funciones.js" type="text/javascript"></script>
    
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
    <script language="javascript">
		$(document).ready(function(){
			$('form').validator();
			$("#txtfechaRecibido").datepicker();
			$("#txtfechaprotesto").datepicker();
			
		});
		
		function ventanaBusqueda(op)
		{
			if(op == "M")
			{
				$("#selecMandante").slideDown(1000);	
				document.getElementById("txtrut_m").focus();
			}
			
			if(op == "D")
			{
				$("#selecDeudor").slideDown(1000);	
				document.getElementById("txtrut_d").focus();
			}
			
		}
		
		function validarRut(tipo)
		{
			var datos = "";
			var rut = "";
			var dv = "";
			
			if(tipo == "D")
			{
				if($.trim($("#txtrut_deudor").val()) == "" || $.trim($("#txtdv_deudor").val()) == "")
				{
					return false;
				}
				
				if(!validaentero($.trim($("#txtrut_deudor").val())))
				{
					return false;
				}
				if(!validaentero($.trim($("#txtdv_deudor").val())))
				{
					return false;
				}
				
				datos = "controlador=Deudores";
				rut = $("#txtrut_deudor").val();
				dv = $("#txtdv_deudor").val();
			}
			if(tipo == "M")
			{
				if($.trim($("#txtrut_mandante").val()) == "" || $.trim($("#txtdv_mandante").val()) == "")
				{
					return false;
				}
				if(!validaentero($.trim($("#txtrut_mandante").val())))
				{
					return false;
				}
				if(!validaentero($.trim($("#txtdv_mandante").val())))
				{
					return false;
				}
				datos = "controlador=Mandantes";
				rut = $("#txtrut_mandante").val();
				dv = $("#txtdv_mandante").val();
			}
				
			datos += "&accion=validarrut";
			datos += "&tipoval=EXISTE";
			datos += "&rut="+rut;
			datos += "&dv="+dv;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{		
						if(res == 0)
						{
							var mensaje = "";
							
							if(tipo == "D")
							{
								document.getElementById("txtdv_deudor").focus();
								mensaje = "El rut ingresado para el deudor es incorrecto.";
							}
							if(tipo == "M")
							{
								document.getElementById("txtdv_mandante").focus();
								mensaje = "El rut ingresado para el mandante es incorrecto.";
							}
							$("#mensaje").text(mensaje);
							$("#mensaje").show("slow");
							setTimeout("limpiarMensaje()",3000);
						}
						else 
						{
							if(tipo == "D")
							{
								$("#id_deudor").val(res);
							}
							if(tipo == "M")
							{
								$("#id_mandante").val(res);
							}
						}
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		
		function limpiarDocumentos()
		{			
			limpiarCampos();
		}
		
		function salir()
		{
			$("#pagina").load('views/admin_documentos.php');
		}


		function seleccionado(id)
		{
			document.getElementById("id_documento").value = id;
		}
		
		function seleccionadoMandante(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosMandante(id);
			cerrarVentMand();
		}
		
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosDeudor(id);
			cerrarVentDeudor();
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
		
		function buscarDatosDeudor(id)
		{
			var datos = "controlador=Deudores";
			datos += "&accion=getDatosDeudor";
			datos += "&id_deudor="+id;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{		
						$("#txtrut_deudor").val(res[0]);
						$("#txtdv_deudor").val(res[1]);
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		
		function cerrarVentMand()
		{
			$("#selecMandante").slideUp(1000);
			//document.getElementById("frmtipocom").src = "";
		}
		
		
		function cerrarVentDeudor()
		{
			$("#selecDeudor").slideUp(1000);
			//document.getElementById("frmtipocom").src = "";
		}
		
		function eliminar()
		{
					
			if(document.getElementById("id_documento").value == "")
			{
				return false;
			}
			
			var id = document.getElementById("id_documento").value;
			var url = "index.php?controlador=Documentos&accion=eliminar&iddocumentos="+id;
			
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function grabar()
		{		
			if(!validar("N"))
			{
				return false;
			}
			
			if($.trim($("#selDeudor").val()) != "")
			{
				var id = document.getElementById("selDeudor").value;
				
				var datos = "controlador=Documentos";
				
				datos += "&accion=grabar";
				datos += "&deudor="+$("#id_deudor").val();
				datos += "&mandante="+$("#id_mandante").val();
				datos += "&txtfechaRecibido="+$("#txtfechaRecibido").val();
				datos += "&txtnrodoc="+$("#txtnrodoc").val();
				datos += "&selTipoDoc="+$("#selTipoDoc").val();
				datos += "&txtmonto="+$("#txtmonto").val();
				datos += "&selBancos="+$("#selBancos").val();
				datos += "&txtctacte="+$("#txtctacte").val();
				datos += "&txtfechaprotesto="+$("#txtfechaprotesto").val();
				datos += "&selCausalProtesta="+$("#selCausalProtesta").val();
				datos += "&selEstadoDoc="+$("#selEstadoDoc").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{						

						document.getElementById("frmlistdocumentos").src="index.php?controlador=Documentos&accion=listarNuevos&iddeudor="+id;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
			}
		}
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
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
		
		function mostrarDeudor(obj)
		{
			var url = "index.php?controlador=Deudores&accion=listar";
			url += "&rut="+$("#txtrut_d").val()+$("#txtrut_dv").val();
			url += "&p_ape="+$("#txtpapellido").val();
			url += "&s_ape="+$("#txtsapellido").val();
			url += "&p_nom="+$("#txtpnombre").val();
			url += "&s_nom="+$("#txtsnombre").val();
			url += "&id_partida=0";
			document.getElementById("frmlistdeudor").src = url;
		}
		

	</script>
</head>
<body>
<div id="selecMandante" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#eeeeee" cellpadding="5" cellspacing="5"> 
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
<div id="selecDeudor" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#eeeeee" cellpadding="5" cellspacing="5"> 
    	<tr>
        	<td height="" align="right">
            	<div onclick="cerrarVentDeudor()" style="cursor:pointer; font-weight:bold; color:#000099;"> cerrar </div>
            </td>
        </tr>
        <tr>
        <th align="left">Seleccionar Deudor</th>
        </tr>
        <tr>
        <td height="10"> </td>
        </tr>
        <tr>
        	<td height="">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr> 
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_d" id="txtrut_d"  size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_d','txtrut_dv')" />&nbsp;<input type="text" name="txtrut_dv" id="txtrut_dv"  size="2" onkeyup='mostrarDeudor(this)'  class="input_form_min" disabled="disabled"/></td>
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
                        <td align="left"> <input type="text" name="txtpapellido" id="txtpapellido" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsapellido" id="txtsapellido" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>  
                        <td align="left"><input type="text" name="txtpnombre" id="txtpnombre" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsnombre" id="txtsnombre" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
        <tr>
        <th align="left">Deudores disponibles</th>
        </tr>
    	<tr>
        	<td height="">
            	
	             <div id="datos" style="">
            	<iframe id="frmlistdeudor" src="index.php?controlador=Deudores&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>
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
<form name="frmadmdocumentos">
<input grabar="S" type="hidden" name="id_documento" id="id_documento" value=""/>
<input grabar="S" type="hidden" name="id_mandante" id="id_mandante" value=""/>
<input grabar="S" type="hidden" name="id_deudor" id="id_deudor" value=""/>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Nueva Liquidacion</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th></th>
    </tr>
	<tr>
		<th align="left">Deudor</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" size="20">
	 <tr>
        <td colspan="4" height="5">

         </td>
    </tr> 
    <tr>
		<td width="70" align="left" class="etiqueta_form">&nbsp;Deudor:</td>
        <td> 
        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="240">
						<input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" onblur=" generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D')" />&nbsp;
	            		<input type="text" name="txtdv_deudor" id="txtdv_deudor" class="input_form_min" onblur="" disabled="disabled" />&nbsp;
                    </td>
                	<td align="left">
			            <img src="images/buscar.png" title="Buscar Deudor" style="cursor:pointer" onclick="ventanaBusqueda('D')"/>
                    </td>
                </tr>
             </table>
        </td>
		
    </tr>
     <tr>
        <td colspan="4" height="10">

         </td>
    </tr>   
    
         <tr>
        <td colspan="4" height="5">

         </td>
    </tr> 
    
    <tr>
        <td colspan="4">
        	<span id="mensaje" style="display:none" ></span>
         </td>
    </tr>   
 </table>
 </div>
 
 
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 	<tr>
		<td colspan="3">
        	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="boton_form_brillante" seleccionado="S" id="btnSimulacion" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('SIMULACION')">
                    	Simulacion
                    </td>
                    <td class="boton_form" id="btnCarta" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('CARTA')">
                    	Carta
                    </td>
                    <td class="boton_form" id="btnCalculadora" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('CALCULADORA')">
                    	Calculadora de Prestamos
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
		<td colspan="3" height="10">
        
        </td>
    </tr>
    <tr>
		<td colspan="3">
        	<iframe id="frmsubpantalla" src="" width="100%" align="middle" height="300" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>

</table>
</div>
</form>
</body>
</html>