
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/funciones.js" type="text/javascript"></script>
</head>
<body>

<form name="frmreceptor">
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>"/>

 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Gastos</th>
    </tr>
 </table>
<!--<div id="datos" style="">-->
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" height="5">
         </td>
    </tr> 
    <tr>
        <td width="100%" valign="top"> 
        	<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%" style="position:relative; margin-left:5px;">	
            <tr>
            	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?
			$totales = array();
            for($j=0; $j<$colGastosGastos->get_count(); $j++) 
			{
				$datoTmp = &$colGastosGastos->items[$j];  
               	if($datoTmp->get_data("rep") == 1)
				{
					$totales[] = $datoTmp->get_data("importe");
			?>
            	<td>
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr>
                	<td align="left" class="etiqueta_form"><? echo($datoTmp->get_data("gasto")) ?></td>
                    </tr>
                    <tr>
                    <td align="left" ><input type="text" disabled name="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" id="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo(conDecimales($datoTmp->get_data("importe"))) ?>"/>
                    </td>
                    </tr>
             	</table>   
                </td>
           <?
		   		}
           	}
		   ?>	
           		
           	</tr>
            <tr>
            	<td colspan="2"></td>
            <?
			$indice = 1;
            for($j=0; $j<$colGastosGastos->get_count(); $j++) 
			{
				$datoTmp = &$colGastosGastos->items[$j];  
				if($datoTmp->get_data("rep") == 2)
				{
					$totales[$indice] = $totales[$indice] + $datoTmp->get_data("importe");
					$indice = $indice + 1;
			?>
            	<td>
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr>
                    <td align="left" >
                    
                    <input type="text" disabled name="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" id="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo(conDecimales($datoTmp->get_data("importe"))) ?>"/>
                    
                    	
					
                    </td>
                    </tr>
             	</table>   
                </td>
           <?
		   		}
           	}
		   ?>	
           		<td colspan="6"></td>
           	</tr>
             <tr>
            	<td colspan="2"></td>
            <?
			$indice = 1;
            for($j=0; $j<$colGastosGastos->get_count(); $j++) 
			{
				$datoTmp = &$colGastosGastos->items[$j];  
				if($datoTmp->get_data("rep") == 3)
				{
					$totales[$indice] = $totales[$indice] + $datoTmp->get_data("importe");
					$indice = $indice + 1;
			?>
            	<td>
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr>
                    <td align="left" >
                    
                    <input type="text" disabled name="txtgasto_<? echo($datoTmp->get_data("id_gasto")) ?>" id="txtgasto_<? echo($datoTmp->get_data("gasto")) ?>" size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" valida="requerido" tipovalida="texto" value="<? echo(conDecimales($datoTmp->get_data("importe"))) ?>"/>
                    
                    	
					
                    </td>
                    </tr>
             	</table>   
                </td>
           <?
		   		}
           	}
		   ?>	
           		<td colspan="6"></td>
           	</tr>
            <tr>
            	<td colspan="13" height="2"></td>
           	</tr>
             <tr>
            	<td colspan="13"><hr></td>
           	</tr>
            <tr>
            	<td class="etiqueta_form">Totales:</td>
                <?
                	for($i=0; $i<count($totales); $i++)
					{
				?>
                <td><? echo(conDecimales($totales[$i])) ?></td>
                <?
					}
				?>
               <!-- <td colspan="12" height="2"></td>-->
           	</tr>
           </table>
        </td>
    </tr>		
    <tr>
        <td colspan="13">
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
