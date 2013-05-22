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
    <link rel="stylesheet" href="css/general.css" type="text/css" />
 	<script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
  	<script src="js/funciones.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
    <script language="javascript">
		$(document).ready(function(){
			$("#txtfecha").datepicker();	
			$("#txtfechavenc").datepicker();	
			$('form').validator();
			$("#txtfechaRecibido").datepicker();
			$("#txtfechaprotesto").datepicker();
			//setParametro("interes_diario_normal","txtinteres");
			//setParametro("valor_uf","txtvaloruf");
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
		
		function validaDeudor()
		{
			if($.trim($("#txtrut_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
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
		/*
		function limpiarDocumentos()
		{			
			limpiarCampos();
		}
		*/
		
		function salir()
		{
			$("#pagina").load('views/admin_documentos.php');
		}

		/*
		function seleccionado(id)
		{
			document.getElementById("id_documento").value = id;
		}
		*/
		
		function seleccionadoMandante(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosMandante(id);
			cerrarVentMand();
		}
		
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_deudor").value = id;
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

/*
		function cargarPantalla(opt)
		{
			//alert("id_deudor: "+document.getElementById("id_deudor").value);
			var url = "index.php?controlador=Deudores&accion=";
			var accion = "";
			var capital = "";
			
			if($.trim($("#id_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
				return false;
			}
			
			document.getElementById("btnSimulacion").setAttribute("seleccionado","");
			$(document.getElementById("btnSimulacion")).removeClass('boton_form_brillante');
			$(document.getElementById("btnSimulacion")).addClass('boton_form');
			
			document.getElementById("btnCarta").setAttribute("seleccionado","");
			$(document.getElementById("btnCarta")).removeClass('boton_form_brillante');
			$(document.getElementById("btnCarta")).addClass('boton_form');
			
			document.getElementById("btnCalculadora").setAttribute("seleccionado","");
			$(document.getElementById("btnCalculadora")).removeClass('boton_form_brillante');
			$(document.getElementById("btnCalculadora")).addClass('boton_form');
			
			if(opt == "SIMULACION")
			{
				accion = "liquidacion_documentos";
				document.getElementById("btnSimulacion").setAttribute("seleccionado","S");
				$(document.getElementById("btnSimulacion")).addClass('boton_form_brillante');
			}
			if(opt == "CARTA")
			{
				accion = "liquidacion_carta";
				document.getElementById("btnCarta").setAttribute("seleccionado","S");
				capital= document.getElementById("frmlistdeudor").getElementById('txttotal').value;
				
				$(document.getElementById("btnCarta")).addClass('boton_form_brillante');
			}
			if(opt == "CALCULADORA")
			{
				accion = "liquidacion_calculadora";
				document.getElementById("btnCalculadora").setAttribute("seleccionado","S");
				$(document.getElementById("btnCalculadora")).addClass('boton_form_brillante');
			}

			url += accion+"&iddeudor="+$("#id_deudor").val();
			url += "&tipoperacion="+$("#tipoperacion").val(); 
			url += "&id_liquidacion="+$("#id_liquidacion").val();
			url += "&capital="+capital;

			document.getElementById("frmsubpantalla").src = url;
		}
		
*/

		function setIdLiquidacion(id)
		{
			
			$("#id_liquidacion").val(id);
		}


		function simular_liquidacion()
		{
			var url = "index.php?controlador=Deudores&accion=";
			var accion = "";
			var capital = "";
			
			if($.trim($("#id_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
				return false;
			}

			accion = "liquidacion_documentos";

			url += accion+"&iddeudor="+$("#id_deudor").val();
			url += "&tipoperacion="+$("#tipoperacion").val(); 
			url += "&id_liquidacion="+$("#id_liquidacion").val();

			document.getElementById("frmsubpantalla").src = url;
		}

		function seleccionado(id)
		{
			var arrayin = new Array(3);
			arrayin[0] = document.getElementById("txtfecha");
			arrayin[1] = document.getElementById("txtinteres");
			arrayin[2] = document.getElementById("txtvaloruf");

			var arraySel = new Array();
			
			if(!validarArray(arrayin, arraySel,"S"))
			{
				return false;
			}
			
			// CALCULO MONTO DEUDA - FECHA VENCIMIENTO 
			document.getElementById("fecha_sim").value = "";
			document.getElementById("monto_documento_sim").value = 0;
			var arraydoc = document.getElementsByTagName('input');
			for(var i=0; i<arraydoc.length; i++)
		 	{	 
				if(arraydoc[i].getAttribute('type') == "checkbox")
				{
	  			 	if(arraydoc[i].checked == true)
   				 	{
						document.getElementById("monto_documento_sim").value = parseFloat(document.getElementById("monto_documento_sim").value) + parseFloat(arraydoc[i].getAttribute('monto'));
						
						if(document.getElementById("fecha_sim").value == "")
						{
							document.getElementById("fecha_sim").value = arraydoc[i].getAttribute('fecha_doc');
						}
						else
						{
							if (Date.parse(arraydoc[i].getAttribute('fecha_doc')) > Date.parse(document.getElementById("fecha_sim").value)) 
							{
								document.getElementById("fecha_sim").value = arraydoc[i].getAttribute('fecha_doc');
							}
						}
		 			}
				}
			}	
			
			if($("#monto_documento_sim").val() == 0)
			{
				$("#txtmonto").val("");
			}
			else
			{
				$("#txtmonto").val($("#monto_documento_sim").val());
			}
			
			if($("#monto_documento_sim").val() == 0)
			{
				$("#txttotal").val("");
			}
			else
			{
				$("#txttotal").val($("#monto_documento_sim").val());
			}
			
//			$("#txtfechavenc").val($("#fecha_sim").val());
			
			// CALCULO CANTIDAD DIAS ATRASO
			var dias = 0;
			if($("#txtfechavenc").val() != "")
			{
				var d1 = $('#txtfechavenc').val().split("/");
				var dat1 = new Date(d1[2], parseFloat(d1[1])-1, parseFloat(d1[0]));
				var d2 = $('#txtfecha').val().split("/");
				var dat2 = new Date(d2[2], parseFloat(d2[1])-1, parseFloat(d2[0]));
 
				var fin = dat2.getTime() - dat1.getTime();
				dias = Math.floor(fin / (1000 * 60 * 60 * 24))  
 
 				$('#txtdiasatraso').val(dias);
			}
			else
			{
				$('#txtdiasatraso').val("");
			}
			
			// CALCULO INTERES DIARIO 
			var interes = (parseFloat($("#txtinteres").val()) * parseFloat($("#monto_documento_sim").val()) ) / 100;
			if(interes == 0)
			{
				$("#txtinteresdiario").val("");
			}
			else
			{
				$("#txtinteresdiario").val(interes);
			}
			
			// CALCULO INTERES ACUMULADO 
			var int_acum = interes * dias;
			if(int_acum == 0)
			{
				$("#txtinteresacumulado").val("");
			}
			else
			{
				$("#txtinteresacumulado").val(int_acum);
			}
		}
		
	</script>
</head>
<body>
<?
	$protesto = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("protesto"));
	$monto = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("monto"));
	$total = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("total"));
	$fecha_venc = (is_null($simulacion)) ? date("d/m/Y") : utf8_decode(formatoFecha($simulacion->get_data("fecha_venc"),"yyyy-mm-dd","dd/mm/yyyy"));
	$diasatraso = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("diasatraso"));
	$interes_diario = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_diario"));
	$interes_acumulado = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_acumulado"));
	
	$array_doc = array();
	
	if(!is_null($doc_simulacion))
	{
		for($j=0; $j<$doc_simulacion->get_count(); $j++) 
		{
			$dTmp = &$doc_simulacion->items[$j];

			$array_doc[] = $dTmp->get_data("id_documento");
		}
	}
?>
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
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_d" id="txtrut_d"  size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_d','txtrut_dv');" />&nbsp;<input type="text" name="txtrut_dv" id="txtrut_dv"  size="2" onkeyup='mostrarDeudor(this)'  class="input_form_min" disabled="disabled"/></td>
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
            	<iframe name="frmlistdeudor" id="frmlistdeudor" src="index.php?controlador=Deudores&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="90%" height="100%"></iframe>
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
<input grabar="S" type="hidden" name="id_liquidacion" id="id_liquidacion" value="<? if($id_liquidacion == "") $id_liquidacion = 0; echo($id_liquidacion) ?>"/>


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
						<input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" onblur="validaDeudor(); generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D'); simular_liquidacion();" />&nbsp;
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

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Simulacion</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 </div>

 <div id="datos" style=" overflow:auto; height:150px; width:99%;">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
	<tr>
		<td colspan="3">
        	<iframe id="frmsubpantalla" src="" width="100%" align="middle" height="500" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>
</table>
</div>

<div > 
<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">

	<tr>
        <td colspan="1" align="right" valign="top">
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">			
                <tr>
                    
                    <td align="right" class="etiqueta_form">Fecha:&nbsp; </td>
                    <td align="left">
                        <input type="text" name="txtfecha" id="txtfecha" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo(date("d/m/Y")) ?>" valida="requerido" tipovalida="fecha" />
                    </td>                                   
                </tr>
                <tr>  
                    <td align="right" class="etiqueta_form">% Interes:&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteres" id="txtinteres" value="<?php $datoTmp = &$interes_base; echo($datoTmp); ?>" class="input_form_min" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" />
                    </td>  
                </tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">Valor UF:&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtvaloruf" id="txtvaloruf"  value="<?php $datoTmp = &$valoruf; echo($datoTmp); ?>"   class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" />
                    </td>
                </tr>
             </table>
        </td>
        <td colspan="1" align="left" valign="top">   
            <table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">			
                <tr>
                    
                    <td align="right" class="etiqueta_form">Protesto Bco.&nbsp; </td>
                    <td align="left">
                        <input type="text" name="txtprotesto" id="txtprotesto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  value="<? echo($protesto) ?>" />
                    </td>                                   
                </tr>
                <tr>  
                    <td align="right" class="etiqueta_form">Monto&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtmonto" id="txtmonto" valida="requerido" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($monto) ?>" />
                    </td>  
                </tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">Total&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txttotal" id="txttotal" valida="requerido" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($total) ?>" />
                    </td>
                </tr>
                <tr>	
                    <td align="right" class="etiqueta_form">Fecha Venc.&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtfechavenc" id="txtfechavenc" valida="requerido" tipovalida="fecha" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  value="<? echo($fecha_venc) ?>" />
                    </td>
                </tr>
                <tr>    
                    <td align="right" class="etiqueta_form">Dias Atraso&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtdiasatraso" id="txtdiasatraso" valida="requerido" tipovalida="entero" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($diasatraso) ?>" />
                    </td>
                 </tr>
                <tr>   
                    <td align="right" class="etiqueta_form">Interes Diario&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteresdiario" id="txtinteresdiario" valida="requerido" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($interes_diario) ?>" />
                    </td>
                 </tr>
                <tr>   
                    <td align="right" class="etiqueta_form">Interes Acumulado&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteresacumulado" id="txtinteresacumulado" valida="requerido" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($interes_acumulado) ?>"/>
                    </td>
                </tr>
            </table>
		</td>
     </tr>
 </table>
</div>
 
 
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Carta</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 <div id="datos" style=" width:99%;">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="left" >
            	<tr>
					<td align="right" class="etiqueta_form" width="150">Honorarios&nbsp;&nbsp;</td>
					<td align="left">
						<input type="text" value="0" name="txthonorarios" id="txthonorarios" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" />
        			</td>
        		</tr>
        		<tr>
					<td align="right" class="etiqueta_form">Capital&nbsp;&nbsp;</td>
                    <td align="left">	
                    	<input type="text" name="txtcapital" id="txtcapital" value="<?php $datoTmp = &$capital; echo($datoTmp); ?>" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" tipovalida="texto"/>
                    </td>        		
        		</tr>
        		<tr>
                    <td align="right" class="etiqueta_form">Interes&nbsp;</td>
                    <td align="left">
                        <input type="text" value="0" name="txtinteres" id="txtinteres" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" tipovalida="entero"/>
                        <input type="radio" value="S" onclick="repactar(this)" name="rdestatus_repacta" id="rdestatus_repacta" />&nbsp;Repacta&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio"  value="N" onclick="repactar(this)" name="rdestatus_no_repacta" id="rdestatus_no_repacta" checked="checked" />&nbsp;No Repacta
                    </td>
                 </tr>
                 <tr>
                 <td align="right" class="etiqueta_form" width="150">Protesto Banco&nbsp;&nbsp;
                    </td>
                    <td class="etiqueta_form" >
                    		<input type="text" value="0" name="txtprotestobanco" id="txtprotestobanco" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" valida="requerido" tipovalida="entero"/>
                    </td>
                 </tr>
                 
                 <tr>
                 	<td align="right" class="etiqueta_form" width="150">Abono&nbsp;&nbsp;</td>
                	<td><input type="text" name="txtabono" id="txtabono" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" tipovalida="entero"/>
                    </td>
                 </tr>
                 
                 <tr>
                    <td align="right" class="etiqueta_form" width="150">Deposito&nbsp;&nbsp;</td>
                    <td><input type="text" name="txtdeposito" id="txtdeposito" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" tipovalida="entero"/>
                    </td>               
            	 </tr>
             </table>
        </td>
    </tr>		
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">
            	<tr>
                    
                 	<td align="center" class="etiqueta_form" width="150">Saldo</td>
                 	<td align="center" class="etiqueta_form" width="150">IMP</td>
                 	<td align="center" class="etiqueta_form" width="150">Total</td>
                </tr>    
                <tr>
                    <td align="center" class="etiqueta_form">
                 		<input type="text" name="txtsaldo" id="txtsaldo" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" valida="requerido" tipovalida="entero"/>
                    </td>
                    <td align="center" class="etiqueta_form">
                    	<input type="text" name="txtimp" id="txtimp" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()"  tipovalida="entero"/>
                    </td>
                    <td align="center" class="etiqueta_form">	
                 		<input type="text" name="txttotal" id="txttotal" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()"  tipovalida="entero"/>
                 	</td>		
                 		
                 </tr>
             </table>
        </td>
    </tr>	
	<tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">
            	<tr>
                    
                 	<td align="center" class="etiqueta_form" width="150">Cuotas</td>
                 	<td align="center" class="etiqueta_form" width="150">Cuotas de UF</td>
                 	<td align="center" class="etiqueta_form" width="150">Valor Aprox.</td>
                </tr>    
                <tr>
                    <td align="center" class="etiqueta_form">
                 		<input type="text" name="txtcuotas" id="txtcuotas" value="1" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" valida="requerido" tipovalida="entero"/>
                    </td>
                  
                    <td align="center" class="etiqueta_form">	
                 		<input type="text" name="txtcuotasuf" id="txtcuotasuf" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()" tipovalida="entero"/>
                 	</td>
                 	
                 	<td align="center" class="etiqueta_form">
                    	<input type="text" name="txtvalorcuota" id="txtvalorcuota" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular()"  tipovalida="entero"/>
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
 
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Calculadora Prestamo</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="datos" style=" width:99%">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="left" >
            	<tr>
					<td align="left" class="etiqueta_form">Importe del prestamo&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtimporte" id="txtimporte" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" tabindex="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input  type="button" name="btncalcular" id="btncalcular" onclick="calcular()"  value="Calcular" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' tabindex="10" />
        			</td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Interes mensual&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtinteresmensual" id="txtinteresmensual" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" tabindex="2"/>
        			</td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Cuotas&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtcuotas" id="txtcuotas" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" value="" tabindex="3"/>
        			</td>        			
        		</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Fecha Inicial&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtfechainicial" id="txtfechainicial" size="15" class="input_form_medio" onFocus="resaltar(this)" valida="requerido" tipovalida="fecha" value="" tabindex="4"/>
        			</td>        			
        		</tr>
                <tr>	
					<td align="left" class="etiqueta_form">IMP&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtimp" id="txtimp" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" onblur="calculoAutomatico()" tabindex="5"/>
        			</td>        			
				</tr>
        		<tr>
					<td align="left" class="etiqueta_form">Pago Mensual&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtpagomensual" id="txtpagomensual" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" tabindex="6"/>
        			</td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Numero de Pagos&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtnumpagos" id="txtnumpagos" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" value="" tabindex="7"/>
        			</td>
				</tr>
			
				<tr>	
					<td align="left" class="etiqueta_form">Costo total prestamo&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtcostoprestamo" id="txtcostoprestamo" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" tabindex="8"/>
        			</td>        			
        		</tr>
        		<tr>	
					<td align="left" class="etiqueta_form">
        				
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
     <tr>
		<td colspan="3">
        	<iframe id="frmcalculos" src="" width="90%" align="middle" height="250" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>
 </table>
 </div>
 
</form>
</body>
</html>