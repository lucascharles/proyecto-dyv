<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script language="javascript"> 
		function seleccionado(id,idest)
		{
			window.parent.seleccionado(id,idest);
		}
		
		function verMasRegistros(id, pantalla)
		{
			var datos = "controlador=Gestiones&accion=listar_mas_registros";
			var tipoG = window.parent.document.getElementById("tipo_gestion").value;
			datos += "&rut_d="+window.parent.document.getElementById("txtrutdeudor").value+"&rut_m="+window.parent.document.getElementById("txtrutmandante").value+"&tipoGestion="+tipoG;
			datos += "&id_partida="+id;
			alert(datos);
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
    	<th width="15" align="center" height="25"></th>
		<th align="center"><font class="titulolistado">MANDANTE</font></th>
		<th align="center"><font class="titulolistado">DEUDOR</font></th>
		<th align="center"><font class="titulolistado">RAZON SOC.</font></th>
        <th align="center"><font class="titulolistado">PRIMER APELLIDO</font></th>
        <th align="center"><font class="titulolistado">SEGUNDO APELLIDO</font></th>
        <th align="center"><font class="titulolistado">PRIMER NOMBRE</font></th>
        <th align="center"><font class="titulolistado">SEGUNDO NOMBRE</font></th>        
        <th align="center"><font class="titulolistado">PROX.GESTION</font></th>
        <th align="center"><font class="titulolistado">ESTADO</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionGestiones->get_count(); $j++) 
	{
		$datoTmp = &$colleccionGestiones->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >
    	<td height="25"><input type="radio" id="<? echo($datoTmp->get_data("id_gestion")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_gestion")) ?>,<? echo($datoTmp->get_data("id_estado")) ?>)"></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("razonsocial"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("primer_apellido"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("segundo_apellido"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("primer_nombre"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("segundo_nombre"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_prox_gestion"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
        
	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="10" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	$datoTmp = &$colleccionGestiones->items[($colleccionGestiones->get_count()-1)];

	if($cant_mas > 0)
	{
		$pantalla = "ADMIN";

	?>
     <tr bgcolor="#FFFFFF">
    	<td colspan="10" align="center">
        <div id='btnvermas_<? echo($datoTmp->get_data("id_gestion")) ?>' onclick="verMasRegistros(<? echo($datoTmp->get_data("id_gestion")) ?>,'<? echo($pantalla) ?>')" style="cursor:pointer;" >Ver mas </div></td>
	</tr>
    <?
    }
	?>
</table>
<?
	if($cant_mas > 0)
	{
?>
<div  mascom='masdatcom' id="masdatos_<? echo($datoTmp->get_data("id_gestion")) ?>" style="display:none;">
    </div>
<?
	}
?>
</body>
</html>