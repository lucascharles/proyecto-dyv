<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	<title></title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
     
    <script language="javascript"> 
		function seleccionado(id)
		{
			window.parent.seleccionado(id);
		}
		
	</script>
</head>
<body bgcolor="#FFFFFF">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr class="cabecera_listado" >
    	<th width="15" align="center"></th>
		<th align="center"><font class="titulolistado">CALLE</font></th>
        <th align="center"><font class="titulolistado">NUMERO</font></th>
        <th align="center"><font class="titulolistado">PISO</font></th>
        <th align="center"><font class="titulolistado">DEPARTAMENTO</font></th>
        <th align="center"><font class="titulolistado">COMUNA</font></th>
        <th align="center"><font class="titulolistado">VIGENTE</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDeudores->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDeudores->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_direccion")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_direccion")) ?>)"></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("calle"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("numero"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("piso"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("depto"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("comuna"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("vigente"))) ?></td>
	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="6" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>