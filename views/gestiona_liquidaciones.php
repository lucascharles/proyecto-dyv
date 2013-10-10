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
			if($.trim($("#control_volver").val()) != "")
			{
				$("#pagina").load('index.php?controlador='+$("#control_volver").val()+'&accion='+$("#accion_volver").val()+'&'+$("#param_volver").val()+'='+$("#val_volver").val()+'&estadoGes='+$.trim($("#idestadoges").val()));
			}
			else
			{
				$("#pagina").load('views/default.php');
			}
		}
		
		function liquidacion()
		{
			if(document.getElementById("id_liquidacion").value == "")
			{
				return false;
			}
			var id = document.getElementById("id_liquidacion").value;
				
			if($.trim($("#control_volver").val()) != "")
			{
				$("#pagina").load('index.php?controlador=Deudores&accion=edita_liquidacion&id='+id+'&tipope=M'+"&control_volver=Gestiones&accion_volver=gestionar&param_volver=idgestion&val_volver="+$("#val_volver").val()+'&idestadoges='+document.getElementById("idestadoges").value);
			}
			else
			{			
				$("#pagina").load('index.php?controlador=Deudores&accion=modifica_liquidacion&id='+id+'&tipope=M');
			}
		}

		function nuevaliquidacion()
		{
			var iddeudor = document.getElementById("id_deudor").value;

			if($.trim($("#control_volver").val()) != "")
			{
//				alert("id_estadoges"+document.getElementById("idestadoges").value);
				$("#pagina").load('index.php?controlador=Deudores&accion=nueva_liquidacion&id='+iddeudor+"&control_volver=Gestiones&accion_volver=gestionar&param_volver=idgestion&val_volver="+$("#val_volver").val()+'&idestadoges='+document.getElementById("idestadoges").value);
			}
			else
			{
				$("#pagina").load('index.php?controlador=Deudores&accion=nueva_liquidacion&id='+iddeudor);
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
		
		function seleccionado(id)
		{
			document.getElementById("id_liquidacion").value = id;
		}
		
	</script>
</head>
<body>
<form name="frmadmliquidaciones">
<input  type="hidden" name="id_liquidacion" id="id_liquidacion" value=""/>
<input type="hidden" name="id_deudor" id="id_deudor" value="<?php echo($deudor->get_data("id_deudor")) ?>"/>
<input type="hidden" name="control_volver" id="control_volver" value="<? echo($control_volver) ?>" />
<input type="hidden" name="accion_volver" id="accion_volver" value="<? echo($accion_volver) ?>" />
<input type="hidden" name="param_volver" id="param_volver" value="<? echo($param_volver) ?>" />
<input type="hidden" name="val_volver" id="val_volver" value="<? echo($val_volver) ?>" />
<input type="hidden" name="idestadoges" id="idestadoges" value="<? echo($idestadoges) ?>" />
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
        R.U.T. Deudor:&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut_deudor" id="txtrut_deudor" value="<?php echo($deudor->get_data("rut_deudor")."-".$deudor->get_data("dv_deudor")) ?>" class="input_form" onblur="" />&nbsp;
        </td>
        <td width="" align="left" class="etiqueta_form">
        Nombre:&nbsp; <input type="text" name="txtnombre_deudor" id="txtnombre_deudor" value="<?php echo($deudor->get_data("primer_apellido")." ".$deudor->get_data("segundo_apellido").$deudor->get_data("primer_nombre")." ".$deudor->get_data("segundo_nombre")) ?>" class="input_form" onblur="" />&nbsp;
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
        	<iframe id="frmlistliquidaciones" src="index.php?controlador=Deudores&accion=listar_liquidaciones&rutdeudor=<?php echo($deudor->get_data("rut_deudor"))?>" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
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