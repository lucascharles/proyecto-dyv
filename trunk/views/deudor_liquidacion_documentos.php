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

	function selecciona_demandas()
	{
		var boxes = document.getElementsByName("checkbox");
		var vid="";
		var vmonto="";
		var vfecha_protesto="";
		var vgasto_protesto="";
		
//		alert('SELECCIONA DEMANDAS');
		for (var i = 0; i < boxes.length; i++) {
			if(boxes[i].getAttribute('estado') == 'DEMANDA')
			{
				boxes[i].checked = true;
				
				vid = boxes[i].getAttribute('id');
				vmonto = boxes[i].getAttribute('monto');
				vfecha_protesto = boxes[i].getAttribute('fecha_protesto');
				if(vfecha_protesto==""){
//					alert('fecha_doc='+boxes[i].getAttribute('fecha_doc'));
					vfecha_protesto=boxes[i].getAttribute('fecha_doc');
				}
				vgastos_protesto = boxes[i].getAttribute('gasto_protesto');
				
				seleccionado2(vid,vmonto,vfecha_protesto,vgasto_protesto);
			}
		}
	}
	
	function selecciona_existencias()
	{
		var boxes = document.getElementsByName("checkbox");
		var vid="";
		var vmonto="";
		var vfecha_protesto="";
		var vgasto_protesto="";
		
		for (var i = 0; i < boxes.length; i++) {
			if(boxes[i].getAttribute('estado') == 'EXISTENCIA')
			{
				boxes[i].checked = true;
				
				vid = boxes[i].getAttribute('id');
				vmonto = boxes[i].getAttribute('monto');
				vfecha_protesto = boxes[i].getAttribute('fecha_protesto');
				if(vfecha_protesto==""){
					vfecha_protesto=boxes[i].getAttribute('fecha_doc');
				}
				vgastos_protesto = boxes[i].getAttribute('gasto_protesto');
				
				seleccionado2(vid,vmonto,vfecha_protesto,vgasto_protesto);
			}
		}
	}

	
	function seleccionado2(id,monto,fecha,gastos)
		{
			
				var v_monto = 0;
				var valor_doc = 0;
				var v_costas_proc = 0;
				var v_dias = 0;
				var v_fecha = "";	
				var v_protesto = 0;
				//var arraydoc = document.getElementsByTagName('input');
				var arraydoc = document.getElementsByName("checkbox");
				for(var i=0; i<arraydoc.length; i++)
				{	 
					if(arraydoc[i].getAttribute('type') == "checkbox")
					{
						if(arraydoc[i].checked == true)
						{
							//v_monto = v_monto + parseFloat(monto);
							 v_monto = v_monto + parseFloat(arraydoc[i].getAttribute('monto'));

//							alert(arraydoc[i].getAttribute('monto'));

							//valor_doc = parseFloat(monto);
							valor_doc = parseFloat(arraydoc[i].getAttribute('monto'));
							
							if(gastos!="")
								v_costas_proc = v_costas_proc + parseFloat(gastos);
							
							if(gastos == "") {
								gastos = 0;
							}
								v_protesto = v_protesto + parseInt(gastos);

							v_fecha = fecha;
							
							if(v_fecha == "")
							{
								v_fecha = fecha; // arraydoc[i].getAttribute('fecha_protesto');
							}
						}
					}
				}	

//				v_protesto = v_protesto - parseInt(gastos);
				
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
					window.parent.quitarDoc(id,v_monto,v_fecha,v_dias,v_protesto,v_costas_proc);
				}
				else
				{
					//alert('id='+id+' monto='+v_monto+' v_fecha='+v_fecha+'v_dias='+v_dias +'v_protesto='+v_protesto +'costas_proc='+v_costas_proc+'valor_doc='+valor_doc);
					window.parent.seleccionado(id,v_monto,v_fecha,v_dias,v_protesto,v_costas_proc,valor_doc);
				}

		}

	
	
	function seleccionado(id,monto,fecha,gastos)
		{
			
				var v_monto = 0;
				var valor_doc = 0;
				var v_costas_proc = 0;
				var v_dias = 0;
				var v_fecha = "";	
				var v_protesto = 0;
				//var arraydoc = document.getElementsByTagName('input');
				var arraydoc = document.getElementsByName("checkbox");
				for(var i=0; i<arraydoc.length; i++)
				{	 
					if(arraydoc[i].getAttribute('type') == "checkbox")
					{
						if(arraydoc[i].checked == true)
						{
							v_monto = v_monto + parseFloat(arraydoc[i].getAttribute('monto'));
							valor_doc = parseFloat(arraydoc[i].getAttribute('monto'));
							
							if(arraydoc[i].getAttribute('costas')!="")
								v_costas_proc = v_costas_proc + parseFloat(arraydoc[i].getAttribute('costas'));
							
							if(gastos == "") {
								gastos = 0;
							}

							//if(arraydoc[i].getAttribute('gastos') != "" || arraydoc[i].getAttribute('gastos') != 0){
								v_protesto = v_protesto + parseInt(arraydoc[i].getAttribute('gasto_protesto'));
//								alert(parseInt(arraydoc[i].getAttribute('gasto_protesto')));
							//}

							v_fecha = arraydoc[i].getAttribute('fecha_doc');
							
							if(v_fecha == "")
							{
								v_fecha = arraydoc[i].getAttribute('fecha_protesto');
							}
						}
					}
				}	

//				v_protesto = v_protesto - parseInt(gastos);
				
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
					window.parent.quitarDoc(id,v_monto,v_fecha,v_dias,v_protesto,v_costas_proc);
				}
				else
				{
					//alert('id='+id+' monto='+v_monto+' v_fecha='+v_fecha+'v_dias='+v_dias +'v_protesto='+v_protesto +'costas_proc='+v_costas_proc);
					window.parent.seleccionado(id,v_monto,v_fecha,v_dias,v_protesto,v_costas_proc,valor_doc);
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
        <th align="center" width="5%"><font class="titulolistado">D</font><input type="checkbox" name="check_dem" value="" onclick="selecciona_demandas()" ><font class="titulolistado">E</font><input type="checkbox" name="check_ext" value="" onclick="selecciona_existencias()" ></th>
		<th align="center" width="10%"><font class="titulolistado">Nro.Doc.</font></th>
        <th align="center" width="10%"><font class="titulolistado">Nro.Ficha</font></th>
        <th align="center" width="10%"><font class="titulolistado">Fecha Venc.</font></th>
		<th align="center" width="8%"><font class="titulolistado">Monto</font></th>
		<th align="center" width="8%"><font class="titulolistado">Estado</font></th>
        <th align="center" width="9%"><font class="titulolistado">Fecha Protesto</font></th>
        <th align="center" width="9%"><font class="titulolistado">Gastos Protesto</font></th>
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
    	<td><input type="checkbox" name="checkbox" estado="<?php echo ($datoTmp->get_data("estado")) ?>" monto="<?php echo ($datoTmp->get_data("monto")) ?>" costas="<?php echo ($datoTmp->get_data("costas")) ?>" gasto_protesto="<?php echo ($datoTmp->get_data("gasto_protesto")) ?>" fecha_protesto="<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?>" fecha_doc="<?php  echo (formatoFecha($datoTmp->get_data("fecha_vencimiento"),"yyyy-mm-dd","dd/mm/yyyy"))?>" id="<? echo($datoTmp->get_data("id_documento")) ?>" name="checkdoc_sim" value="" onclick="seleccionado(<? echo($datoTmp->get_data("id_documento")) ?>,<? echo($datoTmp->get_data("monto")) ?>,'<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?>',<? echo($datoTmp->get_data("gasto_protesto")) ?>)" <? echo($checked) ?>></td>	
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("numero_documento")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("id_ficha")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo (formatoFecha($datoTmp->get_data("fecha_vencimiento"),"yyyy-mm-dd","dd/mm/yyyy")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("monto")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("estado")) ?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php  echo (formatoFecha($datoTmp->get_data("fecha_protesto"),"yyyy-mm-dd","dd/mm/yyyy"))?></td>
		<td align="left" class="dato_lista">&nbsp;&nbsp;<?php echo ($datoTmp->get_data("gasto_protesto")) ?></td>
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