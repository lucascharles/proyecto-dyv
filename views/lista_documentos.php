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
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
	<tr bgcolor="#666666">
		<th align="center"></th>
		<th align="center"><font class="titulolistado">Correlativo</font></th>
        <th align="center"><font class="titulolistado">Deudor</font></th>
		<th align="center"><font class="titulolistado">Mandante</font></th>
        <th align="center"><font class="titulolistado">Recibido</font></th>
		<th align="center"><font class="titulolistado">Estado</font></th>
        <th align="center"><font class="titulolistado">Nro.Doc.</font></th>
        <th align="center"><font class="titulolistado">Tipo Doc.</font></th>
		<th align="center"><font class="titulolistado">Monto</font></th>
        <th align="center"><font class="titulolistado">Banco</font></th>
        <th align="center"><font class="titulolistado">Cta. Cte.</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDatosDocumentos->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDatosDocumentos->items[$j];
			
	?>
	<tr>
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_documento")) ?>)"></td>		
		
		<td align="center"><?php echo ($datoTmp->get_data("id_documento")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("ape1_deudor")." ".$datoTmp->get_data("ape2_deudor").$datoTmp->get_data("nom1_deudor")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("nombre_mandante")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("fecha_siniestro")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("id_estado_doc")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("id_tipo_doc")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("id_banco")) ?></td>
		<td align="left"><?php echo ($datoTmp->get_data("cta_cte")) ?></td>
		
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>