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
			window.parent.quitarOpcion(id);
		}
		
	</script>
</head>
<body bgcolor="#FFFFFF">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr class="cabecera_listado" >
    	<th width="40" align="center"></th>
        <th align="center" width="3%"><font class="titulolistado">ID</font></th>
		<th align="center"><font class="titulolistado">NOMBRE</font></th>
    </tr>
	<?php
	
	if($colOpcionModulo <> NULL)
	{
		for($j=0; $j<$colOpcionModulo->get_count(); $j++) 
		{
			$datoTmp = &$colOpcionModulo->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >
    	<td align="center">
        <? 
			if($detalle <> "S")
			{
		 ?>
        <img src="images/desasignar.gif" id="<? echo($datoTmp->get_data("id")) ?>" title="Quitar opci&oacute;n" onclick="seleccionado(<? echo($datoTmp->get_data("id")) ?>)" style="cursor:pointer"  />
        <?
        	}
		?>
        </td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("nombre")) ?></td>
	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="3" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
		}
	}
	?>
</table>
</body>
</html>