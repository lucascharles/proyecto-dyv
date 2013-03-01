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
		
		
	</script>
</head>
<body>
<form name="frmadmtipdoc">
<input  type="hidden" name="id_tip_doc" id="id_tip_doc" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Carga Masiva Documentos</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 	</td>
</tr>
<tr>
	<td>
         <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <th align="left" height="10"></th>
                <th></th>
                <th></th>
            </tr>
         </table>
	</td>
</tr>
<tr>
	<td>  
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td colspan="3" align="center">
        	<iframe id="frmlisttipdoc" src="index.php?controlador=Documentos&accion=cargam_upload" width="98%" align="middle" height="220" scrolling="no" frameborder="0" style="background-color:#CCCCCC;" allowtransparency="false" ></iframe>
        </td>
    </tr>

</table>
</div>
	</td>
</tr>
</table>
</form>
</body>
</html>