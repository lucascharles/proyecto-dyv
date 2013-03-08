
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
  	<script src="js/funciones.js" type="text/javascript"></script>
    <script language="javascript">
		
		$(document).ready(function(){
			
  			$('form').validator();
			
		});
		
		function grabarConsignacion()
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
					datos += "&accion=grabarConsignacionM";	
				}
				else
				{
					datos += "&accion=grabarConsignacionA";	
				}
			}
			
			if($("#tipoperacion").val() == "M")
			{				
				datos += "&accion=editarConsignacion";	
			}
		
			datos += "&"+getParametros();
			
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
						window.parent.mensajeConfirmacion("Los datos Consignación se guardaron con éxito");
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						$("#mensaje").slideDown();
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function limpiarConsignacion()
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
	
	$id_consignacion = ($id_alta > 0) ? $consignacion->get_data("id_consignacion") : "";
	$id_ficha = ($id_alta > 0) ? $consignacion->get_data("id_ficha") : "";
	$consignacion_view = ($id_alta > 0) ? $consignacion->get_data("consignacion") : "";
	$abono_1 = ($id_alta > 0) ? $consignacion->get_data("abono_1") : "";
	$abono_2 = ($id_alta > 0) ? $consignacion->get_data("abono_2") : "";
	$abono_3 = ($id_alta > 0) ? $consignacion->get_data("abono_3") : "";
	$abono_4 = ($id_alta > 0) ? $consignacion->get_data("abono_4") : "";
	$pago_cliente = ($id_alta > 0) ? $consignacion->get_data("pago_cliente") : "";
	$giro_cheque_1 = ($id_alta > 0) ? $consignacion->get_data("giro_cheque_1") : "";
	$entrega_cheque = ($id_alta > 0) ? $consignacion->get_data("entrega_cheque") : "";
	$costas_procesales = ($id_alta > 0) ? $consignacion->get_data("costas_procesales") : "";
	$pago_costas = ($id_alta > 0) ? $consignacion->get_data("pago_costas") : "";
	$entrega_cheque_1 = ($id_alta > 0) ? $consignacion->get_data("entrega_cheque_1") : "";
	$devolucion_documento = ($id_alta > 0) ? $consignacion->get_data("devolucion_documento") : "";
	$entrega_documento = ($id_alta > 0) ? $consignacion->get_data("entrega_documento") : "";
	$monto_consignacion = ($id_alta > 0) ? $consignacion->get_data("monto_consignacion") : "";
	$monto_1 = ($id_alta > 0) ? $consignacion->get_data("monto_1") : "";
	$monto_2 = ($id_alta > 0) ? $consignacion->get_data("monto_2") : "";
	$monto_3 = ($id_alta > 0) ? $consignacion->get_data("monto_3") : "";
	$monto_4 = ($id_alta > 0) ? $consignacion->get_data("monto_4") : "";
	$pago_dyv = ($id_alta > 0) ? $consignacion->get_data("pago_dyv") : "";
	$providencia_1 = ($id_alta > 0) ? $consignacion->get_data("providencia_1") : "";
	$providencia_2 = ($id_alta > 0) ? $consignacion->get_data("providencia_2") : "";
	$giro_cheque_2 = ($id_alta > 0) ? $consignacion->get_data("giro_cheque_2") : "";
	$providencia_3 = ($id_alta > 0) ? $consignacion->get_data("providencia_3") : "";
	$rendicion_cliente = ($id_alta > 0) ? $consignacion->get_data("rendicion_cliente") : "";
	
