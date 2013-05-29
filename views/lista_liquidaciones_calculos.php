<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
</head>
<body>
<div id="datos" style=" overflow:auto; height:150px; width:99%;">
 <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
	<tr class="cabecera_listado">
		<th align="center"><font class="titulolistado">Num.</font></th>
        <th align="center"><font class="titulolistado">Fecha Pago</font></th>
        <th align="center"><font class="titulolistado">Saldo Inicial</font></th>
        <th align="center"><font class="titulolistado">Pago</font></th>
        <th align="center"><font class="titulolistado">Capital</font></th>
        <th align="center"><font class="titulolistado">Interes</font></th>
        <th align="center"><font class="titulolistado">Saldo Final</font></th>
    </tr>
	<?php
	
	for($i=0; $i<count($array_pagos); $i++) 
	{
		$array_aux = $array_pagos[$i];
	?>
	<tr>
		<td align="center"><?php echo($array_aux["num"]) ?></td>
		<td align="center"><?php echo($array_aux["fecha_pago"]) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo(conDecimales($array_aux["saldo_ini"])) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo(conDecimales($array_aux["pago"])) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo(conDecimales($array_aux["capital"])) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo(conDecimales($array_aux["interes"])) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo(conDecimales($array_aux["saldo_final"])) ?></td>
	</tr>
	<?php
	}
	?>
</table>
</div>
</body>
</html>