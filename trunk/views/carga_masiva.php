<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link id="theme" rel="stylesheet" type="text/css" href="css/general.css" title="theme" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
    <script src="js/funciones.js" type="text/javascript"></script>

    <script language="javascript">
		$(document).ready(function(){
  			$('form').validator();
		});
		
		function overClass(obj)
		{
			$(obj).removeClass('menu_head');
			$(obj).addClass('seleccionado');
		}
		
		function outClass(obj)
		{
			$(obj).removeClass('seleccionado');
			$(obj).addClass('menu_head');
		}
		
		function salir()
		{
			window.parent.salir();
		}
		
		function cargar()
		{		
			
			if(!validar("N"))
			{
				return false;
			}

			document.frmcargamasiva.submit();
			
		}
		
		
	</script>
</head>
<body id="datos">
<form name="frmcargamasiva" action="<?php echo $accion_form ?>" method="post" enctype="multipart/form-data" >
<input type="hidden" name="controlador" id="controlador" value="<? echo($controler) ?>" />
<input type="hidden" name="accion" id="accion" value="<? echo($action) ?>" />
<table width="100%" align="center" border="0" cellpadding="10" cellspacing="10" >
	 <tr>
		<td width="70" align="left" class="etiqueta_form">Archivo:</td>
        <td align="left">&nbsp;&nbsp;&nbsp; <input type="file" name="txtarchivo" id="txtarchivo"  size="40"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto"/></td>
        <td align="center"> </td>
    </tr>
    <tr>
        <td align="center" colspan="3" height="15">
        
         </td>
    </tr>
    <tr>
        <td align="center" colspan="3">
        	 <input  type="button" name="btncargar" id="btncargar" onclick="cargar()"  value="Cargar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
        <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir"  class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
 </table>


 
</form>
</body>
</html>