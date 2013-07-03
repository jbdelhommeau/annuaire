<?php

	class Controller{

		function _construct(){}


		function loadModel($model_name){
			$path_model = APP_DIR.DS."models".DS.$model_name.".php";
			if(file_exists($path_model)){
				require_once($path_model);
				if(isset($this->$model_name)){
					$this->$model_name = new $model_name();
				}
			}else{
				die("Model ". $path_model . " introuvable.");
			}	
		}

		function loadView($view_name, $data = array()){
			$path_view = APP_DIR.DS."views".DS.$view_name.".php";
			if(file_exists($path_view)){
				extract($data);
				include($path_view);
			}else{
				die("View ". $path_view. " introuvable.");
			}
		}


	}

?>