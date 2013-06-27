<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
      <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script language="javascript"> 
		function seleccionado(id)
		{
			window.parent.seleccionado(id);
		}
		
		
		function verMasRegistros(id, pantalla)
		{
			var datos = "controlador=Deudores&accion=listar_mas_registros_fichas";
			datos += "&rutdeudor="+window.parent.document.getElementById("txtrut").value;
			datos += "&id_partida="+id;
			
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#btnvermas_"+id).hide("slow"); 
						$("#masdatos_"+id).html(res); 
						$("#masdatos_"+id).slideDown("slow"); 
					},
					error: function()
					{
						//alert("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
	</script>
</head>
<body>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr class="cabecera_listado" >
		<th align="center" width='1%'><font class="titulolistado"></font></th>
		<th align="center" width='9%'><font class="titulolistado">Numero</font></th>
        <th align="center" width='12%'><font class="titulolistado">Rut Deudor</font></th>
        <th align="center" width='28%'><font class="titulolistado">Nombre Deudor</font></th>
        <th align="center" width='14%'><font class="titulolistado">Rut Mandante</font></th>
        <th align="center" width='20%'><font class="titulolistado">Nombre Mandante</font></th>
        <th align="center" width='16%'><font class="titulolistado">Fecha Ingreso</font></th>
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
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("d_primer_apellido")." ".$datoTmp->get_data("d_segundo_apellido")." ".$datoTmp->get_data("d_primer_nombre")." ".$datoTmp->get_data("d_segundo_nombre"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("nombre"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("ingreso"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>

	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="7" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	
	$datoTmp = &$objTodasFichas->items[($objTodasFichas->get_count()-1)];

	if($cant_mas > 0)
	{
		$pantalla = "ADMIN";

	?>
     <tr bgcolor="#FFFFFF">
    	<td colspan="11" align="center">
        <div id='btnvermas_<? echo($datoTmp->get_data("id_ficha")) ?>' onclick="verMasRegistros(<? echo($datoTmp->get_data("id_ficha")) ?>,'<? echo($pantalla) ?>')" style="cursor:pointer;" >Ver mas </div></td>
	</tr>
    <?
    }
	?>
</table>
<?
	if($cant_mas > 0)
	{
?>
<div  mascom='masdatcom' id="masdatos_<? echo($datoTmp->get_data("id_ficha")) ?>" style="display:none;">
    </div>
<?
	}
?>
</body>
</html>