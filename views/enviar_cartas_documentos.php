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
    <!--<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>-->
    <script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
  	<script src="js/funciones.js" type="text/javascript"></script>
    
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
    <script language="javascript">
		$(document).ready(function(){
			$("#txtdesde").datepicker();	
			$("#txthasta").datepicker();	
		});
	</script>

    <script language="javascript">

    	var arrayCheck;
    
		function mostrar(obj)
		{
			var url = "index.php?controlador=Documentos&accion=listar&des_int="+obj.value;
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function limpiar()
		{
			document.getElementById("txtdesde").value = "";
			document.getElementById("txthasta").value = "";
		}
		
		function buscar()
		{
			var url = "index.php?controlador=Documentos&accion=listar&des_int="+document.getElementById("txtrut").value;
			url += "&desApel1="+document.getElementById("txtPrimerApel").value;
			url += "&desApel2="+document.getElementById("txtSegundoApel").value;
			url += "&desNomb1="+document.getElementById("txtPrimerNomb").value;
			url += "&desNomb2="+document.getElementById("txtSegundoNomb").value;
			document.getElementById("frmlistdocumentos").src = url;
		}
		
		function seleccionado(id)
		{
			document.getElementById("id_documento").value = id;			
		}
		
		
		
		function salir()
		{
			$("#pagina").load('views/default.php');
		}
				
		function enviar()
		{
			documentos = document.getElementById("id_documento").value;
			arrD = documentos.split(" ");
			var url = "index.php?controlador=Documentos&accion=generarcarta";
			for(var i=1; i<arrD.length; i++) {
				var value = arrD[i];
				url = url + "&arr"+i+"="+value;
			}
			document.getElementById("frmlistdocumentos").src = url;	
		}

		function marcar()
		{
			if((document.getElementById("txtdesde").value != "")&&(document.getElementById("txthasta").value != ""))
			{
				var url = "index.php?controlador=Documentos&accion=marcardocs&desde="+document.getElementById("txtdesde").value;
				url += "&hasta="+document.getElementById("txthasta").value;
				document.getElementById("frmlistdocumentos").src = url;
			}
			
		}

		
	</script>
</head>
<body>
<form name="frmadmdocumentos">
<input  type="hidden" name="id_documento" id="id_documento" value=""/>

 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Enviar Cartas</th>
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
 </table>
<div id="buscador" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	 <tr>
		<td width="20" align="left" class="etiqueta_form">Desde:</td>
        <td align="left">&nbsp; <input type="text" name="txtdesde" id="txtdesde"  size="40" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
        
        <td width="40" align="left" class="etiqueta_form">Hasta:</td>
        <td align="left">&nbsp;<input type="text" name="txthasta" id="txthasta"  size="40"  class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
     </tr>
	<tr>      
        <td align="right" colspan="4"> 
        <input type="button" name="btnmarcar" id="btnmarcar" onclick="marcar()"  value="Marcar" onclick="marcar()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         <input  type="button" name="btnenviar" id="btnenviar" onclick="enviar()"  value="Enviar" onclick="enviar()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
          <input  type="button" name="btnlimpiar" id="btnlimpiar" value="Limpiar" onclick="limpiar()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/></td>
    </tr>
    <tr>
		<td></td>
        <td> </td>
        <td>
        	
         </td>
    </tr>
 </table>
 </div>
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="2">
        	<iframe id="frmlistdocumentos" src="index.php?controlador=Documentos&accion=listarcartas" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>
    <tr>
		<td colspan="3" align="right">
        
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"  value="salir" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
         </td>
    </tr>
</table>
</form>
</body>
</html>