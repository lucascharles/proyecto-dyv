<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
   <!-- LIBRERIA PAR CONTROL DE FECHA -->
    <link rel="stylesheet" media="all" type="text/css" href="css/smoothness/jquery-ui-1.8.17.custom.css" />
    <style type="text/css"> 
			/* css for timepicker */	
			#ui-datepicker-div, .ui-datepicker{ font-size: 80%; }
			.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
			.ui-timepicker-div dl { text-align: left; }
			.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
			.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
			.ui-timepicker-div td { font-size: 90%; }
			.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
	</style>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
  	<script src="js/funciones.js" type="text/javascript"></script>
    
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
    <script src="js/funcionesgral.js" type="text/javascript"></script>
    <script language="javascript">
		$(document).ready(function(){
			$('form').validator();
			$("#txtfechaRecibido").datepicker({changeYear: true});
			$("#txtfechaprotesto").datepicker({changeYear: true});
			$("#txtfechavenc").datepicker({changeYear: true});
			
		});
		
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
		
		function cerrarVentMand()
		{
			$("#selecMandante").slideUp(1000);
			//document.getElementById("frmtipocom").src = "";
		}
		
		
		function cerrarVentDeudor()
		{
			$("#selecDeudor").slideUp(1000);
			//document.getElementById("frmtipocom").src = "";
		}
		
		function limpiarDocumentos()
		{
			limpiarCampos();
		}
		
		function salir()
		{
			$("#pagina").load('views/admin_documentos.php');
		}
		
		function grabar()
		{

			if(!validar("N"))
			{
				return false;
			}

				var datos = "controlador=Documentos";
				datos += "&accion=grabaEditar";
				datos += "&iddocumento="+$("#id_documento").val();
				datos += "&deudor="+$("#id_deudor").val();
				datos += "&mandante="+$("#id_mandante").val();
				datos += "&txtfechaRecibido="+$("#txtfechaRecibido").val();
				datos += "&txtnrodoc="+$("#txtnrodoc").val();
				datos += "&selTipoDoc="+$("#selTipoDoc").val();
				datos += "&txtmonto="+$("#txtmonto").val();
				datos += "&selBancos="+$("#selBancos").val();
				datos += "&txtctacte="+$("#txtctacte").val();
				datos += "&txtfechaprotesto="+$("#txtfechaprotesto").val();
				datos += "&selCausalProtesta="+$("#selCausalProtesta").val();
				datos += "&selEstadoDoc="+$("#selEstadoDoc").val();
				datos += "&montoProtesto="+$("#txtmontoprotesto").val();
				datos += "&fechaVencimiento="+$("#txtfechavenc").val();
//				alert("datos: "+datos);
				//return false;
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						if($.trim($("#estadoActual").val()) != $.trim($("#estadoNuevo").val()))
						{
							if($.trim($("#estadoNuevo").val()) == "DEMANDA")
							{
								$("#pagina").load('index.php?controlador=Deudores&accion=deudor_ficha&id='+$("#id_deudor").val()+'&id_doc='+$("#id_documento").val()+'&tipope=A');
							}
							else
							{
								$("#pagina").load('index.php?controlador=Documentos&accion=admin&rutDeudor='+$("#txtrut_deudor").val());
//								alert('index.php?controlador=Documentos&accion=admin&rutDeudor='+$("#txtrut_deudor").val());	
							}
						}
						else
						{
							$("#pagina").load('index.php?controlador=Documentos&accion=admin&rutDeudor='+$("#txtrut_deudor").val());
//									alert('index.php?controlador=Documentos&accion=admin&rutDeudor='+$("#txtrut_deudor").val());		
						}
						alert('Los datos fueron ingresados correctamente.');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});

			
		}

		function cambiarEstado()
		{
			document.getElementById("estadoNuevo").value = document.getElementById('selEstadoDoc').options[document.getElementById('selEstadoDoc').selectedIndex].text;
		}		
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
		function validarRut(tipo)
		{
			var datos = "";
			var rut = "";
			var dv = "";
			
			if(tipo == "D")
			{
				if($.trim($("#txtrut_deudor").val()) == "" || $.trim($("#txtdv_deudor").val()) == "")
				{
					return false;
				}
				
				if(!validaentero($.trim($("#txtrut_deudor").val())))
				{
					return false;
				}
				if(!validaentero($.trim($("#txtdv_deudor").val())))
				{
					return false;
				}
				
				datos = "controlador=Deudores";
				rut = $("#txtrut_deudor").val();
				dv = $("#txtdv_deudor").val();
			}
			if(tipo == "M")
			{
				if($.trim($("#txtrut_mandante").val()) == "" || $.trim($("#txtdv_mandante").val()) == "")
				{
					return false;
				}
				if(!validaentero($.trim($("#txtrut_mandante").val())))
				{
					return false;
				}
				if(!validaentero($.trim($("#txtdv_mandante").val())))
				{
					return false;
				}
				datos = "controlador=Mandantes";
				rut = $("#txtrut_mandante").val();
				dv = $("#txtdv_mandante").val();
			}
				
			datos += "&accion=validarrut";
			datos += "&tipoval=EXISTE";
			datos += "&rut="+rut;
			datos += "&dv="+dv;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{		
						if(res == 0)
						{
							var mensaje = "";
							
							if(tipo == "D")
							{
								document.getElementById("txtdv_deudor").focus();
								mensaje = "El rut ingresado para el deudor es incorrecto.";
							}
							if(tipo == "M")
							{
								document.getElementById("txtdv_mandante").focus();
								mensaje = "El rut ingresado para el mandante es incorrecto.";
							}
							$("#mensaje").text(mensaje);
							$("#mensaje").show("slow");
							setTimeout("limpiarMensaje()",3000);
						}
						else 
						{
							if(tipo == "D")
							{
								$("#id_deudor").val(res);
							}
							if(tipo == "M")
							{
								$("#id_mandante").val(res);
							}
						}
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		
		function seleccionadoMandante(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosMandante(id);
			cerrarVentMand();
		}
		
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosDeudor(id);
			cerrarVentDeudor();
		}
		
		function buscarDatosMandante(id)
		{
			var datos = "controlador=Mandantes";
			datos += "&accion=getDatosMandante";
			datos += "&id_mandante="+id;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{		
						$("#txtrut_mandante").val(res[0]);
						$("#txtdv_mandante").val(res[1]);
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
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
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
	</script>
</head>
<body>
<?php
	$datoDoc = &$datosDocumento->items[0];	
?>
<div id="selecMandante" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#eeeeee" cellpadding="5" cellspacing="5"> 
    	<tr>
        	<td height="" align="right">
            	<div onclick="cerrarVentMand()" style="cursor:pointer; font-weight:bold; color:#000099;"> cerrar </div>
            </td>
        </tr>
        <tr>
        <th align="left">Seleccionar Mandantes</th>
        </tr>
        <tr>
        <td height="10"> </td>
        </tr>
        <tr>
        	<td height="">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr> 
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_m" id="txtrut_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
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
                        
                        
                        <td align="left"><input type="text" name="txtPrimerApel" id="txtPrimerApel"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsapellido_m" id="txtsapellido_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>  
                        <td align="left"><input type="text" name="txtPrimerNomb" id="txtPrimerNomb"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
                        <td align="left"><input type="text" name="txtsnombre_m" id="txtsnombre_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
        <tr>
        <th align="left">Mandantes disponibles</th>
        </tr>
    	<tr>
        	<td height="">
            	
	             <div id="datos" style="">
            	<iframe id="frmmandantes" src="index.php?controlador=Mandantes&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>
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
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_d" id="txtrut_d"  size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_d','txtrut_dv')" />&nbsp;<input type="text" name="txtrut_dv" id="txtrut_dv"  size="2" onkeyup='mostrarDeudor(this)'  class="input_form_min" disabled="disabled"/></td>
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
            	<iframe id="frmlistdeudor" src="index.php?controlador=Deudores&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>
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
<form name="frmadmdocumento">
<input  type="hidden" name="id_documento" id="id_documento" value="<? echo($objDocumento->get_data("id_documento")) ?>"/>
<input  type="hidden" name="estadoNuevo" id="estadoNuevo" value=""/>
<input  type="hidden" name="estadoActual" id="estadoActual" value="<? echo($datoDoc->get_data("estado")) ?>"/>
<input grabar="S" type="hidden" name="id_mandante" id="id_mandante" value="<? echo($datoDoc->get_data("id_mandante")) ?>"/>
<input grabar="S" type="hidden" name="id_deudor" id="id_deudor" value="<? echo($datoDoc->get_data("id_deudor")) ?>"/>


<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Editar Documento</th>
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
	<tr>
		<th align="left">Origen del Documento</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" size="20">
    <tr>
		<td width="70" align="left" class="etiqueta_form">Deudor:</td>
        <td> 
       		 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="240">
        	<input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" onblur=" generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D')" value="<? echo($datoDoc->get_data("rut_deudor")) ?>" />&nbsp;
	            		<input type="text" name="txtdv_deudor" id="txtdv_deudor" class="input_form_min" onblur="" disabled="disabled" value="<? echo($datoDoc->get_data("dv_deudor")) ?>" />&nbsp;
                         </td>
                	<td align="left">
			            <img src="images/buscar.png" title="Buscar Deudor" style="cursor:pointer" onclick="ventanaBusqueda('D')"/>
                    </td>
                </tr>
             </table>
            <!--
        	<select name="selDeudor" grabar="S" valida="requerido" tipovalida="texto" id="selDeudor" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value="<? //echo($datoDoc->get_data("id_deudor"))?>"> <? //echo($datoDoc->get_data("rut_deudor")."-".$datoDoc->get_data("dv_deudor")) ?></option>
        		<?
				/*
			        for($j=0; $j<$coleccion_deudores->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_deudores->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_deudor").">".utf8_encode($datoTmp->get_data("rut_deudor")."-".$datoTmp->get_data("dv_deudor"))."</option>");           
			        }
					*/
    			?>
			</select>
        -->
        </td>
		
		<td width="70" align="left" class="etiqueta_form">Mandatario:</td>
        <td> 
        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="240">
        <input type="text" name="txtrut_mandante" id="txtrut_mandante" class="input_form" onblur=" generadvrut('txtrut_mandante','txtdv_mandante'); validarRut('M')" value="<? echo($datoDoc->get_data("rut_mandante")) ?>" />&nbsp;
            			<input type="text" name="txtdv_mandante" id="txtdv_mandante" class="input_form_min" onblur="" disabled="disabled" value="<? echo($datoDoc->get_data("dv_mandante")) ?>" />
                        
                    </td>
                	<td align="left">
			            <img src="images/buscar.png" title="Buscar Mandante" style="cursor:pointer" onclick="ventanaBusqueda('M')" />
                    </td>
                </tr>
             </table>
                        <!--
        	<select name="selMandante" grabar="S" valida="requerido" tipovalida="texto" id="selMandante" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value="<? //echo($datoDoc->get_data("id_mandante"))?>"> <? //echo($datoDoc->get_data("rut_mandante")."-".$datoDoc->get_data("dv_mandante")) ?></option>
        		<?
					/*
			        for($j=0; $j<$coleccion_mandantes->get_count(); $j++)
			        {
			            $datoTmp = &$coleccion_mandantes->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_mandante").">".utf8_encode($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante"))."</option>");           
			        }
					*/
    			?>
			</select>
        -->
        </td>       
        
    </tr>
    
    <tr>
		<td width="20" align="left" class="etiqueta_form">Recibido:</td>
        <td align="left"><input type="text" grabar="S" name="txtfechaRecibido" id="txtfechaRecibido" value="<?php echo date("d/m/Y"); ?>" size="20" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" onKeyUp="this.value=formateafecha(this.value)"/></td>
        
        <td width="70" align="left" class="etiqueta_form">Estado:</td>
        <td> 
        <? if($_SESSION["perfil"] == 'FUNCIONARIO'){ ?>
        	<select name="selEstadoDoc" disabled="disabled" grabar="S" valida="requerido" tipovalida="texto" id="selEstadoDoc" onchange="cambiarEstado();" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" >
        <? } else { ?>
        	<select name="selEstadoDoc" grabar="S" valida="requerido" tipovalida="texto" id="selEstadoDoc" onchange="cambiarEstado();" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" >
        <? } ?>
        		<?
			        for($j=0; $j<$coleccion_estadoDoc->get_count(); $j++)
			        {
						
			            $datoTmp = &$coleccion_estadoDoc->items[$j];
						$selected = "";
						if($datoDoc->get_data("id_estado") == $datoTmp->get_data("id_estado_doc"))
						{
							$selected = "selected";
						}
			            echo("<option value=".$datoTmp->get_data("id_estado_doc")." ".$selected." >".strtoupper(utf8_encode($datoTmp->get_data("estado")))."</option>");           
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
		<td width="20" align="left" class="etiqueta_form">Nro Doc.:</td>
        <td align="left"><input type="text" grabar="S" name="txtnrodoc" id="txtnrodoc" value="<? echo($datoDoc->get_data("numero_documento"))?>" size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="entero"/></td>
        
        <td width="70" align="left" class="etiqueta_form">Tipo Doc.:</td>
        <td> 
        	<select name="selTipoDoc" grabar="S" valida="requerido" tipovalida="texto" id="selTipoDoc" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
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
        <td width="20" align="left" class="etiqueta_form">Monto:</td>
        <td align="left"><input type="text" grabar="S" name="txtmonto" id="txtmonto" value="<? echo($datoDoc->get_data("monto"))?>" size="15" onkeyup='mostrar(this)' class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="moneda"/></td>
        
        <td width="70" align="left" class="etiqueta_form">Banco:</td>
        <td> 
        	<select name="selBancos" grabar="S" valida="requerido" tipovalida="texto" id="selBancos" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
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
        
            
    </tr>
    
    <tr>
    	 <td width="20" align="left" class="etiqueta_form">Cta. Cte.:</td>
        <td align="left"><input type="text" grabar="S" name="txtctacte" id="txtctacte" value="<? echo($datoDoc->get_data("cta_cte"))?>"  size="15" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="entero"/></td> 
        
    	<td width="20" align="left" class="etiqueta_form">Fecha Protesto:</td>
        <td align="left"><input type="text" grabar="S" name="txtfechaprotesto" id="txtfechaprotesto" value="<? echo(formatoFecha($datoDoc->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?>" size="15" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" onKeyUp="this.value=formateafecha(this.value)"/></td>
        <td width="20" align="left" class="etiqueta_form">Monto Protesto:</td>
        <td align="left"><input type="text" grabar="S" name="txtmontoprotesto" id="txtmontoprotesto" value="<? echo($datoDoc->get_data("gastos_protesto"))?>"  size="15" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="entero"/></td>
		<td width="70" align="left" class="etiqueta_form">Causal Protesto:</td>
        <td> 
        	<select name="selCausalProtesta" grabar="S"  tipovalida="texto" id="selCausalProtesta" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
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
    	<td width="20" align="left" class="etiqueta_form">Fecha Venc.:</td>
        <td align="left"><input type="text" grabar="S" name="txtfechavenc" id="txtfechavenc" value="<? echo(formatoFecha($datoDoc->get_data("fecha_siniestro"),"yyyy-mm-dd","dd/mm/yyyy"))?>" size="15" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" tipovalida="fecha" onKeyUp="this.value=formateafecha(this.value)"/></td>
    
    </tr>
    
 </table></div>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiarDocumentos()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"value="Cancelar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
         </td>
    </tr>
    <tr>
        <td colspan="3"  height="10">
        
         </td>
    </tr>
</table>

</form>
</body>
</html>