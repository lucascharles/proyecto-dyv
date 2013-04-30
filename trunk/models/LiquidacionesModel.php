<?php
class LiquidacionesModel extends ModelBase
{
	public function editarTipoDoc($id, $des)
	{
		$dato = new TipoDocumento();
		$dato->add_filter("id_tipo_documento","=",$id);
		$dato->load();
		$dato->set_data("tipo_documento",$des);
		$dato->save();
	}
	
	public function getTipoDoc($id)
	{
		$dato = new TipoDocumento();
		$dato->add_filter("id_tipo_documento","=",$id);
		$dato->load();
		
		return $dato;
	}
	
	public function altaTipoDoc($des)
	{
		$datoe = new TipoDocumento();
		$datoe->set_data("tipo_documento",$des);
		$datoe->set_data("activo","S");
		$datoe->save();
	}
	
	
	public function getListaTipoDoc($des)
	{
		$dato = new TipoDocumentoCollection();
		$dato->add_filter("activo","=","S");
		if(trim($des) <> "")
		{
			$dato->add_filter("AND");
			$dato->add_filter("tipo_documento","like",trim($des)."%");
		}
		
		$dato->load();
		
		return $dato;
	}
	
	
	public function getTodasLiquidaciones($des)
	{
		$dato = new LiquidacionesCollection();
		if($id_liquidaciones != "")
		{
			$dato->add_filter("id_liquidacion ","in",$des);
		}
		$dato->load();
		
		return $dato;
	}
	
}
?>