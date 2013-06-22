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
<body>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
	<tr class="cabecera_listado">
    	<th width="15" align="center"></th>
		<th align="center"><font class="titulolistado">Mandante</font></th>
        <th align="center"><font class="titulolistado">Fecha creaci&oacute;n</font></th>
        <th align="center"><font class="titulolistado">Usuario creaci&oacute;n</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionLiquidaciones->get_count(); $j++) 
	{
		$datoTmp = &$colleccionLiquidaciones->items[$j];
			
	?>
	<tr>
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_liquidacion")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_liquidacion")) ?>)"></td>
		<td align="center"><?php echo (utf8_decode($datoTmp->get_data("nombre")." ".$datoTmp->get_data("apellido"))) ?></td>
		<td align="center">&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_creacion"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>
		<td align="center">&nbsp;<?php echo ($datoTmp->get_data("usuario_creacion")) ?></td>
		
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>