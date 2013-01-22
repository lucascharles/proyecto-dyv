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
		}
		
		function salir()
		{
			$("#pagina").load('views/admin_documentos.php');
		}
		
		function grabar()
		{

				var datos = "controlador=Documentos";
				datos += "&accion=grabaEditar";
				datos += "&iddocumento="+$("#id_documento").val();
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


//				alert(document.getElementById("selEstadoDoc").options[0].text);
				
				if(document.getElementById("estadoNuevo").value == "Demanda")
					{

					if (confirm("Desea generar o modificar la Ficha del Deudor?")) { 
						alert("Generar Ficha");
						
						$.ajax({
							url: "index.php",
							type: "GET",
							data: datos,
							cache: false,
							success: function(res)
							{
								$("#pagina").load('index.php?controlador=Documentos&accion=fichas');
							},
							error: function()
							{
								$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
							}
						});

							 
					}
				
					else{
						
						$.ajax({
							url: "index.php",
							type: "GET",
							data: datos,
							cache: false,
							success: function(res)
							{
								$("#pagina").load('index.php?controlador=Documentos&accion=admin');
							},
							error: function()
							{
								$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
							}
						});
					}
				}
				else
				{
					$.ajax({
						url: "index.php",
						type: "GET",
						data: datos,
						cache: false,
						success: function(res)
						{
							$("#pagina").load('index.php?controlador=Documentos&accion=admin');
						},
						error: function()
						{
							$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						}
					});
					
				}
				

		}

		function cambiarEstado(estado)
		{
			document.getElementById("estadoNuevo").value = estado;

//			alert(document.getElementById("estadoNuevo").value ); //.options[0].text);
		}		
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
	</script>
</head>
<body>
<form name="frmadmdocumento">
<input  type="hidden" name="id_documento" id="id_documento" value="<? echo($objDocumento->get_data("id_documento")) ?>"/>

<input  type="hidden" name="estadoNuevo" id="estadoNuevo" value=""/>


	<?php
		$datoDoc = &$datosDocumento->items[0];	
	?>

<div id="datos" style="">
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
     			<option value="<? echo($datoDoc->get_data("id_deudor"))?>"> <? echo($datoDoc->get_data("rut_deudor")."-".$datoDoc->get_data("dv_deudor")) ?></option>
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
     			<option value="<? echo($datoDoc->get_data("id_mandante"))?>"> <? echo($datoDoc->get_data("rut_mandante")."-".$datoDoc->get_data("dv_mandante")) ?></option>
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
        	<select name="selEstadoDoc" valida="requerido" tipovalida="texto" id="selEstadoDoc" onchange="cambiarEstado(document.getElementById('selEstadoDoc').options[document.getElementById('selEstadoDoc').selectedIndex].text);" >
     			<option value="<? echo($datoDoc->get_data("id_estado"))?>"> <? echo($datoDoc->get_data("estado")) ?></option>
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
        <td align="left"><input type="text" name="txtnrodoc" id="txtnrodoc" value="<? echo($datoDoc->get_data("numero_documento"))?>" size="20" onkeyup='mostrar(this)' /></td>
        
        <td width="70" align="left">Tipo Doc.:</td>
        <td> 
        	<select name="selTipoDoc" valida="requerido" tipovalida="texto" id="selTipoDoc">
     			<option value="<? echo($datoDoc->get_data("id_tipo_doc"))?>"> <? echo($datoDoc->get_data("tipo_doc")) ?></option>
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
        <td align="left"><input type="text" name="txtmonto" id="txtmonto" value="<? echo($datoDoc->get_data("monto"))?>" size="15" onkeyup='mostrar(this)' /></td>
        
        <td width="70" align="left">Banco:</td>
        <td> 
        	<select name="selBancos" valida="requerido" tipovalida="texto" id="selBancos">
     			<option value="<? echo($datoDoc->get_data("id_banco"))?>"> <? echo($datoDoc->get_data("banco")) ?></option>
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
        <td align="left"><input type="text" name="txtctacte" id="txtctacte" value="<? echo($datoDoc->get_data("cta_cte"))?>"  size="15" onkeyup='mostrar(this)' /></td>        
    </tr>
    
    <tr>
    	<td width="20" align="left">Fecha Protesto:</td>
        <td align="left"><input type="text" name="txtfechaprotesto" id="txtfechaprotesto" value="<? echo($datoDoc->get_data("fecha_siniestro"))?>" size="15" onkeyup='mostrar(this)' /></td>
		<td width="70" align="left">Causal Protesto:</td>
        <td> 
        	<select name="selCausalProtesta" valida="requerido" tipovalida="texto" id="selCausalProtesta">
     			<option value="<? echo($datoDoc->get_data("id_causa_protesto"))?>"> <? echo($datoDoc->get_data("causa_protesto")) ?></option>
        		<?
			        for($j=0; $j<$coleccion_causalProtesta->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_causalProtesta->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_causal").">".utf8_encode($datoTmp->get_data("causal"))."</option>");           
			        }
    			?>
			</select>
        
        </td>
    
    </tr>
    
 </table></div>
<div style="position:relative; margin-top:10px;">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()"  value="Grabar" style=""/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiar()"value="Limpiar" style="" />
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"value="Cancelar" style="" />
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>