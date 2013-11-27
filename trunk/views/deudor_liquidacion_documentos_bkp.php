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
			setParametro("interes_diario_normal","txtinteres");
			setParametro("valor_uf","txtvaloruf");
		});
		
	</script>
    <script language="javascript"> 
		function seleccionado_sim(id, monto)
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
		
		function simular()
		{
			if($.trim($("#id_documento_sim").val()) == "")
			{
				return false;
			}
			
			//recuperarBanco();
			$("#txtmonto").val($("#monto_documento_sim").val());
			$("#txttotal").val($("#monto_documento_sim").val());
			
		}
		
		function recuperarBanco()
		{
			var datos = "controlador=Documentos&accion=get_datos_banco&id_doc="+$("#id_documento_sim").val();
			$.ajax({
				url: "index.php",
				type: "GET",
				data: datos,
				cache: false,
				//dataType: "json",
				success: function(res)
				{	
					$("#txtprotesto").val(res);
				},
				error: function()
				{
					$("#mensaje").text("Ha ocurrido un error y no se ha podido recuperar informacion del Banco.");
					setTimeout("$('#mensaje').text('');",3000);
					
				}
			});	
		}
		
		function setParametro(param,control)
		{
			var datos = "controlador=Parametros&accion=get_parametro&nom_param="+param;
			$.ajax({
				url: "index.php",
				type: "GET",
				data: datos,
				cache: false,
				success: function(res)
				{	
					$("#"+control).val(res);
				},
				error: function()
				{
					$("#mensaje").text("Ha ocurrido un error y no se ha podido recuperar Parametros.");
					setTimeout("$('#mensaje').text('');",3000);
					
				}
			});	
		}
		
		function limpiarSimulacion()
		{
			var array_doc = document.getElementsByTagName('input');

			for(var i=0; i<array_doc.length; i++)
			{
				if(array_doc[i].getAttribute("type") == "checkbox")
				{
					array_doc[i].checked = false;
				}
			}
			
			$("#txtprotesto").val("");
			$("#txtmonto").val("");
			$("#txttotal").val("");
			$("#txtfechavenc").val("");
			$("#txtdiasatraso").val("");
			$("#txtinteresdiario").val("");
			$("#txtinteresacumulado").val("");
		}
		
		function grabarSimulacion()
		{	
			/*
			if(!validar("N"))
			{
				return false;
			}
			*/
			var datos = "controlador=Deudores&accion=grabarSimulacion";
			datos += "&id_deudor="+$("#id_deudor").val();
			datos += "&id_mandante="+$("#id_mandante").val();
			datos += "&id_liquidacion="+$("#id_liquidacion").val();
			datos += "&txtprotesto="+$("#txtprotesto").val();
			datos += "&txtmonto="+$("#txtmonto").val();
			datos += "&txttotal="+$("#txttotal").val();
			datos += "&txtfechavenc="+$("#txtfechavenc").val();
			datos += "&txtdiasatraso="+$("#txtdiasatraso").val();
			datos += "&txtinteresdiario="+$("#txtinteresdiario").val();
			datos += "&txtinteresacumulado="+$("#txtinteresacumulado").val();
			
			var array_doc = document.getElementsByTagName('input');
			var array_param = new Array();
			var j = 0;
			for(var i=0; i<array_doc.length; i++)
			{
				if(array_doc[i].getAttribute("type") == "checkbox")
				{	
					if(array_doc[i].checked == true)
					{	
						array_param[j] = array_doc[i].id;
						j++;
					}
				}
			}
			datos += "&docs="+array_param.toString();
			
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{	
						
						$("#id_liquidacion").val(res);
						window.parent.setIdLiquidacion(res);
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido recuperar informacion del Banco.");
						setTimeout("$('#mensaje').text('');",3000);
					}
				});
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
<form name="frmsim" >
<input type="hidden" name="monto_documento_sim" id="monto_documento_sim" value="0" />
<input type="hidden" name="fecha_sim" id="fecha_sim" value="" />
<input type="hidden" name="id_deudor" valida="requerido" tipovalida="entero" id="id_deudor" value="<? echo($idddeudor) ?>" />
<input type="hidden" name="id_mandante" valida="requerido" tipovalida="entero"  id="id_mandante" value="<? echo($idmandante) ?>" />
<input type="hidden" name="id_liquidacion" valida="requerido" tipovalida="entero" id="id_liquidacion" value="<? echo($id_liquidacion) ?>" />
 <table width="99%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th align="right">
        	<div style="position:relative; margin-right:10px;">
        	<img src="images/grabar.gif" onClick="grabarSimulacion()" title="Grabar" style="cursor:pointer;">&nbsp;&nbsp;
            <img src="images/limpiar.gif" onClick="limpiarSimulacion()" title="Limpiar" style="cursor:pointer;">
            </div>
        </th>
        
    </tr>
 </table>
<div id="datos" style=" overflow:auto; height:150px; width:99%;">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
	<tr class="cabecera_listado" >
        <th align="center" width="5%"></th>
        <th align="center" width="10%"><font class="titulolistado">Nro.Doc.</font></th>
        <th align="center" width="10%"><font class="titulolistado">Fecha Recibido</font></th>
		<th align="center" width="8%"><font class="titulolistado">Monto</font></th>
		<th align="center" width="8%"><font class="titulolistado">Estado</font></th>
        <th align="center" width="9%"><font class="titulolistado">Fecha Protesto</font></th>
        <th align="center" width="8%"><font class="titulolistado">Tipo Doc.</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDoc->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDoc->items[$j];
		$checked = "";
		if(in_array($datoTmp->get_data("id_documento"),$array_doc))
		{
			$checked = "checked";
		}
	?>
	<tr bgcolor="#FFFFFF">
    	<td><input type="checkbox" monto="<?php echo ($datoTmp->get_data("monto")) ?>" fecha_doc="<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?>" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checkdoc_sim" value="" onclick="seleccionado_sim(<? echo($datoTmp->get_data("id_documento")) ?>,<? echo($datoTmp->get_data("monto")) ?>)" <? echo($checked) ?>></td>	
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_siniestro"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"dd-mm-yyyy","dd/mm/yyyy"))?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
	</tr>
	<?php
	}
	?>
</table>
</div>

<div > 
<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2" align="right">
        	<!--
        	<input  type="button" name="btnsimular" id="btnsimular" onclick="simular()" class="boton_form" value="Simular" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' style="position:relative; margin-right:30px;"/>
            -->
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
                        <input type="text" name="txtinteres" id="txtinteres" class="input_form_min" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="porcentaje" />
                    </td>  
                </tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">Valor UF:&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtvaloruf" id="txtvaloruf"  class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" />
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
</form>
</body>
</html>