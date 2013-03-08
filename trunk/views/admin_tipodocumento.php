<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
	<script src="js/funcionesgral.js" type="text/javascript"></script>
    <script language="javascript">
	
		function mostrar(obj)
		{
			var url = "index.php?controlador=TipoDocumento&accion=listar&des_int="+obj.value;
			document.getElementById("frmlisttipdoc").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			var url = "index.php?controlador=TipoDocumento&accion=listar";
			document.getElementById("frmlisttipdoc").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=TipoDocumento&accion=listar&des_int="+document.getElementById("txtdestipdoc").value;
			document.getElementById("frmlisttipdoc").src = url;
		}
		
		function seleccionado(id)
		{
			document.getElementById("id_tip_doc").value = id;
		}
		
		function eliminar()
		{
			if(document.getElementById("id_tip_doc").value == "")
			{
				return false;
			}
			
			var id = document.getElementById("id_tip_doc").value;
			var url = "index.php?controlador=TipoDocumento&accion=eliminar&idtipdoc="+id+"&des_int="+document.getElementById("txtdestipdoc").value;
			document.getElementById("frmlisttipdoc").src = url;
		}
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		function nuevo()
		{
			$("#pagina").load('index.php?controlador=TipoDocumento&accion=alta');
		}
		
		function editar()
		{
			if(document.getElementById("id_tip_doc").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_tip_doc").value;
			$("#pagina").load('index.php?controlador=TipoDocumento&accion=editar&idtipdoc='+id);
		}
		
		
	</script>
</head>
<body>
<form name="frmadmtipdoc" action=""  onKeyPress="return disableEnterKey(event)">
<input  type="hidden" name="id_tip_doc" id="id_tip_doc" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th align="left">Busqueda</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="buscador" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	 <tr>
		<td width="70" align="left">Descripci&oacute;n:</td>
        <td align="left">&nbsp;&nbsp;&nbsp; <input type="text" name="txtdestipdoc" id="txtdestipdoc"  size="40" onkeyup='mostrar(this)' /></td>
        <td> <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="botonform" />&nbsp;
         <input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" class="botonform" onclick="limpiar()"/></td>
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
		<td colspan="2">
        	<iframe id="frmlisttipdoc" src="index.php?controlador=TipoDocumento&accion=listar" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td>
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()"  class="botonformabm" value="Eliminar" style=""/><br />
	        <input  type="button" name="btnnuevo" id="btnnuevo" onclick="nuevo()"  class="botonformabm" value="Nuevo" style=""/><br />
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="editar()"  class="botonformabm" value="Modificar" style=""/>
            </div>
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir" style="width:50px;"/>
         </td>
    </tr>
</table>
</form>
</body>
</html>