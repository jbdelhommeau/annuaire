<?php

	class Url{

		public $action = "index";
		public $request;

		function __construct(){
			$this->_parse();
		}

		function _parse(){
			$this->request = $_GET;
			if(!empty($this->request['a'])){
				$this->action = $this->request['a'];
				unset($this->request['a']);
			}
		}


	}

?>