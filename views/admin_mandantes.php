<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

    <script language="javascript">
		function mostrar(obj)
		{
			var url = "index.php?controlador=Mandantes&accion=listar&des_int="+document.getElementById("txtrut_m").value;
			url += "&desApel1="+document.getElementById("txtPrimerApel").value;
			url += "&desNomb1="+document.getElementById("txtPrimerNomb").value;
			url += "&id_partida=0";
			document.getElementById("frmlistmandantes").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtrut_m").value = "";
			document.getElementById("txtPrimerApel").value = "";
			document.getElementById("txtPrimerNomb").value = "";
			
			var url = "index.php?controlador=Mandantes&accion=listar&id_partida=0";
			document.getElementById("frmlistmandantes").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=Mandantes&accion=listar&des_int="+document.getElementById("txtrut_m").value;
			url += "&desApel1="+document.getElementById("txtPrimerApel").value;
			url += "&desNomb1="+document.getElementById("txtPrimerNomb").value;
			url += "&id_partida=0";
			document.getElementById("frmlistmandantes").src = url;
		}
		
		function seleccionadoMandante(id)
		{
			document.getElementById("id_mandantes").value = id;
		}
		
		function eliminar()
		{
			
			if(document.getElementById("id_mandantes").value == "")
			{
					return false;
			}

			
			var id = document.getElementById("id_mandantes").value;

			var url = "index.php?controlador=Mandantes&accion=eliminar&idmandantes="+id;
			
			document.getElementById("frmlistmandantes").src = url;
		}
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		function nuevo()
		{
			$("#pagina").load('index.php?controlador=Mandantes&accion=alta');
		}
		
		function editar()
		{
			if(document.getElementById("id_mandantes").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_mandantes").value;
			$("#pagina").load('index.php?controlador=Mandantes&accion=editar&idmandantes='+id);
		}
	</script>
</head>
<body>
<form name="frmadmmandantes">
<input  type="hidden" name="id_mandantes" id="id_mandantes" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;B&uacute;squeda Mandantes</th>
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
		<td width="20" align="left"  class="etiqueta_form">Rut:</td>
        <td align="left">&nbsp; <input type="text" name="txtrut_m" id="txtrut_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
        <td></td>
     </tr>
      <tr>
		<td colspan="3" height="15"> </td>
    </tr>
    <tr>
		<td colspan="3"> 
        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
        	<tr>
<!--            	<td align="left" class="etiqueta_form">Apellido</td>-->
<!--                <td align="left" class="etiqueta_form">Nombre</td>-->
<!--                <td align="left" class="etiqueta_form" width="25%"></td>-->
<!--                <td align="left" class="etiqueta_form"  width="25%"s></td>-->
            	<td width="20" align="left"  class="etiqueta_form">Razon Social:</td>
            	<td align="left">&nbsp; <input type="text" name="txtPrimerApel" id="txtPrimerApel"  size="120" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>

            </tr>
<!--		    <tr>-->
<!--            	<td align="left"><input type="text" name="txtPrimerApel" id="txtPrimerApel"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>-->
<!--                <td align="left"><input type="text" name="txtPrimerNomb" id="txtPrimerNomb"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>-->
<!--                -->
<!--                </td>-->
<!--                <td align="left"></td>-->
<!--                <td align="left"></td>-->
<!--            </tr>-->
        </table>
        </td>
        </tr>
         <tr>
		<td colspan="3" height="15"> </td>
    </tr>
	<tr>
        
        
        <td colspan="3" align="right"> 
         <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar"  class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
 <input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar"  onclick="limpiar()"  class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/></td>
    </tr>
    <tr>
		<td></td>
        <td> </td>
        <td>
        	
         </td>
    </tr>
 </table>
 </div>

 <div id="datos">
 
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
        	<iframe id="frmlistmandantes" src="index.php?controlador=Mandantes&accion=listar&id_partida=0" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td>
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()"   class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' value="Eliminar" /><br />
	        <input  type="button" name="btnnuevo" id="btnnuevo" onclick="nuevo()"  value="Nuevo"   class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="editar()"   value="Modificar"  class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
            </div>
         </td>
    </tr>
    <tr>
		<td colspan="3" align="center" height="50" valign="middle">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
</table>
</form>
</body>
</html>