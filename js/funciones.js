// JavaScript Document


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