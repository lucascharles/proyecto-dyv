
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
		$aceptacion_cargo = "";
		$nombre = "";
		$rut_martilero = "";
		$dv_martillero = "";
		$notificacion = "";
		$retirio_especies_fp = "";
		
		$providencia = "";
		$entrega_receptor = "";
		$retiro_especies = "";
		$oposicion_retiro = "";
		$fecha_remate = "";
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
		<th align="left">Martillero</th>
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
                	<td align="left" class="etiqueta_form">Aceptaci&oacute;n cargo</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($aceptacion_cargo) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Nombre martillero</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($nombre) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Rut martilero </td>
                      <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($rut_martilero) ?>"/>&nbsp;<input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_min" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($dv_martillero) ?>"/></td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Notificaci&oacute;n</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($notificacion) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Retirio Especies con F.P.</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($retirio_especies_fp) ?>"/></td>

                 </tr>

            	</table>
        </td>
    
        <td width="40%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%"  style="position:relative; margin-left:5px;">
            	<tr>
                	<td align="left" class="etiqueta_form">Providencia</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($providencia) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Entrega receptor</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($entrega_receptor) ?>"/></td>
                </tr>
                <tr>
					<td align="left" class="etiqueta_form">Retiro especies</td>
                      <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($retiro_especies) ?>"/></td>
                 </tr>   
                 <tr>
					<td align="left" class="etiqueta_form">Oposici&oacute;n retiro</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($resultado_notificacion_1) ?>"/></td>
                 </tr>
                 <tr>
					<td align="left" class="etiqueta_form">Fecha remate</td>
                    <td align="left" ><input type="text" name="txtfecha_mandamiento" id="txtfecha_mandamiento" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo($fecha_remate) ?>"/></td>

                 </tr>

            	</table>
        </td>
        <td width="20%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%" style="position:relative; margin-left:5px;">
            <?
            for($j=0; $j<$colGastosMarillero->get_count(); $j++) 
			{
				$datoTmp = &$colGastosMarillero->items[$j];  
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
