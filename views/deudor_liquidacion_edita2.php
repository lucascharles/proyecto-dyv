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
    <script src="js/funcionesgral.js" type="text/javascript"></script>		

    <script language="javascript">
		$(document).ready(function(){

			$("#txtfecha").datepicker({changeYear: true});	
			$("#txtfechavenc").datepicker({changeYear: true});
			$("#txtfechacalculo").datepicker({changeYear: true});
			$("#txtfechainicial").datepicker({changeYear: true});	
			$('form').validator();
			$("#txtfechaRecibido").datepicker({changeYear: true});
			$("#txtfechaprotesto").datepicker({changeYear: true});
			$('form').validator();		
			validaDeudor(); 
			generadvrut('txtrut_deudor','txtdv_deudor'); 
			validarRut('D'); 
			simular_liquidacion();
			calcular();
			repactar();
			noRepactar();
			recalcular();
			calcular();
		});

		var arrayDoc = new Array();
		var arrayDocDias = new Array();
		
		function ventanaBusqueda(op)
		{
	
			if(op == "D")
			{
				$("#selecDeudor").slideDown(1000);	
				document.getElementById("txtrut_d").focus();
			}
			
		}

		function repactar()
		{
			if(document.getElementById("rdestatus_repacta").checked == true)
			{
				$("#formsoporte").show("slow");
				calculadora_prestamo();
			}
		}
	

		function noRepactar()
		{
			if(document.getElementById("rdestatus_no_repacta").checked == true)
			{
				document.getElementById("rdestatus_repacta").value = "";
				$("#formsoporte").hide("slow");
			}
		}
		
		function validaDeudor()
		{
			if($.trim($("#txtrut_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
			}
		}
		function validarRut(tipo)
		{
			var datos = "";
			var rut = "";
			var dv = "";
			if(tipo == "D")
			{
				if($.trim($("#txtrut_deudor").val()) == "" || $.trim($("#txtdv_deudor").val()) == "")
				{
					return false;
				}
				
				if(!validaentero($.trim($("#txtrut_deudor").val())))
				{
					return false;
				}
				if(!validaentero($.trim($("#txtdv_deudor").val())))
				{
					return false;
				}
				
				datos = "controlador=Deudores";
				rut = $("#txtrut_deudor").val();
				dv = $("#txtdv_deudor").val();
			}
			if(tipo == "M")
			{
				if($.trim($("#txtrut_mandante").val()) == "" || $.trim($("#txtdv_mandante").val()) == "")
				{
					return false;
				}
				if(!validaentero($.trim($("#txtrut_mandante").val())))
				{
					return false;
				}
				if(!validaentero($.trim($("#txtdv_mandante").val())))
				{
					return false;
				}
				datos = "controlador=Mandantes";
				rut = $("#txtrut_mandante").val();
				dv = $("#txtdv_mandante").val();
			}
				
			datos += "&accion=validarrut";
			datos += "&tipoval=EXISTE";
			datos += "&rut="+rut;
			datos += "&dv="+dv;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{		
						if(res == 0)
						{
							var mensaje = "";
							
							if(tipo == "D")
							{
								document.getElementById("txtdv_deudor").focus();
								mensaje = "El rut ingresado para el deudor es incorrecto.";
							}
							if(tipo == "M")
							{
								document.getElementById("txtdv_mandante").focus();
								mensaje = "El rut ingresado para el mandante es incorrecto.";
							}
							$("#mensaje").text(mensaje);
							$("#mensaje").show("slow");
							setTimeout("limpiarMensaje()",3000);
						}
						else 
						{
							if(tipo == "D")
							{
								$("#id_deudor").val(res);
							}
							if(tipo == "M")
							{
								$("#id_mandante").val(res);
							}
						}
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		
		function salir()
		{
			$("#pagina").load('views/admin_documentos.php');
		}

		
		//TODO: mostrar docs
		function seleccionadoDeudor(id)
		{
			document.getElementById("id_deudor").value = id;
			buscarDatosDeudor(id);
			simular_liquidacion();
			cerrarVentDeudor();
		}
		
		
		
		function buscarDatosDeudor(id)
		{
			var datos = "controlador=Deudores";
			datos += "&accion=getDatosDeudor";
			datos += "&id_deudor="+id;
				
			$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					dataType: "json",
					success: function(res)
					{		
						$("#txtrut_deudor").val(res[0]);
						$("#txtdv_deudor").val(res[1]);
						
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}

		
		
		function cerrarVentDeudor()
		{
			$("#selecDeudor").slideUp(1000);
			//document.getElementById("frmtipocom").src = "";
		}
		
		function volver()
		{
			if($.trim($("#control_volver").val()) != "")
			{
				$("#pagina").load('index.php?controlador='+$("#control_volver").val()+'&accion='+$("#accion_volver").val()+'&'+$("#param_volver").val()+'='+$("#val_volver").val()+'&estadoGes='+$.trim($("#idestadoges").val())+'&rutM='+$.trim($("#rutM").val()));
			}
			else
			{
				var url = "index.php?controlador=Deudores&accion=admin_liquidaciones";
				if($.trim($("#id_deudor").val()) != "")
				{
					url += '&iddeudor='+$("#id_deudor").val();
					$("#pagina").load(url);
				}
			}
		}
		
		function grabar()
		{		
			if($.trim($("#id_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
				return false;
			}
			
			if($.trim($("#docs").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar Documentos para la simulacion");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
				return false;
			}
			
			var arrayin = new Array();
			arrayin[0] = document.getElementById("txtinteres");
			arrayin[1] = document.getElementById("txtvaloruf");
			arrayin[2] = document.getElementById("txtfecha");
			arrayin[3] = document.getElementById("txttotal");
			arrayin[4] = document.getElementById("txtprotesto");
			arrayin[5] = document.getElementById("txtfechavenc");
			arrayin[6] = document.getElementById("txtdiasatraso");
			arrayin[7] = document.getElementById("txtinteresdiario");
			arrayin[8] = document.getElementById("txtinteresacumulado");
			arrayin[9] = document.getElementById("txthonorarios");
			arrayin[10] = document.getElementById("txttotalsimulacion");
			
			if(document.getElementById("rdestatus_repacta").checked == true)
			{
				arrayin[11] = document.getElementById("txtimporte");
				arrayin[12] = document.getElementById("txtinteresmensual");
				arrayin[13] = document.getElementById("txtcuotascalc");
				arrayin[14] = document.getElementById("txtfechacalculo");
				arrayin[15] = document.getElementById("txtfechainicial");
				arrayin[16] = document.getElementById("txtimpcalc");
				arrayin[17] = document.getElementById("txtpagomensual");
				arrayin[18] = document.getElementById("txtcostoprestamo");
			}
			
			var arraySel = new Array();
				var datos = "controlador=Deudores";
				datos += "&accion=grabar_editaLiquidacion";
				datos += "&deudor="+$("#id_deudor").val();
				datos += "&id_liquidacion="+$("#id_liquidacion").val();
				datos += "&interes="+$("#txtinteres").val();
				datos += "&valoruf="+$("#txtvaloruf").val();
				datos += "&fechasimulacion="+$("#txtfecha").val();
				datos += "&capital="+$("#txttotal").val();
				datos += "&capitalpagado="+$("#txttotalpagado").val();
				datos += "&protesto="+$("#txtprotesto").val();
				datos += "&fechavenc="+$("#txtfechavenc").val();
				datos += "&diasatraso="+$("#txtdiasatraso").val();
				datos += "&interesdiario="+$("#txtinteresdiario").val();
				datos += "&interesacumulado="+$("#txtinteresacumulado").val();
				datos += "&honoraiorsdyv="+$("#txthonorarios").val();
				datos += "&total="+$("#txttotalsimulacion").val();
				datos += "&importeprestamo="+$("#txtimporte").val();
				datos += "&interesmensual="+$("#txtinteresmensual").val();
				datos += "&cuotas="+$("#txtcuotascalc").val();
				datos += "&fechacalculo="+$("#txtfechacalculo").val();
				datos += "&fechapago="+$("#txtfechainicial").val();
				datos += "&imp="+$("#txtimpcalc").val();
				datos += "&pagomensual="+$("#txtpagomensual").val();
				datos += "&costototal="+$("#txtcostoprestamo").val();
				datos += "&costasprocesales="+$("#txtcostasprocesales").val();
				datos += "&porcentajectdo="+$("#txtporcentajectdo").val();
				datos += "&porcentajedyvhonor="+$("#txtporcentaje").val();
				datos += "&docs="+$("#docs").val();
				
				if(document.getElementById("rdestatus_repacta").checked == true)
				{
					datos += "&repacta=S";
				}
				else
				{
					datos += "&repacta=N";
				}
				
				$.ajax({
					url: "index.php",
					type: "GET",	
					data: datos,
					cache: false,
					success: function(res)
					{	
						if($.trim($("#control_volver").val()) != "")
						{
							$("#pagina").load('index.php?controlador='+$("#control_volver").val()+'&accion='+$("#accion_volver").val()+'&'+$("#param_volver").val()+'='+$("#val_volver").val()+'&estadoGes='+$.trim($("#idestadoges").val())+'&rutM='+$.trim($("#rutM").val()));
						}
						else
						{					
							$("#pagina").load('index.php?controlador=Deudores&accion=admin_liquidaciones&iddeudor='+$("#id_deudor").val());
						}
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
					}
				});
		}
		
		function limpiarMensaje()
		{
			$("#mensaje").hide("slow");
			$("#mensaje").text("");
		}


		
		function mostrarDeudor(obj)
		{
			var url = "index.php?controlador=Deudores&accion=listar";
			url += "&rut="+$("#txtrut_d").val()+$("#txtrut_dv").val();
			url += "&p_ape="+$("#txtpapellido").val();
			url += "&s_ape="+$("#txtsapellido").val();
			url += "&p_nom="+$("#txtpnombre").val();
			url += "&s_nom="+$("#txtsnombre").val();
			url += "&id_partida=0";
			document.getElementById("frmlistdeudor").src = url;
		}

		function setIdLiquidacion(id)
		{
			
			$("#id_liquidacion").val(id);
		}

		function simular_liquidacion()
		{
			var url = "index.php?controlador=Deudores&accion=";
			var accion = "";
			var capital = "";
			
			if($.trim($("#id_deudor").val()) == "")
			{
				$("#mensaje").text("Debe seleccionar un Deudor");
				$("#mensaje").show("slow");
				setTimeout("limpiarMensaje()",3000);
				return false;
			}
			
			accion = "liquidacion_documentos";

			url += accion+"&iddeudor="+$("#id_deudor").val();
			url += "&tipoperacion="+$("#tipoperacion").val(); 
			url += "&id_liquidacion="+$("#id_liquidacion").val();
			url += "&idestadoges="+$("#idestadoges").val();

			document.getElementById("frmsubpantalla").src = url;
		}
		
		function quitarDoc(id,monto,fecha,dias,gasto_protesto,v_costas)
		{
			var array = document.getElementById("docs").value.split(",");
			document.getElementById("docs").value = "";
			for(var i=0; i<array.length; i++)
			{
				if(array[i] != id)
				{
					if(document.getElementById("docs").value == "")
					{
						document.getElementById("docs").value = array[i];
					}	
					else
					{
						document.getElementById("docs").value += ","+array[i];
					}
				}
			}
					
			document.getElementById("txttotal").value = monto;
			document.getElementById("txtfechavenc").value = fecha;
			document.getElementById("txtdiasatraso").value = dias;
			document.getElementById("txtprotesto").value = gasto_protesto;
			document.getElementById("txtcostasprocesales").value = v_costas;
			
			// CALCULO INTERES DIARIO
			 
			var interes = ((parseFloat($("#txtinteres").val()) * parseInt(document.getElementById("txttotal").value) ) / 100)/30;
			if(interes == 0)
			{
				$("#txtinteresdiario").val(0);
			}
			else
			{
				$("#txtinteresdiario").val(interes.toFixed(2));
			}
			
			// CALCULO INTERES ACUMULADO 
			var int_acum = interes * parseInt(dias);
			if(int_acum == 0)
			{
				$("#txtinteresacumulado").val(0);
			}
			else
			{
				$("#txtinteresacumulado").val(int_acum);
			}

			//CALCULO DE SIMULACION
			var capital = document.getElementById("txttotal").value;
			var interes = document.getElementById("txtinteresacumulado").value;
			var protesto = document.getElementById("txtprotesto").value;
			var porcentaje = document.getElementById("txtporcentaje").value;
			var honorarios =  Math.ceil((parseInt(capital) + parseFloat(interes) + parseInt(protesto)) * parseInt(porcentaje)/100).toFixed(2);
	
			document.getElementById("txthonorarios").value = honorarios;

			var total = (parseFloat(capital) + parseFloat(interes) + parseInt(protesto) + parseInt(honorarios)).toFixed(2); 
			document.getElementById("txttotalsimulacion").value = total;
		}

		function seleccionado(id,monto,fecha,dias,protesto,v_costas,valordoc)
		{
			if(document.getElementById("docs").value == "")
			{
				document.getElementById("docs").value = id;
			}	
			else
			{
				document.getElementById("docs").value += ","+id;

				document.all['ocul1'].style.display = "none";
				document.all['ocul2'].style.display = "none";
				document.all['ocul3'].style.display = "none";
			}

			document.getElementById("txttotal").value = monto;
			document.getElementById("txtfechavenc").value = fecha;
			document.getElementById("txtdiasatraso").value = dias;
			document.getElementById("txtprotesto").value = protesto;
			if(v_costas == "") v_costas = 0;
				
			document.getElementById("txtcostasprocesales").value = v_costas;

			// CALCULO INTERES DIARIO 
			var v_int = parseFloat($("#txtinteres").val());
	
			var interes = Math.ceil(( valordoc *(v_int/100))/30);
			arrayDoc.push(valordoc);
			
			if(interes == 0)
			{
				document.getElementById("txtinteresdiario").value = "";
			}
			else
			{
				document.getElementById("txtinteresdiario").value = interes; 
			}
			
			// CALCULO INTERES ACUMULADO 
			
			var int_acum = interes * parseInt(dias);

			arrayDocDias.push(dias);
			
			if(int_acum == 0)
			{
				document.getElementById("txtinteresacumulado").value = "";
			}
			else
			{
				document.getElementById("txtinteresacumulado").value = parseInt(document.getElementById("txtinteresacumulado").value)+ int_acum;
			}

			//CALCULO DE SIMULACION
			var capital = document.getElementById("txttotal").value;
			var protesto = document.getElementById("txtprotesto").value;
			var porcentaje = document.getElementById("txtporcentaje").value;
			var acumulado = document.getElementById("txtinteresacumulado").value;
				 
			var vcostas = document.getElementById("txtcostasprocesales").value;
			var total = Math.ceil((parseInt(capital) + parseInt(acumulado) + parseInt(protesto) + parseInt(vcostas)));
			var honorarios = (parseInt(total) * parseInt(porcentaje)/100) ; 
			var total_simulacion = parseInt(total) + parseInt(honorarios);
			
			document.getElementById("txttotalmandante").value = parseInt(total);
			document.getElementById("txthonorarios").value = honorarios;
			document.getElementById("txttotalpagado").value =document.getElementById("txttotalmandante").value;
			document.getElementById("txttotalsimulacion").value = total_simulacion;

			//RECALCULA LA REPACTACION
			repactar();	
		}

		function calculadora_prestamo()
		{
			//CALCULADORA PRESTAMO
			var porcentajectdo = parseInt(document.getElementById("txtporcentajectdo").value);
			var v_total_simulacion = parseInt(document.getElementById("txttotalsimulacion").value);
			var v_honorarios = parseInt(document.getElementById("txthonorarios").value);
			var total_mandante = document.getElementById("txttotalmandante").value;

			var pagocontado = (parseInt(document.getElementById("txttotalsimulacion").value) - parseInt(document.getElementById("txthonorarios").value))*porcentajectdo/100;
			
			document.getElementById("txtpagocontado").value = (parseInt(total_mandante) * parseInt(porcentajectdo)/100);
			
			document.getElementById("txtimporte").value = (parseInt(total_mandante) * (100 - parseInt(porcentajectdo))/100);
			document.getElementById("txtimpcalc").value = 0; 

			var pagomensual = (parseInt($.trim($("#txtimporte").val())) + parseInt($.trim($("#txtimpcalc").val()))) / parseInt($.trim($("#txtcuotascalc").val()));
			document.getElementById("txtpagomensual").value = pagomensual;
			document.getElementById("txtcostoprestamo").value = parseInt(document.getElementById("txtimporte").value)+parseInt(document.getElementById("txtimpcalc").value);
		}


		function actualizar()
		{
			var total = document.getElementById("txtcostoprestamo").value;
			var cuotas = document.getElementById("txtcuotascalc").value;
			var importe_prestamo = 	document.getElementById("txtimporte").value;
			var imp = document.getElementById("txtimpcalc").value;
			var honorarios_repac = document.getElementById("txthonorariosrepac");
			
			document.getElementById("txtpagomensual").value = parseInt(parseInt(importe_prestamo) / parseInt(cuotas));
			document.getElementById("txtcostoprestamo").value = parseInt(importe_prestamo)+parseInt(imp)+parseInt(honorarios_repac);

			var docs = document.getElementsByName("checkdoc[]");
		}

		function calcular()
		{
			var interes;
			var capital;
			var imp = 0;
			var cuotas = document.getElementById("txtcuotascalc").value;	
			
			

			var pago_mensual = (parseInt($.trim($("#txtimporte").val())) + parseInt($.trim($("#txtimpcalc").val()))) / parseInt($.trim($("#txtcuotascalc").val()));
			document.getElementById("txtpagomensual").value = Math.ceil(pago_mensual);
			
			var x = parseInt(document.getElementById("txtimporte").value)+parseInt(document.getElementById("txtimpcalc").value); 
			document.getElementById("txtcostoprestamo").value = x;

			var porcentajectdo = parseInt(document.getElementById("txtporcentajectdo").value);
			var total_mandante = document.getElementById("txttotalmandante").value;
			document.getElementById("txtpagocontado").value = (parseInt(total_mandante) * parseInt(porcentajectdo)/100);

			var saldo_inicial = parseInt(document.getElementById("txtcostoprestamo").value);
			var interes_mensual = document.getElementById("txtinteresmensual").value;
			
			for($i=0; $i<cuotas; $i++)
			{
				interes = Math.ceil((parseInt(saldo_inicial) * parseFloat(interes_mensual))/100);
				capital = parseInt(pago_mensual) - parseInt(interes);
				imp = imp + parseInt(interes);
				saldo_inicial = saldo_inicial - pago_mensual;
			}

			document.getElementById("txtimpcalc").value = imp;

			x = parseInt(document.getElementById("txtimporte").value)+parseInt(document.getElementById("txtimpcalc").value); 
			document.getElementById("txtcostoprestamo").value = x;

			pago_mensual = (parseInt($.trim($("#txtimporte").val())) + parseInt($.trim($("#txtimpcalc").val()))) / parseInt($.trim($("#txtcuotascalc").val()));
			document.getElementById("txtpagomensual").value = Math.ceil(pago_mensual);

			
			var porcentaje = document.getElementById("txtporcentaje").value;
			var vimp = document.getElementById("txtimpcalc").value; 
			var honordyv = document.getElementById("txthonorarios").value; 
			var honordyv_repac = parseInt(honordyv) + (parseInt(vimp)* parseInt(porcentaje)/100);			
			var importe_prestamo = document.getElementById("txtimporte").value; 
			var  pago_contado = document.getElementById("txtpagocontado").value;
			
			document.getElementById("txthonorariosrepac").value = honordyv_repac;			 
			document.getElementById("txttotalpagocont").value = honordyv_repac + parseInt(pago_contado);		
			


			
			var url = "index.php?controlador=Deudores&accion=calcular";
			url += "&txtimporte="+$("#txtimporte").val();
			url += "&txtinteresmensual="+$("#txtinteresmensual").val();
			url += "&txtcuotas="+$("#txtcuotascalc").val();
			url += "&txtfechainicial="+$("#txtfechacalculo").val();
			url += "&txtpagomensual="+$("#txtpagomensual").val();
			url += "&txtnumpagos="+$("#txtcuotascalc").val();
			url += "&txtimp="+$("#txtimpcalc").val();
			url += "&txtcostoprestamo="+$("#txtcostoprestamo").val();

			document.getElementById("frmcalculos").src = url;

						 
		}
	
	
		function calculoAutomatico()
		{
			if($.trim($("#txtimp").val()) == "")
			{
				return false;
			}
			
			
			var costoprestamo = parseInt($.trim($("#txtimporte").val())) + parseInt($.trim($("#txtimp").val()));
			var pagomensual =  (parseInt($.trim($("#txtimporte").val())) + parseInt($.trim($("#txtimp").val()))) / parseInt($.trim($("#txtcuotascalc").val()));
					
			$("#txtcostoprestamo").val(costoprestamo);
			$("#txtpagomensual").val(pagomensual);
			$("#txtnumpagos").val($.trim($("#txtcuotascalc").val()));

			
		}

		function mostrar()
		{
			var importe_prestamo = document.getElementById("txtimporte").value;
			var pago_contado = document.getElementById("txtpagocontado").value;
			var importe_final = parseInt(importe_prestamo) - parseInt(pago_contado);
			$("#txtimporte").val(importe_final);


			if($.trim($("#txtimp").val()) == "")
			{
				imp = 0;
			}
			
			var costoprestamo = parseInt($.trim($("#txtimporte").val())) + parseInt(document.getElementById("txtimpcalc").value);
			var pagomensual =  (parseInt($.trim($("#txtimporte").val())) + parseInt(document.getElementById("txtimpcalc").value)) / parseInt($.trim($("#txtcuotascalc").val()));
					
			$("#txtcostoprestamo").val(costoprestamo);
			$("#txtpagomensual").val(pagomensual);
			$("#txtnumpagos").val($.trim($("#txtcuotascalc").val()));

		}

		var ids=new Array('a1','a2','a3','thiscanbeanything');

		function switchid(id){	
			hideallids();
			showdiv(id);
		}

		function hideallids(){
			//loop through the array and hide each element by id
			for (var i=0;i<ids.length;i++){
				hidediv(ids[i]);
			}		  
		}

		function hidediv(id) {
			//safe function to hide an element with a specified id
			if (document.getElementById) { // DOM3 = IE5, NS6
				document.getElementById(id).style.display = 'none';
			}
			else {
				if (document.layers) { // Netscape 4
					document.id.display = 'none';
				}
				else { // IE 4
					document.all.id.style.display = 'none';
				}
			}
		}

		function showdiv(id) {
			//safe function to show an element with a specified id
				  
			if (document.getElementById) { // DOM3 = IE5, NS6
				document.getElementById(id).style.display = 'block';
			}
			else {
				if (document.layers) { // Netscape 4
					document.id.display = 'block';
				}
				else { // IE 4
					document.all.id.style.display = 'block';
				}
			}
		}



		function recalcular()
		{
			
			var monto = document.getElementById("txttotal").value;


	
			var v_int_acum_orig = parseInt($("#txtinteresacumulado").val());
			var v_int_orig = parseFloat($("#interes_orig").val());
			var v_int = parseFloat($("#txtinteres").val());
			var v_int_d = 0;
			var v_int_acum = 0;
			var v_sum_int = 0;
	
			var v_int_acum_res = 0;

			v_int_acum_res = (v_int_acum_orig * v_int) / v_int_orig ; 	
			$("#txtinteresacumulado").val(v_int_acum_res);
			 
			//CALCULO DE SIMULACION
			var capital = document.getElementById("txttotal").value;
			var protesto = document.getElementById("txtprotesto").value;
			var porcentaje = document.getElementById("txtporcentaje").value;
			var acumulado = document.getElementById("txtinteresacumulado").value;
				 
			var vcostas = document.getElementById("txtcostasprocesales").value;
			if(vcostas == "") vcostas = 0;
			var total = Math.ceil((parseInt(capital) + parseInt(acumulado) + parseInt(protesto) + parseInt(vcostas)));
			var honorarios = (parseInt(total) * parseInt(porcentaje)/100) ; 
			var total_simulacion = parseInt(total) + parseInt(honorarios);
			
			document.getElementById("txttotalmandante").value = parseInt(total);
			document.getElementById("txthonorarios").value = honorarios;
			document.getElementById("txttotalpagado").value =document.getElementById("txttotalmandante").value;
			document.getElementById("txttotalsimulacion").value = total_simulacion;

			var porcentajectdo = document.getElementById("txtporcentajectdo").value;
			var total_mandante = document.getElementById("txttotalmandante").value;
			var pagocontado = (parseInt(document.getElementById("txttotalsimulacion").value) - parseInt(document.getElementById("txthonorarios").value))*porcentajectdo/100;
			
			document.getElementById("txtpagocontado").value = (parseInt(total_mandante) * parseInt(porcentajectdo)/100);

			calculadora_prestamo();
			
		}
		
	</script>
</head>
<body>

<?
//	$protesto = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("protesto"));
	$monto = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("monto"));
	$total = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("total"));
	$fecha_venc = date("d/m/Y"); //(is_null($simulacion)) ? date("d/m/Y") : utf8_decode(formatoFecha($simulacion->get_data("fecha_venc"),"yyyy-mm-dd","dd/mm/yyyy"));
	$diasatraso = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("diasatraso"));
	$interes_diario = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_diario"));
	$interes_acumulado = 0; //(is_null($simulacion)) ? "" : utf8_decode($simulacion->get_data("interes_acumulado"));
	

?>

<?
	$array_doc = "";
	
	if(!is_null($doc_simulacion))
	{
		for($j=0; $j<$doc_simulacion->get_count(); $j++) 
		{
			$dTmp = &$doc_simulacion->items[$j];

			if($array_doc == "")
			{
				$array_doc = $dTmp->get_data("id_documento");
			}
			else
			{
				$array_doc .= ",".$dTmp->get_data("id_documento");
			}
		}
	}
?>
<div id="selecDeudor" style="position:absolute; margin-left:20px; width:95%; margin-top:30px; display:none; z-index:9999;">
	<table cellpadding="10" cellspacing="10" align="center" border="0" width="100%" bgcolor="#FFFFFF">  
    <tr>
    <td>
	<table width="100%" align="center" border="0" bgcolor="#eeeeee" cellpadding="5" cellspacing="5"> 
    	<tr>
        	<td height="" align="right">
            	<div onclick="cerrarVentDeudor()" style="cursor:pointer; font-weight:bold; color:#000099;"> cerrar </div>
            </td>
        </tr>
        <tr>
        <th align="left">Seleccionar Deudor</th>
        </tr>
        <tr>
        <td height="10"> </td>
        </tr>
        <tr>
        	<td height="">
            	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                	<tr> 
                        
                       <td width="" colspan="4" align="left" class="etiqueta_form">Rut:&nbsp;&nbsp; <input type="text" name="txtrut_d" id="txtrut_d"  size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this); generadvrut('txtrut_d','txtrut_dv');" />&nbsp;<input type="text" name="txtrut_dv" id="txtrut_dv"  size="2" onkeyup='mostrarDeudor(this)'  class="input_form_min" disabled="disabled"/></td>
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
                        <td align="left"> <input type="text" name="txtpapellido" id="txtpapellido" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsapellido" id="txtsapellido" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>  
                        <td align="left"><input type="text" name="txtpnombre" id="txtpnombre" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                        <td align="left"><input type="text" name="txtsnombre" id="txtsnombre" value="" size="20" onkeyup='mostrarDeudor(this)' class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)"/></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
        <tr>
        <th align="left">Deudores disponibles</th>
        </tr>
    	<tr>
        	<td height="">
            	
	             <div id="datos" style="">
            	<iframe name="frmlistdeudor" id="frmlistdeudor" src="index.php?controlador=Deudores&accion=listar&id_partida=0" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>
                </div>
            </td>
       </tr>
        <tr>
        	<td height="15">
            
            </td>
        </tr>
    </table>
    </td>
</tr>
</table>
</div>
<form name="frmadmdocumentos">

<input type="hidden" name="monto_documento_sim" id="monto_documento_sim" value="0" />
<input type="hidden" name="fecha_sim" id="fecha_sim" value="" />
<input grabar="S" type="hidden" name="id_documento" id="id_documento" value=""/>
<input grabar="S" type="hidden" name="id_mandante" id="id_mandante" value=""/>
<input grabar="S" type="hidden" name="id_deudor" id="id_deudor" value="<?=$liquidacion->get_data("id_deudor")?>"/>
<input grabar="S" type="hidden" name="id_liquidacion" id="id_liquidacion" value="<?=$liquidacion->get_data("id_liquidacion")?>"/>
<input grabar="S" type="hidden" name="docs" id="docs" value="<?=$array_doc?>"/>
<input type="hidden" name="control_volver" id="control_volver" value="<? echo($control_volver) ?>" />
<input type="hidden" name="accion_volver" id="accion_volver" value="<? echo($accion_volver) ?>" />
<input type="hidden" name="param_volver" id="param_volver" value="<? echo($param_volver) ?>" />
<input type="hidden" name="val_volver" id="val_volver" value="<? echo($val_volver) ?>" />
<input type="hidden" name="idestadoges" id="idestadoges" value="<? echo($idestadoges) ?>" />
<input type="hidden" name="intacum" id="intacum" value="0" />
<input type="hidden" name="rutM" id="rutM" value="<? echo($rutM) ?>" />
<input type="hidden" name="interes_orig" id="interes_orig" value="<?=conDecimales($liquidacion->get_data("interes"))?>" />



<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Editar Liquidacion</th>
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
		<th align="left">Deudor</th>
        <th></th>
        <th></th>
    </tr>
 </table>

<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" size="20">
	 <tr>
        <td colspan="4" height="5">

         </td>
    </tr> 
    <tr>
		<td width="70" align="left" class="etiqueta_form">&nbsp;Deudor:</td>
        <td> 
        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="240">
						<input type="text" name="txtrut_deudor" id="txtrut_deudor" class="input_form" onblur="validaDeudor(); generadvrut('txtrut_deudor','txtdv_deudor'); validarRut('D'); simular_liquidacion();" value="<?=$deudor->get_data("rut_deudor")?>" onkeyup='mostrarDocs(this)' disabled="disabled"/>&nbsp;
	            		<input type="text" name="txtdv_deudor" id="txtdv_deudor" class="input_form_min" onblur="" disabled="disabled" />&nbsp;
                    </td>
                	<td align="left" colspan="8">
			            <input type="text" name="txtnombre_deudor" id="txtnombre_deudor" class="input_form" onblur="" value ="<?=$deudor->get_data("primer_apellido")." ".$deudor->get_data("segundo_apellido")." ".$deudor->get_data("primer_nombre")?>" disabled="disabled" />&nbsp;
                    </td>

                </tr>
             </table>
        </td>
		
    </tr>
     <tr>
        <td colspan="4" height="10">

         </td>
    </tr>   
    
         <tr>
        <td colspan="4" height="5">

         </td>
    </tr> 
    
    <tr>
        <td colspan="4">
        	<span id="mensaje" style="display:none" ></span>
         </td>
    </tr>   
 </table>
 </div>

<div style="height:500px; width:100%; overflow:scroll;">
 
<div id="datos" style="">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Simulacion</th>
        <th></th>
        <th></th>
    </tr>
 </table>
</div>
<div id="datos" style=" width:100%">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

	<tr>
		<td colspan="5">
        	<iframe id="frmsubpantalla" src="index.php?controlador=Deudores&accion=liquidacion_documentos&iddeudor=0&tipoperacion=A&id_liquidacion=0" width="100%" align="middle" height="170" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>

	<tr>
        <td colspan="1" align="right" valign="top">
        	<table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">			
                <tr>
                    
                    <td align="right" class="etiqueta_form">Fecha:&nbsp; </td>
                    <td align="left">
                        <input type="text" name="txtfecha" id="txtfecha" class="input_form_medio" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<?=formatoFecha($liquidacion->get_data("fecha_simulacion"),"yyyy-mm-dd","dd/mm/yyyy")?>" valida="requerido" tipovalida="fecha" onKeyUp="this.value=formateafecha(this.value)"/>
                    </td>
                </tr>
                <tr>  
                    <td align="right" class="etiqueta_form">% Interes:&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteres" id="txtinteres" value="<?=conDecimales($liquidacion->get_data("interes"))?>" class="input_form_medio" onFocus="resaltar(this)" onBlur="recalcular()" valida="requerido" tipovalida="moneda" />
                    </td>  
                </tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">% Honorarios D&V:&nbsp;</td>
                    <td align="left">
                    <input type="text" name="txtporcentaje" id="txtporcentaje"  value="<?=$liquidacion->get_data("honorarios_dyv_porcentaje") ?>"   class="input_form_medio" onFocus="resaltar(this)" onBlur="recalcular()" valida="requerido" />
                    </td>
                </tr>

             </table>
        </td>
        <td colspan="1" align="left" valign="top">   
            <table cellpadding="5" cellspacing="5" border="0" align="center" width="100%">			
                <tr>  
                    <td align="right" class="etiqueta_form">Capital&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txttotal" id="txttotal" valida="requerido" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($liquidacion->get_data("capital"))?>" />
                    </td>  
                    
                    <td align="right" class="etiqueta_form">Capital pagado&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txttotalpagado" id="txttotalpagado"  tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<? echo($liquidacion->get_data("capital_pagado"))?>" />
                    </td>
                    
                </tr>
                <tr>
                    <td align="right" class="etiqueta_form">Protesto&nbsp; </td>
                    <td align="left">
                        <input type="text" name="txtprotesto" id="txtprotesto" class="input_form" onFocus="resaltar(this)" onblur=""  value="<?=$protesto?>" />
                    </td>                                   
                </tr>

                <tr>   
                    <td align="right" class="etiqueta_form">Interes Acumulado&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtinteresacumulado" id="txtinteresacumulado" valida="requerido" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<?=$liquidacion->get_data("interes_acumulado") ?>"/>
                    </td>
                </tr>
                <tr>   
                    <td align="right" class="etiqueta_form">Costas Procesales&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txtcostasprocesales" id="txtcostasprocesales" tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onblur="recalcular()" value="<?=$liquidacion->get_data("costas_procesales") ?>"/>
                    </td>
                </tr>
                <tr>   
                    <td align="right" class="etiqueta_form">Total Mandante&nbsp;</td>
                    <td align="left">
                        <input type="text" name="txttotalmandante" id="txttotalmandante"  tipovalida="moneda" class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<?= $liquidacion->get_data("capital")+$liquidacion->get_data("interes_acumulado")+$liquidacion->get_data("protesto") ?>"/>
                    </td>
					<td align="right" class="etiqueta_form">Honorarios DyV&nbsp;</td>
					<td align="left"><input type="text" name="txthonorarios" id="txthonorarios" size="15" class="input_form" onFocus="resaltar(this)" value="<?=$liquidacion->get_data("honorarios_dyv") ?>" tabindex="7" valida="requerido" tipovalida="moneda"/>
        			</td>
        			
				</tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">Total&nbsp;</td>
                     <td align="left">
                    	<?
							$repacta = "";
							$norepacta = "";
                        	if($liquidacion->get_data("repacta") == "S")
							{
								$repacta = "checked='checked'";
								$norepacta = "";
							}
							else
							{
								$norepacta = "checked='checked'";
								$repacta = "";
							}
						?>
                        <input type="text" name="txttotalsimulacion" id="txttotalsimulacion"  class="input_form" onFocus="resaltar(this)" onBlur="noresaltar(this)" value="<?=$liquidacion->get_data("total_simulacion")?>" />
                        <input type="radio" value="S" onclick="repactar()" name="rdestatus_repacta" id="rdestatus_repacta" <?=$repacta?>/>&nbsp;Repacta&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio"  value="N" onclick="noRepactar()" name="rdestatus_repacta" id="rdestatus_no_repacta" <?=$norepacta?> />&nbsp;No Repacta
                    </td>
                </tr>
<!--				<tr>-->
<!--					<td align="left">-->
<!--                        <input type="radio" value="S" onclick="repactar(this)" name="rdestatus_repacta" id="rdestatus_repacta" />&nbsp;Repacta&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                    </td>-->
<!--                    <td align="left">-->
<!--                        <input type="radio"  value="N" onclick="noRepactar(this)" name="rdestatus_repacta" id="rdestatus_no_repacta" checked="checked" />&nbsp;No Repacta-->
<!--                    </td>    -->
<!--                </tr> -->
                 
            </table>
		</td>
     </tr>
     <tr>
     	<td height="40"></td>
     </tr>
 </table>
</div>
 <div id="formsoporte" style=" display:none"> 
 <div id="datos" style="">
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="titulopantalla">
	<tr>
		<th align="left" height="30">&nbsp;Calculadora Prestamo</th>
        <th></th>
        <th></th>
    </tr>
 </table>
 </div>
 
<div id="datos" style=" width:100%">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="5">
    <tr>
    	<td>
        	<table cellpadding="5" cellspacing="5" border="0" align="left" >
            	<tr>
					<td align="left" class="etiqueta_form">Importe del prestamo&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtimporte" id="txtimporte" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="<?=$liquidacion->get_data("importe_prestamo")?>" tabindex="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td align="left">
                    <input  type="button" name="btncalcular" id="btncalcular" onclick="calcular()"  value="Calcular" class="boton_form" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)' tabindex="10" />
        			</td>
				</tr>
                <tr>                                     
                    <td align="right" class="etiqueta_form">% Pago Ctdo.:&nbsp;</td>
                    <td align="left">
                    <input type="text" name="txtporcentajectdo" id="txtporcentajectdo"  value="<? $var = $liquidacion->get_data("porcentaje_contado"); if($var == ""){echo("0");}else{echo($var);} ?>"   class="input_form_medio" onFocus="resaltar(this)" onBlur="recalcular()" valida="requerido" />
                    </td>
                </tr>

				<tr>	
					<td align="left" class="etiqueta_form">Pago Contado&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtpagocontado" id="txtpagocontado" size="15" onkeyup='mostrar()' class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="<?=conDecimales($interes_simulacion)?>" tabindex="2"/></td>

					<td align="right" class="etiqueta_form">Honorarios DyV&nbsp;</td>
					<td align="left"><input type="text" name="txthonorariosrepac" id="txthonorariosrepac" size="15" class="input_form" onFocus="resaltar(this)" value="" tabindex="7" valida="requerido" tipovalida="moneda"/></td>

					<td align="right" class="etiqueta_form">Total Pago Contado&nbsp;</td>
					<td align="left"><input type="text" name="txttotalpagocont" id="txttotalpagocont" size="15" class="input_form" onFocus="resaltar(this)" value="" tabindex="7" valida="requerido" tipovalida="moneda"/></td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Interes mensual&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtinteresmensual" id="txtinteresmensual" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="<? $var = $liquidacion->get_data("interes_mensual"); if($var == ""){$var = $interes_simulacion;} echo($var); ?>" tabindex="2"/>
        			</td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Cuotas&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtcuotascalc" id="txtcuotascalc" size="15" class="input_form" onblur="actualizar()" onFocus="resaltar(this)" valida="requerido" tipovalida="entero" value="<? $var = $liquidacion->get_data("cuotas");  if($var == ""){$var = $cuotas_simulacion;} echo($var); ?>" tabindex="3"/>
        			</td>        			
        		</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Fecha Calculo&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtfechacalculo" id="txtfechacalculo" size="15" class="input_form_medio" onFocus="resaltar(this)" value="<? $var = formatoFecha($liquidacion->get_data("fecha_calculo"),"yyyy-mm-dd","dd/mm/yyyy");  if($var == ""){$var =  $fecha_pago;} echo($var); ?>" valida="requerido" tipovalida="fecha" tabindex="4" onKeyUp="this.value=formateafecha(this.value)"/>
        			</td>        			
        		</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Fecha Pago&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtfechainicial" id="txtfechainicial" size="15" class="input_form_medio" onFocus="resaltar(this)" value="<? $var = formatoFecha($liquidacion->get_data("fecha_pago"),"yyyy-mm-dd","dd/mm/yyyy");  if($var == ""){$var =  $fecha_pago;} echo($var); ?>" valida="requerido" tipovalida="fecha" tabindex="4" onKeyUp="this.value=formateafecha(this.value)"/>
        			</td>        			
        		</tr>

                <tr>	
					<td align="left" class="etiqueta_form">IMP&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtimpcalc" id="txtimpcalc" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="<?=$liquidacion->get_data("imp")?>" onblur="calculoAutomatico()" tabindex="5"/>
        			</td>        			
				</tr>
        		<tr>
					<td align="left" class="etiqueta_form">Pago Mensual&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtpagomensual" id="txtpagomensual" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="" tabindex="6"/>
        			</td>
				</tr>
				<tr>	
					<td align="left" class="etiqueta_form">Costo total prestamo&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left"><input type="text" name="txtcostoprestamo" id="txtcostoprestamo" size="15" class="input_form" onFocus="resaltar(this)" valida="requerido" tipovalida="moneda" value="<?=$liquidacion->get_data("costo_total")?>" tabindex="8"/>
        			</td>        			
        		</tr>
        		<tr>	
					<td align="left" class="etiqueta_form">
        				
        			</td>
        		</tr>
             </table>
        </td>
    </tr>		
    <tr>
        <td>
        	<span id="mensaje_prestamo" style="display:none"></span>
         </td>
    </tr>    
     <tr>
		<td colspan="3">
        	<iframe id="frmcalculos" src="" width="100%" align="middle" height="250" scrolling="auto" frameborder="0"></iframe>
        </td>
    </tr>
 </table>
 </div>
 </div>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3" align="center">
        	<input  type="button" name="btngrabar" id="btngrabar" onclick="grabar()" class="boton_form" value="Grabar" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
		<td colspan="3" align="center">
        	<input  type="button" name="btnvolver" id="btnvolver" onclick="volver()" class="boton_form" value="Volver" onMouseOver='overClassBoton(this)' onMouseOut='outClassBoton(this)'/>
        </td>
    </tr>
</table>
</form>
<!--</div>-->
</body>
</html>