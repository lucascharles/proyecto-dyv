<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

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
			$("#pagina").load('index.php?controlador=Gestiones&accion=gestionar&idgestion='+id);
		}
	</script>
</head>
<body>
<form name="frmadmgestiones">
<input  type="hidden" name="id_gestion" id="id_gestion" value=""/>
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
		<td align="right" class="etiqueta_form" width="20">Rut Mandante:</td><td>&nbsp;&nbsp;&nbsp;<input type="text" name="txtrutmandante" id="txtrutmandante"  size="40" onkeyup='mostrar(this)' /> &nbsp;
        </td>
        <td align="right" class="etiqueta_form" width="20">Rut Deudor:</td><td>&nbsp;&nbsp;&nbsp;<input type="text" name="txtrutdeudor" id="txtrutdeudor"  size="40" onkeyup='mostrar(this)' /> &nbsp;
        </td>
        <td> <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="boton_form" />&nbsp;
         	 <input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" class="boton_form" onclick="limpiar()"/>
        </td>
    </tr>
 </table>
 </div>
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2">
        	<iframe id="frmlistgestiones" src="index.php?controlador=Gestiones&accion=listar" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td>
        	<div style="position:relative; margin-left:10px;">
            <input  type="button" name="btngestionar" id="btngestionar" onclick="gestionar()"  class="boton_form" value="Gestionar" style=""/>
            </div>
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()" class="boton_form" value="salir" style="width:50px;"/>
         </td>
    </tr>
</table>
</form>
</body>
</html>