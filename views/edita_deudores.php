<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script>
    
    <script language="javascript">
	
		
		$(document).ready(function(){
			
  			$('form').validator();
			document.getElementById("txtrut").focus();
			
		});
		
		function limpiarDeudor()
		{
			limpiarCampos();
		}
		
		function editarDir()
		{
			if($.trim($("#id_dir").val()) == "")
			{
				return false;
			}
			
			var datos = "controlador=Deudores";
				datos += "&accion=getdirtmp";
				datos += "&iddir="+$("#id_dir").val();
				alert(datos);
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{
						document.getElementById("txtcalle").value = res[0];
						document.getElementById("txtnumero").value = res[1];
						document.getElementById("txtpiso").value = res[2];
						document.getElementById("txtdepartamento").value = res[3];
						document.getElementById("txtcomuna").value = res[4];
						document.getElementById("txtciudad").value = res[5];
						document.getElementById("txtotros").value = res[6];
						$("#formsoporte").show("slow");
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
		}
		
		function habilitar()
		{
			if(document.getElementById("chkempresa").checked == true) 
			{
				document.getElementById("txtrazonsocial").disabled = false;
			}
			else
			{
				document.getElementById("txtrazonsocial").disabled = true;
			}
		}
		
		function agregarDir()
		{
			$("#id_dir").val("");
			$("#formsoporte").show("slow");
		}
		
		
		function salirGDir()
		{
			$("#formsoporte").hide("slow");
			document.getElementById("txtcalle").value = "";
			document.getElementById("txtnumero").value = "";
			document.getElementById("txtpiso").value = "";
			document.getElementById("txtdepartamento").value = "";
			document.getElementById("txtcomuna").value = "";
			document.getElementById("txtciudad").value = "";
			document.getElementById("txtotros").value = "";
			
			$(document.getElementById("txtcalle")).removeClass('notFilled');
			$(document.getElementById("txtnumero")).removeClass('notFilled');
			$(document.getElementById("txtpiso")).removeClass('notFilled');
			$(document.getElementById("txtdepartamento")).removeClass('notFilled');
			$(document.getElementById("txtcomuna")).removeClass('notFilled');
			$(document.getElementById("txtciudad")).removeClass('notFilled');
			$(document.getElementById("txtotros")).removeClass('notFilled');
		}
		
		function grabarDir()
		{
			
			var arrayin = new Array(6);
			arrayin[0] = document.getElementById("txtcalle");
			arrayin[1] = document.getElementById("txtnumero");
			arrayin[2] = document.getElementById("txtpiso");
			arrayin[3] = document.getElementById("txtdepartamento");
			arrayin[4] = document.getElementById("txtcomuna");
			arrayin[5] = document.getElementById("txtciudad");

			var arraySel = new Array();
			
			if(!validarArray(arrayin, arraySel,"N"))
			{
				return false;
			}
			
			var datos = "controlador=Deudores";
				if($.trim($("#id_dir").val()) == "")
				{
					datos += "&accion=grabardirtmp";
				}
				else
				{
					datos += "&accion=editardirtmp";
					datos += "&iddir="+$("#id_dir").val();
				}
				datos += "&calle="+$("#txtcalle").val();
				datos += "&numero="+$("#txtnumero").val();
				datos += "&piso="+$("#txtpiso").val();
				datos += "&departamento="+$("#txtdepartamento").val();
				datos += "&comuna="+$("#txtcomuna").val();
				datos += "&ciudad="+$("#txtciudad").val();
				datos += "&otros="+$("#txtotros").val();
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#formsoporte").hide("slow");
						document.getElementById("frmdireccion").src="index.php?controlador=Deudores&accion=listar_dirtmp";
						document.getElementById("txtcalle").value = "";
						document.getElementById("txtnumero").value = "";
						document.getElementById("txtpiso").value = "";
						document.getElementById("txtdepartamento").value = "";
						document.getElementById("txtcomuna").value = "";
						document.getElementById("txtciudad").value = "";
						document.getElementById("txtotros").value = "";
						
						$(document.getElementById("txtcalle")).removeClass('notFilled');
						$(document.getElementById("txtnumero")).removeClass('notFilled');
						$(document.getElementById("txtpiso")).removeClass('notFilled');
						$(document.getElementById("txtdepartamento")).removeClass('notFilled');
						$(document.getElementById("txtcomuna")).removeClass('notFilled');
						$(document.getElementById("txtciudad")).removeClass('notFilled');
						$(document.getElementById("txtotros")).removeClass('notFilled');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
			
		}
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}
		
		function seleccionado(id)
		{
			$("#id_dir").val(id);
		}
		
		function salirAltaDeudor()
		{
			$("#pagina").load('views/admin_deudores.php');
		}
		
		function grabar()
		{
			var arrayin = new Array(8);
		
			document.getElementById("tipo").value = "";
			var tipo = "";
			if(document.getElementById("chkpersona").checked == true)
			{
				tipo = "P";
			}
			
			if(document.getElementById("chkempresa").checked == true)
			{
				tipo += "E";
				if($.trim($("#txtrazonsocial").val()) == "")
				{
					$("#msj_error_txtrazonsocial").text("Debe ingresar la razon social.");
					setTimeout("$('#msj_error_txtrazonsocial').text('')",3000);
					setTimeout("$('#msj_error_txtrazonsocial').hide()",3000);
					
					return false;
				}
			}
			document.getElementById("tipo").value = tipo;
			
			if($.trim(document.getElementById("tipo").value) == "")
			{
				$("#mensaje").text("Debe indicar si el Deudor es Persona y/o Empresa.");
				setTimeout("$('#mensaje').text('')",3000);
				return false;
			}
			
		
			arrayin[0] = document.getElementById("txtrut");
			arrayin[1] = document.getElementById("txtrut_d");
			//arrayin[2] = document.getElementById("txtrazonsocial");
			arrayin[2] = document.getElementById("txtpapellido");
			//arrayin[4] = document.getElementById("txtsapellido");
			arrayin[3] = document.getElementById("txtpnombre");
			//arrayin[6] = document.getElementById("txtsnombre");
			arrayin[4] = document.getElementById("txtpnombre");
			arrayin[5] = document.getElementById("txtcelular");
			arrayin[6] = document.getElementById("txttelefono");
			arrayin[7] = document.getElementById("txtemail");

			var arraySel = new Array();
			
			if(!validarArray(arrayin, arraySel,"N"))
			{
				return false;
			}
			
			var datos = "controlador=Deudores";
			datos += "&accion=grabaEditar";
			datos += "&iddeudor="+$("#id_deudor").val();
			datos += "&rut="+$("#txtrut").val();
			datos += "&rut_d="+$("#txtrut_d").val();
			datos += "&razonsocial="+$("#txtrazonsocial").val();
			datos += "&papellido="+$("#txtpapellido").val();
			datos += "&sapellido="+$("#txtsapellido").val();
			datos += "&pnombre="+$("#txtpnombre").val();
			datos += "&snombre="+$("#txtsnombre").val();
			datos += "&pnombre="+$("#txtpnombre").val();
			datos += "&celular="+$("#txtcelular").val();
			datos += "&telefono="+$("#txttelefono").val();
			datos += "&email="+$("#txtemail").val();
			datos += "&tipo="+$("#tipo").val();

			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#pagina").load('index.php?controlador=Deudores&accion=admin');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
			
			
		}
	
		function cerrarVentMand()
		{
			$("#selecMandante").slideUp(1000);
		}
	
		function ventanaMandante()
		{
			$("#selecMandante").slideDown(1000);	
			document.getElementById("txtrut_m").focus();
		}
		
		function mostrar(obj)
		{
			var url = "index.php?controlador=Mandantes&accion=listar&pantalla=pdeudor";
			url += "&des_int="+$("#txtrut_m").val();
			url += "&desApel1="+$("#txtpapellido_m").val();
			url += "&desApel2="+$("#txtsapellido_m").val();
			url += "&desNomb1="+$("#txtpnombre_m").val();
			url += "&desNomb2="+$("#txtsnombre_m").val();
			
			document.getElementById("frmmandantes").src = url;
		}
		
		function selMandDeu(id)
		{
			var datos = "controlador=Deudores";
			datos += "&accion=agregarMandSesion";
			datos += "&idmandante="+id;
			
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						document.getElementById("frmmandantes_d").src="index.php?controlador=Deudores&accion=listar_mand_sesion&pantalla=pdeudor_s";
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
		}
		
		function quitarMandDeu(id)
		{
			var datos = "controlador=Deudores";
			datos += "&accion=quitarMandSesion";
			datos += "&idmandante="+id;
			
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						document.getElementById("frmmandantes_d").src="index.php?controlador=Deudores&accion=listar_mand_sesion&pantalla=pdeudor_s";
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
						
					}
				});
		}
		
	</script>
