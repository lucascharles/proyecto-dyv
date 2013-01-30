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

		function imprimirLog()
		{
			window.print();
		}
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
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >	
	<tr class="">
      <td  align="right" colspan="3"><img src="images/print.gif" style="cursor:pointer;" onclick="imprimirLog()" title="Imprimir Log Errores" /></td>  
    </tr>
	<tr class="cabecera_listado">
      <th width="15" align="center"></th>
      <th align="left" colspan="2"><font class="titulolistado">Resultados</font></th>  
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
        <td align="center" colspan="3" height="10">

         </td>
    </tr>
    <tr>
        <td align="left" colspan="3" height="0" class="etiqueta_form">
     	Fecha: <? echo(formatoFecha($logerror->get_data("fecha_hora"),"","")) ?>
         </td>
    </tr>
    <tr>
        <td align="left" colspan="3" height="0" class="etiqueta_form">
		Usuario:&nbsp;<? echo($logerror->get_data("id_usuario")) ?>
         </td>
    </tr>
     <tr>
        <td align="center" colspan="3" height="20">

         </td>
    </tr>
    <tr class="cabecera_listado">
      <th width="15" align="center"></th>
      <th align="left" colspan="2"><font class="titulolistado">Detalles</font></th>  
    </tr>
    <tr class="">
      <td height="10" align="center" colspan="3"></td>
      
    </tr>
     <tr>
        <td align="left" colspan="3" height="15" class="etiqueta_form">
        	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="center" >
    
            	<tr bgcolor="#F3F3F3">
                	<td width="10%" height="15" align="center">
                    	FILA
                    </td>
                    <td width="60%" align="center">
                    	TIPO ERROR
                    </td>
                    <td width="30%" align="center">
                    	ARCHIVO
                    </td>
                </tr>
                        <tr>
                	<td height="5" colspan="3">
                    </td>
                </tr>
    <?
		
		for($j=0; $j<$logerror_det->get_count(); $j++) 
		{
			$datoTmp = &$logerror_det->items[$j];
			$descrip_error = "";
			for($i=0; $i<$coltipoerror->get_count(); $i++) 
			{	
				$datoe = &$coltipoerror->items[$i];
				if($datoTmp->get_data("id_tipo_error") == $datoe->get_data("id"))
				{
					$descrip_error = $datoe->get_data("error");
				}
			}
			?>
            	
                <tr bgcolor="#F3F3F3">
                    <td width="10%"  align="center" height="15">
                    	<font color='#0000FF'><? echo($datoTmp->get_data("fila")); ?></font>
                    </td>
                    <td width="60%" align="center">
                    	<font color='#0000FF'><? echo($descrip_error); ?></font>
                    </td>

                    <td width="30%"  align="center">
                    	<font color='#0000FF'><? echo($datoTmp->get_data("archivo")); ?></font>
                    </td>
                </tr>
                <tr bgcolor="">
                	<td height="5" colspan="3">
                    </td>
                </tr>
                
            <?
			//echo("<br> Fila: <font color='#0000FF'>".$datoTmp->get_data("fila")."</font> | Tipo error: <font color='#0000FF'>".$descrip_error."</font> | Archivo: <font color='#0000FF'>".$datoTmp->get_data("archivo")."</font>");
		}
	?>
    	
    		</table>
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