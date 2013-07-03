<?php

	
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	//Inclusion des Class globales
	require_once SYSTEM_DIR.DS.'Tools.php';
	require_once SYSTEM_DIR.DS.'Url.php';
	require_once SYSTEM_DIR.DS.'Controller.php';
	require_once SYSTEM_DIR.DS.'Model.php';

	$url = $_SERVER['QUERY_STRING'];

	//Analyse du _GET
	$Url = new Url();

	//Chargement du controller par défaut
	require_once APP_DIR.DS.'controllers'.DS.'AppController.php';
	$ctrl = new AppController($Url);

	//Chargement de l'action
	call_user_func_array(array($ctrl, $Url->action), $Url->request);

?>