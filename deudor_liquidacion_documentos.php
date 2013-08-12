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
    <link rel="stylesheet" href="css/general.css" type="text/css" />
 	<script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="js/validacampos.js" type="text/javascript"></script>
  	<script src="js/funciones.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="js/i18n/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
    <script language="javascript">
		$(document).ready(function(){
			$("#txtfecha").datepicker();	
			$("#txtfechavenc").datepicker();	
			$('form').validator();
			setParametro("interes_diario_normal","txtinteres");
			setParametro("valor_uf","txtvaloruf");
		});
		
	</script>
    <script language="javascript"> 

		function seleccionado(id,monto,fecha)
		{
			if(monto == "")
			{
				monto = 0;
			}
			if(fecha == "")
			{
				alert(document.getElementById("fecha_sim").value);
				fecha = document.getElementById("fecha_sim").value;
			}

			var v_monto = 0;
			var v_dias = 0;
			var v_fecha = "";	
			var arraydoc = document.getElementsByTagName('input');
			for(var i=0; i<arraydoc.length; i++)
		 	{	 
				if(arraydoc[i].getAttribute('type') == "checkbox")
				{
	  			 	if(arraydoc[i].checked == true)
   				 	{
	  			 		v_monto = v_monto + parseFloat(arraydoc[i].getAttribute('monto'));
						
						if(v_fecha == "")
						{
							v_fecha = arraydoc[i].getAttribute('fecha_doc');
						}
						else
						{
							if (Date.parse(arraydoc[i].getAttribute('fecha_doc')) > Date.parse(v_fecha)) 
							{
								v_fecha = arraydoc[i].getAttribute('fecha_doc');
							}
						}
		 			}
				}
			}	
			// CALCULO CANTIDAD DIAS ATRASO
			var dias = 0;
			if(v_fecha != "" && v_fecha != "//00/00/00")
			{
				var d1 = v_fecha.split("/");
				var dat1 = new Date(d1[2], parseFloat(d1[1])-1, parseFloat(d1[0]));
				var d2 = $('#fecha_sim').val().split("/");
				var dat2 = new Date(d2[2], parseFloat(d2[1])-1, parseFloat(d2[0]));
 
				var fin = dat2.getTime() - dat1.getTime();
				dias = Math.floor(fin / (1000 * 60 * 60 * 24));  
 				v_dias = dias;
			}
			else
			{
				v_dias = parseInt("0");
			}
			
			window.parent.seleccionado(id,v_monto,v_fecha,v_dias);
		}
    
		
		
		function simular()
		{
			if($.trim($("#id_documento_sim").val()) == "")
			{
				return false;
			}
			
			//recuperarBanco();
			$("#txtmonto").val($("#monto_documento_sim").val());
			$("#txttotal").val($("#monto_documento_sim").val());
			
		}
		
		function recuperarBanco()
		{
			var datos = "controlador=Documentos&accion=get_datos_banco&id_doc="+$("#id_documento_sim").val();
			$.ajax({
				url: "index.php",
				type: "GET",
				data: datos,
				cache: false,
				//dataType: "json",
				success: function(res)
				{	
					$("#txtprotesto").val(res);
				},
				error: function()
				{
					$("#mensaje").text("Ha ocurrido un error y no se ha podido recuperar informacion del Banco.");
					setTimeout("$('#mensaje').text('');",3000);
					
				}
			});	
		}
		
		function setParametro(param,control)
		{
			var datos = "controlador=Parametros&accion=get_parametro&nom_param="+param;
			$.ajax({
				url: "index.php",
				type: "GET",
				data: datos,
				cache: false,
				success: function(res)
				{	
					$("#"+control).val(res);
				},
				error: function()
				{
					$("#mensaje").text("Ha ocurrido un error y no se ha podido recuperar Parametros.");
					setTimeout("$('#mensaje').text('');",3000);
					
				}
			});	
		}
		
		function limpiarSimulacion()
		{
			var array_doc = document.getElementsByTagName('input');

			for(var i=0; i<array_doc.length; i++)
			{
				if(array_doc[i].getAttribute("type") == "checkbox")
				{
					array_doc[i].checked = false;
				}
			}
			
			$("#txtprotesto").val("");
			$("#txtmonto").val("");
			$("#txttotal").val("");
			$("#txtfechavenc").val("");
			$("#txtdiasatraso").val("");
			$("#txtinteresdiario").val("");
			$("#txtinteresacumulado").val("");
		}
		
		function grabarSimulacion()
		{	
			/*
			if(!validar("N"))
			{
				return false;
			}
			*/
			var datos = "controlador=Deudores&accion=grabarSimulacion";
			datos += "&id_deudor="+$("#id_deudor").val();
			datos += "&id_mandante="+$("#id_mandante").val();
			datos += "&id_liquidacion="+$("#id_liquidacion").val();
			datos += "&txtprotesto="+$("#txtprotesto").val();
			datos += "&txtmonto="+$("#txtmonto").val();
			datos += "&txttotal="+$("#txttotal").val();
			datos += "&txtfechavenc="+$("#txtfechavenc").val();
			datos += "&txtdiasatraso="+$("#txtdiasatraso").val();
			datos += "&txtinteresdiario="+$("#txtinteresdiario").val();
			datos += "&txtinteresacumulado="+$("#txtinteresacumulado").val();
			
			var array_doc = document.getElementsByTagName('input');
			var array_param = new Array();
			var j = 0;
			for(var i=0; i<array_doc.length; i++)
			{
				if(array_doc[i].getAttribute("type") == "checkbox")
				{	
					if(array_doc[i].checked == true)
					{	
						array_param[j] = array_doc[i].id;
						j++;
					}
				}
			}
			datos += "&docs="+array_param.toString();
			
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{	
						
						$("#id_liquidacion").val(res);
						window.parent.setIdLiquidacion(res);
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido recuperar informacion del Banco.");
						setTimeout("$('#mensaje').text('');",3000);
					}
				});
		}
	</script>
