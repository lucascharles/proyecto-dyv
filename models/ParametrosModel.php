<?php
class ParametrosModel extends ModelBase
{
	public function getParametro($array)
	{
		$dato = new Parametros();
		$dato->add_filter("nombre_parametro","=",$array["nom_param"]);
		$dato->load();

		return $dato->get_data("valor_parametro");
	}
}
?>