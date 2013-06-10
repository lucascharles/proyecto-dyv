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
			window.parent.seleccionado_doc(id);		
		}
		
		function verMasRegistros(id, pantalla)
		{
			
			var datos = "controlador=Documentos&accion=listar_mas_registros";
			if(pantalla == "ALTA")
			{
				datos = "controlador=Documentos&accion=listar_mas_registros_nuevos";
				datos += "&idedeudor="+window.parent.document.getElementById("selDeudor").value;
			}
			
			if(pantalla == "ADMIN")
			{
				datos += "&desApel1="+window.parent.document.getElementById("txtPrimerApel").value;
				datos += "&desApel2="+window.parent.document.getElementById("txtSegundoApel").value;
				datos += "&desNomb1="+window.parent.document.getElementById("txtPrimerNomb").value;
				datos += "&desNomb2="+window.parent.document.getElementById("txtSegundoNomb").value;
			}
			
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
		<th align="center" width="3%"></th>
		<th align="center" width="10%"><font class="titulolistado">CORRELATIVO</font></th>
        <th align="center" width="10%"><font class="titulolistado">DEUDOR</font></th>
		<th align="center" width="10%"><font class="titulolistado">MANDANTE</font></th>
        <th align="center" width="10%"><font class="titulolistado">F. PROTESTO</font></th>
		<th align="center" width="10%"><font class="titulolistado">ESTADO</font></th>
        <th align="center" width="10%"><font class="titulolistado">NRO. DOC.</font></th>
        <th align="center" width="8%"><font class="titulolistado">TIPO DOC.</font></th>
		<th align="center" width="8%"><font class="titulolistado">MONTO</font></th>
        <th align="center" width="8%"><font class="titulolistado">BANCO</font></th>
        <th align="center" width="8%"><font class="titulolistado">CTA. CTE.</font></th>
        <th align="center" width="7%"><font class="titulolistado">RECIBIDO</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDatosDocumentos->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDatosDocumentos->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF">
    	<td><input type="radio" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_documento")) ?>)"></td>		
		
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("id_documento"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("ape1_deudor")." ".$datoTmp->get_data("ape2_deudor").$datoTmp->get_data("nom1_deudor"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("nombre_mandante"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper(formatoFecha($datoTmp->get_data("fecha_protesto"),"dd-mm-yyyy","dd/mm/yyyy"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("id_estado_doc"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("numero_documento"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("id_tipo_doc"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("monto"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("id_banco"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper($datoTmp->get_data("cta_cte"))) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (strtoupper(formatoFecha($datoTmp->get_data("fecha_recibido"),"dd-mm-yyyy","dd/mm/yyyy"))) ?></td>
	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="11" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	$datoTmp = &$colleccionDatosDocumentos->items[($colleccionDatosDocumentos->get_count()-1)];
	//echo("<br> cant: ".$cant_mas);
	if($cant_mas > 0)
	{
		$pantalla = "ADMIN";
		if($pantalla == "alta")
		{
			$pantalla = "ALTA";
		}
		
	?>
    <tr bgcolor="#FFFFFF">
    	<td colspan="11" align="center">
        <div id='btnvermas_<? echo($datoTmp->get_data("id_documento")) ?>' onclick="verMasRegistros(<? echo($datoTmp->get_data("id_documento")) ?>,'<? echo($pantalla) ?>')" style="cursor:pointer;" >Ver mas </div></td>
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