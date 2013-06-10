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
			var url = "index.php?controlador=Deudores&accion=listar_liquidaciones&rutdeudor="+obj.value;
			document.getElementById("frmlistliquidaciones").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtrut").value = "";
			
			var url = "index.php?controlador=Deudores&accion=listar_liquidaciones";
			document.getElementById("frmlistliquidaciones").src = url;
		}
		
		function buscar()
		{
			if(document.getElementById("txtrut").value == "")
			{
				return false;
			}
			var url = "index.php?controlador=Deudores&accion=listar_liquidaciones&rutdeudor="+document.getElementById("txtrut").value;
			document.getElementById("frmlistliquidaciones").src = url;
		}
		
		function seleccionado(id)
		{
			document.getElementById("id_ficha").value = id;
		}
		
		
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		function liquidacion()
		{
			
			if(document.getElementById("id_liquidacion").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_liquidacion").value;
			
			$("#pagina").load('index.php?controlador=Deudores&accion=deudor_liquidacion&id='+id+'&tipope=M');
		}

		function nuevaliquidacion()
		{
			$("#pagina").load('index.php?controlador=Deudores&accion=nueva_liquidacion');
		}
		
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_deudor").value = id;
			buscarDatosDeudor(id);
			cerrarVentDeudor();
			
			
			
		}
		
		function buscarDatosDeudor(id)
		{
			var datos = "controlador=Deudores";
			datos += "&accion=getDatosDeudor";
			datos += "&id_deudor="+id;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{		
						$("#txtrut_deudor").val(res[0]);
						$("#txtdv_deudor").val(res[1]);
						mostrar(document.getElementById("txtrut_deudor"));
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		
		function cerrarVentDeudor()
		{
			$("#selecDeudor").slideUp(1000);
			//document.getElementById("frmtipocom").src = "";
		}
		
		function ventanaBusqueda(op)
		{
			if(op == "M")
			{
				$("#selecMandante").slideDown(1000);	
				document.getElementById("txtrut_m").focus();
			}
			
			if(op == "D")
			{
				$("#selecDeudor").slideDown(1000);	
				document.getElementById("txtrut_d").focus();
			}
			
		}
	</script>
</head>
<body>
<form name="frmadmliquidaciones">
<input  type="hidden" name="id_liquidacion" id="id_liquidacion" value=""/>
<input type="hidden" name="id_deudor" id="id_deudor" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Liquidaciones</th>
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
		<td width="" align="left" class="etiqueta_form">
        R.U.T. Deudor:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" onblur="validaDeudor(); generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D'); simular_liquidacion();" />&nbsp;
	            		<input type="text" name="txtdv_deudor" id="txtdv_deudor" class="input_form_min" onblur="" disabled="disabled" />&nbsp;
        </td>
        <td width="" align="left" class="etiqueta_form">Nombre:&nbsp; 
        	<input type="text" name="txtnombre_deudor" id="txtnombre_deudor" class="input_form" onblur="" />&nbsp;
        </td>
        
        <td align="left"></td>
        <td> 
        </td>
    </tr>
    
	<tr>
       
    </tr>
   
 </table>
 </div>
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
        	<iframe id="frmlistliquidaciones" src="index.php?controlador=Deudores&accion=listar_liquidaciones&rutdeudor=<?php ?>" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td width="10%">
        	<div style="position:relative; margin-left:10px;">
            <input  type="button" name="btnmodificar" id="btnmodificar" onclick="liquidacion()"  value="Ver/Modificar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            </div>
        	<div style="position:relative; margin-left:10px;">
            <input  type="button" name="btnnuevo" id="btnnuevo" onclick="nuevaliquidacion()"  value="Nueva" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
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