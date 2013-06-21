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
<body>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr class="cabecera_listado" >
		<th align="center"><font class="titulolistado">Num.</font></th>
        <th align="center"><font class="titulolistado">Juzgado</font></th>
        <th align="center"><font class="titulolistado">Rol</font></th>
        <th align="center"><font class="titulolistado">Ficha</font></th>
        <th align="center"><font class="titulolistado">Rep</font></th>
        <th align="center"><font class="titulolistado">Fecha</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDemandas->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDemandas->items[$j];
			
	?>
	<tr>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("juzgado")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rol")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("ficha")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rep")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo (formatFecha($datoTmp->get_data("fecha"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>

	</tr>
	<?php
	}
	?>
</table>
</body>
</html>