
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
			$("#txtfecha_remate").datepicker({changeYear: true});
			$("#txtingreso").datepicker({changeYear: true});
			$("#txtprovidencia").datepicker({changeYear: true});
			$("#txtingreso").datepicker({changeYear: true});
			$("#txtprovidencia").datepicker({changeYear: true});
			$("#txtentrega_receptor").datepicker({changeYear: true});
			$("#txtembargo").datepicker({changeYear: true});
			$("#txtprovidencia").datepicker({changeYear: true});
			$("#txtfecha_remate").datepicker({changeYear: true});
		});
		
		$(document).ready(function(){
			
  			$('form').validator();
			$("#txtfecha_remate").datepicker();			
		});
		
		
		function grabarMartillero()
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
					datos += "&accion=grabarMartilleroM";	
				}
				else
				{
					datos += "&accion=grabarMartilleroA";	
				}
			}
			
			if($("#tipoperacion").val() == "M")
			{				
				datos += "&accion=editarMartillero";	
			}
		
			datos += "&"+getParametros();
			 alert(datos);
			//return false;
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
						window.parent.mensajeConfirmacion("Los datos Martillero se guardaron con éxito");
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function limpiarMartillero()
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
	
	$aceptacion_cargo = ($id_alta > 0) ? $martillero->get_data("aceptacion_cargo") : "";
	$nombre = ($id_alta > 0) ? $martillero->get_data("nombre") : "";
	$rut_martilero = ($id_alta > 0) ? $martillero->get_data("rut_martilero") : "";
	$dv_martillero = ($id_alta > 0) ? $martillero->get_data("dv_martillero") : "";
	$notificacion = ($id_alta > 0) ? $martillero->get_data("notificacion") : "";
	$retirio_especies_fp = ($id_alta > 0) ? $martillero->get_data("retirio_especies_fp") : "";
	
	$providencia = ($id_alta > 0) ? $martillero->get_data("providencia") : "";
	$entrega_receptor = ($id_alta > 0) ? $martillero->get_data("entrega_receptor") : "";
	$retiro_especies = ($id_alta > 0) ? $martillero->get_data("retiro_especies") : "";
	$oposicion_retiro = ($id_alta > 0) ? $martillero->get_data("oposicion_retiro") : "";
	$fecha_remate = ($id_alta > 0) ? formatoFecha($martillero->get_data("fecha_remate"),"yyyy-mm-dd","dd/mm/yyyy") : "";
?>
<form name="frmreceptor">
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>" grabar="S"/>
<input  type="hidden" name="ident" id="ident" value="<? echo($ident) ?>" grabar="S"/>
<input  type="hidden" name="id_alta" id="id_alta" value="<? echo($id_alta) ?>" grabar="S"/>


  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Embargo y Martillero
        
                    
                    		<select name="txtembargomartillero" grabar="S" tipovalida="texto" id="txtnotificacion"  onFocus="resaltar(this)" onBlur="noresaltar(this)">
			     				<option value=""> Seleccione </option>
			     				<option value="Protesto Pagare"> Con Fuerza Publica </option>
			     				<option value="Protesto Letra"> Sin Fuerza Publica </option>
					  		</select>
					
        </th>
        <th></th>
        <th align="right">
        <div style="position:relative; margin-right:10px;">
        	<img src="images/grabar.gif" onClick="grabarMartillero()" title="Grabar" style="cursor:pointer;">&nbsp;&nbsp;
            <img src="images/limpiar.gif" onClick="limpiarMartillero()" title="Limpiar" style="cursor:pointer;">
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
                	<td align="left" class="etiqueta_form">Ingreso</td>
                    <td align="left" ><input type="text" grabar="S" name="txtingreso" id="txtingreso" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="fecha" value="<? echo($aceptacion_cargo) ?>"/></td>
                </tr>
            	<tr>
                	<td align="left" class="etiqueta_form">Providencia</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia" id="txtprovidencia" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="fecha" value="<? echo($aceptacion_cargo) ?>"/></td>
                </tr>
            	<tr>
                	<td align="left" class="etiqueta_form">Oficio</td>
                    <td align="left" ><input type="text" grabar="S" name="txtoficio" id="txtoficio" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($aceptacion_cargo) ?>"/></td>
                </tr>

                <tr>
					<td align="left" class="etiqueta_form">Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtreceptor" id="txtreceptor" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($nombre) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Email/Telefono </td>
                      <td align="left" ><input type="text" grabar="S" name="txtemailreceptor" id="txtemailreceptor" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($rut_martilero) ?>"/>&nbsp;
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Resultado</td>
                    <td align="left" ><input type="text" grabar="S" name="txtresultado" id="txtresultado" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($notificacion) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Embargo</td>
                    <td align="left" ><input type="text" grabar="S" name="txtembargo" id="txtembargo" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($retirio_especies_fp) ?>"/></td>

                 </tr>

            	</table>
        </td>
    
        <td width="40%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%"  style="position:relative; margin-left:5px;">
                <tr>
					<td align="left" class="etiqueta_form">Entrega receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_receptor" id="txtentrega_receptor" size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($entrega_receptor) ?>"/></td>
                </tr>
            	<tr>
                	<td align="left" class="etiqueta_form">Nombre Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtreceptor2" id="txtreceptor2" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($providencia) ?>"/></td>
                	<td align="left" class="etiqueta_form">Email/Telefono</td>
                    <td align="left" ><input type="text" grabar="S" name="txtemailreceptor2" id="txtemailreceptor2" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($providencia) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Embargo</td>
                    <td align="left" ><input type="text" grabar="S" name="txtembargo" id="txtembargo" size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($entrega_receptor) ?>"/></td>
					<td align="left" class="etiqueta_form">def2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtdef2" id="txtdef2" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($entrega_receptor) ?>"/></td>                
                </tr>
                 <tr>
					<td align="left" class="etiqueta_form">def3 Martillero</td>
                    <td align="left" ><input type="text" grabar="S" name="txtdef3" id="txtdef3" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="fecha" value="<? echo($fecha_remate) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Providencia</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia" id="txtprovidencia" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="fecha" value="<? echo($fecha_remate) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>
                 </tr>
            	<tr>
                	<td align="left" class="etiqueta_form">Nombre Martillero</td>
                    <td align="left" ><input type="text" grabar="S" name="txtmartillero" id="txtmartillero" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($providencia) ?>"/></td>
                	<td align="left" class="etiqueta_form">Email/Telefono</td>
                    <td align="left" ><input type="text" grabar="S" name="txtemailmartillero" id="txtemailmartillero" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($providencia) ?>"/></td>
                </tr>
				<tr>
					<td align="left" class="etiqueta_form">Notificacion Martillero</td>
                    <td align="left" ><input type="text" grabar="S" name="txtnotificacionmartillero" id="txtnotificacionmartillero" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="fecha" value="<? echo($fecha_remate) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Retiro especies</td>
                      <td align="left" ><input type="text" grabar="S" name="txtretiro_especies" id="txtretiro_especies" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($retiro_especies) ?>"/></td>
                 </tr>   

                 <tr>
					<td align="left" class="etiqueta_form">Fuerza Publica</td>
                    <td align="left" ><input type="text" grabar="S" name="txtoposicion_retiro" id="txtoposicion_retiro" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="texto" value="<? echo($oposicion_retiro) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Remate</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_remate" id="txtfecha_remate" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="fecha" value="<? echo($fecha_remate) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>

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
        	<input  type="button" name="btngrabar" id="btngrabar" onClick="grabarMartillero()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onClick="limpiarMartillero()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
            -->
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>
