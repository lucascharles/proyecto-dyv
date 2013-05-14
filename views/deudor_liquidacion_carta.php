<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
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
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}

		function calcular(obj)
		{
			var url = "index.php?controlador=Gestiones&accion=listarGestiones&des_int="+obj.value;
			var capital = document.getElementById("txtcapital").value;
			var interes = document.getElementById("txtinteres").value;
			var protesto = document.getElementById("txtprotestobanco").value;
			var abono = document.getElementById("txtabono").value;
			
			document.getElementById("txthonorarios").value = (parseInt(capital) + parseInt(interes) + parseInt(protesto))*10/100;

			document.getElementById("txtsaldo").value = parseInt(capital) + parseInt(interes) + parseInt(protesto) - parseInt(abono);

			var saldo = document.getElementById("txtsaldo").value;
			var imp = document.getElementById("txtimp").value;
			document.getElementById("txttotal").value = parseInt(saldo) + parseInt(imp);
			var total = document.getElementById("txttotal").value;
			
			var cuotas = document.getElementById("txtcuotas").value;
			var valoruf = document.getElementById("txtvaloruf").value;
			document.getElementById("txtvalorcuota").value = (parseInt(total)/parseInt(cuotas));
			var valorcuotasuf = document.getElementById("txtcuotasuf").value = (parseInt(total)/parseInt(cuotas))/parseInt(valoruf);
			
		}
		
	</script>
</head>
<body>
<form name="frmliquidacioncarta">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
 </table>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th align="right">
        <div style="position:relative; margin-right:10px;">
        	<img src="images/grabar.gif" onClick="grabarCarta()" title="Grabar" style="cursor:pointer;">&nbsp;&nbsp;
            <img src="images/limpiar.gif" onClick="limpiarCarta()" title="Limpiar" style="cursor:pointer;">
            </div>
        </th>
    </tr>
 </table>
<div id="datos" style=" width:99%;">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="left" >
            	<tr>
					<td align="right" class="etiqueta_form" width="150">Honorarios&nbsp;&nbsp;</td>
					<td align="left">
						<input type="text" value="0" name="txthonorarios" id="txthonorarios" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" />
        			</td>
        		</tr>
        		<tr>
					<td align="right" class="etiqueta_form">Capital&nbsp;&nbsp;</td>
                    <td align="left">	
                    	<input type="text" name="txtcapital" id="txtcapital" value="<?php $datoTmp = &$capital; echo($datoTmp); ?>" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)" tipovalida="texto"/>
                    </td>        		
        		</tr>
        		<tr>
                    <td align="right" class="etiqueta_form">Interes&nbsp;</td>
                    <td align="left">
                        <input type="text" value="0" name="txtinteres" id="txtinteres" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)" tipovalida="entero"/>
                        <input type="radio" value="S" name="rdestatus_repacta" id="rdestatus_repacta" />&nbsp;Repacta&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio"  value="N" name="rdestatus_repacta" id="rdestatus_no_repacta" checked="checked" />&nbsp;No Repacta
                    </td>
                 </tr>
                 <tr>
                 <td align="right" class="etiqueta_form" width="150">Protesto Banco&nbsp;&nbsp;
                    </td>
                    <td class="etiqueta_form" >
                    		<input type="text" value="0" name="txtprotestobanco" id="txtprotestobanco" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)" valida="requerido" tipovalida="entero"/>
                    </td>
                 </tr>
                 
                 <tr>
                 	<td align="right" class="etiqueta_form" width="150">Abono&nbsp;&nbsp;</td>
                	<td><input type="text" name="txtabono" id="txtabono" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)" tipovalida="entero"/>
                    </td>
                 </tr>
                 
                 <tr>
                    <td align="right" class="etiqueta_form" width="150">Deposito&nbsp;&nbsp;</td>
                    <td><input type="text" name="txtdeposito" id="txtdeposito" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)" tipovalida="entero"/>
                    </td>               
            	 </tr>
             </table>
        </td>
    </tr>		
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">
            	<tr>
                    
                 	<td align="center" class="etiqueta_form" width="150">Saldo</td>
                 	<td align="center" class="etiqueta_form" width="150">IMP</td>
                 	<td align="center" class="etiqueta_form" width="150">Total</td>
                </tr>    
                <tr>
                    <td align="center" class="etiqueta_form">
                 		<input type="text" name="txtsaldo" id="txtsaldo" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)" valida="requerido" tipovalida="entero"/>
                    </td>
                    <td align="center" class="etiqueta_form">
                    	<input type="text" name="txtimp" id="txtimp" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)"  tipovalida="entero"/>
                    </td>
                    <td align="center" class="etiqueta_form">	
                 		<input type="text" name="txttotal" id="txttotal" value="0" size="15" class="input_form" onFocus="resaltar(this)" onBlur="calcular(this)"  tipovalida="entero"/>
                 	</td>		
                 		
                 </tr>
             </table>
        </td>
    </tr>	
	<tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">
            	<tr>
                    
                 	<td align="center" class="etiqueta_form" width="150">Cuotas</td>
                 	<td align="center" class="etiqueta_form" width="150">Cuotas de UF</td>
                 	<td align="center" class="etiqueta_form" width="150">Valor Aprox.</td>
                </tr>    
                <tr>
                    <td align="center" class="etiqueta_form">
                 		<input type="text" name="txtcuotas" id="txtcuotas" size="15" class="input_form" onFocus="calcular(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/>
                    </td>
                    <td align="center" class="etiqueta_form">
                    	<input type="text" name="txtvalorcuota" id="txtvalorcuota" size="15" class="input_form" onFocus="calcular(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
                    </td>
                    <td align="center" class="etiqueta_form">	
                 		<input type="text" name="txtcuotasuf" id="txtcuotasuf" size="15" class="input_form" onFocus="calcular(this)"  tipovalida="entero"/>
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
 </table>
 </div>



</form>
</body>
</html>