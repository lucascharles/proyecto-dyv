<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	<title></title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
     
    <script language="javascript"> 
		function seleccionado(id)
		{
			window.parent.seleccionado(id);
		}
		
		function seleccionar()
		{
			if(document.getElementById("chkTodos").checked == true)
			{
				var url = "index.php?controlador=Informes&accion=marcar&tipoInforme=";
				url += window.parent.document.getElementById("selTipoInforme").value;
				url += "&idmandante="+window.parent.document.getElementById("id_mandante").value;
				url += "&tipoDoc="+window.parent.document.getElementById("selTipoDoc").value;
			}
			else
			{
				var url = "index.php?controlador=Informes&accion=listar&tipoInforme=";
				url += window.parent.document.getElementById("selTipoInforme").value;
				url += "&idmandante="+window.parent.document.getElementById("id_mandante").value;
				url += "&tipoDoc="+window.parent.document.getElementById("selTipoDoc").value;
			}
			window.location = url;
			
		}
		
		function generarExcel()
		{
			var arrayInput = document.getElementsByTagName('input');
	        var arrayID = new Array();
    	    var j = 0;
		
	 		for(var i=0; i<arrayInput.length; i++)
	 		{
  				if(arrayInput[i].type == "checkbox")
   				{
                	if((arrayInput[i].name == "chkMarcar")&&(arrayInput[i].checked == true))
            	 	{
                		arrayID[j] = arrayInput[i].value ;
                    	j = j+1;
                 	}
    			}	
   			}        

			if(j == 0)
			{
				return false;
			}
			var array_str = arrayID.toString();
		
			var url = "index.php?controlador=Informes&accion=generarExcel&tipoInforme=";
				url += window.parent.document.getElementById("selTipoInforme").value
				url += "&idmandante="+window.parent.document.getElementById("id_mandante").value;
				url += "&tipoDoc="+window.parent.document.getElementById("selTipoDoc").value
				url += "&iddocs="+array_str;
				
				window.location = url;
		}
		
		function generarPdf()
		{
			var arrayInput = document.getElementsByTagName('input');
	        var arrayID = new Array();
    	    var j = 0;
		
	 		for(var i=0; i<arrayInput.length; i++)
	 		{
  				if(arrayInput[i].type == "checkbox")
   				{
                	if((arrayInput[i].name == "chkMarcar")&&(arrayInput[i].checked == true))
            	 	{
                		arrayID[j] = arrayInput[i].value ;
                    	j = j+1;
                 	}
    			}	
   			}        

			if(j == 0)
			{
				return false;
			}
			var array_str = arrayID.toString();
		
			var url = "index.php?controlador=Informes&accion=generarPdf&tipoInforme=";
				url += window.parent.document.getElementById("selTipoInforme").value
				url += "&idmandante="+window.parent.document.getElementById("id_mandante").value;
				url += "&tipoDoc="+window.parent.document.getElementById("selTipoDoc").value
				url += "&iddocs="+array_str;
				
				window.location = url;
		}
		
	</script>
</head>
<body bgcolor="#FFFFFF">
<form name="frmlistadoinforme">
<?
$marcar = &$marcartodo;
$title = "Marcar Todos";
$checked = "";
if($marcar == "S")
{
	$title = "Desmarcar Todos";
	$checked = "checked";
}
?>
<div style=" border-width:2px; border-color:#999999;">

<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
<tr class="">
    	<th align="right" colspan="19" height="5" class="cabecera_listado">
    
        </th>
    </tr>
	<tr class="">
    	<th align="left" colspan="19"  valign="middle">
        	<table width="150" align="left" border="0" cellpadding="0"  cellspacing="0" onclick="generarExcel()" style="cursor:pointer; " title="Generar Excel">
            	<tr>
                	<td width="30">
        <img src="images/excel.gif" />
        			</td>
                    <td align="left" class="etiqueta_form">
        		&nbsp;Generar Excel
                	</td>
        		</tr>
            </table>
            <table width="150" align="left" border="0" cellpadding="0"  cellspacing="0" onclick="generarPdf()" style="cursor:pointer; " title="Generar Excel">
            	<tr>
                	<td width="30">
        <img src="images/pdf.gif" />
        			</td>
                    <td align="left" class="etiqueta_form">
        		&nbsp;Generar Pdf
                	</td>
        		</tr>
            </table>
        </th>
        
    </tr>
    <tr class="">
    	<th align="right" colspan="19" height="5" class="cabecera_listado">
    
        </th>
    </tr>
	<tr class="cabecera_listado">
    	<th align="center"><input type="checkbox" <? echo($checked) ?> name="chkTodos" id="chkTodos" title="<? echo($title) ?>" onclick="seleccionar()" /></th>
		<th align="center"><font class="titulolistado">Mandatario</font></th>
        <th align="center"><font class="titulolistado">Rut Deudor</font></th>
        <th align="center"><font class="titulolistado">Deudor</font></th>
        <th align="center"><font class="titulolistado">Tipo Doc.</font></th>
        <th align="center"><font class="titulolistado">Nro. Doc.</font></th>
        <th align="center"><font class="titulolistado">Monto</font></th>
        <th align="center"><font class="titulolistado">Demanda</font></th>
        <th align="center"><font class="titulolistado">Juzgado</font></th>
        <th align="center"><font class="titulolistado">Rol</font></th>
        <th align="center"><font class="titulolistado">Fecha Prox. Gestion</font></th>
        <th align="center"><font class="titulolistado">Comentarios</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionInformes->get_count(); $j++) 
	{
		$datoTmp = &$colleccionInformes->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF" >
	<?php 
		if($marcar == "S")
		{ 
		?>
    	<td align="left" class="dato_lista">&nbsp;&nbsp;
        <input type="checkbox"  name="chkMarcar" checked="checked" id="<? echo($datoTmp->get_data("id_documento")) ?>"  value="<?=$datoTmp->get_data("id_documento")?>" onclick=""></td>
   	<?php }else{ ?>
   		<td align="left" class="dato_lista">&nbsp;&nbsp;<input type="checkbox" name="chkMarcar" id="<? echo($datoTmp->get_data("id_documento")) ?>"  value="<? echo($datoTmp->get_data("id_documento")) ?>" onclick=""></td>
   	<?php } ?>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("razonsocial")." ".$datoTmp->get_data("primer_apellido")." ".$datoTmp->get_data("segundo_apellido")." ".$datoTmp->get_data("primer_nombre")." ".$datoTmp->get_data("segundo_nombre")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_ficha")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("juzgado")) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("rol"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("fecha_prox_gestion"))) ?></td>
        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (utf8_decode($datoTmp->get_data("notas"))) ?></td>

	</tr>
    <tr bgcolor="#FFFFFF" >
    	<td colspan="19" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	?>

</table>
</div>
</form>
</body>
</html>