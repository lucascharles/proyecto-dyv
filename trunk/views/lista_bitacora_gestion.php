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
    	
		<th align="center"><font class="titulolistado">Rut Deudor</font></th>
        <th align="center"><font class="titulolistado">Estado</font></th>
        <th align="center"><font class="titulolistado">Fecha Gestion</font></th>
        <th align="center"><font class="titulolistado">Comentario</font></th>
        <th align="center"><font class="titulolistado">Proxima Gestion</font></th>
        <th align="center"><font class="titulolistado">Usuario</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionBitacoraGestion->get_count(); $j++) 
	{
		$datoTmp = &$colleccionBitacoraGestion->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >    	
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("fecha_gestion")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("notas")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("fecha_prox_gestion")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("usuario")) ?></td>
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