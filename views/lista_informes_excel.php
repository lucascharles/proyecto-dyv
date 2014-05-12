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
        <th align="center"><font class="titulolistado">Rut Deudor</font></th>
        <th align="center"><font class="titulolistado">Deudor</font></th>
        <th align="center"><font class="titulolistado">Tipo Doc.</font></th>
        <th align="center"><font class="titulolistado">Nro. Doc.</font></th>
        <th align="center"><font class="titulolistado">Monto</font></th>
        <th align="center"><font class="titulolistado">Demanda</font></th>
        <th align="center"><font class="titulolistado">Juzgado</font></th>
        <th align="center"><font class="titulolistado">Rol</font></th>
        <th align="center"><font class="titulolistado">Fecha Gestion</font></th>
        <th align="center"><font class="titulolistado">Comentarios</font></th>
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
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("razonsocial")." ".$datoTmp->get_data("primer_apellido")." ".$datoTmp->get_data("segundo_apellido")." ".$datoTmp->get_data("primer_nombre")." ".$datoTmp->get_data("segundo_nombre")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
        <td align="left" class="dato_lista"><?php echo ($datoTmp->get_data("monto")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_ficha")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("juzgado")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("rol"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("fecha_prox_gestion"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("notas"))) ?></td>
	</tr>
	<?php
	}
	?>

</table>
</div>
</form>
</body>
</html>