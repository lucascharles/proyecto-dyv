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
			$("#txtdist_corte").datepicker();
			$("#txtingreso").datepicker();
			recolectarBasura();
			
		});
		
		function recolectarBasura()
		{
			var datos = "controlador=Deudores";
			datos += "&accion=recolectarBasura";

			$.ajax({
					url: "index.php",
					type: "POST",
					data: datos,
					cache: false,
					success: function(res)
					{
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
		}
		
		function grabarFichaDeudor()
		{
			var arrayin = new Array(5);
			
			arrayin[0] = document.getElementById("txtrut_deudor");
			arrayin[1] = document.getElementById("txtrut_d_deudor");
			arrayin[2] = document.getElementById("txtrut_mandante");
			arrayin[3] = document.getElementById("txtrut_d_mandante");
			arrayin[4] = document.getElementById("txtmonto");
			arrayin[5] = document.getElementById("txtabogado");
			arrayin[6] = document.getElementById("txtfirma");
			arrayin[7] = document.getElementById("txtingreso");
			arrayin[8] = document.getElementById("txtprovidencia_1");
			arrayin[9] = document.getElementById("txtdist_corte");
			arrayin[10] = document.getElementById("txtrol");
			arrayin[11] = document.getElementById("selJuzgadoNro");
			arrayin[12] = document.getElementById("selJComuna");
			arrayin[13] = document.getElementById("ident");
			arrayin[14] = document.getElementById("tipoperacion");
			arrayin[15] = document.getElementById("id_alta");
			arrayin[16] = document.getElementById("id_doc");
			
			var arraySel = new Array();
		
			if(!validarArray(arrayin, arraySel,"N"))
			{
				return false;
			}

			var datos = "controlador=Deudores";
			if($("#tipoperacion").val() == "A")
			{
				datos += "&accion=grabarfichadeudor";
			}
			if($("#tipoperacion").val() == "M")
			{
				datos += "&accion=modificarfichadeudor";
			}
			datos += "&"+getParametrosArray(arrayin);
			//alert(datos);
			//return false;
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#pagina").load('views/default.php');
						/*
						$("#mensaje").text("Los datos de la ficha se han guardado con Ã©xito.");
						setTimeout("$('#mensaje').text('')",3000);
						$("#id_alta").val(res);
						*/
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
		}
		
		
			
		function cancelarFichaDeudor()
		{
			$("#pagina").load('views/default.php');
		}
		
		$(document).ready(function() 
		{
			cargarPantalla("DOCUMENTOS");
		});
		
		function cargarPantalla(opt)
		{
			var url = "index.php?controlador=Deudores&accion=";
			var accion = "";
			document.getElementById("btnDocumentos").setAttribute("seleccionado","");
			$(document.getElementById("btnDocumentos")).removeClass('boton_form_brillante');
			$(document.getElementById("btnDocumentos")).addClass('boton_form');
			
			document.getElementById("btnReceptor").setAttribute("seleccionado","");
			$(document.getElementById("btnReceptor")).removeClass('boton_form_brillante');
			$(document.getElementById("btnReceptor")).addClass('boton_form');
			
			document.getElementById("btnMartillero").setAttribute("seleccionado","");
			$(document.getElementById("btnMartillero")).removeClass('boton_form_brillante');
			$(document.getElementById("btnMartillero")).addClass('boton_form');
			
			document.getElementById("btnConsignacion").setAttribute("seleccionado","");
			$(document.getElementById("btnConsignacion")).removeClass('boton_form_brillante');
			$(document.getElementById("btnConsignacion")).addClass('boton_form');
			
			document.getElementById("btnGastos").setAttribute("seleccionado","");
			$(document.getElementById("btnGastos")).removeClass('boton_form_brillante');
			$(document.getElementById("btnGastos")).addClass('boton_form');
		
			if(opt == "SIMULACION")
			{
				accion = "liquidacion_simulacion";
				document.getElementById("btnSimulacion").setAttribute("seleccionado","S");
				$(document.getElementById("btnSimulacion")).addClass('boton_form_brillante');
				
			}
			if(opt == "CARTA")
			{
				accion = "liquidacion_carta";
				document.getElementById("btnCarta").setAttribute("seleccionado","S");
				$(document.getElementById("btnCarta")).addClass('boton_form_brillante');
			}
			if(opt == "CALCULADORA")
			{
				accion = "liquidacion_calculadora";
				document.getElementById("btnCalculadora").setAttribute("seleccionado","S");
				$(document.getElementById("btnCalculadora")).addClass('boton_form_brillante');
			}
			
			url += accion+"&ident="+$("#ident").val();
			url += "&tipoperacion="+$("#tipoperacion").val(); 
			url += "&id_alta="+$("#id_alta").val(); 
			url += "&id_partida=0"; 
			
			document.getElementById("frmsubpantalla").src = url;
		}
		
		function pasarIdFicha(id)
		{
			$("#id_alta").val(id); 
		}
		
		function verDatosDeudor()
		{
			$("#datos_deudor").slideDown(1000);	
		}
		function cerrarVentDD()
		{
			$("#datos_deudor").slideUp(1000);
		}
		
		function mensajeConfirmacion(mensaje)
		{
				$("#mensaje").text(mensaje);
				$("#mensaje").slideDown();
				setTimeout("$('#mensaje').text('')",3000);
		}
		
	</script>
</head>
<body>
<div id="datos_deudor" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#eeeeee" cellpadding="5" cellspacing="5"> 
    	<tr>
        	<td height="" align="right">
            	<div onclick="cerrarVentDD()" style="cursor:pointer; font-weight:bold; color:#000099;"> cerrar </div>
            </td>
        </tr>
        <tr>
        <th align="left">Datos Deudor</th>
        </tr>
        <tr>
        <td height="10" bgcolor="#999999"> </td>
        </tr>
        <tr>
        	<td height="">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
                	<tr bgcolor="#F7F7F7">
                    	<td width="50%">
                    	  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="position:relative; margin-left:10px;">
                          	<tr>
                        		<td width="110" align="left" class="etiqueta_form">Primer Apellido:</td>
                                <td align="left">&nbsp;&nbsp;<? echo($deudor->get_data("primer_apellido")) ?></td>
                             </tr>
                            <tr>
                        		<td width="" align="left" class="etiqueta_form">Segundo Apellido:</td>
                                <td align="left">&nbsp;&nbsp;<? echo($deudor->get_data("segundo_apellido")) ?></td>
                            </tr>
                            <tr>
                        		<td width="" align="left" class="etiqueta_form">Primer Nombre:</td>
                                <td align="left">&nbsp;&nbsp;<? echo($deudor->get_data("primer_nombre")) ?></td>
                            </tr>
                            <tr>
                        		<td width="" align="left" class="etiqueta_form">Segundo Nombre:</td>
                                <td align="left">&nbsp;&nbsp;<? echo($deudor->get_data("segundo_nombre")) ?></td>
                        	</tr>
                          </table>
                        </td>
						<td valign="top">
                    	  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          	<tr>
                                <td width="110" align="left" class="etiqueta_form">Celular:</td>
                                <td align="left">&nbsp;&nbsp;<? echo($deudor->get_data("celular")) ?></td>
                             </tr>
                             <tr>
                                <td width="" align="left" class="etiqueta_form">Tel&eacute;fono fijo:</td>
                                <td align="left">&nbsp;&nbsp;<? echo($deudor->get_data("telefono_fijo")) ?></td>
                             </tr>
                             <tr>
                                <td width="" align="left" class="etiqueta_form">Fax:</td>
                                <td align="left">&nbsp;&nbsp;<? echo($deudor->get_data("fax")) ?></td>
                             </tr>
                           </table>
                        </td>
                    </tr>
					<tr> 
                        <td width="100" height="15" align="left" colspan="2" class="etiqueta_form" valign="top"> </td>
                     </tr>
					<tr> 
                        <td width="100" align="left" colspan="2" class="etiqueta_form" valign="top"><font style="position:relative; margin-left:10px;">Direcci&oacute;n:</font></td>
                     </tr>
                     <tr bgcolor="#F7F7F7">
                        <td width="" align="left" class="" colspan="2">
                           <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="position:relative; margin-left:10px;">
                         		<tr>
                                	<td width="50" align="right" class="etiqueta_form">Calle</td><td align="left">&nbsp;&nbsp;<? echo($direccion->get_data("calle")) ?></td>
                                </tr>
                                <tr>
                                    <td align="right" class="etiqueta_form">N&uacute;mero</td><td align="left">&nbsp;&nbsp;<? echo($direccion->get_data("numero")) ?></td>
                                 </tr>
                                <tr>
                        			<td align="right" class="etiqueta_form">Piso</td><td align="left">&nbsp;&nbsp;<? echo($direccion->get_data("piso")) ?></td>
                                 </tr>
                                <tr>
                        			<td align="right" class="etiqueta_form">Depto</td><td align="left">&nbsp;&nbsp;<? echo($direccion->get_data("depto")) ?></td>
                                 </tr>
                                <tr>
                        			<td align="right" class="etiqueta_form">Comuna</td><td align="left">&nbsp;&nbsp;<? echo($direccion->get_data("comuna")) ?></td>
                                 </tr>
                                <tr>
                        			<td align="right" class="etiqueta_form">Ciudad</td><td align="left">&nbsp;&nbsp;<? echo($direccion->get_data("ciudad")) ?></td>
                                 </tr>
                                <tr>
                        			<td align="right" class="etiqueta_form">Otros</td><td align="left">&nbsp;&nbsp;<? echo($direccion->get_data("otros")) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
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
<?
	$nro = ""; 
	$monto = "";
	$id = 0;
		
    for($j=0; $j<$documento->get_count(); $j++) 
	{
		$datoTmp = &$documento->items[$j];
		$nro = $datoTmp->get_data("numero_documento");
		$monto = $datoTmp->get_data("monto");
		$id = $datoTmp->get_data("id_documento");
		break;
	}

	$monto = ($tipoperacion == "M") ? $ficha->get_data("monto") : "";
	$abogado = ($tipoperacion == "M") ? $ficha->get_data("abogado") : "";
	$firma = ($tipoperacion == "M") ? $ficha->get_data("firma") : "";
	$ingreso = ($tipoperacion == "M") ? formatoFecha($ficha->get_data("ingreso"),"dd-mm-yyyy","dd/mm/yyyy") : "";
	$providencia_1 = ($tipoperacion == "M") ? $ficha->get_data("providencia") : "";
	$dist_corte = ($tipoperacion == "M") ? formatoFecha($ficha->get_data("distribucion_corte"),"dd-mm-yyyy","dd/mm/yyyy") : "";
	$rol = ($tipoperacion == "M") ? $ficha->get_data("rol") : "";
	$juzgadoNro = ($tipoperacion == "M") ? $ficha->get_data("id_juzgado") : "";
	$jComuna = ($tipoperacion == "M") ? $ficha->get_data("id_juzgado_comuna") : "";
	$id_alta = ($tipoperacion == "M") ? $ficha->get_data("id_ficha") : "";
	
?>
<form name="frmdeudorliquidacion">
<input  type="hidden" name="ident" id="ident" value="<? echo($ident) ?>" grabar="S"/>
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>" grabar="S"/>
<input  type="hidden" grabar="S" name="id_alta" id="id_alta" value="<? echo($id_alta) ?>" />
<input  type="hidden" grabar="S" name="id_doc" id="id_doc" value="<? echo($id) ?>" />


  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Liquidacion Deudor</th>
        <th></th>
        <th></th>
    </tr>
 </table>

 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="datos" style="">
	<table width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
	 <tr>
		<td align="right" class="etiqueta_form" width="10">Deudor:</td><td>&nbsp;&nbsp;&nbsp; <input type="text" grabar="S" name="txtrut_deudor" id="txtrut_deudor"  valida="requerido" tipovalida="entero" size="20"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_deudor','txtrut_d_deudor')" value="<? echo($deudor->get_data("rut_deudor")) ?>" />&nbsp;
        <input type="text" grabar="S" name="txtrut_d_deudor" id="txtrut_d_deudor" valida="requerido" tipovalida="entero" size="2"   class="input_form_min" value="<? echo($deudor->get_data("dv_deudor"))?>" disabled="disabled"/>&nbsp;&nbsp; <input  type="button" name="btnDatosDeudor" id="btnDatosDeudor" onClick="verDatosDeudor()"  value="Ver Deudor" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
    </tr>
    <tr>
		<td align="right" class="etiqueta_form" width="20">Mandatario:</td><td>&nbsp;&nbsp;&nbsp; <input type="text" grabar="S" name="txtrut_mandante" id="txtrut_mandante" valida="requerido" tipovalida="entero" size="20"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_mandante','txtrut_d_mandante')" value="<? echo($mandante->get_data("rut_mandante"))?>"/>&nbsp;
        <input type="text" grabar="S" name="txtrut_d_mandante" id="txtrut_d_mandante" valida="requerido" tipovalida="entero" size="2"   class="input_form_min" value="<? echo($mandante->get_data("dv_mandante"))?>" disabled="disabled"/>
        </td>
    </tr>
    <tr>
		<td align="right" class="etiqueta_form" width="20">Deuda Neta:</td><td>&nbsp;&nbsp;&nbsp; <input type="text" grabar="S" name="txtmonto" id="txtmonto" valida="requerido" value="<? echo(conDecimales($monto)) ?>" tipovalida="moneda" size="20"  class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
    </tr>
    
    <tr>
		<td height="5"> </td>
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
                    	Simulación
                    </td>
                    <td class="boton_form" id="btnCarta" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('CARTA')">
                    	Carta
                    </td>
                    <td class="boton_form" id="btnCalculadora" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('CALCULADORA')">
                    	Calculadora de Préstamos
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