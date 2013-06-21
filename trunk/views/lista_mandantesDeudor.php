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
	<tr class="cabecera_listado" >
    	<th width="15" align="center"></th>
		<th align="center"><font class="titulolistado">RUT MANDANTE</font></th>
        <th align="center"><font class="titulolistado">NOMBRE MANDANTE</font></th>
        <th align="center"><font class="titulolistado">EMAIL</font></th>
        <th align="center"><font class="titulolistado">TELEFONO 1</font></th>
        <th align="center"><font class="titulolistado">TELEFONO 2</font></th>
        <th align="center"><font class="titulolistado">FAX</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionMandantesDeudor->get_count(); $j++) 
	{
		$datoTmp = &$colleccionMandantesDeudor->items[$j];
			
	?>
	<tr>
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_mandante")) ?>" name="checkmandante" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_mandante")) ?>)"></td>
		<td align="center"><?php echo($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("nombre"))) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("email"))) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tel1")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tel2")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("fax")) ?></td>
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>