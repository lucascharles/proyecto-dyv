<html>
	<head>
		<title><?php echo $nom_sistema ?></title>
		<link rel="stylesheet" href="css/general.css" type="text/css" />
		<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="js/funciones.js" type="text/javascript"></script>
        
		<!-- ARCHIVOS PARA MENU DESPLEGABLE -->
		<link rel="stylesheet" type="text/css" href="../css/menuheader.css" />
		<script type="text/javascript" src="../js/menuheader.js"></script>
                
        <!-- SCRIPT PARA MENU -->
<script type='text/javascript'>
//<![CDATA[
//------------------------------
// Developed by Roshan Bhattarai
// Visit http://roshanbh.com.np for this script and more.
// This notice MUST stay intact for legal use
// ---------------------------------


$(document).ready(function()
{
	$("#firstpane p.menu_head").click(function()
	{
		$(this).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
		$(this).siblings();
	});


	$("#secondpane p.menu_head").mouseover(function()
	{
		$(this).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
		$(this).siblings();
	});
	
	//setTimeout("desplegarMenu(1)",500);
	$("#pagina").load('views/default.php');
});

//]]>

function overClass(obj)
{
	$(obj).removeClass('menu_head');
	$(obj).addClass('seleccionado');
}

function outClass(obj)
{
	$(obj).removeClass('seleccionado');
	$(obj).addClass('menu_head');
}
function verDetalle(obj)
{
	$("#pagina").load($(obj).attr("acceso_op"));
	
	var array = document.getElementsByTagName('a');
	for(var i=0; i<array.length; i++)
	{	
		if(array[i].id.substring(0, 5) == "item_")
		{
			$(array[i]).removeClass('menu_body_sel');
			$(array[i]).addClass('menu_body');
	 		document.getElementById(array[i].id).style.color="";	
		}		
	}
	
	$(obj).addClass('menu_body_sel');
	document.getElementById(obj.id).style.color="#333333";
	
}

function desplegarMenu(cod)
{
	 <?
		for($i=0; $i<count($arrayObjPermisos);$i++)
		{
			$arraymodulo = $arrayObjPermisos[$i];		
			echo("$('#menu".$arraymodulo[0]."').next('div.menu_body').slideToggle(300).siblings('div.menu_body');");
			echo("$('#menu".$arraymodulo[0]."').siblings();");
		}
	?>
	/*
	$('#menu1').next("div.menu_body").slideToggle(300).siblings("div.menu_body");//.slideUp("slow");
	$('#menu1').siblings();

	$('#menu2').next("div.menu_body").slideToggle(300).siblings("div.menu_body");//.slideUp("slow");
	$('#menu2').siblings();

	$('#menu3').next("div.menu_body").slideToggle(300).siblings("div.menu_body");//.slideUp("slow");
	$('#menu3').siblings();

	$('#menu4').next("div.menu_body").slideToggle(300).siblings("div.menu_body");//.slideUp("slow");
	$('#menu4').siblings();

	$('#menu5').next("div.menu_body").slideToggle(300).siblings("div.menu_body");//.slideUp("slow");
	$('#menu5').siblings();
	*/
}
function retraerMenu()
{
	$('#menu1').next("div.menu_body").slideUp("slow");
	$('#menu1').siblings();
	
	$('#menu2').next("div.menu_body").slideUp("slow");
	$('#menu2').siblings();

	$('#menu3').next("div.menu_body").slideUp("slow");
	$('#menu3').siblings();

	$('#menu4').next("div.menu_body").slideUp("slow");
	$('#menu4').siblings();

	$('#menu5').next("div.menu_body").slideUp("slow");
	$('#menu5').siblings();
	
} 
</script>
<style type="text/css">
.menu_list 
{
	width: 200px; /* Ancho del men&uacute; */
	position:relative;
	margin-top:10px;
	margin-left:0px;
}

.seleccionado
{
	font-family:Tahoma;
	font-size:15px;
	font-weight:bold;
	padding: 5px 5px;
	color:#333333;
	cursor: pointer;
	position: relative;
	margin:1px;
	margin-left:0;
	margin-right:0;
	background:url(images/selected.png);
	
}



.menu_head 
{
	font-family:Tahoma;
	font-size:15px;
	font-weight:bold;
	padding: 5px 5px;
	color:#333333; /* Color de las pesta&ntilde;as principales */
	cursor: pointer;
	position: relative;
	margin:1px;
	margin-left:0;
	margin-right:0;
	/*background-color: #424242;  Color de fondo */
	/*background-position:center right;*/
	background-repeat:no-repeat;
}

.menu_body 
{
	display:none;
	padding: 5px 5px;
	font-family:Tahoma;
	font-size:15px;
	
}

.menu_body a
{
	display:block;
	color:#666666; /* Color de los enlaces */
	/*background-color:#BDBDBD;  Color de fondo de los enlaces */
	/*padding-left:10px;*/
	padding: 5px 5px;
	/*font-weight:bold;*/
	text-decoration:none;
	font-size:15px;
	font-family:Tahoma;
}
.menu_body a:hover{
color: #333333; /* Color de los enlaces al pasar el cursor */
/*text-decoration:underline;*/
/*background:#CCCCCC;*/
background:url(images/selected.png);
}

.menu_body_sel 
{
	/*color: #333333; */
	background:url(images/selected.png);
}
</style>


	</head>
	<body>
    	<? include("cabecera.php") ?>
        <table width="100%" height="100%" align="left" border="0" cellpadding="0" cellspacing="0" bgcolor="#eeeeee">
        <tr>
        	<td valign="top" width="200">
		<div id="menu">
        
        <div style="position:relative; margin-top:5px; color:#3278b4; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; width:200px;">
        <table width="100%" border="0" cellpadding="10" cellspacing="10" align="center" bgcolor="#E4E4E4">
        	<tr>
            	<td align="center" style="color:#3278b4; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold;">
        MENU PRICIPAL
        		</td>
        	</tr>
        </table>
        </div>
        	<div id="firstpane" class="menu_list">

								
        <?
		for($i=0; $i<count($arrayObjPermisos);$i++)
		{
			$arraymodulo = $arrayObjPermisos[$i];
			echo("<p class='menu_head' id='menu".$arraymodulo[0]."' onMouseOver='overClass(this)' onMouseOut='outClass(this)'><font> ".$arraymodulo[1]."</font></p>");
			$arrayopcion = $arraymodulo[2];
			echo("<div class='menu_body'>");
			for($j=0; $j<count($arrayopcion);$j++)
			{
				$arraydetop = $arrayopcion[$j];
                echo("<a href='#' id='item_".$arraydetop[0]."' acceso_op='".$arraydetop[2]."' onClick='verDetalle(this)'>&nbsp; ".$arraydetop[1]."</a>");
			}
			echo("</div>");
		}
		?>
        </div> 
		</div>
        </td>
        <td  valign="top">
        	<div id="contenedor" style="position:relative; margin-top:0px; margin-left:5px; height:85%; border: 5px solid #DDD; padding: 10px; border-bottom:0px; border-left-width:0px; border-top-width:0px;">
        
        		<div id="pagina"  style="position:relative; margin-top:0px; margin-left:0px; height:85%;">
           		</div>
        	</div>
        </td>
       </tr>
      </table>
	</body>
</html>
