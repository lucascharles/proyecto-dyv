<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
    <script src="js/funcionesgral.js" type="text/javascript"></script>

    <script language="javascript">
		$(document).ready(function(){
  			$('form').validator();
			document.getElementById("txtdestipdoc").focus()
		});
		
		function limpiar()
		{
			document.getElementById("txtdestipdoc").value = "";
			document.getElementById("txtdestipdoc").focus()
			$(document.getElementById("txtdestipdoc")).removeClass('notFilled');

		}
		
		function salir()
		{
			$("#pagina").load('views/admin_tipodocumento.php');
		}
		
		function grabar()
		{
			if(!validar("S"))
			{
				return false;
			}
			
		
			if($.trim($("#txtdestipdoc").val()) != "")
			{
				var datos = "controlador=TipoDocumento";
				datos += "&accion=grabar";
				datos += "&des_int="+$("#txtdestipdoc").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#pagina").load('index.php?controlador=TipoDocumento&accion=admin');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
			}
		}
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
	</script>
</head>
<body onload="">
<form name="frmadmtipdoc">
<input  type="hidden" name="id_tip_doc" id="id_tip_doc" value=""/>
<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td width="70" align="left">Descripci&oacute;n:</td>
        <td> &nbsp;&nbsp;&nbsp;<input type="text" name="txtdestipdoc" id="txtdestipdoc"  size="40"  valida="requerido" tipovalida="texto" class="input_form"/><span id="msj_error_txtdestipdoc" class="msjdato_incomp"></span>
        </td>
        <td> </td>
    </tr>
    <tr>
        <td colspan="3">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
 </table>
 </div>
 <div style="position:relative; margin-top:10px;">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()"  value="Grabar" style=""/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiar()"value="Limpiar" style="" />
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salir()"value="Cancelar" style="" />
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>