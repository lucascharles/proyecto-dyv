<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

    <script language="javascript">
		function mostrar()
		{
			var url = "index.php?controlador=Documentos&accion=listar&des_int="+document.getElementById("txtrut").value;
			url += "&desApel1="+document.getElementById("txtPrimerApel").value;
			//url += "&desApel2="+document.getElementById("txtSegundoApel").value;
			//url += "&desNomb1="+document.getElementById("txtPrimerNomb").value;
			//url += "&desNomb2="+document.getElementById("txtSegundoNomb").value;
			url += "&id_partida=0";
			url += "&rutmandante="+document.getElementById("txtrutmandante").value;
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtrut").value = "";
			document.getElementById("txtPrimerApel").value = "";
			//document.getElementById("txtSegundoApel").value = "";
			//document.getElementById("txtPrimerNomb").value = "";
			//document.getElementById("txtSegundoNomb").value = "";
			document.getElementById("txtrutmandante").value = "";
			var url = "index.php?controlador=Documentos&accion=listar&id_partida=0";
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function buscar()
		{
			var url = "index.php?controlador=Documentos&accion=listar&des_int="+document.getElementById("txtrut").value;
			url += "&desApel1="+document.getElementById("txtPrimerApel").value;
			url += "&desApel2="+document.getElementById("txtSegundoApel").value;
			url += "&desNomb1="+document.getElementById("txtPrimerNomb").value;
			url += "&desNomb2="+document.getElementById("txtSegundoNomb").value;
			url += "&id_partida=0";
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
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;B&uacute;squeda Documentos</th>
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
		<td width="" align="left" class="etiqueta_form">R.U.T. Deudor:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut" id="txtrut"  size="20" onkeyup='mostrar()' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
        <td align="left"></td>
        <td width="" align="left" class="etiqueta_form">R.U.T. Mandante:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrutmandante" id="txtrutmandante"  size="20" onkeyup='mostrar()' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
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
            		<td align="left" class="etiqueta_form">Primer Apellido Deudor</td>
	                <td align="left" class="etiqueta_form"><!--Segundo Apellido--></td>
    	            <td align="left" class="etiqueta_form"><!--Primer Nombre--></td>
        	        <td align="left" class="etiqueta_form"><!--Segundo Nombre--></td>
			     </tr>
                 <tr>
                    <td><input type="text" name="txtPrimerApel" id="txtPrimerApel"  size="20" onkeyup='mostrar()' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                    <td align="left"><!--<input type="text" name="txtSegundoApel" id="txtSegundoApel"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>--></td>
                    <td align="left"><!--<input type="text" name="txtPrimerNomb" id="txtPrimerNomb"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>--></td>
                    <td align="left"><!--<input type="text" name="txtSegundoNomb" id="txtSegundoNomb"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>--></td>
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
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" onclick="limpiar()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
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
        	<iframe id="frmlistdocumentos" src="index.php?controlador=Documentos&accion=listar&id_partida=0" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td width="10%">
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()" value="Eliminar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
	        <input  type="button" name="btnnuevo" id="btnnuevo" onclick="nuevo()"  value="Nuevo" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="editar()"  value="Modificar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            <input  type="button" name="btnenvcarta" id="btnenvcarta" onclick="enviarcarta()"  value="Cartas" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            </div>
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;&nbsp;
         </td>
    </tr>
     <tr>
		<td colspan="3" height="10">
        
         
         </td>
    </tr>
</table>
</form>
</body>
</html>