<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" href="css/general.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script language="javascript">


		function mostrar(obj)
		{
			var url = "index.php?controlador=Deudores&accion=listar";
			url += "&rut="+$("#txtrut").val()+$("#txtrut_d").val();
			url += "&p_ape="+$("#txtpapellido").val();
			url += "&s_ape="+$("#txtsapellido").val();
			url += "&p_nom="+$("#txtpnombre").val();
			url += "&s_nom="+$("#txtsnombre").val();
			
			document.getElementById("frmlistdeudor").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			var url = "index.php?controlador=TipoDocumento&accion=listar";
			document.getElementById("frmlistdeudor").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=TipoDocumento&accion=listar&des_int="+document.getElementById("txtdestipdoc").value;
			document.getElementById("frmlistdeudor").src = url;
		}
		
		function seleccionado(id)
		{
			document.getElementById("id_deudor").value = id;
		}
		
		function eliminar()
		{
			if(document.getElementById("id_deudor").value == "")
			{
				return false;
			}
			
			var id = document.getElementById("id_deudor").value;
			var url = "index.php?controlador=Deudores&accion=eliminar&iddeudor="+id;
			url += "&rut="+$("#txtrut").val()+$("#txtrut_d").val();
			url += "&p_ape="+$("#txtpapellido").val();
			url += "&s_ape="+$("#txtsapellido").val();
			url += "&p_nom="+$("#txtpnombre").val();
			url += "&s_nom="+$("#txtsnombre").val();
			document.getElementById("frmlistdeudor").src = url;
		}
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		function nuevo()
		{
			$("#pagina").load('index.php?controlador=Deudores&accion=alta');
		}
		
		function editar()
		{
			if(document.getElementById("id_deudor").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_deudor").value;
			$("#pagina").load('index.php?controlador=Deudores&accion=editar&iddeudor='+id);
		}
	</script>
</head>
<body>
<form name="frmadmtipdoc">
<input  type="hidden" name="id_deudor" id="id_deudor" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;B&uacute;squeda Deudores</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="buscador" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	 <tr>
		<td width="" align="left" class="etiqueta_form">R.U.T.:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut" id="txtrut"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;<input type="text" name="txtrut_d" id="txtrut_d"  size="2" onkeyup='mostrar(this)'  class="input_form_min"/></td>
        <td align="left"></td>
        <td> 
        </td>
    </tr>
     <tr>
		<td colspan="3" height="15"> </td>
    </tr>
    <tr>
		<td colspan="3"> 
        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td align="left" class="etiqueta_form">Primer Apellido</td>
                <td align="left" class="etiqueta_form">Segundo Apellido</td>
                <td align="left" class="etiqueta_form">Primer Nombre</td>
                <td align="left" class="etiqueta_form">Segundo Nombre</td>
            </tr>
            <tr>
            	<td><input type="text" name="txtpapellido" id="txtpapellido" value="" size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                <td><input type="text" name="txtsapellido" id="txtsapellido" value="" size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                <td><input type="text" name="txtpnombre" id="txtpnombre" value="" size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                <td><input type="text" name="txtsnombre" id="txtsnombre" value="" size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
            </tr>
        </table>
        </td>
    </tr>
     <tr>
		<td colspan="3" height="15"> </td>
    </tr>
    <tr>
        <td colspan="3" align="right"> 
        <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />&nbsp;
        <input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" class="boton_form" onclick="limpiar()" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
    </tr>
    <tr>
		<td></td>
        <td> </td>
        <td>
        	
         </td>
    </tr>
 </table>
 </div>
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
        	<iframe id="frmlistdeudor" src="index.php?controlador=Deudores&accion=listar" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"  style="background-color:#FFFFFF;"></iframe>
        </td>
        <td width="10%">
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()" value="Eliminar"  class="boton_form" onMouseOver="overClassBoton(this)" onMouseOut='outClassBoton(this)'/><br />
	        <input  type="button" name="btnnuevo" id="btnnuevo" onclick="nuevo()" value="Nuevo" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="editar()"  value="Modificar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
            </div>
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right" height="10">
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
</table>
</form>
</body>
</html>