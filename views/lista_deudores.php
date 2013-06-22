<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script language="javascript"> 
		function seleccionado(id)
		{
			window.parent.seleccionadoDeudor(id);
		}
		
		function verMasRegistros(id)
		{
			var datos = "controlador=Deudores&accion=listar_mas_registros";
			datos += "&rut="+window.parent.document.getElementById("txtrut_d").value;
			datos += window.parent.document.getElementById("txtrut_dv").value;
			datos += "&p_ape="+window.parent.document.getElementById("txtpapellido").value;
			datos += "&s_ape="+window.parent.document.getElementById("txtsapellido").value;
			datos += "&p_nom="+window.parent.document.getElementById("txtpnombre").value;
			datos += "&s_nom="+window.parent.document.getElementById("txtsnombre").value;
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
<body bgcolor="#FFFFFF">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr class="cabecera_listado" >
    	<th width="3%" align="center" height="25"></th>
		<th align="center" width="17%"><font class="titulolistado">RUT</font></th>
        <th align="center" width="20%"><font class="titulolistado">PRIMER APELLIDO</font></th>
        <th align="center" width="20%"><font class="titulolistado">SEGUNDO APELLIDO</font></th>
        <th align="center" width="20%"><font class="titulolistado">PRIMER NOMBRE</font></th>
        <th align="center" width="20%"><font class="titulolistado">SEGUNDO NOMBRE</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDeudores->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDeudores->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >
    	<td height="25"><input type="radio" id="<? echo($datoTmp->get_data("id_deudor")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_deudor")) ?>)"></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("rut_deudor"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper(utf8_decode($datoTmp->get_data("primer_apellido")))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper(utf8_decode($datoTmp->get_data("segundo_apellido")))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper(utf8_decode($datoTmp->get_data("primer_nombre")))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper(utf8_decode($datoTmp->get_data("segundo_nombre")))) ?></td>
	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="6" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	
	$datoTmp = &$colleccionDeudores->items[($colleccionDeudores->get_count()-1)];
	if($cant_mas > 0)
	{
		
	?>
    <tr bgcolor="#FFFFFF">
    	<td colspan="6" align="center">
        <div id='btnvermas_<? echo($datoTmp->get_data("id_deudor")) ?>' onclick="verMasRegistros(<? echo($datoTmp->get_data("id_deudor")) ?>)" style="cursor:pointer;" >Ver mas </div></td>
	</tr>
    <?
    }
	?>
    </table>
	  <?
    if($cant_mas > 0)
	{
	?>
	<div  mascom='masdatcom' id="masdatos_<? echo($datoTmp->get_data("id_deudor")) ?>" style="display:none;">
    </div>
    <?
    }
	?>
</body>
</html>