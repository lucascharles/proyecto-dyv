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
		<th align="center"><font class="titulolistado"></font></th>
		<th align="center"><font class="titulolistado">Numero</font></th>
        <th align="center"><font class="titulolistado">Rut Deudor</font></th>
        <th align="center"><font class="titulolistado">Nombre Deudor</font></th>
        <th align="center"><font class="titulolistado">Rut Mandante</font></th>
        <th align="center"><font class="titulolistado">Nombre Mandante</font></th>
        <th align="center"><font class="titulolistado">Fecha Ingreso</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$objTodasFichas->get_count(); $j++) 
	{
		$datoTmp = &$objTodasFichas->items[$j];
			
	?>
	<tr>
		<td><input type="radio" id="<? echo($datoTmp->get_data("id_ficha")) ?>" name="checkficha" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_ficha")) ?>)"></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_ficha")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("d_primer_apellido")." ".$datoTmp->get_data("d_segundo_apellido")
													." ".$datoTmp->get_data("d_primer_nombre")." ".$datoTmp->get_data("d_segundo_nombre")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("nombre")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("ingreso"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>

	</tr>
	<?php
	}
	?>
</table>
</body>
</html>