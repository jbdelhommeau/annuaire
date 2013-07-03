<?php
	
	class AppController extends Controller{

		function index($cat = ""){
			$this->loadModel("Category");
			$this->loadModel("Sheet");

			$current_categoryid = $cat;


			$list_of_categories = $this->Category->get_arbo();
			if($current_categoryid == NULL){
				$list_of_sheets = $this->Sheet->get_all();
			}else{
				$list_of_sheets = $this->Sheet->findByCategoryid($current_categoryid);
			}

			$data = array(
				'list_of_categories' => $list_of_categories,
				'list_of_sheets' => $list_of_sheets,
				'current_categoryid' => $current_categoryid
			);


			$this->loadView("index", $data);
		}


	}

?>