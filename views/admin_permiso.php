<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" href="css/general.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script language="javascript">
		
		function salirPermiso()
		{
			$("#pagina").load('views/default.php');
		}
		
		function nuevoPermiso()
		{
			$("#pagina").load('index.php?controlador=Permiso&accion=alta_permiso');
		}
		
		
		function seleccionadoPermiso(id)
		{
			document.getElementById("id_permiso").value = id;
		}
		
		function eliminarPermiso()
		{
			if(document.getElementById("id_permiso").value == "")
			{
				return false;
			}
			
			var id = document.getElementById("id_permiso").value;
			var url = "index.php?controlador=Permiso&accion=eliminar&idpermiso="+id;
			document.getElementById("frmlistpermiso").src = url;
		}
		
		function editarPermiso()
		{
			if(document.getElementById("id_permiso").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_permiso").value;
			$("#pagina").load('index.php?controlador=Permiso&accion=editar&idpermiso='+id);
		}
		
		function detallePermiso()
		{
			if(document.getElementById("id_permiso").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_permiso").value;
			$("#pagina").load('index.php?controlador=Permiso&accion=detalle&idpermiso='+id);
		}
		
		/*
		function mostrar(obj)
		{
			var url = "index.php?controlador=Deudores&accion=listar";
			url += "&rut="+$("#txtrut").val()+$("#txtrut_d").val();
			url += "&p_ape="+$("#txtpapellido").val();
			url += "&s_ape="+$("#txtsapellido").val();
			url += "&p_nom="+$("#txtpnombre").val();
			url += "&s_nom="+$("#txtsnombre").val();
			url += "&id_partida=0";
			document.getElementById("frmlistdeudor").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			var url = "index.php?controlador=TipoDocumento&accion=listar&id_partida=0";
			document.getElementById("frmlistdeudor").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=Deudores&accion=listar";
			url += "&rut="+$("#txtrut").val()+$("#txtrut_d").val();
			url += "&p_ape="+$("#txtpapellido").val();
			url += "&s_ape="+$("#txtsapellido").val();
			url += "&p_nom="+$("#txtpnombre").val();
			url += "&s_nom="+$("#txtsnombre").val();
			url += "&id_partida=0";
			document.getElementById("frmlistdeudor").src = url;
		}
		
		seleccionadoPermiso
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_deudor").value = id;
		}
		
		eliminarPermiso
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
		
		
		function nuevo()
		{
			$("#pagina").load('index.php?controlador=Deudores&accion=alta');
		}
		
		
		*/
	</script>
</head>
<body>
<form name="frmadmpermiso">
<input  type="hidden" name="id_permiso" id="id_permiso" value=""/>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Permisos</th>
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

 <div id="datos">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
        	<iframe id="frmlistpermiso" src="index.php?controlador=Permiso&accion=listar_permisos" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"  style="background-color:#FFFFFF;"></iframe>
        </td>
        <td width="10%">
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminarPermiso()" value="Eliminar"  class="boton_form" onMouseOver="overClassBoton(this)" onMouseOut='outClassBoton(this)'/><br />
	        <input  type="button" name="btnnuevo" id="btnnuevo" onclick="nuevoPermiso()" value="Nuevo" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="editarPermiso()"  value="Modificar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
            <input  type="button" name="btndetalle" id="btndetalle" onclick="detallePermiso()"  value="Detalle" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
            </div>
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right" height="10">
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salirPermiso()"  value="salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;&nbsp;
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