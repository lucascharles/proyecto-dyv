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
  			$('form').validator();
			document.getElementById("txtimporte").focus();
			$("#txtfechainicial").datepicker();	
		});
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
		
		function calcular()
		{
			if(!validar("N"))
			{
				return false;
			}
			
			var url = "index.php?controlador=Deudores&accion=calcular";
			url += "&txtimporte="+$("#txtimporte").val();
			url += "&txtinteresmensual="+$("#txtinteresmensual").val();
			url += "&txtcuotas="+$("#txtcuotas").val();
			url += "&txtfechainicial="+$("#txtfechainicial").val();
			url += "&txtpagomensual="+$("#txtpagomensual").val();
			url += "&txtnumpagos="+$("#txtnumpagos").val();
			url += "&txtimp="+$("#txtimp").val();
			url += "&txtcostoprestamo="+$("#txtcostoprestamo").val();
			
			document.getElementById("frmcalculos").src = url;
		}
			
		function calculoAutomatico()
		{
			if($.trim($("#txtimp").val()) == "")
			{
				return false;
			}
			
			
			var costoprestamo = parseFloat($.trim($("#txtimporte").val())) + parseFloat($.trim($("#txtimp").val()));
			var pagomensual =  (parseFloat($.trim($("#txtimporte").val())) + parseFloat($.trim($("#txtimp").val()))) / parseInt($.trim($("#txtcuotas").val()));
					
			$("#txtcostoprestamo").val(costoprestamo);
			$("#txtpagomensual").val(pagomensual);
			$("#txtnumpagos").val($.trim($("#txtcuotas").val()));
			
		}
	</script>
</head>
<body>
<form name="frmliquidacioncalculadora" action="" method="post">
 <table width="99%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th align="right">
        	<div style="position:relative; margin-right:10px;">
        	<img src="images/grabar.gif" onClick="grabarCalculo()" title="Grabar" style="cursor:pointer;">&nbsp;&nbsp;
            <img src="images/limpiar.gif" onClick="limpiarCalculo()" title="Limpiar" style="cursor:pointer;">
            </div>
        </th>
        
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