</head>
<body>
<?
	$protesto = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("protesto"));
	$monto = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("monto"));
	$total = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("total"));
	$fecha_venc = (is_null($simulacion)) ? date("d/m/Y") : utf8_decode(formatoFecha($simulacion->get_data("fecha_venc"),"yyyy-mm-dd","dd/mm/yyyy"));
	$diasatraso = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("diasatraso"));
	$interes_diario = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_diario"));
	$interes_acumulado = (is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_acumulado"));
	
	$array_doc = array();
	
	if(!is_null($doc_simulacion))
	{
		for($j=0; $j<$doc_simulacion->get_count(); $j++) 
		{
			$dTmp = &$doc_simulacion->items[$j];

			$array_doc[] = $dTmp->get_data("id_documento");
		}
	}
?>
<form name="frmsim" >

<input type="hidden" name="monto_documento_sim" id="monto_documento_sim" value="0" />
<input type="hidden" name="fecha_sim" id="fecha_sim" value="<?php  echo(date("d/m/Y"));?>" />
<input type="hidden" name="id_deudor" valida="requerido" tipovalida="entero" id="id_deudor" value="<? echo($idddeudor) ?>" />
<input type="hidden" name="id_mandante" valida="requerido" tipovalida="entero"  id="id_mandante" value="<? echo($idmandante) ?>" />
<input type="hidden" name="id_liquidacion" valida="requerido" tipovalida="entero" id="id_liquidacion" value="<? echo($id_liquidacion) ?>" />

<div id="datos" style=" overflow:auto; height:150px; width:99%;">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
	<tr class="cabecera_listado" >
        <th align="center" width="5%"></th>
        <th align="center" width="10%"><font class="titulolistado">Nro.Doc.</font></th>
        <th align="center" width="10%"><font class="titulolistado">Fecha Recibido</font></th>
		<th align="center" width="8%"><font class="titulolistado">Monto</font></th>
		<th align="center" width="8%"><font class="titulolistado">Estado</font></th>
        <th align="center" width="9%"><font class="titulolistado">Fecha Protesto</font></th>
        <th align="center" width="8%"><font class="titulolistado">Tipo Doc.</font></th>
    </tr>
	<?php
	
	for($j=0; $j<$colleccionDoc->get_count(); $j++) 
	{
		$datoTmp = &$colleccionDoc->items[$j];
		$checked = "";
		if(in_array($datoTmp->get_data("id_documento"),$array_doc))
		{
			$checked = "checked";
		}
	?>
	<tr bgcolor="#FFFFFF">
    	<td><input type="checkbox" monto="<?php echo ($datoTmp->get_data("monto")) ?>" fecha_doc="<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?>" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checkdoc_sim" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_documento")) ?>,<? echo($datoTmp->get_data("monto")) ?>,'<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"dd-mm-yyyy","dd/mm/yyyy"))?>')" <? echo($checked) ?>></td>	
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_siniestro"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"dd-mm-yyyy","dd/mm/yyyy"))?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("tipo_documento")) ?></td>
	</tr>
	<?php
	}
	?>
</table>
</div>

</form>
</body>
</html>