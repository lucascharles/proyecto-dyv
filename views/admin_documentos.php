<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MVC - Modelo, Vista, Controlador - Jourmoly</title>

    <script language="javascript">
		function mostrar(obj)
		{
			var url = "index.php?controlador=Documentos&accion=listar&des_int="+obj.value;
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtrut").value = "";
			document.getElementById("txtPrimerApel").value = "";
			document.getElementById("txtSegundoApel").value = "";
			document.getElementById("txtPrimerNomb").value = "";
			document.getElementById("txtSegundoNomb").value = "";
			
			var url = "index.php?controlador=Documentos&accion=listar";
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=Documentos&accion=listar&des_int="+document.getElementById("txtrut").value;
			url += "&desApel1="+document.getElementById("txtPrimerApel").value;
			url += "&desApel2="+document.getElementById("txtSegundoApel").value;
			url += "&desNomb1="+document.getElementById("txtPrimerNomb").value;
			url += "&desNomb2="+document.getElementById("txtSegundoNomb").value;
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function seleccionado(id)
		{
			document.getElementById("id_documento").value = id;
		}
		
		function eliminar()
		{
			
			if(document.getElementById("id_documento").value == "")
			{
					return false;
			}

			
			var id = document.getElementById("id_documento").value;

			var url = "index.php?controlador=Documentos&accion=eliminar&id_documento="+id;
			
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		function nuevo()
		{
			$("#pagina").load('index.php?controlador=Documentos&accion=alta');
		}
		
		function editar()
		{
			
			if(document.getElementById("id_documento").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_documento").value;
			
			$("#pagina").load('index.php?controlador=Documentos&accion=editar&id_documento='+id);
		}

		function enviarcarta()
		{
			
			$("#pagina").load('index.php?controlador=Documentos&accion=enviarcarta');
		}
		
	</script>
</head>
<body>
<form name="frmadmdocumentos">
<input  type="hidden" name="id_documento" id="id_documento" value=""/>
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
		<td width="20" align="left">Rut:</td>
        <td align="left">&nbsp; <input type="text" name="txtrut" id="txtrut"  size="40" onkeyup='mostrar(this)' /></td>
        
        <td width="40" align="left">Primer Apellido:</td>
        <td align="left">&nbsp;<input type="text" name="txtPrimerApel" id="txtPrimerApel"  size="40" onkeyup='mostrar(this)' /></td>
     
        <td width="40" align="left">Segundo Apellido:</td>
        <td align="left">&nbsp;&nbsp; <input type="text" name="txtSegundoApel" id="txtSegundoApel"  size="40" onkeyup='mostrar(this)' /></td>
     </tr>
     <tr>   
        <td width="70" align="left">Primer Nombre:</td>
        <td align="left">&nbsp;&nbsp; <input type="text" name="txtPrimerNomb" id="txtPrimerNomb"  size="40" onkeyup='mostrar(this)' /></td>
      
        <td width="70" align="left">Segundo Nombre:</td>
        <td align="left">&nbsp;&nbsp; <input type="text" name="txtSegundoNomb" id="txtSegundoNomb"  size="40" onkeyup='mostrar(this)' /></td>
	</tr>
	<tr>
		<td></td>
        <td></td>
		<td></td>
        <td></td>
        
        
        <td> <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="botonform" /></td>
        <td> <input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" class="botonform" onclick="limpiar()"/></td>
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
        	<iframe id="frmlistdocumentos" src="index.php?controlador=Documentos&accion=listar" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td>
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()"  class="botonformabm" value="Eliminar" style=""/><br />
	        <input  type="button" name="btnnuevo" id="btnnuevo" onclick="nuevo()"  class="botonformabm" value="Nuevo" style=""/><br />
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="editar()"  class="botonformabm" value="Modificar" style=""/><br />
            <input  type="button" name="btnenvcarta" id="btnenvcarta" onclick="enviarcarta()"  class="botonformabm" value="Cartas" style=""/><br />
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