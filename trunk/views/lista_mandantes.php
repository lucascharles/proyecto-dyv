<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
      <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script language="javascript"> 
		function verMasRegistros(id)
		{
			var datos = "controlador=Mandantes&accion=listar_mas_registros";
			datos += "&des_int="+window.parent.document.getElementById("txtrut_m").value;
			datos += "&desApel1="+window.parent.document.getElementById("txtPrimerApel").value;
			datos += "&desNomb1="+window.parent.document.getElementById("txtPrimerNomb").value;
			datos += "&id_partida="+id;
			datos += "&pantalla="+document.getElementById("pantalla").value;
			
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
		
		function seleccionado(id)
		{
			window.parent.seleccionadoMandante(id);
		}
		
		function selMandDeu(id)
		{
			window.parent.selMandDeu(id);
		}
		
		function quitarMandDeu(id)
		{
			window.parent.quitarMandDeu(id);
		}
	</script>
</head>
<body bgcolor="#FFFFFF">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
	<tr class="cabecera_listado">
    	<th width="3%" align="center"></th>
      <th align="center" width="17%"><font class="titulolistado">Rut</font></th>
      <th align="center" width="15%"><font class="titulolistado">Apellido</font></th>
      <th align="center" width="15%"><font class="titulolistado">Nombre</font></th>
      <th align="center" width="15%"><font class="titulolistado">Banco 1</font></th>
      <th align="center" width="10%"><font class="titulolistado">Cta Cte1</font></th>
      <th align="center" width="15%"><font class="titulolistado">Banco2</font></th>
      <th align="center" width="10%"><font class="titulolistado">Cta Cte 2</font></th>   
    </tr>
	<?php

	for($j=0; $j<$colleccionMandantes->get_count(); $j++) 
	{
		$datoTmp = &$colleccionMandantes->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF">
      <td  class="dato_lista">
      <input type="hidden" name="pantalla" id="pantalla" value="<? echo($pantalla) ?>" />
      <?
	 
      if($pantalla == "pdeudor")
	  {
	  	?>
        <input type="button" id="<? echo($datoTmp->get_data("id_mandante")) ?>" name="btnmandante" value="" onclick="selMandDeu(<? echo($datoTmp->get_data("id_mandante")) ?>)">
        <?
	  }
	  else
	  {
	  	if($pantalla == "pdeudor_s")
		{
	  ?>
      <input type="button" id="<? echo($datoTmp->get_data("id_mandante")) ?>" name="btnmandante" value="" onclick="quitarMandDeu(<? echo($datoTmp->get_data("id_mandante")) ?>)">
      <?
	  	}
		else
		{
		?>
      <input type="radio" id="<? echo($datoTmp->get_data("id_mandante")) ?>" name="checktipdoc" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_mandante")) ?>)">
      <?
		}
      }
	  ?>
      </td>
      
      <td align="left"  class="dato_lista"><?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante"))?></td>      
      <td align="left" class="dato_lista"><?php echo ($datoTmp->get_data("apellido")) ?></td>
      <td align="left" class="dato_lista"><?php echo ($datoTmp->get_data("nombre")) ?></td>           
  
      <td align="left" class="dato_lista">
	  <?php 
	  for($i=0; $i<$colleccionBancos->get_count(); $i++) 
	  {
	  	$dbTmp = &$colleccionBancos->items[$i];
		if($dbTmp->get_data("id_banco") == $datoTmp->get_data("banco1"))
		{
	  		echo ($dbTmp->get_data("banco"));
			break;
		}
	  }
	  ?>
      </td>
      <td align="left" class="dato_lista"><?php echo ($datoTmp->get_data("cuenta_corriente1")) ?></td>      
      <td align="left" class="dato_lista">
	   <?php 
	  for($i=0; $i<$colleccionBancos->get_count(); $i++) 
	  {
	  	$dbTmp = &$colleccionBancos->items[$i];
		if($dbTmp->get_data("id_banco") == $datoTmp->get_data("banco2"))
		{
	  		echo ($dbTmp->get_data("banco"));
			break;
		}
	  }
	  ?>
      </td>
      <td align="left" class="dato_lista"><?php echo ($datoTmp->get_data("cuenta_corriente2")) ?></td>
      <tr bgcolor="#FFFFFF" >
    	<td colspan="8" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	$datoTmp = &$colleccionMandantes->items[($colleccionMandantes->get_count()-1)];
	
	if($cant_mas > 0)
	{
		
	?>
    <tr bgcolor="#FFFFFF">
    	<td colspan="8" align="center">
        <div id='btnvermas_<? echo($datoTmp->get_data("id_mandante")) ?>' onclick="verMasRegistros(<? echo($datoTmp->get_data("id_mandante")) ?>)" style="cursor:pointer;" >Ver mas </div></td>
	</tr>
    <?
    }
	?>
    
</table>
<?
	if($cant_mas > 0)
	{
?>
<div  mascom='masdatcom' id="masdatos_<? echo($datoTmp->get_data("id_mandante")) ?>" style="display:none;">
    </div>
    <?
    }
	?>
</body>
</html>