</head>
<body onload="">
<div id="selecMandante" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#f4f4f4" cellpadding="0"> 
    	<tr>
        	<td height="" align="right">
            	<div onclick="cerrarVentMand()" style="cursor:pointer; font-weight:bold; color:#000099;"> cerrar </div>
            </td>
        </tr>
        <tr>
        <th align="left">Seleccionar Mandantes</th>
        </tr>
        <tr>
        <td height="10"> </td>
        </tr>
        <tr>
        	<td height="">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr> 
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_m" id="txtrut_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
                     </tr>
                     <tr>
                        
                        <td width="" align="left" height="15"></td>
                      
                    </tr>
                	<tr>
                        
                        <td width="" align="left" class="etiqueta_form">Primer Apellido:</td>
                        <td width="" align="left" class="etiqueta_form">Segundo Apellido:</td>
                        <td width="" align="left" class="etiqueta_form">Primer Nombre:</td>
                        <td width="70" align="left" class="etiqueta_form">Segundo Nombre:</td>
                    </tr>
                    
                    <tr> 
                        
                        
                        <td align="left"><input type="text" name="txtpapellido_m" id="txtpapellido_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsapellido_m" id="txtsapellido_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>  
                        <td align="left"><input type="text" name="txtpnombre_m" id="txtpnombre_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
                        <td align="left"><input type="text" name="txtsnombre_m" id="txtsnombre_m"  size="40" onkeyup='mostrar(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
        <tr>
        <th align="left">Mandantes disponibles</th>
        </tr>
    	<tr>
        	<td height="">
	             <div id="datos" style="">
            	<iframe id="frmmandantes" src="index.php?controlador=Mandantes&accion=listar&pantalla=pdeudor" scrolling="no" frameborder="0" width="100%" height="100%"></iframe>
                </div>
            </td>
        </tr>
         <tr>
        	<td height="15">
            
            </td>
        </tr>
        <tr>
        <th align="left">Mandantes seleccionados</th>
        </tr>
        <tr>
        	<td height="">
	             <div id="datos" style="">
            	<iframe id="frmmandantes_d" src="index.php?controlador=Deudores&accion=listar_mand_sesion&pantalla=pdeudor_s" scrolling="no" frameborder="0" width="100%" height="100%"></iframe>
                </div>
            </td>
        </tr>
    </table>
    </td>
