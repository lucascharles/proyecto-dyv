<?php
class CausalProtestaModel extends ModelBase
{
	public function editarCausalProtesta($id, $des)
	{
		$dato = new CausalProtesta();
		$dato->add_filter("id_causal","=",$id);
		$dato->load();
		$dato->set_data("causal",$des);
		$dato->save();
	}
	
	public function getCausalProtesta($id)
	{
		$dato = new Bancos();
		$dato->add_filter("id_causal","=",$id);
		$dato->load();
		
		return $dato;
	}
	
	public function altaCausalProtesta($des)
	{
		$datoe = new CausalProtesta();
		$datoe->set_data("causal",$des);
		$datoe->set_data("activo","S");
		$datoe->save();
	}
	
	
	public function getListaCausalProtesta($des)
	{
		$dato = new CausalProtestaCollection();
		$dato->add_filter("activo","=","S");
		if(trim($des) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("causal","like",trim($des)."%");
		}
		
		$dato->load();
		
		return $dato;
	}
	
	
	public function bajaCausalProtesta($id, $des)
	{
		$datoe = new Bancos();
		$datoe->add_filter("id_causal","=",$id);
		$datoe->load();
		$datoe->set_data("activo","N");
		$datoe->save();
		
		$dato = new BancosCollection();
		$dato->add_filter("activo","=","S");
		if(trim($array["des_int"]) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("causal","like",trim($des)."%");
		}
		$dato->load();
		
		return $dato;
	}
	
}
?>