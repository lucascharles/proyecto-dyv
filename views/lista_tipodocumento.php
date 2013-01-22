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
		<th align="center"><font class="titulolistado">ID</font></th>
        <th align="center"><font class="titulolistado">Tipo Documentoz</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionTipDoc->get_count(); $j++) 
	{
		$datoTmp = &$colleccionTipDoc->items[$j];
			
	?>
	<tr>
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_tipo_documento")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_tipo_documento")) ?>)"></td>
		<td align="center"><?php echo ($datoTmp->get_data("id_tipo_documento")) ?></td>
		<td align="left">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
	</tr>
	<?php
	}
	?>
</table>
</body>
</html>