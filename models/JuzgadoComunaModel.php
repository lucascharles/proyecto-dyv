<?php
class JuzgadoComunaModel extends ModelBase
{
	public function getListaJuzgadosComuna($des='')
	{
		$dato = new JuzgadoComunaCollection();
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