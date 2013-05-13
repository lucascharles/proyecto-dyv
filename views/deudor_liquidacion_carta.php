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
						<input type="text" name="txthonorarios" id="txthonorarios" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" />
        			</td>
        		</tr>
        		<tr>
					<td align="right" class="etiqueta_form">Capital&nbsp;&nbsp;</td>
                    <td align="left">	
                    	<input type="text" name="txtcapital" id="txtcapital" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="texto"/>
                    </td>        		
        		</tr>
        		<tr>
                    <td align="right" class="etiqueta_form">Interes&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteres" id="txtinteres" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="entero"/>
                        <input type="radio" value="S" name="rdestatus_repacta" id="rdestatus_repacta" />&nbsp;Repacta&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio"  value="N" name="rdestatus_repacta" id="rdestatus_no_repacta" checked="checked" />&nbsp;No Repacta
                    </td>
                 </tr>
             </table>
        </td>
    </tr>		
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">
            	<tr>
                    
                 	<td align="right" class="etiqueta_form" width="150">Saldo&nbsp;&nbsp;
                    </td>
                    <td class="etiqueta_form">
                 				<input type="text" name="txtsaldo" id="txtsaldo" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cuotas&nbsp;&nbsp;
                    
                 				<input type="text" name="txtcuotas" id="txtcuotas" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/></td>
                 </tr>
             </table>
        </td>
    </tr>	
 	<tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">
            	
                <tr>
                    
                    <td align="right" class="etiqueta_form" width="150">IMP&nbsp;&nbsp;
                    </td>
                    <td class="etiqueta_form">
                 				<input type="text" name="txtimp" id="txtimp" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cuotas de UF&nbsp;&nbsp;
                 				<input type="text" name="txtcuotasuf" id="txtcuotasuf" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
                    </td>                                   
            	 </tr>
         	</table>
         </td>
    </tr>
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">
            	<tr>
                    <td align="right" class="etiqueta_form" width="150">Protesto Banco&nbsp;&nbsp;
                    </td>
                    <td class="etiqueta_form" >
                    		<input type="text" name="txtprotestobanco" id="txtprotestobanco" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="entero"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;
                 	 		<input type="text" name="txttotal" id="txttotal" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor aprox.&nbsp;&nbsp;
                 	 		<input type="text" name="txtvalorcuota" id="txtvalorcuota" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/></td>                                   
            	 </tr>
         	</table>
         </td>
    </tr> 
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="left" >
            	<tr>
                    <td align="right" class="etiqueta_form" width="150">Abono&nbsp;&nbsp;</td>
                	<td><input type="text" name="txtabono" id="txtabono" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="entero"/>
                    </td>               
            	 </tr>
         	</table>
         </td>
    </tr> 
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="left" >
            	<tr>
                    <td align="right" class="etiqueta_form" width="150">Deposito&nbsp;&nbsp;</td>
                    <td><input type="text" name="txtdeposito" id="txtdeposito" size="15" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="entero"/>
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