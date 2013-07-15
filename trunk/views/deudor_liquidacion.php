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
    <script src="js/funcionesgral.js" type="text/javascript"></script>		

    <script language="javascript">
		$(document).ready(function(){
			$("#txtfecha").datepicker({changeYear: true});	
			$("#txtfechavenc").datepicker({changeYear: true});
			$("#txtfechacalculo").datepicker({changeYear: true});
			$("#txtfechainicial").datepicker({changeYear: true});	
			$('form').validator();
			$("#txtfechaRecibido").datepicker({changeYear: true});
			$("#txtfechaprotesto").datepicker({changeYear: true});
			$('form').validator();		
			validaDeudor(); 
			generadvrut('txtrut_deudor','txtdv_deudor'); 
			validarRut('D'); 
			simular_liquidacion();
		});
		
		
		function ventanaBusqueda(op)
		{
	
			if(op == "D")
			{
				$("#selecDeudor").slideDown(1000);	
				document.getElementById("txtrut_d").focus();
			}
			
		}

		function repactar()
		{
			if(document.getElementById("rdestatus_repacta").checked == true)
			{
				$("#formsoporte").show("slow");
				calculadora_prestamo();
			}
		}
	

		function noRepactar()
		{
			if(document.getElementById("rdestatus_no_repacta").checked == true)
			{
				document.getElementById("rdestatus_repacta").value = "";
				$("#formsoporte").hide("slow");
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
		
		//TODO: mostrar docs
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_deudor").value = id;
			buscarDatosDeudor(id);
			simular_liquidacion();
			cerrarVentDeudor();
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

		
		
		function cerrarVentDeudor()
		{
			$("#selecDeudor").slideUp(1000);
			//document.getElementById("frmtipocom").src = "";
		}
		
		function volver()
		{
			if($.trim($("#control_volver").val()) != "")
			{
				$("#pagina").load('index.php?controlador='+$("#control_volver").val()+'&accion='+$("#accion_volver").val()+'&'+$("#param_volver").val()+'='+$("#val_volver").val());
			}
			else
			{
				var url = "index.php?controlador=Deudores&accion=admin_liquidaciones";
				if($.trim($("#id_deudor").val()) != "")
				{
					url += '&iddeudor='+$("#id_deudor").val();
					$("#pagina").load(url);
				}
			}
		}
		
		function grabar()
		{		
			if($.trim($("#id_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
				return false;
			}
			
			if($.trim($("#docs").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar Documentos para la simulacion");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
				return false;
			}
			
			var arrayin = new Array();
			arrayin[0] = document.getElementById("txtinteres");
			arrayin[1] = document.getElementById("txtvaloruf");
			arrayin[2] = document.getElementById("txtfecha");
			arrayin[3] = document.getElementById("txttotal");
			arrayin[4] = document.getElementById("txtprotesto");
			arrayin[5] = document.getElementById("txtfechavenc");
			arrayin[6] = document.getElementById("txtdiasatraso");
			arrayin[7] = document.getElementById("txtinteresdiario");
			arrayin[8] = document.getElementById("txtinteresacumulado");
			arrayin[9] = document.getElementById("txthonorarios");
			arrayin[10] = document.getElementById("txttotalsimulacion");
			
			if(document.getElementById("rdestatus_repacta").checked == true)
			{
				arrayin[11] = document.getElementById("txtimporte");
				arrayin[12] = document.getElementById("txtinteresmensual");
				arrayin[13] = document.getElementById("txtcuotascalc");
				arrayin[14] = document.getElementById("txtfechacalculo");
				arrayin[15] = document.getElementById("txtfechainicial");
				arrayin[16] = document.getElementById("txtimpcalc");
				arrayin[17] = document.getElementById("txtpagomensual");
				arrayin[18] = document.getElementById("txtcostoprestamo");
			}
			
			var arraySel = new Array();
			
//			if(!validarArray(arrayin, arraySel,"N"))
//			{
//				return false;
//			}
			
			
				var datos = "controlador=Deudores";
				
				datos += "&accion=grabarLiquidacion";
				datos += "&deudor="+$("#id_deudor").val();
				datos += "&interes="+$("#txtinteres").val();
				datos += "&valoruf="+$("#txtvaloruf").val();
				datos += "&fechasimulacion="+$("#txtfecha").val();
				
				datos += "&capital="+$("#txttotal").val();
				datos += "&protesto="+$("#txtprotesto").val();
				datos += "&fechavenc="+$("#txtfechavenc").val();
				datos += "&diasatraso="+$("#txtdiasatraso").val();
				datos += "&interesdiario="+$("#txtinteresdiario").val();
				datos += "&interesacumulado="+$("#txtinteresacumulado").val();
				datos += "&honoraiorsdyv="+$("#txthonorarios").val();
				datos += "&total="+$("#txttotalsimulacion").val();

				datos += "&importeprestamo="+$("#txtimporte").val();
				datos += "&interesmensual="+$("#txtinteresmensual").val();
				datos += "&cuotas="+$("#txtcuotascalc").val();
				datos += "&fechacalculo="+$("#txtfechacalculo").val();
				datos += "&fechapago="+$("#txtfechainicial").val();
				datos += "&imp="+$("#txtimpcalc").val();
				datos += "&pagomensual="+$("#txtpagomensual").val();
				datos += "&costototal="+$("#txtcostoprestamo").val();
				datos += "&docs="+$("#docs").val();
				if(document.getElementById("rdestatus_repacta").checked == true)
				{
					datos += "&repacta=S";
				}
				else
				{
					datos += "&repacta=N";
				}

				$.ajax({
					url: "index.php",
					type: "GET",	
					data: datos,
					cache: false,
					success: function(res)
					{	
						if($.trim($("#control_volver").val()) != "")
						{
							$("#pagina").load('index.php?controlador='+$("#control_volver").val()+'&accion='+$("#accion_volver").val()+'&'+$("#param_volver").val()+'='+$("#val_volver").val());
						}
						else
						{					
							$("#pagina").load('index.php?controlador=Deudores&accion=admin_liquidaciones&iddeudor='+$("#id_deudor").val());
						}
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
		
		function quitarDoc(id,monto,fecha,dias)
		{
			var array = document.getElementById("docs").value.split(",");
			document.getElementById("docs").value = "";
			for(var i=0; i<array.length; i++)
			{
				if(array[i] != id)
				{
					if(document.getElementById("docs").value == "")
					{
						document.getElementById("docs").value = array[i];
					}	
					else
					{
						document.getElementById("docs").value += ","+array[i];
					}
				}
			}
					
			document.getElementById("txttotal").value = monto;
			document.getElementById("txtfechavenc").value = fecha;
			document.getElementById("txtdiasatraso").value = dias;
			
			// CALCULO INTERES DIARIO 
			var interes = ((parseFloat($("#txtinteres").val()) * parseFloat(document.getElementById("txttotal").value) ) / 100)/30;
			if(interes == 0)
			{
				$("#txtinteresdiario").val(0);
			}
			else
			{
				$("#txtinteresdiario").val(interes.toFixed(2));
			}
			
			// CALCULO INTERES ACUMULADO 
			var int_acum = interes * parseInt(dias);
			if(int_acum == 0)
			{
				$("#txtinteresacumulado").val(0);
			}
			else
			{
				$("#txtinteresacumulado").val(int_acum.toFixed(2));
			}

			//CALCULO DE SIMULACION
			var capital = document.getElementById("txttotal").value;
			var interes = document.getElementById("txtinteresacumulado").value;
			var protesto = document.getElementById("txtprotesto").value;
//			alert(capital+" / "+interes+" / "+protesto)
			var honorarios = ((parseInt(capital) + parseFloat(interes) + parseInt(protesto))*10/100).toFixed(2);

			document.getElementById("txthonorarios").value = honorarios;

			var total = (parseFloat(capital) + parseFloat(interes) + parseFloat(protesto) + parseFloat(honorarios)).toFixed(2); 
			document.getElementById("txttotalsimulacion").value = total;
		}

		function seleccionado(id,monto,fecha,dias)
		{
			if(document.getElementById("docs").value == "")
			{
				document.getElementById("docs").value = id;
			}	
			else
			{
				document.getElementById("docs").value += ","+id;
			}

			document.getElementById("txttotal").value = monto;
			document.getElementById("txtfechavenc").value = fecha;
			document.getElementById("txtdiasatraso").value = dias;

			// CALCULO INTERES DIARIO 
			var interes = Math.ceil(((parseFloat($("#txtinteres").val()) * parseFloat(document.getElementById("txttotal").value) ) / 100)/30);
			if(interes == 0)
			{
				$("#txtinteresdiario").val("");
			}
			else
			{
				$("#txtinteresdiario").val(interes);
			}
			
			// CALCULO INTERES ACUMULADO 
			var int_acum = interes * parseInt(dias);
			if(int_acum == 0)
			{
				$("#txtinteresacumulado").val("");
			}
			else
			{
				$("#txtinteresacumulado").val(int_acum);
			}

			//CALCULO DE SIMULACION
			var capital = document.getElementById("txttotal").value;
			var interes = document.getElementById("txtinteresacumulado").value;
			var protesto = document.getElementById("txtprotesto").value;
			var honorarios = Math.ceil(((parseInt(capital) + parseFloat(interes) + parseInt(protesto))*10/100));

			document.getElementById("txthonorarios").value = honorarios;

			var total = Math.ceil((parseFloat(capital) + parseFloat(interes) + parseFloat(protesto) + parseFloat(honorarios))); 
			document.getElementById("txttotalsimulacion").value = total;
			
		}

		function calculadora_prestamo()
		{
			//CALCULADORA PRESTAMO
			
			var porcentaje_prestamo = (parseFloat(document.getElementById("txttotal").value)+parseFloat(document.getElementById("txtinteresacumulado").value))*30/100;
			
			document.getElementById("txtimporte").value = (parseInt(document.getElementById("txttotal").value)+parseFloat(document.getElementById("txtinteresacumulado").value))- parseFloat(porcentaje_prestamo);
//			document.getElementById("txtinteresmensual").value = document.getElementById("txtinteres").value;
			document.getElementById("txtimpcalc").value = 0; //definir formula

			var pagomensual = (parseFloat($.trim($("#txtimporte").val())) + parseFloat($.trim($("#txtimpcalc").val()))) / parseInt($.trim($("#txtcuotascalc").val()));
			document.getElementById("txtpagomensual").value = pagomensual;
			document.getElementById("txtcostoprestamo").value = parseFloat(document.getElementById("txtimporte").value)+parseFloat(document.getElementById("txtimpcalc").value)+parseFloat(document.getElementById("txthonorarios").value);

			
			var pagocontado = parseFloat(porcentaje_prestamo) + parseFloat(document.getElementById("txthonorarios").value);
			document.getElementById("txtpagocontado").value = pagocontado;
		}


		function actualizar()
		{
			var total = document.getElementById("txtcostoprestamo").value;
			var cuotas = document.getElementById("txtcuotascalc").value;
			var valoruf = document.getElementById("txtvaloruf").value;

			document.getElementById("txtpagomensual").value = parseFloat(parseInt(total) / parseInt(cuotas)).toFixed(2);
			document.getElementById("txtcostoprestamo").value = parseFloat(document.getElementById("txtimporte").value)+parseFloat(document.getElementById("txtimpcalc").value)+parseFloat(document.getElementById("txthonorarios").value);

		}

		function calcular()
		{
			var interes;
			var capital;
			var imp = 0;
			var cuotas = document.getElementById("txtcuotascalc").value;	
			var saldo_inicial = document.getElementById("txtcostoprestamo").value;
			var interes_mensual = document.getElementById("txtinteresmensual").value;
			var pago_mensual = document.getElementById("txtpagomensual").value;
		

			for($i=0; $i<cuotas; $i++)
			{
				interes = (parseInt(saldo_inicial) * parseInt(interes_mensual))/100;
				capital = parseInt(pago_mensual) - parseInt(interes);
				imp = imp + parseInt(interes);
				saldo_inicial = parseInt(saldo_inicial) - parseInt(capital);
			}

			document.getElementById("txtimpcalc").value = imp;
			var url = "index.php?controlador=Deudores&accion=calcular";
			url += "&txtimporte="+$("#txtimporte").val();
			url += "&txtinteresmensual="+$("#txtinteresmensual").val();
			url += "&txtcuotas="+$("#txtcuotascalc").val();
			url += "&txtfechainicial="+$("#txtfechainicial").val();
			url += "&txtpagomensual="+$("#txtpagomensual").val();
			url += "&txtnumpagos="+$("#txtcuotascalc").val();
			url += "&txtimp="+$("#txtimpcalc").val();
			url += "&txtcostoprestamo="+$("#txtcostoprestamo").val();
//			alert(url);
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
<input grabar="S" type="hidden" name="id_deudor" id="id_deudor" value="<?=$deudor->get_data("id_deudor")?>"/>
<input grabar="S" type="hidden" name="id_liquidacion" id="id_liquidacion" value="<? if($id_liquidacion == "") $id_liquidacion = 0; echo($id_liquidacion) ?>"/>
<input grabar="S" type="hidden" name="docs" id="docs" value=""/>
<input type="hidden" name="control_volver" id="control_volver" value="<? echo($control_volver) ?>" />
<input type="hidden" name="accion_volver" id="accion_volver" value="<? echo($accion_volver) ?>" />
<input type="hidden" name="param_volver" id="param_volver" value="<? echo($param_volver) ?>" />
<input type="hidden" name="val_volver" id="val_volver" value="<? echo($val_volver) ?>" />

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
						<input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" onblur="validaDeudor(); generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D'); simular_liquidacion();" value="<?=$deudor->get_data("rut_deudor")?>" onkeyup='mostrarDocs(this)' disabled="disabled"/>&nbsp;
	            		<input type="text" name="txtdv_deudor" id="txtdv_deudor" class="input_form_min" onblur="" disabled="disabled" />&nbsp;
                    </td>
                	<td align="left">
			           <!-- <img src="images/buscar.png" title="Buscar Deudor" style="cursor:pointer" onclick="ventanaBusqueda('D')"/>-->
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
                        <input type="text" name="txtfecha" id="txtfecha" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo(date("d/m/Y")) ?>" valida="requerido" tipovalida="fecha" onKeyUp="this.value=formateafecha(this.value)"/>
                    </td>                                   
                </tr>
                <tr>  
                    <td align="right" class="etiqueta_form">% Interes:&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteres" id="txtinteres" value="<?=conDecimales($interes_base)?>" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" />
                    </td>  
                </tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">Valor UF:&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtvaloruf" id="txtvaloruf"  value="<?=$valoruf?>"   class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" />
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
                        <input type="text" name="txtfechavenc" id="txtfechavenc" valida="requerido" tipovalida="fecha" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  value="<? echo($fecha_venc) ?>" onKeyUp="this.value=formateafecha(this.value)"/>
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
					<td align="left"><input type="text" name="txthonorarios" id="txthonorarios" size="15" class="input_form" onFocus="resaltar(this)" value="" tabindex="7" valida="requerido" tipovalida="moneda"/>
        			</td>
				</tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">Total&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txttotalsimulacion" id="txttotalsimulacion"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="" valida="requerido" tipovalida="moneda" />
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
					<td align="left" class="etiqueta_form">Pago Contado&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtpagocontado" id="txtpagocontado" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="<?=conDecimales($interes_simulacion)?>" tabindex="2"/>
        			</td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Interes mensual&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtinteresmensual" id="txtinteresmensual" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="<?=$interes_simulacion?>" tabindex="2"/>
        			</td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Cuotas&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtcuotascalc" id="txtcuotascalc" size="15" class="input_form" onblur="actualizar()" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" value="<?=$cuotas_simulacion?>" tabindex="3"/>
        			</td>        			
        		</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Fecha Calculo&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtfechacalculo" id="txtfechacalculo" size="15" class="input_form_medio" onFocus="resaltar(this)" value="<? echo(date("d/m/Y")) ?>" valida="requerido" tipovalida="fecha" tabindex="4" onKeyUp="this.value=formateafecha(this.value)"/>
        			</td>        			
        		</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Fecha Pago&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtfechainicial" id="txtfechainicial" size="15" class="input_form_medio" onFocus="resaltar(this)" value="<?=$fecha_pago?>" valida="requerido" tipovalida="fecha" tabindex="4" onKeyUp="this.value=formateafecha(this.value)"/>
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