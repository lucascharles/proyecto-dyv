
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
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

	 <script src="js/funcionesgral.js" type="text/javascript"></script>
    
    <script language="javascript">
		
		$(function () {
			$("#txtcertificado").datepicker({changeYear: true});
			$("#txtmandamiento").datepicker({changeYear: true});
			$("#txtbusqueda").datepicker({changeYear: true});
			$("#txtddaejec").datepicker({changeYear: true});
			$("#txtnotificacion").datepicker({changeYear: true});
			$("#txtencargado").datepicker({changeYear: true});
		});
		
		$(document).ready(function(){
			
  			$('form').validator();
			$("#txtfecha_remate").datepicker();			
		});
		
		
		function grabarDDaEjec()
		{
			if(!validar("N"))
			{
				return false;
			}
					
			var datos = "controlador=Deudores";
			
			if($("#tipoperacion").val() == "A")
			{
				if($("#id_alta").val() > 0 && $.trim($("#id_alta").val()) != "")
				{
					datos += "&accion=grabarDDaEjecM";	
				}
				else
				{
					datos += "&accion=grabarDDaEjecA";	
				}
			}
			
			if($("#tipoperacion").val() == "M")
			{				
				datos += "&accion=editarDDaEjec";	
			}
		
			datos += "&"+getParametros();
			datos += "&"+"idusuario=usuarioX";
			//alert(datos);
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						//alert(res);
						window.parent.pasarIdFicha(res);
						$("#id_alta").val(res);
						window.parent.mensajeConfirmacion("Los datos de la DDA Ejecutiva se guardaron con éxito");
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function limpiarDDaEjec()
		{
			limpiarCampos();
		}
	</script>
</head>
<body>

<?
	if($tipoperacion == "M")
	{
		$id_alta  = $ident;
	}
	/*
	$aceptacion_cargo = ($id_alta > 0) ? $martillero->get_data("aceptacion_cargo") : "";
	$nombre = ($id_alta > 0) ? $martillero->get_data("nombre") : "";
	$rut_martilero = ($id_alta > 0) ? $martillero->get_data("rut_martilero") : "";
	$dv_martillero = ($id_alta > 0) ? $martillero->get_data("dv_martillero") : "";
	$notificacion = ($id_alta > 0) ? $martillero->get_data("notificacion") : "";
	$retirio_especies_fp = ($id_alta > 0) ? $martillero->get_data("retirio_especies_fp") : "";
	*/
	/*
	$providencia = ($id_alta > 0) ? $martillero->get_data("providencia") : "";
	$entrega_receptor = ($id_alta > 0) ? $martillero->get_data("entrega_receptor") : "";
	$retiro_especies = ($id_alta > 0) ? $martillero->get_data("retiro_especies") : "";
	$oposicion_retiro = ($id_alta > 0) ? $martillero->get_data("oposicion_retiro") : "";
	*/
	
?>
<form name="frmreceptor">
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>" grabar="S"/>
<input  type="hidden" name="ident" id="ident" value="<? echo($ident) ?>" grabar="S"/>
<input  type="hidden" name="id_alta" id="id_alta" value="<? echo($id_alta) ?>" grabar="S"/>


  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;DDA Ejecutiva</th>
        <th></th>
        <th align="right">
        <div style="position:relative; margin-right:10px;">
        	<img src="images/grabar.gif" onClick="grabarDDaEjec()" title="Grabar" style="cursor:pointer;">&nbsp;&nbsp;
            <img src="images/limpiar.gif" onClick="limpiarDDaEjec()" title="Limpiar" style="cursor:pointer;">
            </div>
        </th>
    </tr>
 </table>
<!--<div id="datos" style="">-->
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" height="5">
       </td>
    </tr>   
    <tr>
    	<td width="40%" valign="top">
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
                 <tr>
					<td align="left" class="etiqueta_form">Nombre Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtnomreceptor" id="txtnomreceptor" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto" value="<? echo($nomreceptor) ?>"/></td>
					<td align="left" class="etiqueta_form">Email Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtemailreceptor" id="txtemailreceptor" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($emailreceptor) ?>"/></td>
					<td align="left" class="etiqueta_form">Fono Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfonoreceptor" id="txtfonoreceptor" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($fonoreceptor) ?>"/></td>
                 </tr>

            	<tr>
                	<td align="left" class="etiqueta_form">Certificado</td>
                    <td align="left" ><input type="text" grabar="S" name="txtcertificado" id="txtcertificado" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" value="<? echo(formatoFecha($certificado,"yyyy-mm-dd","dd/mm/yyyy")) ?>"/></td>
               
					<td align="left" class="etiqueta_form">DDA Ejecutiva</td>
                    <td align="left" ><input type="text" grabar="S" name="txtddaejec" id="txtddaejec" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" value="<? echo(formatoFecha($ddaejec,"yyyy-mm-dd","dd/mm/yyyy")) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Mandamiento</td>
                      <td align="left" ><input type="text" grabar="S" name="txtmandamiento" id="txtmandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" value="<? echo(formatoFecha($mandamiento,"yyyy-mm-dd","dd/mm/yyyy")) ?>"/>&nbsp;
					<td align="left" class="etiqueta_form">Encargado a Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtencargado" id="txtencargado" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" value="<? echo(formatoFecha($encargado,"yyyy-mm-dd","dd/mm/yyyy")) ?>"/></td>
                 </tr>

               	<tr>
                	<td align="left" class="etiqueta_form">Fecha Busqueda</td>
                    <td align="left" ><input type="text" grabar="S" name="txtbusqueda" id="txtbusqueda" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" value="<? echo(formatoFecha($busqueda,"yyyy-mm-dd","dd/mm/yyyy")) ?>"/></td>
           			<td align="left" class="etiqueta_form">Fecha Notificacion</td>
                    <td align="left" ><input type="text" grabar="S" name="txtnotificacion" id="txtnotificacion" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" value="<? echo(formatoFecha($notificacion,"yyyy-mm-dd","dd/mm/yyyy")) ?>"/></td>
                </tr>
            </table>
        </td>
        
    </tr>		
    <tr>
        <td colspan="3">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>    
 </table>
<!-- </div>-->

 <div style="position:relative; margin-top:10px;">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<!--
        	<input  type="button" name="btngrabar" id="btngrabar" onClick="grabarDDaEjec()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onClick="limpiarDDaEjec()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
            -->
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>
