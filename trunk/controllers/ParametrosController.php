<?php
class ParametrosController extends ControllerBase
{
    public function get_parametro($array)
    {
		require 'models/ParametrosModel.php';
		$param = new ParametrosModel();
		
		$valor = $param->getParametro($array);
		
		echo($valor);
	}
}
?>