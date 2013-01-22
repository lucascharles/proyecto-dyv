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
	  
?>
