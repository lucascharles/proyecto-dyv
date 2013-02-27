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
		
		function limpiarDocumentos()
		{			
			limpiarCampos();
			/*
			document.getElementById("txtdestipdoc").value = "";
			document.getElementById("selDeudor").value = "";
			document.getElementById("selMandante").value = "";
			document.getElementById("txtfechaRecibido").value = "";
			document.getElementById("txtnrodoc").value = "";
			document.getElementById("selTipoDoc").value = "";
			document.getElementById("txtmonto").value = "";
			document.getElementById("selBancos").value = "";
			document.getElementById("txtctacte").value = "";
			document.getElementById("txtfechaprotesto").value = "";
			document.getElementById("selCausalProtesta").value = "";
			*/
		}
		
		function salir()
		{
			
			$("#pagina").load('views/admin_documentos.php');
		}


		function seleccionado(id)
		{
			document.getElementById("id_documento").value = id;
		}
		
		function eliminar()
		{
			alert("eliminar");
					
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
				datos += "&deudor="+$("#selDeudor").val();
				datos += "&mandante="+$("#selMandante").val();
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


	</script>
</head>
<body>
<form name="frmadmdocumentos">
<input grabar="S" type="hidden" name="id_documento" id="id_documento" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Alta Documento</th>
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
		<th align="left">Origen del Documento</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" size="20">
    <tr>
		<td width="70" align="left" class="etiqueta_form">Deudor:</td>
        <td> 
        	<select name="selDeudor" grabar="S" valida="requerido" tipovalida="texto" id="selDeudor" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_deudores->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_deudores->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_deudor").">".utf8_encode($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor"))."</option>");           
			        }
    			?>
			</select>
        
        </td>
		
		<td width="70" align="left" class="etiqueta_form">Mandatario:</td>
        <td> 
        	<select name="selMandante" grabar="S" valida="requerido" tipovalida="texto" id="selMandante" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_mandantes->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_mandantes->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_mandante").">".utf8_encode($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante"))."</option>");           
			        }
    			?>
			</select>
        
        </td>       
        
    </tr>
     <tr>
        <td colspan="4" height="10">

         </td>
    </tr>   
    
    <tr>
		<td width="20" align="left" class="etiqueta_form">Recibido:</td>
        <td align="left"><input type="text" grabar="S" name="txtfechaRecibido" id="txtfechaRecibido" value="<?php echo date("d/m/Y"); ?>" size="20"  valida="requerido" tipovalida="fecha" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
        
        <td width="70" align="left" class="etiqueta_form">Estado:</td>
        <td> 
        	<select name="selEstadoDoc" grabar="S" valida="requerido" tipovalida="texto" id="selEstadoDoc" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_estadoDoc->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_estadoDoc->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_estado_doc").">".utf8_encode($datoTmp->get_data("estado"))."</option>");           
			        }
    			?>
			</select>
        
        </td>  
                
    </tr>
        
    
    <tr>
        <td colspan="4">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
 </table>
 </div>
 
 
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 <tr>
        <th colspan="3" height="15"></th>
    </tr>
	<tr>
		<th align="left">Detalle del Documento</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 <tr>
 		<td>
        	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
					<td width="20" align="left" class="etiqueta_form">Tipo Doc.:</td>
        			<td width="70" align="left" class="etiqueta_form">Nro Doc.:</td>
        			<td width="20" align="left" class="etiqueta_form">Monto:</td>       
        			<td width="70" align="left" class="etiqueta_form">Banco:</td>
                </tr>
                <tr>
        			<td> 
                        <select name="selTipoDoc" grabar="S" valida="requerido" tipovalida="texto" id="selTipoDoc" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
                            <option value=""><? print utf8_encode("----Seleccione----") ?></option>
                            <?
                                for($j=0; $j<$coleccion_tipoDoc->get_count(); $j++)
                                {
                                    $datoTmp = &$coleccion_tipoDoc->items[$j];
                                    echo("<option value=".$datoTmp->get_data("id_tipo_documento").">".utf8_encode($datoTmp->get_data("tipo_documento"))."</option>");           
                                }
                            ?>
                        </select>       
        			</td>  
        			<td align="left"><input type="text" grabar="S" name="txtnrodoc" id="txtnrodoc"  size="20" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  valida="requerido" tipovalida="entero"/></td>
        			<td align="left"><input type="text" grabar="S" name="txtmonto" id="txtmonto" value="0" size="15" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" /></td>
        			<td> 
                    <select name="selBancos" grabar="S" valida="requerido" tipovalida="texto" id="selBancos" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_bancos->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_bancos->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_banco").">".utf8_encode($datoTmp->get_data("codigo")."-".$datoTmp->get_data("banco"))."</option>");           
			        }
    			?>
			</select>
        	       </td>
               </tr>
               <tr>                  
		        <td align="left" height="10" colspan="4" ></td>
                </tr>
			   <tr>                  
		        <td width="20" align="left" class="etiqueta_form">Cta. Cte.:</td>
                <td width="20" align="left" class="etiqueta_form">Fecha Protesto:</td>
                <td width="70" align="left" colspan="2" class="etiqueta_form">Causal Protesto:</td>
        	   </tr>
    			<tr>
    				<td align="left"><input type="text" grabar="S" name="txtctacte" id="txtctacte"  size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero" /></td>        
        			<td align="left"><input type="text" grabar="S" name="txtfechaprotesto" id="txtfechaprotesto"  size="15" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha"/></td>
                    <td colspan="2">
        	<select name="selCausalProtesta" grabar="S" valida="requerido" tipovalida="texto" id="selCausalProtesta" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_causalProtesta->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_causalProtesta->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_causal").">".utf8_encode($datoTmp->get_data("causal"))."</option>");           
			        }
    			?>
			</select>
                </td>
           </tr>
    		<tr>
    	<td colspan="4" align="right">        	
         	<input  type="button" name="btnAgregar" id="btnAgregar" onclick="grabar()" value="Agregar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>            
         </td>
         	</tr>
            </table>
            </td>
    
    </tr>
    
 </table>
 
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
        	<iframe id="frmlistdocumentos" src="index.php?controlador=Documentos&accion=listarNuevos" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td width="10%">
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()" value="Eliminar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            </div>
         </td>
    </tr>
</table>
 
 
 
 </div> 
 
 
 
 
 <div style="position:relative; margin-top:10px;">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiarDocumentos()" value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />&nbsp;
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"value="Salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>