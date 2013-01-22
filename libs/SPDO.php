<?php
class PDOs
{
	private $server = null;
	private $dbuser = null;
	private $dbpass = null;
	
	public function __construct($server_n, $dbuser_n, $dbpass_n) 
	{
		$server = $server_n;
		$dbuser = $dbuser_n;
		$dbpass = $dbpass_n;
	}

}

class SPDO extends PDOs
{
	private static $instance = null;

	public function __construct() 
	{
		$config = Config::singleton();
		parent::__construct('mysql:host=' . $config->get('dbhost') . ';dbname=' . $config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'));
	}

	public static function singleton() 
	{
		if( self::$instance == null ) 
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
}


?>