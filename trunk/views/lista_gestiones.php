<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
    	<th width="15" align="center" height="25"></th>
		<th align="center"><font class="titulolistado">MANDANTE</font></th>
		<th align="center"><font class="titulolistado">DEUDOR</font></th>
        <th align="center"><font class="titulolistado">PRIMER APELLIDO</font></th>
        <th align="center"><font class="titulolistado">SEGUNDO APELLIDO</font></th>
        <th align="center"><font class="titulolistado">PRIMER NOMBRE</font></th>
        <th align="center"><font class="titulolistado">SEGUNDO NOMBRE</font></th>        
        <th align="center"><font class="titulolistado">PROX.GESTION</font></th>
        <th align="center"><font class="titulolistado">ESTADO</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionGestiones->get_count(); $j++) 
	{
		$datoTmp = &$colleccionGestiones->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >
    	<td height="25"><input type="radio" id="<? echo($datoTmp->get_data("id_gestion")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_gestion")) ?>)"></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("primer_apellido")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("segundo_apellido")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("primer_nombre")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("segundo_nombre")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("fecha_gestion")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
        
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