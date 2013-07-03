<?php 

	//Affichage des erreurs PHP
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	//Variable globles
	define('APP_DIR', 'app');
	define('SYSTEM_DIR', 'system');
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', dirname(__FILE__));
	define('WEBROOT_DIR', 'webroot');
	define('WWW_ROOT', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS);

	//Amorcage de l'application
	require_once SYSTEM_DIR.DS.'Bootstrap.php';

?>