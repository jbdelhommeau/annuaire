<?php
	class Category extends Model{

		function __construct(){
			parent::__construct();
		}

		function get_all(){

			$datas = array();
			$index = array();
			$dbh = $this->db->prepare("SELECT * FROM `categories` ORDER BY name");
			$dbh->execute();

			$ref = null;
			foreach ($dbh->fetchAll(PDO::FETCH_ASSOC) as $row) {
				$categoryid = $row["categoryid"];
				$parent_id = $row['parent_id'] === NULL ? "NULL" : $row['parent_id'];
				$datas[$categoryid] = $row;
				$index[$parent_id][] = $categoryid;
			}

			$categories = array("datas" => $datas, "index" => $index);

			return $categories;

		}


		function get_arbo($categories = false){
			if(!$categories){
				$categories = $this->get_all();
			}

			$result = array();
			$this->_get_build_arbo($result, $categories, NULL);

			return $result;
		}

		function _get_build_arbo(&$result, $datas, $parent_id, $level = 0){
			$parent_id = $parent_id === NULL ? "NULL" : $parent_id;

			if (isset($datas["index"][$parent_id])) {
				foreach ($datas["index"][$parent_id] as $id) {
		        	$result[$datas["datas"][$id]['categoryid']] =  str_repeat("-", $level) . $datas["datas"][$id]["name"] . "\n";
		        	self::_get_build_arbo($result, $datas, $id , $level + 1);
		    	}
			}
		}


		function add($name, $parent_id = null){

			if(!empty($name)){
				$stmt = $this->db->prepare("INSERT INTO `categories` (`parent_id`, `name`) VALUES (?, ?)");
				try{
					if(empty($parent_id)) $parent_id = NULL;

					$stmt->execute(array($parent_id, $name));
					return $this->db->lastInsertId();

				} catch(PDOExecption $e){
					echo "Erreur lors de l'insertion de la catégorie: " . $e->getMessage(); 
				}

			}
			return false;

		}

		function update($id, $name){

			if(!empty($name)){
				$stmt = $this->db->prepare("UPDATE `categories` SET `name` = :name WHERE `categoryid` = :id");
				try{
						$stmt->bindParam(":name",$name);
						$stmt->bindParam(":id",$id);
					return $stmt->execute();
				} catch(PDOExecption $e){
					echo "Erreur lors de la mise à jour de la catégorie: ".$id . " - " . $e->getMessage(); 
				}

			}
			return false;

		}

		function delete($categoryid){

			if(!empty($categoryid)){
				return $this->db->query("DELETE FROM `categories`  WHERE `categoryid` = '". $categoryid ."'");
			}
			return false;

		}


	}

	$this->Category = new Category();

?>