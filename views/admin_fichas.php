<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

    <script language="javascript">
		function mostrar(obj)
		{
			var url = "index.php?controlador=Deudores&accion=listar_fichas&rutdeudor="+obj.value;
			document.getElementById("frmlistfichas").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtrut").value = "";
			
			var url = "index.php?controlador=Deudores&accion=listar_fichas";
			document.getElementById("frmlistfichas").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=Deudores&accion=listar_fichas&rutdeudor="+document.getElementById("txtrut").value;
			document.getElementById("frmlistfichas").src = url;
		}
		
		function seleccionado(id)
		{
			document.getElementById("id_ficha").value = id;
		}
		
		function eliminar()
		{
			
			if(document.getElementById("id_ficha").value == "")
			{
					return false;
			}

			
			var id = document.getElementById("id_ficha").value;

			var url = "index.php?controlador=Deudores&accion=eliminar_ficha&idficha="+id;
			
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		function editar()
		{
			
			if(document.getElementById("id_ficha").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_ficha").value;
			
			$("#pagina").load('index.php?controlador=Deudores&accion=deudor_ficha&id='+id+'&tipope=M');
		}

		
	</script>
</head>
<body>
<form name="frmadmfichas">
<input  type="hidden" name="id_ficha" id="id_ficha" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;B&uacute;squeda de Fichas</th>
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
 </table>
<div id="buscador" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="" align="left" class="etiqueta_form">R.U.T. Deudor:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut" id="txtrut"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
        <td align="left"></td>
        <td> 
        </td>
    </tr>
    
	<tr>
       <td colspan="3" align="right"> 
       		<input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" onclick="limpiar()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
       </td>
    </tr>
   
 </table>
 </div>
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
        	<iframe id="frmlistfichas" src="index.php?controlador=Deudores&accion=listar_fichas" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td width="10%">
        	<div style="position:relative; margin-left:10px;">
<!--        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()" value="Eliminar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />-->
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="editar()"  value="Modificar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            </div>
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