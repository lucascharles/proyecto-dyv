<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

    <script language="javascript">
			
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
		
		$(document).ready(function() 
		{
			cargarPantalla("DOCUMENTOS");
		});
		
		function cargarPantalla(opt)
		{
			var url = "index.php?controlador=Deudores&accion=";
			var accion = "";
			if(opt == "DOCUMENTOS")
			{
				accion = "ficha_documentos";
			}
			if(opt == "RECEPTOR")
			{
				accion = "ficha_receptor";
			}
			if(opt == "MARTILLERO")
			{
				accion = "ficha_martillero";
			}
			if(opt == "CONSIGNACION")
			{
				accion = "ficha_consignacion";
			}
			if(opt == "GASTOS")
			{
				accion = "ficha_gastos";
			}
			url += accion+"&ident="+$("#ident").val()+"&tipoperacion="+$("#tipoperacion").val(); 
			
			document.getElementById("frmsubpantalla").src = url;
		}
		
	</script>
</head>
<body>

<form name="frmadmtipdoc">
<input  type="hidden" name="ident" id="ident" value="<? echo($ident) ?>"/>
<input  type="hidden" name="tipoperacion" id="tipoperacion" value="<? echo($tipoperacion) ?>"/>


  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Ficha Deudor</th>
        <th></th>
        <th></th>
    </tr>
 </table>

 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<th align="left" height="20"></th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="datos" style="">
	<table width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
	 <tr>
		<td align="right" class="etiqueta_form" width="10">Deudor:</td><td>&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut_deudor" id="txtrut_deudor"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($deudor->get_data("rut_deudor")) ?>" />&nbsp;<input type="text" name="txtrut_d_deudor" id="txtrut_d_deudor"  size="2" onkeyup='mostrar(this)'  class="input_form_min" value="<? echo($deudor->get_data("dv_deudor"))?>"/>
        </td>
    </tr>
    <tr>
		<td align="right" class="etiqueta_form" width="20">Mandatario:</td><td>&nbsp;&nbsp;&nbsp; <input type="text" name="txtrut_mandante" id="txtrut_mandante"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($mandante->get_data("rut_mandante"))?>"/>&nbsp;<input type="text" name="txtrut_d_mandante" id="txtrut_d_mandante"  size="2" onkeyup='mostrar(this)'  class="input_form_min" value="<? echo($mandante->get_data("dv_mandante"))?>"/>
        </td>
    </tr>
    <tr>
		<td align="right" class="etiqueta_form" width="20">Monto:</td><td>&nbsp;&nbsp;&nbsp; <input type="text" name="txtmonto" id="txtmonto"  size="20" onkeyup='mostrar(this)' class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
    </tr>
     <tr>
		<td colspan="3" height="15"> </td>
    </tr>
   </table>
</div>

<div id="datos" style="">
	<table width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
     
	 <tr>
		<td align="left" class="etiqueta_form">Abogado</td>
        <td align="left" class="etiqueta_form">Firma</td>
        <td align="left" class="etiqueta_form">Ingreso</td>
        <td align="left" class="etiqueta_form">Providencia_1</td>
    </tr>
    <tr>
        <td><input type="text" name="txtabogado" id="txtabogado"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" name="txtfirma" id="txtfirma"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" name="txtingreso" id="txtingreso"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" name="txtprovidencia_1" id="txtprovidencia_1"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
    </tr>
    <tr>
		<td align="left" class="etiqueta_form">Distribuci&oacute;n Corte</td>
        <td align="left" class="etiqueta_form">Rol</td>
        <td align="left" class="etiqueta_form">Juzgado Nro.</td>
        <td align="left" class="etiqueta_form">J. Comuna</td>
    </tr>
    <tr>
        <td><input type="text" name="txtdist_corte" id="txtdist_corte"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><input type="text" name="txtrol" id="txtrol"  size="20" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" />
        </td>
        <td><select name="selJuzgadoNro" valida="requerido" tipovalida="texto" id="selJuzgadoNro" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
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
        </td>
        <td><select name="selJComuna" valida="requerido" tipovalida="texto" id="selJComuna" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
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
        </td>
    </tr>
    
    
     <tr>
		<td colspan="3" height="15"> </td>
    </tr>
   </table>
</div>

 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 	<tr>
		<td colspan="3">
        	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' onclick="cargarPantalla('DOCUMENTOS')">
                    	Documentos
                    </td>
                    <td class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' onclick="cargarPantalla('RECEPTOR')">
                    	Receptor
                    </td>
                    <td class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' onclick="cargarPantalla('MARTILLERO')">
                    	Martillero
                    </td>
                    <td class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' onclick="cargarPantalla('CONSIGNACION')">
                    	Consiganaci&oacute;n
                    </td>
                    <td class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' onclick="cargarPantalla('GASTOS')">
                    	Gastos
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
		<td colspan="3" height="10">
        
        </td>
    </tr>
    <tr>
		<td colspan="3">
        	<iframe id="frmsubpantalla" src="" width="100%" align="middle" height="300" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>

</table>
</div>
</form>
</body>
</html>