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
	<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
    <script language="javascript"> 

		function seleccionado(id,monto,fecha)
		{
			
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
	
				if(document.getElementById(id).checked == false)
				{
					window.parent.quitarDoc(id,v_monto,v_fecha,v_dias);
				}
				else
				{
					window.parent.seleccionado(id,v_monto,v_fecha,v_dias);
				}

		}
    

		

	
		
		
		
		
	</script>
</head>
<body>
<?

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
    	<td><input type="checkbox" monto="<?php echo ($datoTmp->get_data("monto")) ?>" fecha_doc="<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?>" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checkdoc_sim" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_documento")) ?>,<? echo($datoTmp->get_data("monto")) ?>,'<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?>')" <? echo($checked) ?>></td>	
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_siniestro"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?></td>
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