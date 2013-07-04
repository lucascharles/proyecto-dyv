<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
    <script src="js/funcionesgral.js" type="text/javascript"></script>
    <script language="javascript">
		$(document).ready(function(){
  			$('form').validator();
  			$("#txtfechaproxgestion").datepicker({changeYear: true});
		});
		
		function ventanaBusqueda()
		{
			$("#selecMandante").slideDown(1000);	
			document.getElementById("txtrut_m").focus();
			//alert($(document).height());
			setTimeout("window.scrollTo(0,$(document).height())",1000);
			//$(window).scrollTop();
			 //$("html, body").animate({ scrollTop: $(document).height() }, "slow");
  //return false;
		}

		
		function ocultarDir()
		{
				$("#formsoporte").hide("slow");
		}
	

		function agregarDir()
		{
				$("#formsoporte").show("slow");
			
		}

		function agregarDemanda()
		{
				$("#formsoporteDemanda").show("slow");
		}

		function ocultarDemanda()
		{
				$("#formsoporteDemanda").hide("slow");
		}
		
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			document.getElementById("txtdestipdoc").focus()
			$(document.getElementById("txtdestipdoc")).removeClass('notFilled');
		}
		
		function salir()
		{
			$("#pagina").load('views/admin_gestiones.php');
		}

		function volver()
		{
			var tg = document.getElementById("tipoGestion").value;

			if(tg == "D")	
			{
				$("#pagina").load('index.php?controlador=Gestiones&accion=admin&proc=1');
			}
			else
			{
				$("#pagina").load('views/admin_gestiones.php');
			}
		}
		
		function cerrarVentMand()
		{
			$("#selecMandante").slideUp(1000);
		}
		function seleccionadoMandante(id)
		{
			document.getElementById("id_mandante").value = id;
			buscarDatosMandante(id);
			cerrarVentMand();
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
		
		function grabar()
		{
			
			if(document.getElementById("iddocumento").value == "" )
//				&& ((document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "DEMANDA")
//						|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "CASTIGADO")
//						|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "DDA/RECUPERADO")
//						|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "DDA/CASTIGADO")
//						|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "FACTURADO")
//						|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "RECUPERADO")))
					
			{
				alert('Debe Seleccionar un Documento para registrar la bitacora.');
			}
			else
			{
			
				
			if(($.trim($("#txtfechagestion").val()) != "")
					&&($.trim($("#txtcomentarios").val()) != "")
					&&($.trim($("#txtrut_mandante").val()) != "")
					&&($.trim($("#txtfechaproxgestion").val()) != "")
					&&($.trim($("#txtusuario").val()) != "")
					&&(document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text != "") )
					
					{

					var datos = "controlador=Gestiones";
					datos += "&accion=grabaEditar";
					datos += "&idgestion="+$("#id_gestion").val();
					datos += "&selGestion="+$("#selGestion").val();
					datos += "&txtfechagestion="+$("#txtfechagestion").val();
					datos += "&txtcomentarios="+$("#txtcomentarios").val();
					datos += "&selMandantes="+$("#id_mandante").val();
					datos += "&txtfechaproxgestion="+$("#txtfechaproxgestion").val();
					datos += "&txtusuario="+$("#txtusuario").val();

					if(document.getElementById("iddocumento").value != "") 
//						&& ((document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "DEMANDA")
//								|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "CASTIGADO")
//								|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "DDA/RECUPERADO")
//								|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "DDA/CASTIGADO")
//								|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "FACTURADO")
//								|| (document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "RECUPERADO")))
							
					{
						datos += "&iddocumento="+$("#iddocumento").val();
					}
					$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						if(document.getElementById('selGestion').options[document.getElementById('selGestion').selectedIndex].text == "DEMANDA")
						{	
							alert("Se generara una FICHA para el deudor.");
							$("#pagina").load('index.php?controlador=Deudores&accion=deudor_ficha&id='+$("#id_deudor").val()+'&id_doc='+$("#iddocumento").val()+'&tipope=A'+'&idGes='+$("#id_gestion").val());
						}
						document.getElementById("frmlistagestiones").src="index.php?controlador=Gestiones&accion=listar_bitacora_gestion&idgestion="+$("#id_gestion").val()+"&iddocumento="+$("#iddocumento").val();
					},
					error: function()
					{
					$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
					});
				
					}
			
			}
		}

		function grabarDir()
		{
			if($.trim($("#iddireccion").val()) != "")
			{
				var datos = "controlador=Gestiones";
				datos += "&accion=grabaEditarDir";
				datos += "&iddireccion="+$("#idgestion").val();

				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{						
						document.getElementById("frmdireccion").src="index.php?controlador=Gestiones&accion=grabarDir&iddireccion="+$("#iddireccion").val();
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
							}
		}
		function fechaGestion(){
			document.getElementById("txtfechagestion").value = "<?php echo date("d-m-Y H:i"); ?>";
		}


		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}

		function seleccionado_dir(id)
		{
			document.getElementById("iddireccion").value = id;
		}

		function seleccionado_doc(id)
		{
			document.getElementById("iddocumento").value = id;
			document.getElementById("id_gestion").value = <? echo($objGestion->get_data("id_gestion")) ?>;
//			alert("index.php?controlador=Gestiones&accion=listar_bitacora_gestion&idgestion="+<? echo($objGestion->get_data("id_gestion")) ?>+"&iddocumento="+id);
			document.getElementById("frmlistagestiones").src="index.php?controlador=Gestiones&accion=listar_bitacora_gestion&idgestion="+<? echo($objGestion->get_data("id_gestion")) ?>+"&iddocumento="+id;			
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

		function modDeudor(iddeudor)
		{
			if(iddeudor == "")
			{
				return false;
			}

			$("#pagina").load('index.php?controlador=Deudores&accion=editar&iddeudor='+iddeudor+"&control_volver=Gestiones&accion_volver=gestionar&param_volver=idgestion&val_volver="+$("#id_gestion").val());
		}

		function liquidar(iddeudor)
		{
			if(iddeudor == "")
			{
				return false;
			}
//			alert('index.php?controlador=Gestiones&accion=gestiona_liquidacion&iddeudor='+iddeudor);
			$("#pagina").load('index.php?controlador=Gestiones&accion=gestiona_liquidacion&iddeudor='+iddeudor+"&control_volver=Gestiones&accion_volver=gestionar&param_volver=idgestion&val_volver="+$("#id_gestion").val());		
		}


		
		
	</script>
</head>
<body>
<div id="selecMandante" style="position:absolute; margin-left:20px; width:95%; margin-top:60%; display:none; z-index:9999;">
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
<form name="frmadmgestion">
	<input  type="hidden" name="id_deudor" id="id_deudor" value="<? echo($objGestion->get_data("id_deudor")) ?>"/>
	<input  type="hidden" name="id_gestion" id="id_gestion" value="<? echo($objGestion->get_data("id_gestion")) ?>"/>
	<input  type="hidden" name="iddireccion" id="iddireccion" value=""/>
    <input  type="hidden" name="id_mandante" id="id_mandante" value="<? $var = &$idMandante; echo($var); ?>"/>
    <input  type="hidden" name="iddocumento" id="iddocumento" value=""/>
    <input  type="hidden" name="tipoGestion" id="tipoGestion" value="<? $var = &$tipoGestion; echo($var); ?>"/>
    
<div id="datos" style="">

  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Deudor - Mandatario</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td height="5">
        </td>
    </tr>
    <tr>
		<td align="right" class="etiqueta_form" width="20">Mandante:</td><td>&nbsp;&nbsp;&nbsp;
			<input type="text" name="txtmandatario" id="txtmandatario" value="<? $var = &$rutMandante; echo($var); ?>" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
        	<input type="text" name="txtmandantenombre" id="txtmandantenombre" value="<? $var = &$nomMandante; echo($var); ?>" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
       	</td>
    </tr>
     <tr>
    	<td height="5">
        </td>
    </tr>
	
    <tr>
		<td align="right" class="etiqueta_form" width="20">Deudor:</td><td>&nbsp;&nbsp;&nbsp;
    		<input type="text" name="txtrutdeudor" id="txtrutdeudor" value="<? $var = &$rutDeudor; echo($var); ?>" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
    		<input type="text" name="txtdeudornombre" id="txtdeudornombre" value="<? $var = &$nomDeudor; echo($var); ?>" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
    	</td>	
    	<td align="left" class="etiqueta_form" >Celular:&nbsp;
    			<input type="text" name="txtceldeudor" id="txtceldeudor" value="<? $var = &$celDeudor; echo($var); ?>" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />&nbsp;
    	</td>	
    	<td align="left" class="etiqueta_form" >Tel.Fijo: &nbsp;
    		<input type="text" name="txtteldeudor" id="txtteldeudor" value="<? $var = &$telDeudor; echo($var); ?>" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
    	</td>
    	<td align="left" class="etiqueta_form" >Email: &nbsp;
    		<input type="text" name="txtemaildeudor" id="txtemaildeudor" value="<? $var = &$emailDeudor; echo($var); ?>" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
    	</td>
    	<td align="left" class="etiqueta_form" >
    		<input  type="button" name="btnmoddeudor" id="btnmoddeudor" onclick="modDeudor(<? echo($objGestion->get_data("id_deudor")) ?>)" class="boton_form" value="Deudor" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
    	</td>
    	
	</tr>
     <tr>
    	<td height="5">
        </td>
    </tr>
    <tr>
        <td colspan="3">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
</table>
</div>


<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Documentos por Mandantes               
        	<select name="selMandantes" tipovalida="texto" id="selMandantes" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value="<? $var = &$idMandante; echo($var); ?>"> <? $var = &$rutMandante; $var2 = &$nomMandante; echo($var."   ".$var2); ?> </option>
        		<?
			        for($j=0; $j<$coleccionMandantesDeudor->get_count(); $j++)
			        {
			            $datoTmp = &$coleccionMandantesDeudor->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_mandatario").">".utf8_encode($datoTmp->get_data("rut_mandante")."-".$datoTmp->get_data("dv_mandante")."   ".$datoTmp->get_data("nombre"))."</option>");           
			        }
    			?>
			</select>
        </th>
        
        <th align="left" height="30"> Deuda Neta:&nbsp;&nbsp;<? $var = &$deudaNeta; echo($var); ?></th> 
        
    </tr>
 </table>
<table width="100%" height="120" align="center" border="0" cellpadding="0" cellspacing="0">
     <tr>
     	<td valign="top" colspan="2">

        </td>
    </tr>
    <tr>
    	<td colspan="2" height="5" >
        </td>
     </tr>
    <tr>
    	<td align="right" valign="top" >
        			<iframe id="frmlistdocumentos" src="index.php?controlador=Gestiones&accion=listarDocumentoMandante&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>&idmandante=<? echo($objGestion->get_data("id_mandante")) ?>" frameborder="0" align="middle" width="100%" height="120" scrolling="auto"></iframe>
        </td>
        <td align="center" width="100">
					<input  type="button" name="btnLiquidacion" id="btnLiquidacion" onclick="liquidar(<? echo($objGestion->get_data("id_deudor")) ?>)" class="boton_form" value="Liquidaci&oacute;n" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
        </td>
    </tr>
</table>

</div>

<div id="datos" style="">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<td>
		<th align="left" height="30">&nbsp;Direcciones</th>
        <th></th>
        <th align="center" ></th>
        <th></th>
        <th></th>
        </td>
        <td align="right">
			<input  type="button" name="btnVerDireccion" id="btnVerDireccion" onclick="agregarDir()" class="boton_form" value="Ver Direccion" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
        </td>
    </tr>
 </table>
</div> 
 <div id="formsoporte" style=" display:none"> 
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

    <tr>
		<td >
        	<iframe id="frmdireccion" src="index.php?controlador=Gestiones&accion=listar_dir&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>" frameborder="0" align="middle" width="100%" height="120" scrolling="auto"></iframe>
        </td>
        <td width="100" >
        	&nbsp;
         <tr>
         <input  type="button" name="btngrabardir" id="btngrabardir" onclick="grabarDir()" class="boton_form" value="Grabar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
         </tr>
         <tr>
         <input  type="button" name="btnocultardir" id="btnocultardir" onclick="ocultarDir()" class="boton_form" value="Ocultar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
         </tr>
        </td>
	</tr>
</table>
</div>

<div id="datos" style="">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<td>
		<th align="left" height="30">&nbsp;Demandas - Cantidad: <? $var = &$cantidadDemandas; echo($var); ?></th>
        <th></th>
        <th align="center" ></th>
        <th></th>
        <th></th>
        </td>
        <td align="right">
			<input  type="button" name="btnVerDemandas" id="btnVerDemandas" onclick="agregarDemanda()" class="boton_form" value="Ver Demanda" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
        </td>
    </tr>
 </table>

 <div id="formsoporteDemanda" style=" display:none">  
<table width="100%" align="center" border="1" cellpadding="0" cellspacing="0">
	<tr>
	     <th></th>
    </tr>
    <tr>
		<td >
            	<iframe id="frmdemandas" src="index.php?controlador=Gestiones&accion=listar_demandas&iddeudor=<? echo($objGestion->get_data("id_deudor")) ?>" frameborder="0" align="middle" width="80%" height="120" scrolling="auto"></iframe>
        </td>
	</tr>
	<tr>
    	<input  type="button" name="btnocultardem" id="btnocultardem" onclick="ocultarDemanda()" class="boton_form" value="Ocultar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
    </tr>
</table>
</div>
</div>

<div id="datos" style="">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Gestiones</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    </tr>
    <tr>
		<td >
        	<iframe id="frmlistagestiones" src="index.php?controlador=Gestiones&accion=listar_bitacora_gestion&idgestion=<? echo($objGestion->get_data("id_gestion")) ?>" frameborder="0" align="middle" width="100%" height="120" scrolling="auto"></iframe>
        </td>
	</tr>
</table>
</div>

<div id="datos">

<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" >
<tr>
        <td colspan="6" height="5">
         </td>
    </tr>   
    <tr>
		<td align="center" class="etiqueta_form">Gestion</td>
        <td> 
        	<select name="selGestion" valida="requerido" tipovalida="texto" id="selGestion" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value="<? $var = &$idUltimaGestion; echo($var); ?>"> <? $var = &$estadoUltimaGestion; echo($var); ?> </option>
        		<?
			        for($j=0; $j<$coleccionEstadoGestion->get_count(); $j++)
			        {
			            $datoTmp = &$coleccionEstadoGestion->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_estado").">".utf8_encode($datoTmp->get_data("estado"))."</option>");           
			        }
    			?>
			</select>
        </td>
        <td align="center" class="etiqueta_form">Fecha Gestion</td>
        <td> <input type="text" name="txtfechagestion" id="txtfechagestion" value="<?php echo (date("Y-m-d")) ?>" class="input_form_medio" valida="requerido" tipovalida="texto" onFocus="resaltar(this)" onBlur="noresaltar(this)"/>
        </td>
        <td align="center" class="etiqueta_form">Comentarios</td>
        <td> <input type="text" name="txtcomentarios" id="txtcomentarios" value="" class="input_form" valida="requerido" tipovalida="texto" onFocus="resaltar(this);" onBlur="noresaltar(this)"/>
        </td>
    </tr>
    <tr>
        <td align="center" class="etiqueta_form">Mandantes</td>
        <td> 
        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="240">
						<input type="text" name="txtrut_mandante" id="txtrut_mandante" value="<? $var = &$rutMand; echo($var); ?>" class="input_form" onblur=" generadvrut('txtrut_mandante','txtdv_mandante'); validarRut('M')"  />&nbsp;
            			<input type="text" name="txtdv_mandante" id="txtdv_mandante" value="<? $var = &$rutDvMand; echo($var); ?>"  class="input_form_min" onblur="" disabled="disabled" />
                    </td>
                	<td align="left">
			            <img src="images/buscar.png" title="Buscar Mandante" style="cursor:pointer" onclick="ventanaBusqueda()" />
                    </td>
                </tr>
             </table>
        </td>
        <?php 
        	$fecha = date('Y-m-d');
			$nuevafecha = strtotime ( '+3 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        ?>
        <td align="center" class="etiqueta_form">Prox. Gestion</td>
        <td> <input type="text" name="txtfechaproxgestion" id="txtfechaproxgestion" value="<?php echo($nuevafecha); ?>" class="input_form_medio" valida="requerido" tipovalida="texto" onFocus="resaltar(this)" onBlur="noresaltar(this)" onKeyUp="this.value=formateafecha(this.value)"/>
        </td>
        <td align="center" class="etiqueta_form">Usuario</td>
        <td> <input type="text" name="txtusuario" id="txtusuario" disabled="disabled" value="<?php echo($_SESSION["idusuario"])?>" class="input_form_medio" valida="requerido" tipovalida="texto" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
    </tr>   
    <tr>
        <td colspan="6" height="5">
         </td>
    </tr>   
    
</table>
</div>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()" class="boton_form" value="Grabar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
		<td colspan="3" align="center">
        	<input  type="button" name="btnvolver" id="btnvolver" onclick="volver()" class="boton_form" value="Volver" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
    </tr>
</table>

</form>
</body>
</html>