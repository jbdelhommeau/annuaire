<?php 
	require_once 'config'. DIRECTORY_SEPARATOR .'core.php';

	/*Action relative à la page*/
	class Controller{

		private $action = "index";

		function __construct(){

			if(!empty($_GET['a'])){
				$this->action = $_GET['a'];
			}

			//Chargement de l'action associé
			self::{$this->action}();

		}

		//Page d'accueil
		function index(){
			//Chargement du model catégorie
			require MODEL.DS.'Category.php';
			require MODEL.DS.'Sheet.php';

			$current_categoryid = !empty($_GET['cat']) ? $_GET['cat'] : NULL;


			$list_of_categories = $this->Category->get_arbo();
			if($current_categoryid == NULL){
				$list_of_sheets = $this->Sheet->get_all();
			}else{
				$list_of_sheets = $this->Sheet->findByCategoryid($current_categoryid);
			}

			/*Rendu de la vues*/
			require VIEW.DS.'index.php';
		}

		function add_category(){
			$data = $_POST;
			if(!empty($data['name'])){
				require MODEL.DS.'Category.php';
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
				require MODEL.DS.'Category.php';
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
				require MODEL.DS.'Category.php';
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

	new Controller();

?>