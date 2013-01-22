<?php
class BancosModel extends ModelBase
{

	public function getListaBancos($des)
	{
		
	
    	$dato = new BancosCollection();
	    $dato->add_filter("activo","=","S");
    	if(trim($des) <> "")
	    {
    	    $dato->add_filter("AND");
        	$dato->add_filter("banco","like",trim($des)."%");
	    }
   
    	$dato->load();
       
	    return $dato;
	}
	
}
?>