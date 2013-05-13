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
	
	
	public function getCalculoPrestamo($array)
	{	
		$saldo_inicial = $array["txtimporte"];
		$array_pagos = array();

		for($i=0; $i<$array["txtnumpagos"]; $i++)
		{
			$fechainicial = formatoFecha($array["txtfechainicial"],"dd/mm/yyyy","yyyy-mm-dd");
			$fecha_aux =  strtotime ( '+'.($i+1).' month' , strtotime ( $fechainicial ) ) ;
			$fecha = date("d/m/Y",$fecha_aux);
			$array_aux = array();
			$array_aux["num"] = $i+1;
			$array_aux["fecha_pago"] = $fecha;
			$array_aux["saldo_ini"] = round($saldo_inicial, array(0, PHP_ROUND_HALF_UP));
			$array_aux["pago"] = round($array["txtpagomensual"], array(2, PHP_ROUND_HALF_UP));
			$interes = round(($saldo_inicial * 2)/100, array(0, PHP_ROUND_HALF_UP));
			$capital = round($array["txtpagomensual"], array(0, PHP_ROUND_HALF_UP)) - $interes;
	        $array_aux["capital"] = $capital;
        	$array_aux["interes"] = $interes;
        	$array_aux["saldo_final"] = round($saldo_inicial - $capital, array(0, PHP_ROUND_HALF_UP));
			$saldo_inicial = $saldo_inicial - $capital;
			
			$array_pagos[] = $array_aux;
		}
		
		return $array_pagos;
	}
}
?>