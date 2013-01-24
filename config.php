<?php
$config = Config::singleton();

$config->set('controllersFolder', 'controllers/');
$config->set('modelsFolder', 'models/');
$config->set('viewsFolder', 'views/');


// CONFIGURACION SQL SERVER
$config->set('dbhost', 'SEBA-D5DE59D8ED\SQLEXPRESS');
$config->set('dbname', 'sistemadv');
$config->set('dbuser', 'sa');
$config->set('dbpass', 'sa654seba');


/*
// CONFIGURACION MYSQL
// maquina local
$config->set('dbhost', 'localhost');
$config->set('dbname', 'sistemadv');
$config->set('dbuser', 'root');
$config->set('dbpass', 'root');


// demo
$config->set('dbname', 'w1031297_apuestas');
$config->set('dbuser', 'w1031297');
$config->set('dbpass', 'mi11finePO');
*/

$include_url = $_SERVER[DOCUMENT_ROOT]."/sistemadv";
$dir_uploaded_files = $_SERVER[DOCUMENT_ROOT]."/sistemadv/cargamasiva/";

?>
