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
			document.getElementById("txtid_usuario").focus();
			borrarTemporalAsignar();		
		});
		

		function salirAsignarPermiso()
		{
			$("#pagina").load('views/default.php');
		}
		
		function borrarTemporalAsignar()
		{
			var datos = "controlador=Permiso";
				datos += "&accion=borrarTmpAsignar";
			
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						var url = "index.php?controlador=Permiso&accion=listar_permisostmp";
						document.getElementById("frmpermisostmp").src = url;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function buscarUsuario()
		{
			if($.trim($("#txtid_usuario").val()) == "")
			{
				return false;
			}
			
			var datos = "controlador=Permiso";
				datos += "&accion=datos_usuario";
				datos += "&idusuario="+$("#txtid_usuario").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{
						$("#nombre_usuario").text(res[0]+" "+res[1]);
						var url = "index.php?controlador=Permiso&accion=listar_permisostmp";
						document.getElementById("frmpermisostmp").src = url;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						$("#mensaje").slideDown();
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function seleccionadoPermiso(id)
		{
			if($.trim($("#txtid_usuario").val()) == "")
			{
				return false;
			}
			
			var datos = "controlador=Permiso";
				datos += "&accion=agregarPermisoTmp";
				datos += "&idpermiso="+id;
				datos += "&idusuario="+$("#txtid_usuario").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						var url = "index.php?controlador=Permiso&accion=listar_permisostmp";
						document.getElementById("frmpermisostmp").src = url;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						$("#mensaje").slideDown();
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		
		function quitarPermiso(id)
		{
			if($.trim($("#txtid_usuario").val()) == "")
			{
				return false;
			}
			
			var datos = "controlador=Permiso";
				datos += "&accion=quitarPermisoTmp";
				datos += "&idpermiso="+id;
				datos += "&idusuario="+$("#txtid_usuario").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						var url = "index.php?controlador=Permiso&accion=listar_permisostmp";
						document.getElementById("frmpermisostmp").src = url;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		
		function grabarAsignarPermiso()
		{
			if(!validar("N"))
			{
				return false;
			}
			
			var datos = "controlador=Permiso";
			datos += "&accion=grabar_asignar_permiso";
			datos += "&idusuario="+$("#txtid_usuario").val();

			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#mensaje").text("El permiso/s se asigno con exito.");
						$("#mensaje").slideDown();
						
						setTimeout("limpiarMensaje()",3000);
						setTimeout("$('#pagina').load('views/default.php')",3500);
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						$("#mensaje").slideDown();
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
		}
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
		
		/*
		borrarTemporalAsignar
		function borrarTemporalOpcion()
		{
			var datos = "controlador=Permiso";
				datos += "&accion=borrarTmpOpcion";
			
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						var url = "index.php?controlador=Permiso&accion=listar_opcionesmodulotmp";
						document.getElementById("frmopcionesmenutmp").src = url;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		
		
		
		function mostrarOpcionesmenu()
		{
			var url = "index.php?controlador=Permiso&accion=listar_opcionesmodulo&id_modulo="+$("#selModulo").val();
			document.getElementById("frmopcionesmenu").src = url;
		}
		quitarPermiso
		function quitarOpcion(id)
		{
			var datos = "controlador=Permiso";
				datos += "&accion=quitarOcionTmp";
				datos += "&idopcion="+id;
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						var url = "index.php?controlador=Permiso&accion=listar_opcionesmodulotmp";
						document.getElementById("frmopcionesmenutmp").src = url;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function seleccionadoOpcion(id)
		{
			var datos = "controlador=Permiso";
				datos += "&accion=agregarOcionTmp";
				datos += "&idopcion="+id;
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						var url = "index.php?controlador=Permiso&accion=listar_opcionesmodulotmp";
						document.getElementById("frmopcionesmenutmp").src = url;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		
		
	*/
	</script>
</head>
<body  >

<form name="frmpermisos">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Asignar Permiso</th>
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
                    <td width="70" align="left" class="etiqueta_form">Usuario:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" name="txtid_usuario" id="txtid_usuario" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); buscarUsuario();" />
                    </td>
                    <td><span id="nombre_usuario"></span></td>
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
        <td colspan="3" align="center">
        <iframe id="frmopcionesmenu" src="index.php?controlador=Permiso&accion=listar_permisos&pantalla=asignar" frameborder="0" align="middle" width="100%" height="150" scrolling="auto"></iframe>

         </td>
    </tr>
    <tr>
        <td colspan="3" align="left" height="15">
         </td>
    </tr>
    <tr>
        <td colspan="3" align="left">
        Permisos del usuario
         </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
                	<iframe id="frmpermisostmp" src="index.php?controlador=Permiso&accion=listar_permisostmp" frameborder="0" align="middle" width="100%" height="150" scrolling="auto"></iframe>
         </td>
    </tr>
</table> 
  </div>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabarAsignarPermiso()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnsalir" id="btnsalir" onclick="salirAsignarPermiso()"value="Cancelar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
</table>

</form>
</body>
</html>