<?php
class JuzgadoModel extends ModelBase
{
	public function getListaJuzgados($des='')
	{
		$dato = new JuzgadoCollection();
		$dato->add_filter("activo","=","S");
		if(trim($des) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("descripcion","like",trim($des)."%");
		}
		
		$dato->load();
		
		return $dato;
	}	
}
?>