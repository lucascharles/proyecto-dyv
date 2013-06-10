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
			$("#txtfechainicial").datepicker();	
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

		function repactar()
		{
			if($.trim($("#txtrut_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
			}
		}

		function repactar()
		{
			if(document.getElementById("rdestatus_repacta").value == "S")
			{
				$("#formsoporte").show("slow");
				calculadora_prestamo();
			}

			if(document.getElementById("rdestatus_repacta").value == "N")
			{
				$("#formsoporte").show("slow");
			}
		}
	

		function noRepactar()
		{
			document.getElementById("rdestatus_repacta").value = "";
			$("#formsoporte").hide("slow");
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

		//TODO: mostrar docs
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_deudor").value = id;
			buscarDatosDeudor(id);
			simular_liquidacion();
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
		
		function grabar()
		{		
				var datos = "controlador=Deudores";
				
				datos += "&accion=grabarLiquidacion";
				datos += "&deudor="+$("#id_deudor").val();
				datos += "&interes="+$("#txtinteres").val();
				datos += "&valoruf="+$("#txtvaloruf").val();
//				datos += "&abono="+$("#txtabono").val();
//				datos += "&cuotas="+$("#txtcuotas").val();
//				datos += "&repacta="+$("#rdestatus_repacta").val();
//				datos += "&fechainicialcalc="+$("#txtfechaincial").val();
				datos += "&fechasimulacion="+$("#txtfecha").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{						
						alert('Los Datos se grabaron correctamente.');
					//$("#pagina").load('index.php?controlador=Deudores&accion=editaLiquidacion');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
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

		function seleccionado(id,monto,fecha,dias)
		{
			document.getElementById("txttotal").value = monto;
			document.getElementById("txtfechavenc").value = fecha;
			document.getElementById("txtdiasatraso").value = dias;

			// CALCULO INTERES DIARIO 
			var interes = ((parseFloat($("#txtinteres").val()) * parseFloat(document.getElementById("txttotal").value) ) / 100)/30;
			if(interes == 0)
			{
				$("#txtinteresdiario").val("");
			}
			else
			{
				$("#txtinteresdiario").val(interes.toFixed(2));
			}
			
			// CALCULO INTERES ACUMULADO 
			var int_acum = interes * parseInt(dias);
			if(int_acum == 0)
			{
				$("#txtinteresacumulado").val("");
			}
			else
			{
				$("#txtinteresacumulado").val(int_acum.toFixed(2));
			}

			//CALCULO DE SIMULACION
			var capital = document.getElementById("txttotal").value;
			var interes = document.getElementById("txtinteresacumulado").value;
			var protesto = document.getElementById("txtprotesto").value;
			var honorarios = ((parseInt(capital) + parseFloat(interes) + parseInt(protesto))*10/100).toFixed(2);

			document.getElementById("txthonorarios").value = honorarios;

			var total = (parseFloat(capital) + parseFloat(interes) + parseFloat(protesto) + parseFloat(honorarios)).toFixed(2); 
			document.getElementById("txttotalsimulacion").value = total;
			
		}

		function calculadora_prestamo()
		{
			//CALCULADORA PRESTAMO
			document.getElementById("txtimporte").value = parseInt(document.getElementById("txttotal").value)+parseFloat(document.getElementById("txtinteresacumulado").value);
			document.getElementById("txtinteresmensual").value = document.getElementById("txtinteres").value;
			document.getElementById("txtimpcalc").value = 0; //definir formula
			var pagomensual = (parseFloat($.trim($("#txtimporte").val())) + parseFloat($.trim($("#txtimpcalc").val()))) / parseInt($.trim($("#txtcuotascalc").val()));
			document.getElementById("txtpagomensual").value = pagomensual;
			document.getElementById("txtcostoprestamo").value = parseFloat(document.getElementById("txtimporte").value)+parseFloat(document.getElementById("txtimpcalc").value)+parseFloat(document.getElementById("txthonorarios").value);
		}


		function actualizar()
		{
			var total = document.getElementById("txtimporte").value;
			var cuotas = document.getElementById("txtcuotascalc").value;
			var valoruf = document.getElementById("txtvaloruf").value;

			document.getElementById("txtpagomensual").value = parseFloat(parseInt(total) / parseInt(cuotas)).toFixed(2);
			document.getElementById("txtcostoprestamo").value = parseFloat(document.getElementById("txtimporte").value)+parseFloat(document.getElementById("txtimpcalc").value)+parseFloat(document.getElementById("txthonorarios").value);

		}

		function calcular()
		{
			var url = "index.php?controlador=Deudores&accion=calcular";
			url += "&txtimporte="+$("#txtimporte").val();
			url += "&txtinteresmensual="+$("#txtinteresmensual").val();
			url += "&txtcuotas="+$("#txtcuotascalc").val();
			url += "&txtfechainicial="+$("#txtfechainicial").val();
			url += "&txtpagomensual="+$("#txtpagomensual").val();
			url += "&txtnumpagos="+$("#txtcuotascalc").val();
			url += "&txtimp="+$("#txtimpcalc").val();
			url += "&txtcostoprestamo="+$("#txtcostoprestamo").val();
			alert(url);
			document.getElementById("frmcalculos").src = url;
		}
	
	
		function calculoAutomatico()
		{
			if($.trim($("#txtimp").val()) == "")
			{
				return false;
			}
			
			
			var costoprestamo = parseFloat($.trim($("#txtimporte").val())) + parseFloat($.trim($("#txtimp").val()));
			var pagomensual =  (parseFloat($.trim($("#txtimporte").val())) + parseFloat($.trim($("#txtimp").val()))) / parseInt($.trim($("#txtcuotascalc").val()));
					
			$("#txtcostoprestamo").val(costoprestamo);
			$("#txtpagomensual").val(pagomensual);
			$("#txtnumpagos").val($.trim($("#txtcuotascalc").val()));
			
		}
	</script>
</head>
<body>

<?
	$protesto = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("protesto"));
	$monto = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("monto"));
	$total = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("total"));
	$fecha_venc = date("d/m/Y"); //(is_null($simulacion)) ? date("d/m/Y") : utf8_decode(formatoFecha($simulacion->get_data("fecha_venc"),"yyyy-mm-dd","dd/mm/yyyy"));
	$diasatraso = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("diasatraso"));
	$interes_diario = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_diario"));
	$interes_acumulado = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_acumulado"));
	
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
            	<iframe name="frmlistdeudor" id="frmlistdeudor" src="index.php?controlador=Deudores&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>
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
<input type="hidden" name="monto_documento_sim" id="monto_documento_sim" value="0" />
<input type="hidden" name="fecha_sim" id="fecha_sim" value="" />
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
						<input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" onblur="validaDeudor(); generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D'); simular_liquidacion();" onkeyup='mostrarDocs(this)'/>&nbsp;
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

<div style="height:500px; width:100%; overflow:scroll;">
 
<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Simulacion</th>
        <th></th>
        <th></th>
    </tr>
 </table>
</div>
<div id="datos" style=" width:100%">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

	<tr>
		<td colspan="5">
        	<iframe id="frmsubpantalla" src="index.php?controlador=Deudores&accion=liquidacion_documentos&iddeudor=0&tipoperacion=&id_liquidacion=0" width="100%" align="middle" height="170" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>

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
                    <td align="right" class="etiqueta_form">Capital&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txttotal" id="txttotal" valida="requerido" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($monto) ?>" />
                    </td>  
                </tr>
                <tr>
                    <td align="right" class="etiqueta_form">Protesto&nbsp; </td>
                    <td align="left">
                        <input type="text" name="txtprotesto" id="txtprotesto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  value="<? echo($protesto) ?>" />
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
                 <tr>	
					<td align="right" class="etiqueta_form">Honorarios DyV&nbsp;</td>
					<td align="left"><input type="text" name="txthonorarios" id="txthonorarios" size="15" class="input_form" onFocus="resaltar(this)" value="" tabindex="7"/>
        			</td>
				</tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">Total&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txttotalsimulacion" id="txttotalsimulacion"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="" />
                        <input type="radio" value="S" onclick="repactar(this)" name="rdestatus_repacta" id="rdestatus_repacta" />&nbsp;Repacta&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio"  value="N" onclick="noRepactar(this)" name="rdestatus_repacta" id="rdestatus_no_repacta" checked="checked" />&nbsp;No Repacta
                    </td>
                </tr>
                 
                 
            </table>
		</td>
     </tr>
     <tr>
     	<td height="40"></td>
     </tr>
 </table>
</div>
 <div id="formsoporte" style=" display:none"> 
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Calculadora Prestamo</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 </div>
 
<div id="datos" style=" width:100%">
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
					<td align="left"><input type="text" name="txtcuotascalc" id="txtcuotascalc" size="15" class="input_form" onblur="actualizar()" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" value="1" tabindex="3"/>
        			</td>        			
        		</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Fecha Calculo&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtfechacalculo" id="txtfechacalculo" size="15" class="input_form_medio" onFocus="resaltar(this)" value="<? echo(date("d/m/Y")) ?>" valida="requerido" tipovalida="fecha" tabindex="4"/>
        			</td>        			
        		</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Fecha Pago&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtfechainicial" id="txtfechainicial" size="15" class="input_form_medio" onFocus="resaltar(this)" value="<? echo(date("d/m/Y")) ?>" valida="requerido" tipovalida="fecha" tabindex="4"/>
        			</td>        			
        		</tr>

                <tr>	
					<td align="left" class="etiqueta_form">IMP&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtimpcalc" id="txtimpcalc" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" onblur="calculoAutomatico()" tabindex="5"/>
        			</td>        			
				</tr>
        		<tr>
					<td align="left" class="etiqueta_form">Pago Mensual&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtpagomensual" id="txtpagomensual" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" tabindex="6"/>
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
        	<span id="mensaje_prestamo" style="display:none"></span>
         </td>
    </tr>    
     <tr>
		<td colspan="3">
        	<iframe id="frmcalculos" src="" width="100%" align="middle" height="250" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>
 </table>
 </div>
 </div>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()" class="boton_form" value="Grabar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
		<td colspan="3" align="center">
        	<input  type="button" name="btnvolver" id="btnvolver" onclick="volver()" class="boton_form" value="Volver" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
    </tr>
</table>
</form>
<!--</div>-->
</body>
</html>