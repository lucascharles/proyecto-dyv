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
		<th align="center"><font class="titulolistado">CONTACTO</font></th>
        <th align="center"><font class="titulolistado">EMAIL</font></th>
        <th align="center"><font class="titulolistado">CELULAR</font></th>
        <th align="center"><font class="titulolistado">TELEFONO</font></th>
        <th align="center"><font class="titulolistado">FAX</font></th>
        <th align="center"><font class="titulolistado">OBSERVACI&Oacute;N</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionContactos->get_count(); $j++) 
	{
		$datoTmp = &$colleccionContactos->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_contacto")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_contacto")) ?>)"></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("contacto"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("email")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("celular")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("telefono")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("fax")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("observacion"))) ?></td>
	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="7" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>