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

							if(!validatexto($.trim($(arrayInput[i]).val())))
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
						if(!validatexto($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "mail")
					{
						if(!validamail($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "moneda")
					{
						if(!validamoneda($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "fecha")
					{
						if(!validafecha($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "entero")
					{
						if(!validaentero($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
				}
			}
			
			if(resultado == false)
			{
				var clase = $.trim($(arrayInput[i]).attr("class"));
				$(arrayInput[i]).removeClass(clase);
				
				if(clase == "input_form" || clase == "resalta" || clase == "notFilled")
				{
					$(arrayInput[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min" || clase == "notFilled_min")
				{
					$(arrayInput[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio" || clase == "notFilled_medio")
				{
					$(arrayInput[i]).addClass('notFilled_medio');
				}
				if(clase == "input_form_medio hasDatepicker" || clase == "resalta_medio" || clase == "notFilled_medio")
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
				if(document.getElementById(""+arraySelect[i].getAttribute('condicion')).checked == true)
				{
					if(arraySelect[i].getAttribute('tipovalida') != null)
					{
						if(arraySelect[i].getAttribute('tipovalida') == "texto")
						{
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
						if(!validatexto($(arraySelect[i]).val()))
						{
							resultado = false;
						}
					}
				}
			}
			
			if(resultado == false)
			{
				$(arraySelect[i]).removeClass(clase);
				if(clase == "input_form" || clase == "resalta" || clase == "notFilled")
				{
					$(arraySelect[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min" || clase == "notFilled_min")
				{
					$(arraySelect[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio" || clase == "notFilled_medio")
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
	
	
	 for(var i=0; i<arrayInput.length; i++)
	 {	 
	 	var resultado = true;
  		 if(arrayInput[i].getAttribute('valida') == "requerido")
   		 {
			if(arrayInput[i].getAttribute('condicion') != null)
			{
				if(document.getElementById(""+arrayInput[i].getAttribute('condicion')).checked == true)
				{
					if(arrayInput[i].getAttribute('tipovalida') != null)
					{
						if(arrayInput[i].getAttribute('tipovalida') == "texto")
						{
							if(!validatexto($.trim($(arrayInput[i]).val())))
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
						
						if(!validatexto($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "mail")
					{
						if(!validamail($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "moneda")
					{
						if(!validamoneda($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "fecha")
					{
						if(!validafecha($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
					if(arrayInput[i].getAttribute('tipovalida') == "entero")
					{
						if(!validaentero($.trim($(arrayInput[i]).val())))
						{
							resultado = false;
						}
					}
					
				}
			}
			
			if(resultado == false)
			{	
				var clase = $.trim(arrayInput[i].getAttribute("class"));
				
				$(arrayInput[i]).removeClass(clase);

				if(clase == "input_form" || clase == "resalta" || clase == "notFilled")
				{
					$(arrayInput[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min" || clase == "notFilled_min")
				{
					$(arrayInput[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio" || clase == "notFilled_medio")
				{
					$(arrayInput[i]).addClass('notFilled_medio');
				}
				if(clase == "input_form_medio hasDatepicker" || clase == "resalta_medio" || clase == "notFilled_medio")
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
				if(document.getElementById(""+arraySelect[i].getAttribute('condicion')).checked == true)
				{
					if(arraySelect[i].getAttribute('tipovalida') != null)
					{
						if(arraySelect[i].getAttribute('tipovalida') == "texto")
						{
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
						if(!validatexto($(arraySelect[i]).val()))
						{
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
			
			if(resultado == false)
			{
				var clase = arraySelect[i].getAttribute("class");
				$(arraySelect[i]).removeClass(clase);
				if(clase == "input_form" || clase == "resalta" || clase == "notFilled")
				{
					$(arraySelect[i]).addClass('notFilled');
				}
				if(clase == "input_form_min" || clase == "resalta_min" || clase == "notFilled_min")
				{
					$(arraySelect[i]).addClass('notFilled_min');
				}
				if(clase == "input_form_medio" || clase == "resalta_medio" || clase == "notFilled_medio")
				{
					$(arraySelect[i]).addClass('notFilled_medio');
				}
				
				if(clase == "input_form_medio hasDatepicker" || clase == "resalta_medio" || clase == "notFilled_medio")
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
	var result = true;
	
	if(trimAll(val) == "")
	{
		result = false;
	}
	return result;
}

function validamoneda(val)
{
	var re=/^[0-9]{1,10}(\.[0-9]{0,2})?$/;
	return re.test(val);
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

function validafecha(fecha)
{
	var result = true;
    if (fecha != undefined && fecha != "" )
	{
		if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fecha))
		{
			alert("primer ");
          result = false;
        }
		else
		{
			var dia  =  parseInt(fecha.substring(0,2),10);
			var mes  =  parseInt(fecha.substring(3,5),10);
			var anio =  parseInt(fecha.substring(6),10);
		 
			switch(mes)
			{
				case 1:
				case 3:
				case 5:
				case 7:
				case 8:
				case 10:
				case 12:
					numDias=31;
					break;
				case 4: case 6: case 9: case 11:
					numDias=30;
					break;
				case 2:
					if (fEsAnioBisiesto(anio)){ numDias=29 }else{ numDias=28};
					break;
				default:
					result = false;
			}
		
			if(result)
			{
        		if (dia>numDias || dia==0)
				{
            		result = false;
        		}
			}
		}    
    }
	else
	{
		result = false;
	}
	return result;
 }
	
function validaentero(val) 
{
     var result = true; 

     var re = /^(-)?[0-9]*$/;
	 if($.trim(val) != "")
	 {
     	if (!re.test(val)) 
	 	{
        	 result = false;
     	}
	 }
	 else
	 {
		 result = false;
	 }
	 
     return result;
 }
 
function fEsAnioBisiesto(Anio)
	{
    	var checkYear = (((Anio % 4 == 0) && (Anio % 100 != 0)) || (Anio % 400 == 0)) ? 1 : 0;
	
		if (! checkYear )  
        	return false;
    	else 
        	return true;
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
	$(this).find(".notFilled").live('change', function(){
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
