<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

    <script language="javascript">
		function mostrar(obj)
		{
			var tipoG = document.getElementById("tipo_gestion").value;
			var url = "index.php?controlador=Gestiones&accion=listarGestiones&rut_d="+document.getElementById("txtrutdeudor").value+"&rut_m="+document.getElementById("txtrutmandante").value+"&tipoGestion="+tipoG;
			url +="&id_partida=0";
			document.getElementById("frmlistgestiones").src = url;

		}
		
		function limpiar()
		{
			document.getElementById("txtrutdeudor").value = "";
			document.getElementById("txtrutmandante").value = "";
			var tipoG = document.getElementById("tipo_gestion").value;
			var url = "index.php?controlador=Gestiones&accion=listarGestiones&rut_d="+document.getElementById("txtrutdeudor").value+"&rut_m="+document.getElementById("txtrutmandante").value+"&tipoGestion="+tipoG;
			url +="&id_partida=0";
			document.getElementById("frmlistgestiones").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=Gestiones&accion=listarGestiones&des_int="+document.getElementById("txtrutdeudor").value;
			url +="&id_partida=0";
			document.getElementById("frmlistgestiones").src = url;
		}
		
		function seleccionado(id)
		{
			document.getElementById("id_gestion").value = id;
		}
		
		
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		
		function gestionar()
		{
			if(document.getElementById("id_gestion").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_gestion").value;
			
			$("#pagina").load('index.php?controlador=Gestiones&accion=gestionar&idgestion='+id+'&tipoGestion='+document.getElementById("tipo_gestion").value);
			
		}
	</script>
</head>
<body>
<form name="frmadmgestiones">
<input  type="hidden" name="id_gestion" id="id_gestion" value=""/>
<input  type="hidden" name="tipo_gestion" id="tipo_gestion" value="<?php $var = &$tipoGestion; echo($var); ?>"/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Gestiones<?php $var = &$tipoGestion; if($var == "D"){echo(" del dia");} ?></th>
        <th></th>
        <th></th>
    </tr>
 </table>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th></th>
    </tr>
	<tr>
		<th align="left">Busqueda</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="buscador" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	 
	 <tr>
		<td align="right" class="etiqueta_form" width="20">Rut Mandante:</td>
        <td>&nbsp;&nbsp;&nbsp;<input type="text" name="txtrutmandante" id="txtrutmandante"  onkeyup='mostrar(this)' class="input_form"  onFocus="resaltar(this)" onBlur="noresaltar(this)" /> &nbsp;
        </td>
        <td align="right" class="etiqueta_form" width="20">Rut Deudor:</td>
        <td>&nbsp;&nbsp;&nbsp;<input type="text" name="txtrutdeudor" id="txtrutdeudor"  size="40" onkeyup='mostrar(this)' class="input_form"  onFocus="resaltar(this)" onBlur="noresaltar(this)"/> &nbsp;
        </td>
        <td> <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	 <input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" class="boton_form" onclick="limpiar()" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
    </tr>
 </table>
 </div>
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2">
        	<iframe id="frmlistgestiones" src="index.php?controlador=Gestiones&accion=listarGestiones&tipoGestion=<? $var = &$tipoGestion; echo($var); ?>&id_partida=0" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td>
        	<div style="position:relative; margin-left:10px;">
            <input  type="button" name="btngestionar" id="btngestionar" onclick="gestionar()"  class="boton_form" value="Gestionar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
            </div>
         </td>
    </tr>
    <tr>
    	 <td align="left" class="etiqueta_form" >Cantidad Gestiones: <?php $var = &$cantGestion; echo($var); ?></td>
    </tr>
	<tr>
		<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
			<tr class="cabecera_listado" >
				<th align="center"><font class="titulolistado">Documento</font></th>
				<th align="center"><font class="titulolistado">Estado</font></th>
				<th align="center"><font class="titulolistado">Cantidad</font></th>
		        <th align="center"><font class="titulolistado">Monto</font></th>
		    </tr>
			<?php
			
			for($j=0; $j<$detalleDocs->get_count(); $j++) 
			{
				$datoTmp = &$detalleDocs->items[$j];
					
			?>
			<tr bgcolor="#FFFFFF" >
		        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("documento"))?></td>
		        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado"))?></td>
		        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("cantidad"))?></td>
		        <td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto"))?></td>
			</tr>
		    <tr bgcolor="#FFFFFF" >
		    	<td colspan="9" style="border-bottom:solid; border-bottom-width:2px; border-bottom-color:#CCCCCC; "></td>
			</tr>
			<?php
			}
			?>
		</table>
	</tr>
	
	<tr>
		<td colspan="3" align="right">
        	<input  type="button" name="btnsalir" id="btnsalir" onclick="salir()" class="boton_form" value="salir" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />&nbsp;&nbsp;&nbsp;
        </td>
	</tr>

    <tr>
		<td colspan="3" align="right" height="10">
         
         </td>
    </tr>
</table>
</form>
</body>
</html>