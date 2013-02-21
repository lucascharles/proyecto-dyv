// JavaScript Document

function getParametrosArray(arrayInputS)
{
	var arrayInput = arrayInputS; 
	var urlp = "";
	var val = "";
		
	 for(var i=0; i<arrayInput.length; i++)
	 {	
	 	val = "";
	 	if(arrayInput[i].getAttribute('grabar') == "S")
   		{
			val = arrayInput[i].value;
			if(arrayInput[i].getAttribute('tipovalida') == "moneda")
			{
				if($.trim($(arrayInput[i]).val()) == "")
				{
					val = 0;
				}
			}
					
			if(urlp == "")	
			{
				urlp = arrayInput[i].getAttribute('name')+"="+val;
			}
			else
			{
				urlp += "&"+arrayInput[i].getAttribute('name')+"="+val;
			}
		}
	 }
	 
	 return urlp;
}

function getParametros()
{
	var arrayInput = document.getElementsByTagName('input');
	var arraySelect = document.getElementsByTagName('select');
	
	var urlp = "";
		
	 for(var i=0; i<arrayInput.length; i++)
	 {	
	 	val = "";
	 	if(arrayInput[i].getAttribute('grabar') == "S")
   		{
			val = arrayInput[i].value;
			if(arrayInput[i].getAttribute('tipovalida') == "moneda")
			{
				if($.trim($(arrayInput[i]).val()) == "")
				{
					val = 0;
				}
			}
			
			if(urlp == "")	
			{
				urlp = arrayInput[i].getAttribute('name')+"="+val;
			}
			else
			{
				urlp += "&"+arrayInput[i].getAttribute('name')+"="+val;
			}
		}
	 }
	 
	 for(var i=0; i<arraySelect.length; i++)
	 {	
	 	if(arraySelect[i].getAttribute('grabar') == "S")
   		{
			if(urlp == "")	
			{
				urlp = arraySelect[i].getAttribute('name')+"="+arraySelect[i].value;
			}
			else
			{
				urlp += "&"+arraySelect[i].getAttribute('name')+"="+arraySelect[i].value;
			}
		}
	 }
	 
	 return urlp;
}


function limpiarCampos()
{
	var arrayInput = document.getElementsByTagName('input');
	var arraySelect = document.getElementsByTagName('select');

	
	 for(var i=0; i<arrayInput.length; i++)
	 {	
	 	if(arrayInput[i].getAttribute('grabar') == "S")
   		{
			//alert(arrayInput[i].getAttribute('name')+"("+arrayInput[i].getAttribute("class")+")");
			arrayInput[i].value = "";
			var clase = arrayInput[i].getAttribute("class");
			
			if($.trim(clase) == "notFilled")
			{
				$(arrayInput[i]).removeClass(clase);
				$(arrayInput[i]).addClass('input_form');
			}
			if($.trim(clase) == "notFilled_min")
			{
				$(arrayInput[i]).removeClass(clase);
				$(arrayInput[i]).addClass('input_form_min');
			}
			if($.trim(clase) == "notFilled_medio")
			{
				$(arrayInput[i]).removeClass(clase);
				$(arrayInput[i]).addClass('input_form_medio');
			}
		}
	 }
	 
	 for(var i=0; i<arraySelect.length; i++)
	 {	
	 	if(arraySelect[i].getAttribute('grabar') == "S")
   		{
			arraySelect[i].selectedIndex = 0;
			var clase = $.trim(arraySelect[i].getAttribute("class"));
			
			
			if($.trim(clase) == "notFilled")
			{
				$(arraySelect[i]).removeClass(clase);
				$(arraySelect[i]).addClass('input_form');
			}
			if($.trim(clase) == "notFilled_min")
			{
				$(arraySelect[i]).removeClass(clase);
				$(arraySelect[i]).addClass('input_form_min');
			}
			if($.trim(clase) == "notFilled_medio")
			{
				$(arraySelect[i]).removeClass(clase);
				$(arraySelect[i]).addClass('input_form_medio');
			}
		}
	 }
}

function resaltar(obj)
{
	if($(obj).attr("class") != "notFilled" && $(obj).attr("class") != "notFilled_medio" && $(obj).attr("class") != "notFilled_min")
	{
		if($(obj).attr("class") == "input_form")
		{
			$(obj).removeClass('input_form');
			$(obj).addClass('resalta');
		}
		
		if($(obj).attr("class") == "input_form_medio")
		{
			$(obj).removeClass('input_form_medio');
			$(obj).addClass('resalta_medio');
		}
		
		if($(obj).attr("class") == "input_form_min")
		{
			$(obj).removeClass('input_form_min');
			$(obj).addClass('resalta_min');
		}
	}
}

function noresaltar(obj)
{
	if($(obj).attr("class") != "notFilled" && $(obj).attr("class") != "notFilled_medio" && $(obj).attr("class") != "notFilled_min")
	{
		if($(obj).attr("class") == "resalta")
		{
			$(obj).removeClass('resalta');
			$(obj).addClass('input_form');
		}
		
		if($(obj).attr("class") == "resalta_medio")
		{
			$(obj).removeClass('resalta_medio');
			$(obj).addClass('input_form_medio');
		}
		
		if($(obj).attr("class") == "resalta_min")
		{
			$(obj).removeClass('resalta_min');
			$(obj).addClass('input_form_min');
		}
		
	}
}

function overClassBoton(obj)
{
	$(obj).removeClass('boton_form');
	$(obj).addClass('boton_form_brillante');
	
}

function outClassBoton(obj)
{

	$(obj).removeClass('boton_form_brillante');
	$(obj).addClass('boton_form');

}

function overClassBotonMenu(obj)
{
	$(obj).removeClass('boton_form');
	$(obj).addClass('boton_form_brillante');
}

function outClassBotonMenu(obj)
{
	if($(obj).attr("seleccionado") == "S")
	{ 
		return false;
	}
	$(obj).removeClass('boton_form_brillante');
	$(obj).addClass('boton_form');
}

function salirSistema()
{
	var datos = "controlador=Index";
	datos += "&accion=logoff";
				
				$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						window.location = "index.php";
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
}

function cambiarClave()
{
		$("#pagina").load('index.php?controlador=Usuario&accion=cambia_clave');
		/*
	var datos = "controlador=Usuario";
	datos += "&accion=cambia_clave";
				
	$.ajax({
					url: "index.php",
					type: "GET",
					data: datos,
					cache: false,
					success: function(res)
					{
						$("#pagina").load('index.php?controlador=Deudores&accion=alta');
					},
					error: function()
					{
						$("#mensaje").text("Ha ocurrido un error y no se ha podido agregar el registro.");
						setTimeout("$('#mensaje').text('')",3000);
					}
				});
	*/
}