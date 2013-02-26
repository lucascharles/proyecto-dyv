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
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
	<tr bgcolor="#666666">
    	<th width="15" align="center"></th>
		<th align="center"><font class="titulolistado">Mandatario</font></th>
        <th align="center"><font class="titulolistado">Deudor</font></th>
        <th align="center"><font class="titulolistado">Siniestro</font></th>
        <th align="center"><font class="titulolistado">Expr1</font></th>
        <th align="center"><font class="titulolistado">Estado</font></th>
        <th align="center"><font class="titulolistado">Monto</font></th>
        <th align="center"><font class="titulolistado">Doc</font></th>
        <th align="center"><font class="titulolistado">Banco</font></th>
        <th align="center"><font class="titulolistado">Num</font></th>
        <th align="center"><font class="titulolistado">Causal</font></th>
        <th align="center"><font class="titulolistado">Ficha</font></th>
        <th align="center"><font class="titulolistado">Nombre</font></th>
        <th align="center"><font class="titulolistado">Apellido</font></th>
        <th align="center"><font class="titulolistado">Juzgado</font></th>
        <th align="center"><font class="titulolistado">Rol</font></th>
        <th align="center"><font class="titulolistado">Comentario</font></th>
        <th align="center"><font class="titulolistado">Sugerencia</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionTipDoc->get_count(); $j++) 
	{
		$datoTmp = &$colleccionTipDoc->items[$j];
			
	?>
	<tr>
    	<td><input type="checkbox" id="<? echo($datoTmp->get_data("id_tipo_documento")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_tipo_documento")) ?>)"></td>
		<td align="center"><?php echo ($datoTmp->get_data("id_tipo_documento")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
		
		<td align="center"><font class="titulolistado">Mandatario</font></td>
        <td align="center"><font class="titulolistado">Deudor</font></td>
        <td align="center"><font class="titulolistado">Siniestro</font></td>
        <td align="center"><font class="titulolistado">Expr1</font></td>
        <td align="center"><font class="titulolistado">Estado</font></td>
        <td align="center"><font class="titulolistado">Monto</font></td>
        <td align="center"><font class="titulolistado">Doc</font></td>
        <td align="center"><font class="titulolistado">Banco</font></td>
        <td align="center"><font class="titulolistado">Num</font></td>
        <td align="center"><font class="titulolistado">Causal</font></td>
        <td align="center"><font class="titulolistado">Ficha</font></td>
        <td align="center"><font class="titulolistado">Nombre</font></td>
        <td align="center"><font class="titulolistado">Apellido</font></td>
        <td align="center"><font class="titulolistado">Juzgado</font></td>
        <td align="center"><font class="titulolistado">Rol</font></td>
        <td align="center"><font class="titulolistado">Comentario</font></td>
        <td align="center"><font class="titulolistado">Sugerencia</font></td>
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>