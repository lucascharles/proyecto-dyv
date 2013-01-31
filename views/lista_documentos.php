<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MVC - Modelo, Vista, Controlador - Jourmoly</title>
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
		<th align="center"></th>
		<th align="center"><font class="titulolistado">CORRELATIVO</font></th>
        <th align="center"><font class="titulolistado">DEUDOR</font></th>
		<th align="center"><font class="titulolistado">MANDANTE</font></th>
        <th align="center"><font class="titulolistado">RECIBIDO</font></th>
		<th align="center"><font class="titulolistado">ESTADO</font></th>
        <th align="center"><font class="titulolistado">NRO. DOC.</font></th>
        <th align="center"><font class="titulolistado">TIPO DOC.</font></th>
		<th align="center"><font class="titulolistado">MONTO</font></th>
        <th align="center"><font class="titulolistado">BANCO</font></th>
        <th align="center"><font class="titulolistado">CTA. CTE.</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDatosDocumentos->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDatosDocumentos->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF">
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_documento")) ?>)"></td>		
		
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("ape1_deudor")." ".$datoTmp->get_data("ape2_deudor").$datoTmp->get_data("nom1_deudor")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("nombre_mandante")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("fecha_siniestro")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_estado_doc")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_tipo_doc")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_banco")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("cta_cte")) ?></td>
		
	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="11" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>