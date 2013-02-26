<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

    <script language="javascript">
		function mostrar(obj)
		{
			var url = "index.php?controlador=TipoDocumento&accion=listar&des_int="+obj.value;
			document.getElementById("frmlisttipdoc").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			var url = "index.php?controlador=TipoDocumento&accion=listar";
			document.getElementById("frmlisttipdoc").src = url;
		}
		
		function buscar()
		{

			var url = "index.php?controlador=Informes&accion=listar&tipoInforme="+document.getElementById("selTipoInforme").value+"&idmandante="+document.getElementById("selMandantes").value;
				url = url+"&tipoDoc="+document.getElementById("selTipoDoc").value
			document.getElementById("frmlistinforme").src = url;
		}

		function marcartodo()
		{

			var url = "index.php?controlador=Informes&accion=marcar&tipoInforme="+document.getElementById("selTipoInforme").value+"&idmandante="+document.getElementById("selMandantes").value;
			url = url+"&tipoDoc="+document.getElementById("selTipoDoc").value
			document.getElementById("frmlistinforme").src = url;
		}

		function desmarcartodo()
		{

			var url = "index.php?controlador=Informes&accion=listar&tipoInforme="+document.getElementById("selTipoInforme").value+"&idmandante="+document.getElementById("selMandantes").value;
			url = url+"&tipoDoc="+document.getElementById("selTipoDoc").value
			document.getElementById("frmlistinforme").src = url;
		}

		
		function salir()
		{
			$("#pagina").load('views/defaultl.php');
		}
		
	</script>
</head>
<body>
<form name="frmadminformes">
<input  type="hidden" name="id_tipoinforme" id="id_tipoinforme" value=""/>

<div id="datos" style="">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" bgcolor="#FFFFFF">
    <tr></tr>
    <tr class="cabecera_listado" >
    	
		<th align="center"><font class="titulolistado">Tipo de Informe</font></th>
        <th align="center"><font class="titulolistado">Mandatario</font></th>
        <th align="center"><font class="titulolistado">Tipo Documento</font></th>
    </tr>
   
    <tr>
        <td > 
        	<select name="selTipoInforme" valida="requerido" tipovalida="texto" id="selTipoInforme" onchange="validarUsuario()" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
     			<option value="Judicial"><?print utf8_encode("Judicial")?></option>
     			<option value="Prejudicial"><?print utf8_encode("Prejudicial")?></option>
			</select>
        </td>
        
        <td> 
        	<select name="selMandantes" valida="requerido" tipovalida="texto" id="selMandantes" onchange="validarUsuario()" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" >
     			<option value=""><? print utf8_encode("----Seleccione----") ?></option>
        		<?
			        for($j=0; $j<$colleccionMandantes->get_count(); $j++)
			        {
			            $datoTmp = &$colleccionMandantes->items[$j];
			            echo("<option value=".$datoTmp->get_data("id_mandante").">".utf8_encode($datoTmp->get_data("rut_mandante"))."-".utf8_encode($datoTmp->get_data("dv_mandante"))."  ".utf8_encode($datoTmp->get_data("nombre"))."</option>");           
			        }
    			?>
			</select>
        </td>

        <td> 
                        <select name="selTipoDoc" valida="requerido" tipovalida="texto" id="selTipoDoc" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)">
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
        
        <td>
        <input  type="button" name="btnbuscar" id="btnbuscar" onclick="buscar()"  value="Buscar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
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
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2" width="90%">
	 
        	<iframe id="frmlistinforme" src="index.php?controlador=Informes&accion=listar&tipoInforme="+document.getElementById("selTipoInforme").value width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        	
        </td>
        <td width="10%">
        	<div style="position:relative; margin-left:10px;">
                  <input  type="button" name="btnmarcartodo" id="btnmarcartodo" onclick="marcartodo()"  value="Marcar Todo" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
                  <input  type="button" name="btndesmarcartodo" id="btndesmarcartodo" onclick="desmarcartodo()"  value="Desmarcar Todo" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
                  <input  type="button" name="btngenerar" id="btngenerar" onclick="generar()"  value="Generar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/><br />
            </div>
         </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
</table>
</div>

</form>
</body>
</html>