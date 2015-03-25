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
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr class="cabecera_listado" >
		<th align="center" width='1%'><font class="titulolistado"></font></th>
        <th align="center"><font class="titulolistado">Ficha</font></th>
        <th align="center"><font class="titulolistado">Juzgado</font></th>
        <th align="center"><font class="titulolistado">Rol</font></th>
        <th align="center"><font class="titulolistado">Monto</font></th>
        <th align="center"><font class="titulolistado">Aval</font></th>
        <th align="center"><font class="titulolistado">Exhorto</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDemandas->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDemandas->items[$j];

		if($datoTmp->get_data("exhorto1") <> "") $varexhorto = $datoTmp->get_data("exhorto1");
		if($datoTmp->get_data("exhorto2") <> "") $varexhorto = $datoTmp->get_data("exhorto2");
		if($datoTmp->get_data("exhorto3") <> "") $varexhorto = $datoTmp->get_data("exhorto3");
			
		
	?>
	<tr>
		<td><input type="radio" id="<? echo($datoTmp->get_data("ficha")) ?>" name="checkdemanda" value="" onclick="seleccionado(<? echo($datoTmp->get_data("ficha")) ?>)"></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("ficha")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("juzgado")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rol")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("aval")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($varexhorto) ?></td>
		<!-- <td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("exhorto")) ?></td> -->

	</tr>
	<?php
	}
	?>
</table>
</body>
</html>