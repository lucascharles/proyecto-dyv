<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script language="javascript"> 
		function simular(monto,fechavenc)
		{
			document.getElementById("txtmonto").value = document.getElementById("txtmonto").value + monto;
			document.getElementById("txttotal").value = document.getElementById("txttotal").value + monto;
			document.getElementById("txtfechavenc").value = fechavenc;
			document.getElementById("txtdiasatraso").value = "";
			document.getElementById("txtinteresdiario").value = "";
			document.getElementById("txtinteresacumulado").value = "";
		}
		
	</script>
</head>
<body>



<div id="datos" style="">
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
			
	?>
	<tr bgcolor="#FFFFFF">
    	<td><input type="checkbox" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checktipdoc" value="" onclick="simular(<?php echo ($datoTmp->get_data("monto")) ?>,<?php echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"dd-mm-yyyy","dd/mm/yyyy"))?>)"></td>	
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_siniestro"),"dd-mm-yyyy","dd/mm/yyyy")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"dd-mm-yyyy","dd/mm/yyyy"))?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
	</tr>
	<?php
	}
	?>
</table>
</div>

<div > 
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="4" align="left">
        	<input  type="button" name="btnsimular" id="btnsimular" onclick="simular()" class="boton_form" value="Simular" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
    </tr>
</table>
</div>

<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">			
	<tr>
		
		<td align="right" class="etiqueta_form">Protesto Bco.&nbsp; </td>
        <td align="left">
            <input type="text" name="txtprotesto" id="txtprotesto" value="0" size="5" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
        </td>                                   
    </tr>
    <tr>  
        <td align="right" class="etiqueta_form">Monto&nbsp;</td>
        <td align="left">
            <input type="text" name="txtmonto" id="txtmonto" value="0" size="5" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
        </td>  
    </tr>
    <tr>                                     
		<td align="right" class="etiqueta_form">Total&nbsp;</td>
        <td align="left">
        	<input type="text" name="txttotal" id="txttotal" value="0" size="5" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
        </td>
	</tr>
    <tr>	
		<td align="right" class="etiqueta_form">Fecha Venc.&nbsp;</td>
        <td align="left">
        	<input type="text" name="txtfechavenc" id="txtfechavenc" size="5" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
        </td>
    </tr>
    <tr>    
        <td align="right" class="etiqueta_form">Dias Atraso&nbsp;</td>
        <td align="left">
        	<input type="text" name="txtdiasatraso" id="txtdiasatraso" size="5" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
        </td>
     </tr>
    <tr>   
        <td align="right" class="etiqueta_form">Interes Diario&nbsp;</td>
        <td align="left">
        	<input type="text" name="txtinteresdiario" id="txtinteresdiario" value="0" size="5" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
        </td>
     </tr>
    <tr>   
        <td align="right" class="etiqueta_form">Interes Acumulado&nbsp;</td>
        <td align="left">
        	<input type="text" name="txtinteresacumulado" id="txtinteresacumulado" value="0" size="5" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"  tipovalida="entero"/>
        </td>
	</tr>
</table>



</body>
</html>