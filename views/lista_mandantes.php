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
    	<th width="15" align="center"></th>
      <th align="center"><font class="titulolistado">Rut</font></th>
      <th align="center"><font class="titulolistado">Apellido</font></th>
      <th align="center"><font class="titulolistado">Nombre</font></th>
      <th align="center"><font class="titulolistado">Banco 1</font></th>
      <th align="center"><font class="titulolistado">Cta Cte1</font></th>
      <th align="center"><font class="titulolistado">Banco2</font></th>
      <th align="center"><font class="titulolistado">Cta Cte 2</font></th>   
    </tr>
	<?php

	for($j=0; $j<$colleccionMandantes->get_count(); $j++) 
	{
		$datoTmp = &$colleccionMandantes->items[$j];
			
	?>
	<tr bgcolor="#FFFFFF">
      <td  class="dato_lista">
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
      
      <td align="center"  class="dato_lista"><?php echo ($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante"))?></td>      
      <td align="center" class="dato_lista"><?php echo ($datoTmp->get_data("apellido")) ?></td>
      <td align="center" class="dato_lista"><?php echo ($datoTmp->get_data("nombre")) ?></td>           
  
      <td align="center" class="dato_lista">
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
      <td align="center" class="dato_lista"><?php echo ($datoTmp->get_data("cuenta_corriente1")) ?></td>      
      <td align="center" class="dato_lista">
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
      <td align="center" class="dato_lista"><?php echo ($datoTmp->get_data("cuenta_corriente2")) ?></td>
      <tr bgcolor="#FFFFFF" >
    	<td colspan="19" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
	</tr>
	<?php
	}
	?>
    
</table>
</body>
</html>