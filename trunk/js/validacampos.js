function trimAll(sString) 
{
	while (sString.substring(0,1) == ' ')
	{
		sString = sString.substring(1, sString.length);
	}

	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
		sString = sString.substring(0,sString.length-1);
	}

	return sString;
}


function removerClase(obj)
{
	if($(obj).val() != "")
	{
		$(obj).removeClass('notFilled');
	}
}

function printmensajeval(obj)
{
	$("#msj_error_"+obj.id).text("Campo requerido");
	$("#msj_error_"+obj.id).show("slow");
	setTimeout("$('#msj_error_"+obj.id+"').hide('slow');",3000);
	setTimeout("$('#msj_error_"+obj.id+"').text('');",4000);
}


function validarArray(arrayInputS, arraySelectS, mensaje)
{
	var arrayInput = arrayInputS; //document.getElementsByTagName('input');
	var arraySelect = arraySelectS; //document.getElementsByTagName('select');
	var obj;
	var primero = 0;
	var result = true;
	
	//alert(arrayInput.length);
	//alert(arrayInput[4].id+" / "+arrayInput[4].getAttribute("valida")+" / "+arrayInput[4].getAttribute("class"));
	 for(var i=0; i<arrayInput.length; i++)
	 {	 
	 	var resultado = true;
  		 if(arrayInput[i].getAttribute('valida') == "requerido")
   		 {
			 /*
			alert("hay para validar");
			alert("condicion: "+arrayInput[i].getAttribute('condicion')+" / tipovalida: "+arrayInput[i].getAttribute('tipovalida'));
			*/
			if(arrayInput[i].getAttribute('condicion') != null)
			{
				if(document.getElementById(""+arrayInput[i].getAttribute('condicion')).checked == true)
				{
					if(arrayInput[i].getAttribute('tipovalida') != null)
					{
						if(arrayInput[i].getAttribute('tipovalida') == "texto")
						{
							if(!validatexto($(arrayInput[i]).val()))
							{
								resultado = false;
							}
						}
					}
				}
			}
			else
			{
				if(arrayInput[i].getAttribute('tipovalida') != null)
				{
					if(arrayInput[i].getAttribute('tipovalida') == "texto")
					{
						//alert("valida el texto");
						if(!validatexto($(arrayInput[i]).val()))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "mail")
					{
						if(!validamail($(arrayInput[i]).val()))
						{
							resultado = false;
						}
					}
				}
			}
			
			if(resultado == false)
			{
				var clase = $(arrayInput[i]).attr("class");// arrayInput[i].getAttribute("class");
				//alert(arrayInput[4].getAttribute("name")+" | class: "+arrayInput[4].getAttribute("class")+" | clase_ant: "+clase);
				/*
				if(i == 4)
				{
					alert(arrayInput[i].getAttribute("name")+" | class: "+arrayInput[i].getAttribute("class")+" | clase_ant: "+clase);
				}
				*/
				$(arrayInput[i]).removeClass(clase);
				
				if(clase == "input_form" || clase == "resalta")
				{
					$(arrayInput[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min")
				{
					$(arrayInput[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio")
				{
					$(arrayInput[i]).addClass('notFilled_medio');
				}
				if(mensaje == "S")
				{
					printmensajeval(arrayInput[i]);
				}
				if(primero == 0)
				{
					obj = arrayInput[i];
					primero = 1;
				}

				//alert(arrayInput[i].getAttribute("name")+"["+i+"] | class: "+arrayInput[i].getAttribute("class")+" | clase_ant: "+clase);

			}
   		}
  	}
	
	 for(var i=0; i<arraySelect.length; i++)
	 {	 
	 	var resultado = true;
  		 if(arraySelect[i].getAttribute('valida') == "requerido")
   		 {
			 
			if(arraySelect[i].getAttribute('condicion') != null)
			{
				//alert("( con condicion ) name: "+arraySelect[i].name+" / value: "+arraySelect[i].value);
				//alert("condicion: "+document.getElementById(""+arraySelect[i].getAttribute('condicion')).checked);
				//alert($(arraySelect[i]).val());
				if(document.getElementById(""+arraySelect[i].getAttribute('condicion')).checked == true)
				{
					//alert("tipovalida: "+arraySelect[i].getAttribute('tipovalida'));
					if(arraySelect[i].getAttribute('tipovalida') != null)
					{
						if(arraySelect[i].getAttribute('tipovalida') == "texto")
						{
							//alert("(en el validaddor)name: "+arraySelect[i].name+" / value: "+arraySelect[i].value);
							if(!validatexto($(arraySelect[i]).val()))
							{
								resultado = false;
							}
						}
					}
				}
			}
			else
			{
				if(arraySelect[i].getAttribute('tipovalida') != null)
				{
					if(arraySelect[i].getAttribute('tipovalida') == "texto")
					{
						//alert("name: "+arraySelect[i].name+" / value: "+arraySelect[i].value);
						if(!validatexto($(arraySelect[i]).val()))
						{
							//alert("si no tiene pasa por aca");
							resultado = false;
						}
					}
					/*
					if(arraySelect[i].getAttribute('tipovalida') == "mail")
					{
						if(!validamail($(arraySelect[i]).val()))
						{
							resultado = false;
						}
					}
					*/
				}
			}
			//alert("resultado: "+resultado);
			
			if(resultado == false)
			{
				$(arraySelect[i]).removeClass(clase);
				if(clase == "input_form" || clase == "resalta")
				{
					$(arraySelect[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min")
				{
					$(arraySelect[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio")
				{
					$(arraySelect[i]).addClass('notFilled_medio');
				}
				if(mensaje == "S")
				{
					printmensajeval(arraySelect[i]);
				}
				if(primero == 0)
				{
					obj = arraySelect[i];
					primero = 1;
				}
			}
   		}
  	}
	
	
	if(primero != 0)
	{
		obj.focus();
		
		result = false;
	}
	
	return result;
}

function validar(mensaje)
{
	var arrayInput = document.getElementsByTagName('input');
	var arraySelect = document.getElementsByTagName('select');
	var obj;
	var primero = 0;
	var result = true;
	
	//alert(arrayInput.length);
	
	 for(var i=0; i<arrayInput.length; i++)
	 {	 
	 	var resultado = true;
  		 if(arrayInput[i].getAttribute('valida') == "requerido")
   		 {
			 /*
			alert("hay para validar");
			alert("condicion: "+arrayInput[i].getAttribute('condicion')+" / tipovalida: "+arrayInput[i].getAttribute('tipovalida'));
			*/
			if(arrayInput[i].getAttribute('condicion') != null)
			{
				if(document.getElementById(""+arrayInput[i].getAttribute('condicion')).checked == true)
				{
					if(arrayInput[i].getAttribute('tipovalida') != null)
					{
						if(arrayInput[i].getAttribute('tipovalida') == "texto")
						{
							if(!validatexto($(arrayInput[i]).val()))
							{
								resultado = false;
							}
						}
					}
				}
			}
			else
			{
				if(arrayInput[i].getAttribute('tipovalida') != null)
				{
					if(arrayInput[i].getAttribute('tipovalida') == "texto")
					{
						//alert("valida el texto");
						if(!validatexto($(arrayInput[i]).val()))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "mail")
					{
						if(!validamail($(arrayInput[i]).val()))
						{
							resultado = false;
						}
					}
				}
			}
			
			if(resultado == false)
			{	
				var clase = arrayInput[i].getAttribute("class");
				$(arrayInput[i]).removeClass(clase);
				if(clase == "input_form" || clase == "resalta")
				{
					$(arrayInput[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min")
				{
					$(arrayInput[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio")
				{
					$(arrayInput[i]).addClass('notFilled_medio');
				}
				if(mensaje == "S")
				{
					printmensajeval(arrayInput[i]);
				}
				if(primero == 0)
				{
					obj = arrayInput[i];
					primero = 1;
				}
			}
   		}
  	}
	
	 for(var i=0; i<arraySelect.length; i++)
	 {	 
	 	var resultado = true;
  		 if(arraySelect[i].getAttribute('valida') == "requerido")
   		 {
			 
			if(arraySelect[i].getAttribute('condicion') != null)
			{
				//alert("( con condicion ) name: "+arraySelect[i].name+" / value: "+arraySelect[i].value);
				//alert("condicion: "+document.getElementById(""+arraySelect[i].getAttribute('condicion')).checked);
				//alert($(arraySelect[i]).val());
				if(document.getElementById(""+arraySelect[i].getAttribute('condicion')).checked == true)
				{
					//alert("tipovalida: "+arraySelect[i].getAttribute('tipovalida'));
					if(arraySelect[i].getAttribute('tipovalida') != null)
					{
						if(arraySelect[i].getAttribute('tipovalida') == "texto")
						{
							//alert("(en el validaddor)name: "+arraySelect[i].name+" / value: "+arraySelect[i].value);
							if(!validatexto($(arraySelect[i]).val()))
							{
								resultado = false;
							}
						}
					}
				}
			}
			else
			{
				if(arraySelect[i].getAttribute('tipovalida') != null)
				{
					if(arraySelect[i].getAttribute('tipovalida') == "texto")
					{
						//alert("name: "+arraySelect[i].name+" / value: "+arraySelect[i].value);
						if(!validatexto($(arraySelect[i]).val()))
						{
							//alert("si no tiene pasa por aca");
							resultado = false;
						}
					}
					
					if(arraySelect[i].getAttribute('tipovalida') == "mail")
					{
						if(!validamail($(arraySelect[i]).val()))
						{
							resultado = false;
						}
					}
				}
			}
			//alert("resultado: "+resultado);
			
			if(resultado == false)
			{

				var clase = arraySelect[i].getAttribute("class");
				$(arraySelect[i]).removeClass(clase);
				if(clase == "input_form" || clase == "resalta")
				{
					$(arraySelect[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min")
				{
					$(arraySelect[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio")
				{
					$(arraySelect[i]).addClass('notFilled_medio');
				}
				if(mensaje == "S")
				{
					printmensajeval(arraySelect[i]);
				}
				if(primero == 0)
				{
					obj = arraySelect[i];
					primero = 1;
				}
			}
   		}
  	}
	
	
	if(primero != 0)
	{
		obj.focus();
		
		result = false;
	}
	
	return result;
}

function validatexto(val)
{
	//alert(val);
	var result = true;
	
	if(trimAll(val) == "")
	{
		result = false;
	}
	return result;
}

function validamail(val)
{
	var result = true;
	
	var valor = val;
	var minimo = 0;
	for(a=0; a < valor.length; a++)
	{
		switch(valor.charAt(a))
		{
			case "@": minimo++; break;
			case ".": minimo++; break;
		}
	}
	
	if(minimo<2)
	{
		result = false;
	}
	
	return result;
}
/*
(function($){
  $.fn.validator = function(opts){
    $(this).find('.notFilled').live('keyup', function(){
      if($(this).val()!=""){
		  
          $(this).removeClass('notFilled');
      }
    });
  };
})(jQuery);

*/

(function($){
  $.fn.validator = function(opts){
	  
	var clase = "notFilled";
	var clasep = "input_form";
	
	// PARA IMPUT LARGO
    $(this).find(".notFilled").live('keyup', function(){
		clase = "notFilled";
		clasep = "resalta";
		
      if($(this).val()!=""){
		  
          $(this).removeClass(clase);
		  $(this).addClass(clasep);
		  
      }
    });
	
	// PARA INPUT MEDIO
	$(this).find(".notFilled_medio").live('keyup', function(){
	

		clase = "notFilled_medio";
		clasep = "resalta_medio";

      if($(this).val()!=""){
		  
          $(this).removeClass(clase);
		  $(this).addClass(clasep);
		  
      }
    });
	
	// PARA INPUT CORTO
	$(this).find(".notFilled_min").live('keyup', function(){
	

		clase = "notFilled_min";
		clasep = "resalta_min";
	
	
      if($(this).val()!=""){
		  
          $(this).removeClass(clase);
		  $(this).addClass(clasep);
		  
      }
    });
  };
})(jQuery);
