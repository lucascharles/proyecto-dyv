<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script language="javascript">
		function limpiar()
		{			
			document.getElementById("txtdestipdoc").value = "";
			document.getElementById("selDeudor").value = "";
			document.getElementById("selMandante").value = "";
			document.getElementById("txtfechaRecibido").value = "";
			document.getElementById("txtnrodoc").value = "";
			document.getElementById("selTipoDoc").value = "";
			document.getElementById("txtmonto").value = "";
			document.getElementById("selBancos").value = "";
			document.getElementById("txtctacte").value = "";
			document.getElementById("txtfechaprotesto").value = "";
			document.getElementById("selCausalProtesta").value = "";
		}
		
		function salir()
		{
			
			$("#pagina").load('views/admin_documentos.php');
		}


		function seleccionado(id)
		{
			document.getElementById("id_documento").value = id;
		}
		
		function eliminar()
		{
			alert("eliminar");
					
			if(document.getElementById("id_documento").value == "")
			{
				return false;
			}
			
			var id = document.getElementById("id_documento").value;
			var url = "index.php?controlador=Documentos&accion=eliminar&iddocumentos="+id;
			
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function grabar()
		{		
			
			if($.trim($("#selDeudor").val()) != "")
			{
				var id = document.getElementById("selDeudor").value;
				
				var datos = "controlador=Documentos";
				
				datos += "&accion=grabar";
				datos += "&deudor="+$("#selDeudor").val();
				datos += "&mandante="+$("#selMandante").val();
				datos += "&txtfechaRecibido="+$("#txtfechaRecibido").val();
				datos += "&txtnrodoc="+$("#txtnrodoc").val();
				datos += "&selTipoDoc="+$("#selTipoDoc").val();
				datos += "&txtmonto="+$("#txtmonto").val();
				datos += "&selBancos="+$("#selBancos").val();
				datos += "&txtctacte="+$("#txtctacte").val();
				datos += "&txtfechaprotesto="+$("#txtfechaprotesto").val();
				datos += "&selCausalProtesta="+$("#selCausalProtesta").val();
				datos += "&selEstadoDoc="+$("#selEstadoDoc").val();
				
				
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{						

						document.getElementById("frmlistdocumentos").src="index.php?controlador=Documentos&accion=listarNuevos&iddeudor="+id;
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
			}
		}
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}


	</script>
</head>
<body>
<form name="frmadmdocumentos">
<input  type="hidden" name="id_documento" id="id_documento" value=""/>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th align="left">Origen del Documento</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" size="20">
    <tr>
		<td width="70" align="left">Deudor:</td>
        <td> 
        	<select name="selDeudor" valida="requerido" tipovalida="texto" id="selDeudor">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_deudores->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_deudores->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_deudor").">".utf8_encode($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor"))."</option>");           
			        }
    			?>
			</select>
        
        </td>
		
		<td width="70" align="left">Mandatario:</td>
        <td> 
        	<select name="selMandante" valida="requerido" tipovalida="texto" id="selMandante">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_mandantes->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_mandantes->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_mandante").">".utf8_encode($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante"))."</option>");           
			        }
    			?>
			</select>
        
        </td>       
        
    </tr>
    
    <tr>
		<td width="20" align="left">Recibido:</td>
        <td align="left"><input type="text" name="txtfechaRecibido" id="txtfechaRecibido" value="<?php echo date("d/m/Y"); ?>" size="20" onkeyup='mostrar(this)' /></td>
        
        <td width="70" align="left">Estado:</td>
        <td> 
        	<select name="selEstadoDoc" valida="requerido" tipovalida="texto" id="selEstadoDoc">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_estadoDoc->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_estadoDoc->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_estado_doc").">".utf8_encode($datoTmp->get_data("estado"))."</option>");           
			        }
    			?>
			</select>
        
        </td>  
                
    </tr>
        
    
    <tr>
        <td colspan="3">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
 </table>
 </div>
 
 
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th align="left">Detalle del Documento</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  
 <tr>
		<td width="20" align="left">Nro Doc.:</td>
        <td align="left"><input type="text" name="txtnrodoc" id="txtnrodoc"  size="20" onkeyup='mostrar(this)' /></td>
        
        <td width="70" align="left">Tipo Doc.:</td>
        <td> 
        	<select name="selTipoDoc" valida="requerido" tipovalida="texto" id="selTipoDoc">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_tipoDoc->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_tipoDoc->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_tipo_documento").">".utf8_encode($datoTmp->get_data("tipo_documento"))."</option>");           
			        }
    			?>
			</select>
        
        </td>  
        <td width="20" align="left">Monto:</td>
        <td align="left"><input type="text" name="txtmonto" id="txtmonto" value="0" size="15" onkeyup='mostrar(this)' /></td>
        
        <td width="70" align="left">Banco:</td>
        <td> 
        	<select name="selBancos" valida="requerido" tipovalida="texto" id="selBancos">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_bancos->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_bancos->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_banco").">".utf8_encode($datoTmp->get_data("codigo")."-".$datoTmp->get_data("banco"))."</option>");           
			        }
    			?>
			</select>
        
        </td>
        
        <td width="20" align="left">Cta. Cte.:</td>
        <td align="left"><input type="text" name="txtctacte" id="txtctacte"  size="15" onkeyup='mostrar(this)' /></td>        
    </tr>
    
    <tr>
    	<td width="20" align="left">Fecha Protesto:</td>
        <td align="left"><input type="text" name="txtfechaprotesto" id="txtfechaprotesto"  size="15" onkeyup='mostrar(this)' /></td>
		<td width="70" align="left">Causal Protesto:</td>
        <td> 
        	<select name="selCausalProtesta" valida="requerido" tipovalida="texto" id="selCausalProtesta">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$coleccion_causalProtesta->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_causalProtesta->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_causal").">".utf8_encode($datoTmp->get_data("causal"))."</option>");           
			        }
    			?>
			</select>
        
        </td>
    
    	<td colspan="3" align="right">        	
         	<input  type="button" name="btnAgregar" id="btnAgregar" onclick="grabar()" value="Agregar" style="" />            
         </td>
    
    </tr>
    
 </table>
 
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2">
        	<iframe id="frmlistdocumentos" src="index.php?controlador=Documentos&accion=listarNuevos" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
        <td>
        	<div style="position:relative; margin-left:10px;">
        	<input  type="button" name="btneliminar" id="btneliminar" onclick="eliminar()"  class="botonformabm" value="Eliminar" style=""/><br />
            </div>
         </td>
    </tr>
</table>
 
 
 
 </div> 
 
 
 
 
 <div style="position:relative; margin-top:10px;">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiar()"value="Limpiar" style="" />
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"value="Salir" style="" />
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>