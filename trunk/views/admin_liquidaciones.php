<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script src="js/funciones.js" type="text/javascript"></script>
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
		/*
		function seleccionado(id)
		{
			document.getElementById("id_ficha").value = id;
		}
		*/
		
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		
		function seleccionado(id)
		{
			document.getElementById("id_liquidacion").value = id;
		}
		
		function liquidacion()
		{
			
			if(document.getElementById("id_liquidacion").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_liquidacion").value;
			
			$("#pagina").load('index.php?controlador=Deudores&accion=edita_liquidacion&id='+id+'&tipope=M');
		}

		function nuevaliquidacion()
		{
			if($.trim($("#id_deudor").val()) != "")
			{
				var iddeudor = document.getElementById("id_deudor").value;
				$("#pagina").load('index.php?controlador=Deudores&accion=nueva_liquidacion'+'&id='+iddeudor);
			}
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
<?
$id_deudor = "";
$rutdeudor = "";
$dvdeudor = "";
if(!is_null($deudor))
{
	$id_deudor = $deudor->get_data("id_deudor");
	$rutdeudor = $deudor->get_data("rut_deudor");
	$dvdeudor = $deudor->get_data("dv_deudor");	
}
			
?>
<body>
<div id="selecDeudor" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#eeeeee" cellpadding="5" cellspacing="5"> 
    	<tr>
        	<td height="" align="right">
            	<div onclick="cerrarVentDeudor()" style="cursor:pointer; font-weight:bold; color:#000099;"> cerrar </div>
            </td>
        </tr>
        <tr>
        <th align="left">Seleccionar Deudor</th>
        </tr>
        <tr>
        <td height="10"> </td>
        </tr>
        <tr>
        	<td height="">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr> 
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_d" id="txtrut_d"  size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_d','txtrut_dv');" />&nbsp;<input type="text" name="txtrut_dv" id="txtrut_dv"  size="2" onkeyup='mostrarDeudor(this)'  class="input_form_min" disabled="disabled"/></td>
                     </tr>
                     <tr>
                        
                        <td width="" align="left" height="15"></td>
                      
                    </tr>
                	<tr>
                        
                        <td width="" align="left" class="etiqueta_form">Primer Apellido:</td>
                        <td width="" align="left" class="etiqueta_form">Segundo Apellido:</td>
                        <td width="" align="left" class="etiqueta_form">Primer Nombre:</td>
                        <td width="70" align="left" class="etiqueta_form">Segundo Nombre:</td>
                    </tr>
                    
                    <tr>                       
                        <td align="left"> <input type="text" name="txtpapellido" id="txtpapellido" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsapellido" id="txtsapellido" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>  
                        <td align="left"><input type="text" name="txtpnombre" id="txtpnombre" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsnombre" id="txtsnombre" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
        <tr>
        <th align="left">Deudores disponibles</th>
        </tr>
    	<tr>
        	<td height="">
            	
	             <div id="datos" style="">
            	<iframe name="frmlistdeudor" id="frmlistdeudor" src="index.php?controlador=Deudores&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>
                </div>
            </td>
       </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
    </table>
    </td>
</tr>
</table>
</div>
<form name="frmadmliquidaciones">
<input  type="hidden" name="id_liquidacion" id="id_liquidacion" value=""/>
<input type="hidden" name="id_deudor" id="id_deudor" value="<?=$id_deudor?>"/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;B&uacute;squeda de Liquidaciones</th>
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
        <!--
        R.U.T. Deudor:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut" id="txtrut"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        -->
        R.U.T. Deudor:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" value="<?=$rutdeudor?>"  onblur="validaDeudor(); generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D');" />&nbsp;
	            		<input type="text" name="txtdv_deudor" id="txtdv_deudor" class="input_form_min" value="<?=$dvdeudor?>" onblur="" disabled="disabled" />&nbsp;
                        <img src="images/buscar.png" title="Buscar Deudor" style="cursor:pointer" onclick="ventanaBusqueda('D')"/>
        </td>
        <td align="left"></td>
        <td> 
        </td>
    </tr>
    
	<tr>
       <td colspan="3" align="right"> 
       		<!--
       		<input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />&nbsp;
            -->
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" onclick="limpiar()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
       </td>
    </tr>
   
 </table>
 </div>
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
        	<iframe id="frmlistliquidaciones" src="" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
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
<?
if(!is_null($deudor))
{
	echo("<script language='javascript'>");
	echo("mostrar(document.getElementById('txtrut_deudor'));");
	echo("</script>");
}
?>

