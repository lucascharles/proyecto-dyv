<?php
	function getUltimoId($obj, $clave)
	{
		$id = 0;
		
		$obj->add_sort($clave, false);
		$obj->load();
		
		for($i=0; $i<$obj->get_count(); $i++) 
		{
			$datoTmp = &$obj->items[$i];
			$id = $datoTmp->get_data($clave);
			break;
		}
		
		return $id;
	}
	
	function formatoFecha($fechavieja, $formatoOrigen, $formatoDestino)
	{
		$resp = "";
		if(strlen($fechavieja) > 10)
		{
			$tiempo = substr($fechavieja, 10);
		
			$fechavieja = substr($fechavieja, 0, 10);
		}
		if(strpos($fechavieja,"-") <> false)
		{
			list($a,$b,$c) = explode("-", $fechavieja);
		}
		else
		{
			list($a,$b,$c) = explode("/", $fechavieja);
		}
		
		if(strlen($a)<2)
		{
			$a = str_pad($a, 2, "0", STR_PAD_LEFT);
		}
		if(strlen($b)<2)
		{
			$b = str_pad($b, 2, "0", STR_PAD_LEFT);
		}
		if(strlen($c)<2)
		{
			$c = str_pad($c, 2, "0", STR_PAD_LEFT);
		}
		
		if(strpos($fechavieja,"-") <> false)
		{
			$fechavieja = $a."-".$b."-".$c;
		}
		else
		{
			$fechavieja = $a."/".$b."/".$c;
		}
		
		
		if($formatoOrigen == "yyyy-mm-dd" && $formatoDestino == "dd/mm/yyyy")
		{
    		list($a,$m,$d) = explode("-", $fechavieja);
			$resp = $d."/".$m."/".$a;
		}
		
		if($formatoOrigen == "yyyy-mm-dd H:m:s" && $formatoDestino == "dd/mm/yyyy")
		{
		
    		list($a,$m,$d) = explode("-", $fechavieja);
			$resp = $d."/".$m."/".$a." ".$tiempo;
		}
		
		if($formatoOrigen = "dd/mm/yyyy" && $formatoDestino == "yyyy-mm-dd")
		{
    		list($d,$m,$a) = explode("/", $fechavieja);
			$resp = $a."-".$m."-".$d;
		}
		
		
		if($formatoOrigen == $formatoDestino)
		{
    		$resp = $fechavieja." ".$tiempo;
		}
				
		return $resp;
	}
	  
?>