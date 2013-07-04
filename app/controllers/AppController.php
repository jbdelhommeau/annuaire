<?php
	
	class AppController extends Controller{

		function _construct(){}


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


		function manage_sheet(){
			$data = $_POST;

			if(!empty($data['sheet_title']) && !empty($data['sheet_description']) && count($data['sheet_categories']) > 0){
				$this->loadModel("Sheet");
				$result = $this->Sheet->save($data);
				echo $result;
			}else{
				echo "error_seizure";
			}
		}


		function delete_sheet(){
			$data = $_POST;
			if(!empty($data['id'])){
				$this->loadModel("Sheet");

				if($this->Sheet->delete($data['id'])){
					echo "ok";
				}else{
					echo "nk";
				}

			}else{
				echo "error_id";
			}
		}


		function add_category(){
			$data = $_POST;
			if(!empty($data['name'])){
				$this->loadModel('Category');
				if($this->Category->add($data['name'], $data['parent_id'])){
					echo "ok";
				}else{
					echo "nk";
				}
			}else{
				echo "error_name";
			}
		}


		function edit_category(){
			$data = $_POST;
			if(!empty($data['name']) && !empty($data['id'])){
				$this->loadModel('Category');
				if($this->Category->update($data['id'], $data['name'])){
					echo "ok";
				}else{
					echo "nk";
				}
			}else{
				echo "error_name";
			}
		}


		function delete_category(){
			$data = $_POST;
			if(!empty($data['id'])){
				$this->loadModel('Category');
				if($this->Category->delete($data['id'])){
					echo "ok";
				}else{
					echo "nk";
				}
			}else{
				echo "error_id";
			}
		}


	}

?>