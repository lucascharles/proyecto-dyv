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
		$interes_mensual = $array["txtinteresmensual"];
		$saldo_inicial = $array["txtcostoprestamo"];
		$array_pagos = array();

		for($i=0; $i<$array["txtnumpagos"]; $i++)
		{
			$fechainicial = formatoFecha($array["txtfechainicial"],"dd/mm/yyyy","yyyy-mm-dd");
			$fecha_aux =  strtotime ( '+'.($i+1).' month' , strtotime ( $fechainicial ) ) ;
			$fecha = date("d/m/Y",$fecha_aux);
			$array_aux = array();
			$array_aux["num"] = $i+1;
			$array_aux["fecha_pago"] = $fecha;
			
			$array_aux["saldo_ini"] = ceil($saldo_inicial);
			$array_aux["pago"] = ceil($array["txtpagomensual"]);
			$interes = ceil(($saldo_inicial * $interes_mensual)/100);
			$capital = ceil($array["txtpagomensual"]) - $interes;
	        $array_aux["capital"] = $capital;
        	$array_aux["interes"] = $interes;
        	$sald_final = ceil($saldo_inicial - $capital - $interes );
        	if($sald_final < 0) {
        		$array_aux["saldo_final"] = 0;
        	}else
        	{
        		$array_aux["saldo_final"] = $sald_final;
        	}
			$saldo_inicial = $saldo_inicial - $capital - $interes ;
			$array_pagos[] = $array_aux;
		}
		
		return $array_pagos;
	}
	
	
	public function getLiquidacion($id)
	{
		$dato = new Liquidaciones();
		$dato->add_filter("id_liquidacion","=",$id);
		$dato->load();
		
		return $dato;
	}
	
	public function getLiquidacionesDeudor($array)
	{
		$deudor = new Deudores();
		$deudor->add_filter("rut_deudor","=",$array["rutdeudor"]);
		$deudor->add_filter("AND");
		$deudor->add_filter("activo","=","S");
		
		$deudor->load();
		/*
		$dato = new LiquidacionesCollection();
		$dato->add_filter("id_deudor","=",$deudor->get_data("id_deudor"));
		$dato->load();
		*/
		
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
		$sqlpersonal->set_select( " l.id_liquidacion id_liquidacion,
	   		   m.nombre nombre, m.apellido apellido, l.fecha_creacion fecha_creacion, l.usuario_creacion usuario_creacion");
		$sqlpersonal->set_from(" liquidaciones l, mandantes m ");
		
		$where = " l.id_deudor = ".$deudor->get_data("id_deudor")." and l.id_mandante = m.id_mandante  ";

		$sqlpersonal->set_where($where);
		
    	$sqlpersonal->load();

    	return $sqlpersonal;	
		
		return $dato;
	}
	
	public function eliminaLiquidacion($id)
	{
		$dato = new Liquidaciones();
		$dato->add_filter("id_liquidacion","=",$id);
		$dato->load();
		$dato->mark_deleted();
		$dato->save();
	}
}
?>