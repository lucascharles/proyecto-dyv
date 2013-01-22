<?php
class ModoPagoModel extends ModelBase
{

	public function getListaModoPago($des)
	{
		
	
    	$dato = new ModoPagoCollection();
	    $dato->add_filter("activo","=","S");
    	if(trim($des) <> "")
	    {
    	    $dato->add_filter("AND");
        	$dato->add_filter("modo_pago","like",trim($des)."%");
	    }
   
    	$dato->load();
       
	    return $dato;
	}
	
}
?>