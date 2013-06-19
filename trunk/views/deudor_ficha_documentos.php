<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MVC - Modelo, Vista, Controlador - Jourmoly</title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
      <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
     
    <script language="javascript"> 
		function seleccionado(id)
		{
			window.parent.seleccionado(id);			
		}
		function mostrarTotal(total)
		{
			
			var datos = "controlador=Deudores&accion=buscar_total";
			datos += "&ident="+window.parent.document.getElementById("ident").value;
			datos += "&tipoperacion="+window.parent.document.getElementById("tipoperacion").value; 
			
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						document.getElementById("lblTotal").innerHTML = "Total: "+res;
					},
					error: function()
					{
						//alert("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		function verMasRegistros(id)
		{
			var datos = "controlador=Deudores&accion=listar_mas_fichadoc";
			datos += "&id_partida="+id;
			datos += "&ident="+window.parent.document.getElementById("ident").value;
			datos += "&tipoperacion="+window.parent.document.getElementById("tipoperacion").value; 
			
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

 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Documentos</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr bgcolor="#FFFFFF">
    	<td colspan="11" align="left">
        	<label id="lblTotal" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;"></label>
        </td>
    </tr>
	<tr class="cabecera_listado" >
		<th align="center" width='2%'></th>
		<th align="center" width='17%'><font class="titulolistado">CORRELATIVO</font></th>
        <th align="center" width='10%'><font class="titulolistado">DEUDOR</font></th>
		<th align="center" width='10%'><font class="titulolistado">MANDANTE</font></th>
        <th align="center" width='10%'><font class="titulolistado">RECIBIDO</font></th>
		<th align="center" width='10%'><font class="titulolistado">ESTADO</font></th>
        <th align="center" width='10%'><font class="titulolistado">NRO. DOC.</font></th>
        <th align="center" width='8%'><font class="titulolistado">TIPO DOC.</font></th>
		<th align="center" width='5%'><font class="titulolistado">MONTO</font></th>
        <th align="center" width='10%'><font class="titulolistado">BANCO</font></th>
        <th align="center" width='8%'><font class="titulolistado">CTA. CTE.</font></th>
    </tr>
	<?php
	$total = 0;
	for($j=0; $j<$colleccionDoc->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDoc->items[$j];
		$total = $total + $datoTmp->get_data("monto");
	?>
	<tr bgcolor="#FFFFFF">
    	<td></td>		
		
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("ape1_deudor")." ".$datoTmp->get_data("ape2_deudor").$datoTmp->get_data("nom1_deudor")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("nombre_mandante")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_siniestro"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_estado_doc")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_tipo_doc")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_banco")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("cta_cte")) ?></td>
		
	</tr>
    <tr bgcolor="#FFFFFF">
    	<td colspan="11" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	?>

<?
	echo("<script language='javascript'>");
	echo("mostrarTotal(".$total.");");
	echo("</script>");

	$datoTmp = &$colleccionDoc->items[($colleccionDoc->get_count()-1)];
	if($cant_mas > 0)
	{
		
	?>
    <tr bgcolor="#FFFFFF">
    	<td colspan="11" align="center">
        <div id='btnvermas_<? echo($datoTmp->get_data("id_documento")) ?>' onclick="verMasRegistros(<? echo($datoTmp->get_data("id_documento")) ?>)" style="cursor:pointer;" >Ver mas </div></td>
	</tr>
    <?
    }
	?>
    </table>
    <?
    if($cant_mas > 0)
	{
	?>
	<div  mascom='masdatcom' id="masdatos_<? echo($datoTmp->get_data("id_documento")) ?>" style="display:none;">
    </div>
    <?
    }
	?>
    
</body>
</html>
