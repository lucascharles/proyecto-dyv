<?php
	require '../libs/Config.php'; //de configuracion
	include('../config.php');
	include($include_url.'/includes/clases/mygen_framework.php');
	include($include_url.'/includes/clases/mygen_mysql.php');
	include($include_url.'/includes/clases/clases_sistemadv.php');
	
	$q = strtolower($_GET["term"]);
	if (!$q) return; //si no nos trae nada retornamos
	$items[] = array();//creamos un array llamado items
	$cadena = trim($q); //le asignamos a cadena $Q sin espacios
	
	$dato = new DeudoresCollection();
	$dato->add_filter("activo","=","S");
	$dato->add_filter("AND");
	$dato->add_filter("primer_nombre","LIKE",$cadena."%");
	$dato->add_sort("primer_nombre",true);
	$dato->load();

	if($dato->get_count() == 0)
	{
		return false;
	}
	else
	{
		for($j=0; $j<$dato->get_count(); $j++) 
		{
			$datoTmp = &$dato->items[$j];
			$items[] = array("id"=>$datoTmp->get_data("id"),"label"=>$datoTmp->get_data("primer_nombre"),"value"=>$datoTmp->get_data("primer_nombre"));

		}
	}


echo json_encode($items);
?>