<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
     <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
    <script language="javascript">

		$(document).ready(function(){
			
  			$('form').validator();
			document.getElementById("txtclave").focus();			
		});
		
		function salirCambioClave()
		{
			$("#pagina").load('views/default.php');
		}
		
		function validarClave(campo)
		{
			var resp = false;
			
			if(campo == "clave")
			{
				if($("#txtclave").val() == "")
				{
					$("#msj_error_txtclave").show();
					$("#msj_error_txtclave").text("No se permite campo vacio");
				}
				else
				{
					if($("#txtclave").val().length < 4)
					{
						$("#msj_error_txtclave").show();
						$("#msj_error_txtclave").text("Debe ingresar 4 o mas caracteres");
					}
					else
					{
						$("#msj_error_txtclave").hide();
						resp = true;
					}
				}
			}
			
			if(campo == "clave_confirm")
			{
				if($("#txtclaveconfirm").val() == "")
				{
					$("#msj_error_txtclaveconfirm").show();
					$("#msj_error_txtclaveconfirm").text("No se permite campo vacio");
				}
				else
				{
					if($("#txtclaveconfirm").val().length < 4)
					{
						$("#msj_error_txtclaveconfirm").show();
						$("#msj_error_txtclaveconfirm").text("Debe ingresar 4 o mas caracteres");
					}
					else
					{
						if($("#txtclave").val() != $("#txtclaveconfirm").val())
						{
							$("#clave_confirm_error").show();
							$("#msj_error_txtclaveconfirm").text("Confirmacion incorrecta");
						}
						else
						{
							$("#msj_error_txtclaveconfirm").hide();
							resp = true;
						}
					}
				}
			}
			
			return resp;
		}
		
		function grabarCambioClave()
		{
			if(validarClave("clave"))
			{
				if(validarClave("clave_confirm"))
				{				
					var datos = "controlador=Usuario";
					datos += "&accion=graba_cambio_clave";
					datos += "&nueva="+$("#txtclaveconfirm").val();
							
					$.ajax({
						url: "index.php",
						type: "GET",
						data: datos,
						cache: false,
						success: function(res)
						{							
							$("#mensaje").text("La clave se cambió con éxito.");
							setTimeout("$('#pagina').load('views/default.php')",3000);
						},
						error: function()
						{
							$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
							setTimeout("$('#mensaje').text('')",3000);
						}
					});
				}
			}
			
		}
		


		
	</script>
</head>
<body onload="">

<form name="frmcambioclave">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th align="left">Cambio Clave</th>
        <th></th>
        <th></th>
    </tr>
 </table>
<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="60%">
            <table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">    	
                <tr>
                    <td width="150" align="left"  class="etiqueta_form">Usuario apellido:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" name="txtnomape" id="txtnomape" value="<? echo($usuario->get_data("nom_usuario")." ".$usuario->get_data("ape_usuario")) ?>"  size="40" disabled="disabled" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtnomape" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left"  class="etiqueta_form">Login:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" name="txtlogin" id="txtlogin" value="<? echo($usuario->get_data("id_usuario")) ?>"  size="40" valida="requerido" tipovalida="texto" disabled="disabled" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtlogin" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left"  class="etiqueta_form">Clave:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="password" name="txtclave" id="txtclave"  value="" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); validarClave('clave')"/><span id="msj_error_txtclave" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left" class="etiqueta_form">Confirmar Clave:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="password" name="txtclaveconfirm" id="txtclaveconfirm" value="" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); validarClave('clave_confirm')"/><span id="msj_error_txtclaveconfirm" class="msjdato_incomp"></span>
                    </td>
                </tr>
            </table>
       	</td>
    </tr>
    <tr>
        <td colspan="2">
        	<span id="mensaje"></span>
         </td>
    </tr>   
 </table>
 </div>
 <div style="position:relative; margin-top:10px;">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabarCambioClave()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salirCambioClave()"value="Cancelar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
         </td>
    </tr>
</table>
</div>
</form>
</body>
</html>