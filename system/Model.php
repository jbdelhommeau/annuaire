<?php

	class Model{

		public static $db_connected;

		var $db;

		function __construct(){
			self::_init_connect();
		}

		function _init_connect(){
			//récupération paramètres de connexion

			if(empty(self::$db_connected)){
				
				require_once APP_DIR.DS.'config'.DS.'database.php';

				$dsn = 'mysql:dbname='. $db_config['database'] .';host='. $db_config['host'];
				$user = $db_config['user'];
				$password = $db_config['password'];

				try {
					self::$db_connected = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '". $db_config['encodage'] ."'"));
				} catch (PDOException $e) {
					die('Connexion échouée : ' . $e->getMessage());
				}
				
			}
			$this->db = self::$db_connected;

		}

	}

?>