?>
<form name="frmconsignacion">
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>" grabar="S"/>
<input  type="hidden" name="ident" id="ident" value="<? echo($ident) ?>" grabar="S"/>
<input  type="hidden" name="id_alta" id="id_alta" value="<? echo($id_alta) ?>" grabar="S"/>


  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Consignaci&oacute;n</th>
        <th></th>
        <th align="right">
         <div style="position:relative; margin-right:10px;">
        	<img src="images/grabar.gif" onClick="grabarConsignacion()" title="Grabar" style="cursor:pointer;">&nbsp;&nbsp;
            <img src="images/limpiar.gif" onClick="limpiarConsignacion()" title="Limpiar" style="cursor:pointer;">
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
                	<td align="left" class="etiqueta_form">Consignaci&oacute;n</td>
                    <td align="left" ><input type="text" grabar="S" name="txtconsignacion" id="txtconsignacion" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($consignacion_view) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Abono 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtabono_1" id="txtabono_1" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($abono_1) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Abono 2</td>
                      <td align="left" ><input type="text" grabar="S" name="txtabono_2" id="txtabono_2" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($abono_2) ?>"/></td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Abono 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtabono_3" id="txtabono_3" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($abono_3) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Abono 4</td>
                    <td align="left" ><input type="text" grabar="S" name="txtabono_4" id="txtabono_4" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($abono_4) ?>"/></td>

                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Pago Cliente</td>
                    <td align="left" ><input type="text" grabar="S" name="txtpago_cliente" id="txtpago_cliente" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($pago_cliente) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Giro Cheque 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtgiro_cheque_1" id="txtgiro_cheque_1" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($giro_cheque_1) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Entrega Cheque</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_cheque" id="txtentrega_cheque" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($entrega_cheque) ?>"/></td>

                 </tr>
                  <tr>
					<td align="left" class="etiqueta_form">Costas Procesales</td>
                    <td align="left" ><input type="text" grabar="S" name="txtcostas_procesales" id="txtcostas_procesales" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($costas_procesales) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Pago Costas</td>
                    <td align="left" ><input type="text" grabar="S" name="txtpago_costas" id="txtpago_costas" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($pago_costas) ?>"/></td>
                  </tr> 
                  <tr>
					<td align="left" class="etiqueta_form">Entrega cheque 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_cheque_1" id="txtentrega_cheque_1" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($entrega_cheque_1) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Devoluci&oacute;n documento</td>
                    <td align="left" ><input type="text" grabar="S" name="txtdevolucion_documento" id="txtdevolucion_documento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($devolucion_documento) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Entrega documento</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_documento" id="txtentrega_documento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_documento) ?>"/></td>
                  </tr>
            	</table>
        </td>
    
        <td width="40%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%"  style="position:relative; margin-left:5px;">
            	<tr>
                	<td align="left" class="etiqueta_form">Monto consignaci&oacute;n</td>
                    <td align="left" ><input type="text" grabar="S" name="txtmonto_consignacion" id="txtmonto_consignacion" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo(conDecimales($monto_consignacion)) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Monto 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtmonto_1" id="txtmonto_1" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo(conDecimales($monto_1)) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Monto 2</td>
                      <td align="left" ><input type="text" grabar="S" name="txtmonto_2" id="txtmonto_2" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo(conDecimales($monto_2)) ?>"/></td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Monto 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtmonto_3" id="txtmonto_3" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo(conDecimales($monto_3)) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Monto 4</td>
                    <td align="left" ><input type="text" grabar="S" name="txtmonto_4" id="txtmonto_4" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo(conDecimales($monto_4)) ?>"/></td>

                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Pago DyV</td>
                    <td align="left" ><input type="text" grabar="S" name="txtpago_dyv" id="txtpago_dyv" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo(conDecimales($pago_dyv)) ?>"/></td>
                 </tr> 
                 <tr>
					<td align="left" class="etiqueta_form">Providencia 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia_1" id="txtprovidencia_1" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($providencia_1) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Providencia 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia_2" id="txtprovidencia_2" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($providencia_2) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Giro cheque 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtgiro_cheque_2" id="txtgiro_cheque_2" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($giro_cheque_2) ?>"/></td>
                  </tr> 
                  <tr>
					<td align="left" class="etiqueta_form">Providencia 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia_3" id="txtprovidencia_3" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($providencia_3) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Rendici&oacute;n cliente</td>
                    <td align="left" ><input type="text" grabar="S" name="txtrendicion_cliente" id="txtrendicion_cliente" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo($providencia_3) ?>"/></td>
                  </tr>                  
            	</table>
        </td>
        <td width="20%" valign="top"> 
        	<div style="border:solid; border-width:2px; position:relative; margin-left:10px;">
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%" style="position:relative; margin-left:5px;">
            <tr>
                	<td align="center" class="etiqueta_form" colspan="3">
                    	GASTOS
                    </td>
                </tr>
            <?
            for($j=0; $j<$colGastosConsignacion->get_count(); $j++) 
			{
				$datoTmp = &$colGastosConsignacion->items[$j];  
			?>
            	<tr>
                	<td align="left" class="etiqueta_form"><? echo($datoTmp->get_data("gasto")) ?></td>
                    <td align="left" ><input type="text"  grabar="S" name="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" id="txtgasto_<? echo($datoTmp->get_data("gasto")) ?>" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda" value="<? echo(conDecimales($datoTmp->get_data("importe"))) ?>"/></td>
                    <td width="5"></td>
                </tr>
           <?
           }
		   ?>
             </table>
             </div>
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
        	<input  type="button" name="btngrabar" id="btngrabar" onClick="grabarConsignacion()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onClick="limpiarConsignacion()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
            -->
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>
