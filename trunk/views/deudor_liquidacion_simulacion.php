<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
     <link rel="stylesheet" href="css/general.css" type="text/css" />
    <script language="javascript"> 
		function seleccionado(id)
		{
			window.parent.seleccionado(id);
		}
		
	</script>
</head>
<body>



<div id="datos" style="">
	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
		<td colspan="2" width="90%">
        	<iframe id="frmlistdocumentos" src="index.php?controlador=Documentos&accion=listarDocDeudor&idd=<?php $datoTmp = &$iddeudor->items[0]; echo($datoTmp); ?>&id_partida=0" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
    	</td>
	</table>
</div>


<div id="datos" style="">
	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
		<td colspan="2" width="90%">
        	<iframe id="frmliquidadocumentos" src="index.php?controlador=Deudores&accion=liquidacion_documentos&iddoc=0" width="100%" align="middle" height="220" scrolling="auto" frameborder="0"></iframe>
    	</td>
	</table>
</div>
</body>
</html>