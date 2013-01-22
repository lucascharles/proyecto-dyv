<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <link id="theme" rel="stylesheet" type="text/css" href="css/general.css" title="theme" />
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>

    <script language="javascript">

		
		function salir()
		{
			window.parent.salir();
		}
		
		function cargar()
		{
			var arraySel = new Array();
			
			if(!validar("N"))
			{
				return false;
			}
			
			document.frmcargamasiva.submit();
			
		}
		
		
	</script>
</head>
<body id="datos">
<form name="frmcargamasiva" action="" method="post" >
<table width="100%" align="center" border="0" cellpadding="10" cellspacing="10" >
	 <tr>
		<td width="70" align="left">Resultados:</td>
        <td align="left"></td>
        <td align="center"> </td>
    </tr>
    <?
    if(is_null($logerror->get_data("id")))
	{
	?>
    <tr>
        <td align="center" colspan="3" height="15">
     	Sin errores   
         </td>
    </tr>
    <?
    }
	else
	{
	?>
    <tr>
        <td align="left" colspan="3" height="0" class="etiqueta_form">
     	Fecha: <? echo($logerror->get_data("fecha_hora")) ?>
         </td>
    </tr>
    <tr>
        <td align="left" colspan="3" height="0" class="etiqueta_form">
		Usuario:&nbsp;<? echo($logerror->get_data("id_usuario")) ?>
         </td>
    </tr>
     <tr>
        <td align="center" colspan="3" height="15">

         </td>
    </tr>
    <tr>
        <td align="left" colspan="3" height="0"  >
     	Detalle   
         </td>
    </tr>
     <tr>
        <td align="left" colspan="3" height="15" class="etiqueta_form">
    <?
		
		for($j=0; $j<$logerror_det->get_count(); $j++) 
		{
			$datoTmp = &$logerror_det->items[$j];
			echo("<br> Fila: ".$datoTmp->get_data("fila")." | Tipo error: ".$datoTmp->get_data("id_tipo_error")." | Archivo: ".$datoTmp->get_data("archivo"));
		}
	?>
    	</td>
    </tr>
    <?
	}
	?>
    <tr>
        <td align="center" colspan="3">
        
         </td>
    </tr>
 </table>


 
</form>
</body>
</html>