</tr>
</table>
</div>
<form name="frmadmtipdoc">
<input type="hidden" name="id_deudor" id="id_deudor" value="<? echo($objDeudor->get_data("id_deudor")) ?>" />
<input  type="hidden" name="id_dir" id="id_dir" value=""/>
<input  type="hidden" name="tipo" id="tipo" value=""/>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Editar Deudores</th>
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
	<tr>
		<th align="left">Datos personales</th>
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
                    <td width="70" align="left"  class="etiqueta_form">R.U.T.:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" name="txtrut" id="txtrut" value="<? echo($objDeudor->get_data("rut_deudor")) ?>"  size="40" valida="requerido" tipovalida="entero" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut','txtrut_d')"/>
                    <input type="text" grabar="S" name="txtrut_d" id="txtrut_d" value="<? echo($objDeudor->get_data("dv_deudor")) ?>"  size="2" valida="requerido" tipovalida="texto" maxlength="1" class="input_form_min" disabled="disabled" /><span id="msj_error_txtrut" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left"  class="etiqueta_form">Razon social:</td>
                    <td> 
                    <?
					$disabled = "disabled";
                    if(trim($objDeudor->get_data("tipo")) == "E" || trim($objDeudor->get_data("tipo")) == "PE") 
					{
						$disabled = "";
					}
					?>
                    &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" disabled="disabled" value="<? echo($objDeudor->get_data("razonsocial")) ?>" name="txtrazonsocial" id="txtrazonsocial"  size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtrazonsocial" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left"  class="etiqueta_form">Primer apellido:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" name="txtpapellido" id="txtpapellido" value="<? echo($objDeudor->get_data("primer_apellido")) ?>"  size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtpapellido" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left"  class="etiqueta_form">Segundo apellido:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" name="txtsapellido" id="txtsapellido" value="<? echo($objDeudor->get_data("segundo_apellido")) ?>"  size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtsapellido" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left"  class="etiqueta_form">Primer nombre:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" name="txtpnombre" id="txtpnombre"  value="<? echo($objDeudor->get_data("primer_nombre")) ?>" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtpnombre" class="msjdato_incomp"></span>
                    </td>
                </tr>
                <tr>
                    <td width="150" align="left" class="etiqueta_form">Segundo nombre:</td>
                    <td> &nbsp;&nbsp;&nbsp;<input type="text" grabar="S" name="txtsnombre" id="txtsnombre" value="<? echo($objDeudor->get_data("segundo_nombre")) ?>"  size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtsnombre" class="msjdato_incomp"></span>
                    </td>
                </tr>
            </table>
       	</td>
        <td width="40%">
            <table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">    	
                <tr>
                    <td align="left" colspan="2">
                    	<? 
						$checkedp = "";
						$checkede = "";
						if(trim($objDeudor->get_data("tipo")) == "P" || trim($objDeudor->get_data("tipo")) == "PE") 
						{
							$checkedp = "checked";
						}
						
						if(trim($objDeudor->get_data("tipo")) == "E" || trim($objDeudor->get_data("tipo")) == "PE") 
						{
							$checkede = "checked";
						}
						?>
                    	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="etiqueta_form">
                    				<input type="checkbox" name="chkpersona" id="chkpersona" <? echo($checkedp) ?> onclick="habilitar()" />&nbsp;Persona
                        		</td>
                        	</tr>
                            <tr>
                            	<td class="etiqueta_form">
                    				<input type="checkbox" name="chkempresa" id="chkempresa" <? echo($checkede) ?> onclick="habilitar()"/>&nbsp;Empresa
                        		</td>
                        	</tr>
                        </table>
                    </td>
                </tr>
                 <tr>
                	<td colspan="2" height="15"></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Celular</td>
                    <td><input type="text" grabar="S" name="txtcelular" id="txtcelular"  value="<? echo($objDeudor->get_data("celular")) ?>" size="25" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtcelular" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Tel&eacute;fono</td>
                    <td><input type="text" grabar="S" name="txttelefono" id="txttelefono"  value="<? echo($objDeudor->get_data("telefono_fijo")) ?>" size="25" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txttelefono" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Email</td>
                    <td><input type="text" grabar="S" name="txtemail" id="txtemail" value="<? echo($objDeudor->get_data("email")) ?>"   size="25" valida="requerido" tipovalida="mail" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtemail" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td colspan="2" height="25"></td>
                </tr>
                <tr>
                	<td colspan="2" align="right" >
                    	<input type="button" name="btnMandante" id="btnMandante" value="Mandante" onclick="ventanaMandante()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
                    </td>
                </tr>
            </table>
       	</td>
    <tr>
        <td colspan="2">
        	<span id="mensaje" style="display:none"></span>
         </td>
    </tr>   
 </table>
 </div>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
 <tr>
		<th align="left" height="20"></th>
        <th></th>
        <th></th>
    </tr>
	<tr>
		<th align="left">Dirección</th>
        <th></th>
        <th align="right"><input type="button" name="btnagregardir" id="btnagregardir" title="Agregar Direcci&oacute;n" value="+" onclick="agregarDir()" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'>&nbsp;<input type="button" name="btneditardir" id="btneditardir" title="Editar Direcci&oacute;n" onclick="editarDir()" value="<>" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'></th>
    </tr>
 </table>
 <div id="formsoporte" style=" display:none">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
			<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
            	<tr>
                	<td class="etiqueta_form">Calle</td>
                    <td><input type="text" name="txtcalle" id="txtcalle" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtcalle" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">N&uacute;mero</td>
                    <td><input type="text" name="txtnumero" id="txtnumero" size="40" valida="requerido" tipovalida="entero" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtnumero" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Piso</td>
                    <td><input type="text" name="txtpiso" id="txtpiso" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtpiso" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Departamento</td>
                    <td><input type="text" name="txtdepartamento" id="txtdepartamento" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtdepartamento" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Comuna</td>
                    <td><input type="text" name="txtcomuna" id="txtcomuna" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtcomuna" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Ciudad</td>
                    <td><input type="text" name="txtciudad" id="txtciudad" size="40" valida="requerido" tipovalida="texto" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/><span id="msj_error_txtciudad" class="msjdato_incomp"></span></td>
                </tr>
                <tr>
                	<td class="etiqueta_form">Otros</td>
                    <td><input type="text" name="txtotros" id="txtotros" size="40" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                    	<input type="button" name="btnagregardir" id="btnagregardir" onclick="grabarDir()" value="Grabar" title="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
                        <input type="button" name="btnsalirgdir" id="btnsalirgdir" onclick="salirGDir()" value="Cancelar" title="Cancelar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
                    </td>
                </tr>
            </table>
         </td>
         <td align="center">

         </td>
    </tr>
</table> 
  </div>
  <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<iframe id="frmdireccion" src="index.php?controlador=Deudores&accion=listar_dirtmp" frameborder="0" align="middle" width="100%" height="150" scrolling="auto"></iframe>
         </td>
    </tr>
</table> 
  </div>

 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()"  value="Grabar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>&nbsp;
         	<input  type="button" name="btnlimpiar" id="btnlimpiar" onclick="limpiarDeudor()"value="Limpiar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
            <input  type="button" name="btnsalir" id="btnsalir" onclick="salirAltaDeudor()"value="Cancelar" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' />
         </td>
    </tr>
</table>
</form>
</body>
</html>