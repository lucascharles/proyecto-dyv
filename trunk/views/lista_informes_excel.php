<?
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=listado.xls; format=number");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>   
</head>
<body bgcolor="#FFFFFF">
<form name="frmlistadoinforme">

<div id="datos" style="">

<table width="100%" cellpadding="2" cellspacing="2" align="center" border="1" bgcolor="#FFFFFF">

	<tr class="cabecera_listado">
    	<th align="center"></th>
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
        <th align="center"><font class="titulolistado">Comuna</font></th>
        <th align="center"><font class="titulolistado">Rol</font></th>
        <th align="center"><font class="titulolistado">Comentario</font></th>
        <th align="center"><font class="titulolistado">Sugerencia</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionInformes->get_count(); $j++) 
	{
		$datoTmp = &$colleccionInformes->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >

    	<td align="left" class="dato_lista"></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_siniestro")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("fecha_siniestro")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("banco")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("causal")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_ficha")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("primer_nombre")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("primer_apellido")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("juzgado_numero")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("juzgado_comuna")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rol")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ("comentario") ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ("sugerencia") ?></td>
	</tr>
	<?php
	}
	?>

</table>
</div>
</form>
</body>
</html>