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
    <link rel="stylesheet" href="css/autocompletar/jquery/themes/base/jquery.ui.all.css" type="text/css" />

    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
  	<script src="js/funciones.js" type="text/javascript"></script>
    <script src="js/funcionesgral.js" type="text/javascript"></script>
    
	<script src="js/autocompletar/jquery/ui/jquery.ui.core.js" type="text/javascript"></script>
	<script src="js/autocompletar/jquery/ui/jquery.ui.widget.js" type="text/javascript"></script>
    <script src="js/autocompletar/jquery/ui/jquery.ui.position.js" type="text/javascript"></script>
    <script src="js/autocompletar/jquery/ui/jquery.ui.autocomplete.js" type="text/javascript"></script>	
    
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
	
 	
   	
    
    <script language="javascript">
	$(function () {
			$.datepicker.setDefaults($.datepicker.regional["es"]);
			$("#txtdist_corte").datepicker({changeYear: true});
			$("#txtingreso").datepicker({changeYear: true});
			 $("#txtjuzgadoanexo").autocomplete({
		            source: "ajax/lista_juzgados.php",
					minLength: 3, 
		       		select: asignarIdJuzgado
		        });
		});

		function asignarIdJuzgado(event, ui)
		{
			var id = ui.item.id;
			if(id != "undefined" && $.trim(id) != "")
			{
				$("#id_juzgado").val(id);
			}
		}
	
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
						$("#mensaje").show();
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
		}
		
		function grabarFichaDeudor()
		{
			var arrayin = new Array(19);
			arrayin[0] = document.getElementById("txtrut_deudor");
			arrayin[1] = document.getElementById("txtrut_d_deudor");
			arrayin[2] = document.getElementById("txtrut_mandante");
			arrayin[3] = document.getElementById("txtrut_d_mandante");
			arrayin[4] = document.getElementById("txtmonto");
			arrayin[5] = document.getElementById("txtabogado");
			arrayin[7] = document.getElementById("txtingreso");
			arrayin[9] = document.getElementById("txtdist_corte");
			arrayin[10] = document.getElementById("txtrol");
			arrayin[13] = document.getElementById("ident");
			arrayin[14] = document.getElementById("tipoperacion");
			arrayin[15] = document.getElementById("id_alta");
			arrayin[16] = document.getElementById("id_doc");
			arrayin[17] = document.getElementById("txtabogado2");
			arrayin[18] = document.getElementById("txtjuzgadoanexo");
			arrayin[19] = document.getElementById("txtexhorto");
			arrayin[20] = document.getElementById("txtexhorto2");
			arrayin[21] = document.getElementById("txtexhorto3");


			var arraySel = new Array();

			var datos = "controlador=Deudores";
			if($("#tipoperacion").val() == "A")
			{
				datos += "&accion=grabarfichadeudor";
			}
			if($("#tipoperacion").val() == "M")
			{
				datos += "&accion=modificarfichadeudor";
			}

			datos += "&txtrut_deudor="+document.getElementById("txtrut_deudor").value;
			datos += "&txtrut_d_deudor="+document.getElementById("txtrut_d_deudor").value;
			datos += "&txtrut_mandante="+document.getElementById("txtrut_mandante").value;
			datos += "&txtrut_d_mandante="+document.getElementById("txtrut_d_mandante").value;
			datos += "&txtmonto="+document.getElementById("txtmonto").value;
			
			datos += "&txtabogado="+document.getElementById("txtabogado").value;
			datos += "&txtabogado2="+document.getElementById("txtabogado2").value;
			datos += "&txtdist_corte="+document.getElementById("txtdist_corte").value;
			datos += "&txtrol="+document.getElementById("txtrol").value;
			datos += "&id_alta="+document.getElementById("id_alta").value;
			datos += "&tipoperacion="+document.getElementById("tipoperacion").value;
			datos += "&txtjuzgadoanexo="+document.getElementById("txtjuzgadoanexo").value;

			datos += "&txtaval="+document.getElementById("txtaval").value;
			datos += "&txtrutaval="+document.getElementById("txtrutaval").value;
			datos += "&txttelaval="+document.getElementById("txttelaval").value;
			datos += "&txtdomicilioaval="+document.getElementById("txtdomicilioaval").value;
			datos += "&txtexhorto="+document.getElementById("txtexhorto").value;
			datos += "&txtexhorto2="+document.getElementById("txtexhorto2").value;
			datos += "&txtexhorto3="+document.getElementById("txtexhorto3").value;
			datos += "&listdocs="+document.getElementById("listdocs").value;
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						
						$("#mensaje").text("Los datos de la Ficha se han guardado correctamente.");
						$("#mensaje").show();
						setTimeout("$('#mensaje').text('')",3000);
						
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						$("#mensaje").show();
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
		}
		
		
			
		function cancelarFichaDeudor()
		{
			var idGes = document.getElementById("idGes").value;
			var idestadoges = 7; // document.getElementById("idestadoges").value;
			var rutM = document.getElementById("txtrut_mandante").value;
			var tipoges = document.getElementById("tipo_ges").value;
			var fecproxges = document.getElementById("fecproxges").value;
			$("#pagina").load('index.php?controlador=Gestiones&accion=gestionar&idgestion='+idGes+'&estadoGes='+idestadoges+'&rutM='+rutM+"&tipoGestion="+tipoges+'&fecproxges='+fecproxges);
			
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

			document.getElementById("btnDDAEjecutiva").setAttribute("seleccionado","");
			$(document.getElementById("btnDDAEjecutiva")).removeClass('boton_form_brillante');
			$(document.getElementById("btnDDAEjecutiva")).addClass('boton_form');
			
			if(opt == "DOCUMENTOS")
			{
				accion = "ficha_documentos";
				document.getElementById("btnDocumentos").setAttribute("seleccionado","S");
				$(document.getElementById("btnDocumentos")).addClass('boton_form_brillante');
				
			}
			if(opt == "RECEPTOR")
			{
				accion = "ficha_receptor";
				document.getElementById("btnReceptor").setAttribute("seleccionado","S");
				$(document.getElementById("btnReceptor")).addClass('boton_form_brillante');
			}
			if(opt == "MARTILLERO")
			{
				accion = "ficha_martillero";
				document.getElementById("btnMartillero").setAttribute("seleccionado","S");
				$(document.getElementById("btnMartillero")).addClass('boton_form_brillante');
			}
			if(opt == "CONSIGNACION")
			{
				accion = "ficha_consignacion";
				document.getElementById("btnConsignacion").setAttribute("seleccionado","S");
				$(document.getElementById("btnConsignacion")).addClass('boton_form_brillante');
			}
			if(opt == "GASTOS")
			{
				accion = "ficha_gastos";
				document.getElementById("btnGastos").setAttribute("seleccionado","S");
				$(document.getElementById("btnGastos")).addClass('boton_form_brillante');
			}
			if(opt == "DDAEJECUTIVA")
			{
				accion = "ficha_ddaejecutiva";
				document.getElementById("btnDDAEjecutiva").setAttribute("seleccionado","S");
				$(document.getElementById("btnDDAEjecutiva")).addClass('boton_form_brillante');
				
			}
			
			url += accion+"&ident="+$("#ident").val();
			url += "&tipoperacion="+$("#tipoperacion").val(); 
			url += "&id_alta="+$("#id_alta").val();
			url += "&listdocs="+$("#listdocs").val();
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

		function cambiaTexto(c,o){
			c.options[c.selectedIndex].text = o.value
			o.style.display = 'none'
			c.style.display = 'inline'
		}
		function cambiaCampo(c,o,v){
			if(o.selectedIndex>0){
				o.style.display = 'none'
				c.style.display = 'inline'
				c.value = v
				c.focus()
			}
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

	$monto = ($tipoperacion == "M") ? $ficha->get_data("monto") : $montodemanda;
	$abogado = ($tipoperacion == "M") ? $ficha->get_data("abogado") : "";
	$abogado2 = ($tipoperacion == "M") ? $ficha->get_data("abogado2") : "";
	$exhorto = ($tipoperacion == "M") ? $ficha->get_data("exhorto") : "";
	$exhorto2 = ($tipoperacion == "M") ? $ficha->get_data("exhorto2") : "";
	$exhorto3 = ($tipoperacion == "M") ? $ficha->get_data("exhorto3") : "";
	$firma = ($tipoperacion == "M") ? $ficha->get_data("firma") : "";
	$ingreso = ($tipoperacion == "M") ? formatoFecha($ficha->get_data("ingreso"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$providencia_1 = ($tipoperacion == "M") ? $ficha->get_data("providencia") : "";
	$dist_corte = ($tipoperacion == "M") ? formatoFecha($ficha->get_data("distribucion_corte"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$rol = ($tipoperacion == "M") ? $ficha->get_data("rol") : "";
	$juzgadoNro = ($tipoperacion == "M") ? $ficha->get_data("id_juzgado") : "";
	$jComuna = ($tipoperacion == "M") ? $ficha->get_data("id_juzgado_comuna") : "";
	$id_alta = ($tipoperacion == "M") ? $ficha->get_data("id_ficha") : "";
	$juzgadoanexo = ($tipoperacion == "M") ? $ficha->get_data("juzgado_anexo") : "";

	$aval = ($tipoperacion == "M") ? $ficha->get_data("aval") : "";
	$rutaval = ($tipoperacion == "M") ? $ficha->get_data("rut_aval") : "";
	$telaval = ($tipoperacion == "M") ? $ficha->get_data("tel_aval") : "";
	$domicilioaval = ($tipoperacion == "M") ? $ficha->get_data("domicilio_aval") : "";
	
?>
<form name="frmadmtipdoc">
<input  type="hidden" name="ident" id="ident" value="<? echo($ident) ?>" grabar="S"/>
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>" grabar="S"/>
<input  type="hidden" grabar="S" name="id_alta" id="id_alta" value="<? echo($id_alta) ?>" />
<input  type="hidden" grabar="S" name="id_doc" id="id_doc" value="<? echo($id) ?>" />
<input  type="hidden" name="idGes" id="idGes" value="<? echo($idGes) ?>" />
<input  type="hidden" name="idestadoges" id="idestadoges" value="<? echo($idestadoges) ?>" />
<input  type="hidden" name="listdocs" id="listdocs" value="<? echo($list_docs) ?>" />
<input  type="hidden" name="id_juzgado" id="id_juzgado" value="" />
<input  type="hidden" name="tipo_ges" id="tipo_ges" value="<? echo($tipo_ges) ?>" />
<input  type="hidden" name="fecproxges" id="fecproxges" value="<? echo($fecproxges) ?>" />
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Ficha Deudor</th>
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
		<td align="right" class="etiqueta_form" width="20">Monto:</td><td>&nbsp;&nbsp;&nbsp; <input type="text" grabar="S" name="txtmonto" id="txtmonto" valida="requerido" value="<? echo($monto) ?>"  size="20"  class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
    </tr>
     <tr>

		<td align="right" class="etiqueta_form">Nro. doc.:</td><td>&nbsp;&nbsp;&nbsp;<? echo($id_alta) ?> </td>
    </tr>
     <tr>
		<td height="5"> </td>
    </tr>
   </table>
</div>

<div id="datos" style="">
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="center" height="30">&nbsp;General</th>
        <th></th>
        <th></th>
    </tr>
 	</table>
	<table width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
     <tr>
     </tr>
	 <tr>
		<td align="left" class="etiqueta_form">Abogado</td>
        <td align="left" class="etiqueta_form">Abogado (2)</td>
		<td align="left" class="etiqueta_form">Exhorto (1)</td>
		<td align="left" class="etiqueta_form">Exhorto (2)</td>
		<td align="left" class="etiqueta_form">Exhorto (3)</td>
    </tr>
    <tr>
        <td><input type="text" grabar="S" name="txtabogado"  value="<? echo($abogado) ?>" id="txtabogado"  size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" grabar="S" name="txtabogado2" id="txtabogado2"  value="<? echo($abogado2) ?>" size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
		<td><input type="text" grabar="S" name="txtexhorto" id="txtexhorto"  value="<? echo($exhorto) ?>" size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
		</td>
		<td><input type="text" grabar="S" name="txtexhorto2" id="txtexhorto2"  value="<? echo($exhorto2) ?>" size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
		</td>
		<td><input type="text" grabar="S" name="txtexhorto3" id="txtexhorto3"  value="<? echo($exhorto3) ?>" size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
		</td>
    </tr>
    <tr>
		<td align="left" class="etiqueta_form">Distribuci&oacute;n Corte</td>
        <td align="left" class="etiqueta_form">Rol</td>
        <td align="left" class="etiqueta_form">Poder Judicial</td>
    </tr>
    <tr>
        <td><input type="text" grabar="S" name="txtdist_corte" value="<? echo($dist_corte) ?>" id="txtdist_corte"  size="20" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" onKeyUp="this.value=formateafecha(this.value)" />
        </td>
        <td><input type="text" grabar="S" name="txtrol"  value="<? echo($rol) ?>"id="txtrol"  size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
<!--        <td><input type="text" grabar="S" name="txtjuzgadoanexo"  value="<? echo($juzgadoanexo) ?>" id="txtjuzgadoanexo"  size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />-->
<!--        </td>-->
        
        <td>
        <input type="text" grabar="S" name="txtjuzgadoanexo" id="txtjuzgadoanexo" value="<? echo($juzgadoanexo) ?>"  class="input_form" onFocus="resaltar(this)" referente="id_juzgado" onBlur="noresaltar(this)"/>
        	<!--<select name="txtjuzgadoanexo" grabar="S"  id="txtjuzgadoanexo" value="<? echo($juzgadoanexo) ?>"  class= "input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode($juzgadoanexo) ?></option>
        		<option value="1 CIVIL VALPARAISO">1 CIVIL VALPARAISO</option>
  				<option value="2 CIVIL VALPARAISO">2 CIVIL VALPARAISO</option>
  				<option value="4 CIVIL VALPARAISO">4 CIVIL VALPARAISO</option>
  				<option value="5 CIVIL VALPARAISO">5 CIVIL VALPARAISO</option>
  				<option value="1 VI�A DEL MAR">1 CIVIL VI�A DEL MAR</option>
  				<option value="2 VI�A DEL MAR">2 CIVIL VI�A DEL MAR</option>
  				<option value="3 VI�A DEL MAR">3 CIVIL VI�A DEL MAR</option>
  				<option value="28 CIVIL SANTIAGO">28 CIVIL SANTIAGO</option>
  				<option value="12 CIVIL SANTIAGO">12 CIVIL SANTIAGO</option>
  				<option value="28 VI�A DEL MAR">28 CIVIL SANTIAGO</option>
			</select>
        --></td>
    </tr>
    
    <tr>
		<td colspan="4" height="10"> </td>
    </tr>
    <tr>
		<td align="left" class="etiqueta_form">Aval</td>
        <td align="left" class="etiqueta_form">Rut Aval</td>
        <td align="left" class="etiqueta_form">Tel Aval</td>
        <td align="left" class="etiqueta_form">Domicilio Aval</td>
    </tr>
    <tr>
		<td><input type="text" name="txtaval" value="<? echo($aval) ?>" id="txtaval"  size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" name="txtrutaval"  value="<? echo($rutaval) ?>"id="txtrutaval"  size="20" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" name="txttelaval"  value="<? echo($telaval) ?>" id="txttelaval"  size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" name="txtdomicilioaval"  value="<? echo($domicilioaval) ?>" id="txtdomicilioaval"  size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
		
		<td colspan="4" align="right"> 
        <input  type="button" name="btngrabar" id="btngrabar" onClick="grabarFichaDeudor()"  value="Confirmar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
        <?
        if($origen <> "admin_fichas")
		{
		?>
         	<input  type="button" name="btncancelar" id="btncancelar" onClick="cancelarFichaDeudor()"value="Volver" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
        <?
        }
		?>
        </td>
    </tr>
    
     <tr>
		<td colspan="4" height="15" align="left"><span id="mensaje" style="display:none"></span> </td>
    </tr>
   </table>
</div>

 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 	<tr>
		<td colspan="3">
        	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="boton_form_brillante" seleccionado="S" id="btnDocumentos" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('DOCUMENTOS')">
                    	Documentos
                    </td>
                    <td class="boton_form" id="btnReceptor" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('RECEPTOR')">
                    	Notificacion / Citacion
                    </td>
                    <td class="boton_form" id="btnDDAEjecutiva" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('DDAEJECUTIVA')">
                    	DDA Ejecutiva
                    </td>
                    <td class="boton_form" id="btnMartillero" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('MARTILLERO')">
                    	Embargo y Martillero
                    </td>
                    <td class="boton_form" id="btnConsignacion" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('CONSIGNACION')">
                    	Consignaciones / Devoluciones
                    </td>
                    <td class="boton_form"  id="btnGastos" onMouseOver='overClassBotonMenu(this)' onMouseOut='outClassBotonMenu(this)' onclick="cargarPantalla('GASTOS')">
                    	Gastos
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