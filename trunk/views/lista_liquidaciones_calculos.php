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
		<th align="center"><font class="titulolistado">Num.</font></th>
        <th align="center"><font class="titulolistado">Fecha Pago</font></th>
        <th align="center"><font class="titulolistado">Saldo Inicial</font></th>
        <th align="center"><font class="titulolistado">Pago</font></th>
        <th align="center"><font class="titulolistado">Capital</font></th>
        <th align="center"><font class="titulolistado">Interes</font></th>
        <th align="center"><font class="titulolistado">Saldo Final</font></th>
    </tr>
	<?php
	
	for($j=1; $j<=6; $j++) 
	{
		$fechainicial = "23/07/2007" ;
		$fecha = date("d/m/Y",strtotime("$fechainicial + ".$j ." Month"));
	?>
	<tr>
		<td align="center"><?php echo($j) ?></td>
		<td align="center"><?php echo($fecha) ?></td>
		<td align="center"><?php echo(111) ?></td>
		<td align="center"><?php echo(222) ?></td>
		<td align="center"><?php echo(333) ?></td>
		<td align="center"><?php echo(444) ?></td>
		<td align="center"><?php echo(555) ?></td>
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>