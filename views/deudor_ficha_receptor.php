
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
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
  			$("#txtprovidencia").datepicker({changeYear: true});
  			$("#txtprovidencia_1").datepicker({changeYear: true});
  			$("#txtprovidencia_2").datepicker({changeYear: true});
  			$("#txtprovidencia_3").datepicker({changeYear: true});
			$("#txtfecha_mandamiento").datepicker({changeYear: true});	
			$("#txtfecha_domicilio").datepicker({changeYear: true});	
			$("#txtfecha_domicilio_1").datepicker({changeYear: true});	
			$("#txtfecha_embargo_fp").datepicker({changeYear: true});	
			$("#txtfecha_oficio").datepicker({changeYear: true});	
			$("#txtfecha_traba_emb").datepicker({changeYear: true});	
			$("#txtfecha_busqueda_2").datepicker({changeYear: true});	
			
		});
		
    	function grabarReceptor()
		{
			/*
			if(!validar("N"))
			{
				return false;
			}
			*/	
			var datos = "controlador=Deudores";
			
			if($("#tipoperacion").val() == "A")
			{
				if($("#id_alta").val() > 0 && $.trim($("#id_alta").val()) != "")
				{
					datos += "&accion=grabarReceptorM";	
				}
				else
				{
					datos += "&accion=grabarReceptorA";	
				}
			}
			
			if($("#tipoperacion").val() == "M")
			{				
				datos += "&accion=editarReceptor";	
			}
		
			datos += "&"+getParametros();
			alert(datos);
			//return false;
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						//alert(res);
						window.parent.pasarIdFicha(res);
						$("#id_alta").val(res);
						window.parent.mensajeConfirmacion("La Notificacion/Citacion se guardo con éxito");
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function limpiarReceptor()
		{
			limpiarCampos();
		}
	</script>
</head>
<body>

<?
	
	if($tipoperacion == "M")
	{
		$id_alta  = $ident;
	}
	
	$id_receptor = ($id_alta > 0) ? $receptor->get_data("id_receptor") : "";
	$id_ficha = ($id_alta > 0) ? $receptor->get_data("id_ficha") : "";
	$fecha_mandamiento = ($id_alta > 0) ? formatoFecha($receptor->get_data("fecha_mandamiento"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$fecha_providencia = ($id_alta > 0) ? formatoFecha($receptor->get_data("fecha_providencia"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$receptor_view = ($id_alta > 0) ? $receptor->get_data("receptor") : "";
	$busqueda = ($id_alta > 0) ? $receptor->get_data("busqueda") : "";
	$notificacion = ($id_alta > 0) ? $receptor->get_data("notificacion") : "";
	$fecha_domicilio = ($id_alta > 0) ?  formatoFecha($receptor->get_data("fecha_domicilio"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$entrega_receptor_2 = ($id_alta > 0) ? $receptor->get_data("entrega_receptor_2") : "";
	$notificacion_2 = ($id_alta > 0) ? $receptor->get_data("notificacion_2") : "";
	$fecha_domicilio_1 = ($id_alta > 0) ?  formatoFecha($receptor->get_data("fecha_domicilio_1"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$entrega_receptor_3 = ($id_alta > 0) ? $receptor->get_data("entrega_receptor_3") : "";
	$notificacion_3 = ($id_alta > 0) ? $receptor->get_data("notificacion_3") : "";
	$fecha_embargo_fp = ($id_alta > 0) ? formatoFecha($receptor->get_data("fecha_embargo_fp"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$fecha_oficio = ($id_alta > 0) ? formatoFecha($receptor->get_data("fecha_oficio"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$fecha_traba_emb = ($id_alta > 0) ? formatoFecha($receptor->get_data("fecha_traba_emb"),"yyyy-mm-dd","dd/mm/yyyy") : "";
		
	$entrega_receptor_1 = ($id_alta > 0) ? $receptor->get_data("entrega_receptor_1") : "";
	$fono_receptor = ($id_alta > 0) ? $receptor->get_data("fono_receptor") : "";
	$resultado_busqueda = ($id_alta > 0) ? $receptor->get_data("resultado_busqueda") : "";
	$resultado_notificacion_1 = ($id_alta > 0) ? $receptor->get_data("resultado_notificacion_1") : "";
	$providencia_1 = ($id_alta > 0) ? $receptor->get_data("providencia_1") : "";
	$fecha_busqueda_2 = ($id_alta > 0) ? formatoFecha($receptor->get_data("fecha_busqueda_2"),"yyyy-mm-dd","dd/mm/yyyy") : "";
	$resultado_notificacion_2 = ($id_alta > 0) ? $receptor->get_data("resultado_notificacion_2") : "";
	$providencia_2 = ($id_alta > 0) ? $receptor->get_data("providencia_2") : "";
	$busqueda_3 = ($id_alta > 0) ? $receptor->get_data("busqueda_3") : "";
	$resultado_notificacion_3 = ($id_alta > 0) ? $receptor->get_data("resultado_notificacion_3") : "";
	$providencia_3 = ($id_alta > 0) ? $receptor->get_data("providencia_3") : "";
	$entrega_receptor_4 = ($id_alta > 0) ? $receptor->get_data("entrega_receptor_4") : "";
	$embargo = ($id_alta > 0) ? $receptor->get_data("embargo") : "";
	$notificacion_ficha = ($id_alta > 0) ? $receptor->get_data("notificacion_ficha") : "";
	$citacion = ($id_alta > 0) ? $receptor->get_data("citacion") : "";
	$art1044 = ($id_alta > 0) ? $receptor->get_data("articulo_431044") : "";
?>
<form name="frmreceptor">
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>" grabar="S"/>
<input  type="hidden" name="ident" id="ident" value="<? echo($ident) ?>" grabar="S"/>
<input  type="hidden" name="id_alta" id="id_alta" value="<? echo($id_alta) ?>" grabar="S"/>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;</th>
        <th></th>
        <td align="left" >Notificacion</td>
                    <td align="left" >
                    		<select name="txtnotificacion_ficha" grabar="S" tipovalida="texto" id="txtnotificacion_ficha"  onFocus="resaltar(this)" onBlur="noresaltar(this)">
			     				<option value=""> <?php if($notificacion_ficha ==""){?>Seleccione<?php }else{echo($notificacion_ficha);} ?> </option>
			     				<option value="Protesto Pagare"> Protesto Pagare </option>
			     				<option value="Protesto Letra"> Protesto Letra </option>
			     				<option value="Protesto Letra"> Protesto Cheque </option>
			     				<option value="Protesto Letra"> Protesto Factura </option>
					  		</select>
					</td>
                    <td align="left" >Citacion</td>
                    <td align="left" >
                    		<select name="txtcitacion" grabar="S" tipovalida="texto" id="txtcitacion"  onFocus="resaltar(this)" onBlur="noresaltar(this)">
			     				<option value=""> <?php if($citacion ==""){?>Seleccione<?php }else{echo($citacion);} ?> </option>
			     				<option value="Confesa Deuda"> Confesar Deuda </option>
			     				<option value="Reconocer Firma y Confesar Deuda"> Reconocer Firma y Confesar Deuda </option>
					  		</select>
		</td>
        <th align="right">
        	<div style="position:relative; margin-right:10px;">
        	<img src="images/grabar.gif" onClick="grabarReceptor()" title="Grabar" style="cursor:pointer;">&nbsp;&nbsp;
            <img src="images/limpiar.gif" onClick="limpiarReceptor()" title="Limpiar" style="cursor:pointer;">
            </div>
        </th>
        
    </tr>
 </table>
<!--<div id="datos" style="">-->
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" height="5">
        	
         </td>
    </tr>   
    <tr>
    	<td width="40%" valign="top">
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
            	<tr>
                	<td align="left" class="etiqueta_form">Providencia</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_providencia" id="txtfecha_providencia" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($fecha_providencia) ?>" onKeyUp="this.value=formateafecha(this.value)" /></td>
                    
                </tr>
            	
            	<tr>
                	<td align="left" class="etiqueta_form">Fecha mandamiento</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($fecha_mandamiento) ?>" onKeyUp="this.value=formateafecha(this.value)" /></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtreceptor" id="txtreceptor" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($receptor_view) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">B&uacute;squeda</td>
                      <td align="left" ><input type="text" grabar="S" name="txtbusqueda" id="txtbusqueda" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($busqueda) ?>"/></td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Notificaci&oacute;n</td>
                    <td align="left" ><input type="text" grabar="S" name="txtnotificacion" id="txtnotificacion" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($notificacion) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Fecha domicilio</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_domicilio" id="txtfecha_domicilio" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($fecha_domicilio) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>

                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Entrega receptor 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_receptor_2" id="txtentrega_receptor_2" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_2) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Notificaci&oacute;n 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtnotificacion_2" id="txtnotificacion_2" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($notificacion_2) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Fecha domicilio 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_domicilio_1" id="txtfecha_domicilio_1" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($fecha_domicilio_1) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>

                 </tr>
                  <tr>
					<td align="left" class="etiqueta_form">Entrega receptor 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_receptor_3" id="txtentrega_receptor_3" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_3) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Notificaci&oacute;n 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtnotificacion_3" id="txtnotificacion_3" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($notificacion_3) ?>"/></td>
                  </tr> 
                  <tr>
					<td align="left" class="etiqueta_form">Fecha embargo fuerza p&uacute;blica</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_embargo_fp" id="txtfecha_embargo_fp" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($fecha_embargo_fp) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Fecha oficio</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_oficio" id="txtfecha_oficio" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($fecha_oficio) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Fecha traba embargo</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_traba_emb" id="txtfecha_traba_emb" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($fecha_traba_emb) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>
                  </tr>
            	</table>
        </td>
    
        <td width="40%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%"  style="position:relative; margin-left:5px;">
            	<tr>
                	<td align="left" class="etiqueta_form">Entrega receptor 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_receptor_1" id="txtentrega_receptor_1" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_1) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Fono/Email Receptor</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfono_receptor" id="txtfono_receptor" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fono_receptor) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Resultado B&uacute;squeda</td>
                      <td align="left" >
                      	<select name="txtresultado_busqueda" grabar="S" tipovalida="texto" id="txtresultado_busqueda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
			     			<option value="Positiva"> <?php if($resultado_busqueda == ""){?>Positiva<?php }else{echo($resultado_busqueda);}?> </option>
			     			<option value="Negativa"> Negativa </option>
			        		
					  	</select>
					  </td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Resultado Notificaci&oacute;n 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtresultado_notificacion_1" id="txtresultado_notificacion_1" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_notificacion_1) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Providencia 1</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia_1" id="txtprovidencia_1" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($providencia_1) ?>"/></td>

                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Fecha B&uacute;squeda 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtfecha_busqueda_2" id="txtfecha_busqueda_2" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($entrega_receptor_1) ?>" onKeyUp="this.value=formateafecha(this.value)"/></td>
                 </tr> 
                 <tr>
					<td align="left" class="etiqueta_form">Resultado notificaci&oacute;n 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtresultado_notificacion_2" id="txtresultado_notificacion_2" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_notificacion_2) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Providencia 2</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia_2" id="txtprovidencia_2" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($providencia_2) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">B&uacute;squeda 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtbusqueda_3" id="txtbusqueda_3" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($busqueda_3) ?>"/></td>
                  </tr> 
                  <tr>
					<td align="left" class="etiqueta_form">Resultado notificaci&oacute;n 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtresultado_notificacion_3" id="txtresultado_notificacion_3" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_notificacion_3) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Providencia 3</td>
                    <td align="left" ><input type="text" grabar="S" name="txtprovidencia_3" id="txtprovidencia_3" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="fecha" value="<? echo($providencia_3) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Entrega receptor 4</td>
                    <td align="left" ><input type="text" grabar="S" name="txtentrega_receptor_4" id="txtentrega_receptor_4" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_4) ?>"/></td>
                  </tr>
            	<tr>
                	<td align="left" class="etiqueta_form">Embargo</td>
                    <td align="left" ><input type="text" grabar="S" name="txtembargo" id="txtembargo" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($embargo) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Art. 1044</td>
                    <td align="left" ><input type="text" grabar="S" name="txtarticulo_431044" id="txtarticulo_431044" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($art1044) ?>"/></td>
                </tr>
                
            	</table>
        </td>
        <td width="20%" valign="top"><!-- 
        	<div style="border:solid; border-width:2px; position:relative; margin-left:10px;">
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%" style="position:relative; margin-left:5px;">
            	<tr>
                	<td align="center" class="etiqueta_form" colspan="3">
                    	GASTOS
                    </td>
                </tr>
            <?
            for($j=0; $j<$colGastosReceptor->get_count(); $j++) 
			{
				$datoTmp = &$colGastosReceptor->items[$j];  
			?>
            	<tr>
                	<td align="left" class="etiqueta_form"><? echo($datoTmp->get_data("gasto")) ?></td>
                    <td align="left" ><input type="text" grabar="S" name="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" id="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($datoTmp->get_data("importe")) ?>"/></td>
                    <td width="5"></td>
                </tr>
           <?
           }
		   ?>
             </table>
             </div>
        --></td>
    </tr>		
    <tr>
        <td colspan="3">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>    
 </table>
<!-- </div>-->

 <div style="position:relative; margin-top:10px;">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        <!--
        	<input  type="button" name="btngrabar" id="btngrabar" onClick="grabarReceptor()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onClick="limpiarReceptor()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
       -->
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>
