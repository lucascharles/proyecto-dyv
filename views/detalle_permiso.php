<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script>
    <script language="javascript">
	$(document).ready(function(){
			
  			$('form').validator();
			document.getElementById("txtnombre").focus();
			
		});
				
		function salirAltaPermiso()
		{
			$("#pagina").load('index.php?controlador=Permiso&accion=admin_permiso');
		}
		
		function mostrarOpcionesmenu()
		{
			var url = "index.php?controlador=Permiso&accion=listar_opcionesmodulo&id_modulo="+$("#selModulo").val();
			document.getElementById("frmopcionesmenu").src = url;
		}
		
		
		
		
		
		
		

	</script>
</head>
<body  >

<form name="frmpermisos">
<input type="hidden" name="id_permiso" id="id_permiso" value="<? echo($datPermiso->get_data("id")) ?>" />
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Detalle Permisos</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="60%">
            <table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">    	
                <tr>
                    <td width="70" align="left" class="etiqueta_form">Permiso:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" name="txtnombre" id="txtnombre" valida="requerido" tipovalida="texto" class="input_form" value="<? echo($datPermiso->get_data("nombre")) ?>" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
                    </td>
                </tr>
            </table>
       	</td>
        <td width="40%">
            
       	</td>
    <tr>
        <td colspan="2">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
 </table>
 </div>
  
 
  <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 	
    <tr>
        <td colspan="3" align="left" height="15">
         </td>
    </tr>
    <tr>
        <td colspan="3" align="left">
        Opciones del permiso
         </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
              	<iframe id="frmopcionesmenutmp" src="index.php?controlador=Permiso&accion=listar_opcionesmodulotmp&detalle=S" frameborder="0" align="middle" width="100%" height="150" scrolling="auto"></iframe>
         </td>
    </tr>
</table> 
  </div>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
         	<input  type="button" name="btnsalir" id="btnsalir" onclick="salirAltaPermiso()"value="Salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
</table>

</form>
</body>
</html>