
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/funciones.js" type="text/javascript"></script>
</head>
<body>

<?
	if($tipoperacion == "A")
	{
		$id_receptor = "";
		$id_ficha = "";
		$fecha_mandamiento = "";
		$receptor = "";
		$busqueda = "";
		$notificacion = "";
		$fecha_domicilio = "";
		$entrega_receptor_2 = "";
		$notificacion_2 = "";
		$fecha_domicilio_1 = "";
		$entrega_receptor_3 = "";	
		$notificacion_3 = "";
		$fecha_embargo_fp = "";
		$fecha_oficio = "";
		$fecha_traba_emb = "";
		
		$entrega_receptor_1 = "";
		$fono_receptor = "";
		$resultado_busqueda = "";
		$resultado_notificacion_1 = "";
		$providencia_1 = "";
		$fecha_busqueda_2 = "";
		$resultado_notificacion_2 = "";
		$providencia_2 = "";
		$busqueda_3 = "";
		$resultado_notificacion_3 = "";
		$providencia_3 = "";
		$entrega_receptor_4 = "";	
		$embargo = "";
		$articulo_431044 = "";
	}
	
?>
<form name="frmreceptor">
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>"/>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th align="right"></th>
    </tr>
	<tr>
		<th align="left">Receptor</th>
        <th></th>
        <th align="right"></th>
    </tr>
 </table>
<!--<div id="datos" style="">-->
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td width="40%" valign="top">
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
            	<tr>
                	<td align="left" class="etiqueta_form">Fecha mandamiento</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fecha_mandamiento) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Receptor</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($receptor) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">B&uacute;squeda</td>
                      <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($busqueda) ?>"/></td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Notificaci&oacute;n</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($notificacion) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Fecha domicilio</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fecha_domicilio) ?>"/></td>

                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Entrega receptor 2</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_2) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Notificaci&oacute;n 2</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($notificacion_2) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Fecha domicilio 2</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fecha_domicilio_1) ?>"/></td>

                 </tr>
                  <tr>
					<td align="left" class="etiqueta_form">Entrega receptor 3</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_3) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Notificaci&oacute;n 3</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($notificacion_3) ?>"/></td>
                  </tr> 
                  <tr>
					<td align="left" class="etiqueta_form">Fecha embargo fuerza p&uacute;blica</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fecha_embargo_fp) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Fecha oficio</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fecha_oficio) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Fecha traba embargo</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fecha_traba_emb) ?>"/></td>
                  </tr>
            	</table>
        </td>
    
        <td width="40%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%"  style="position:relative; margin-left:5px;">
            	<tr>
                	<td align="left" class="etiqueta_form">Entrega receptor 1</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_1) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Fono receptor</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fono_receptor) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Resultado B&uacute;squeda</td>
                      <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_busqueda) ?>"/></td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Resultado Notificaci&oacute;n 1</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_notificacion_1) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Providencia 1</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($providencia_1) ?>"/></td>

                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Fecha B&uacute;squeda 2</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_1) ?>"/></td>
                 </tr> 
                 <tr>
					<td align="left" class="etiqueta_form">Resultado notificaci&oacute;n 2</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_notificacion_2) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Providencia 2</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($providencia_2) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">B&uacute;squeda 3</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($busqueda_3) ?>"/></td>
                  </tr> 
                  <tr>
					<td align="left" class="etiqueta_form">Resultado notificaci&oacute;n 3</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_notificacion_3) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Providencia 3</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($providencia_3) ?>"/></td>
                  </tr>  
                  <tr>
					<td align="left" class="etiqueta_form">Entrega receptor 4</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor_4) ?>"/></td>
                  </tr>
            	<tr>
                	<td align="left" class="etiqueta_form">Embargo</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($embargo) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Art&iacute;culo 431044</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($articulo_431044) ?>"/></td>
                </tr>
                
            	</table>
        </td>
        <td width="20%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%" style="position:relative; margin-left:5px;">
            <?
            for($j=0; $j<$colGastosReceptor->get_count(); $j++) 
			{
				$datoTmp = &$colGastosReceptor->items[$j];  
			?>
            	<tr>
                	<td align="left" class="etiqueta_form"><? echo($datoTmp->get_data("gasto")) ?></td>
                    <td align="left" ><input type="text" name="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" id="txtgasto_<? echo($datoTmp->get_data("gasto")) ?>" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($datoTmp->get_data("importe")) ?>"/></td>
                </tr>
           <?
           }
		   ?>
             </table>
        </td>
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
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabarReceptor()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiarReceptor()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>
