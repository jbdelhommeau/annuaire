<?php
	class Sheet extends Model{

		function __construct(){
			parent::__construct();
		}


		function get_all(){

			$sheets = array();

			$dbh = $this->db->prepare("SELECT * FROM `sheets`");
			$dbh->execute();

			$dbh_cat = $this->db->prepare("SELECT `categories`.* FROM `sheets_categories` LEFT JOIN `categories` ON `sheets_categories`.`categoryid` = `categories`.`categoryid` WHERE `sheets_categories`.`sheetid` = ? ");

			foreach ($dbh->fetchAll(PDO::FETCH_ASSOC) as $row) {

				$dbh_cat->execute(array($row['sheetid']));
				$categories = $dbh_cat->fetchAll(PDO::FETCH_ASSOC);

				$sheets[] = array('sheet' =>$row, 'categories' => $categories);
			}

			return $sheets;

		}

		function findByCategoryid($categoryid = ""){

			$sheets = array();

			$dbh = $this->db->prepare("SELECT `sheets`.* FROM `sheets_categories` LEFT JOIN `sheets` ON `sheets_categories`.`sheetid` = `sheets`.`sheetid` WHERE `sheets_categories`.`categoryid` = ? ");
			$dbh->execute(array($categoryid));

			$dbh_cat = $this->db->prepare("SELECT `categories`.* FROM `sheets_categories` LEFT JOIN `categories` ON `sheets_categories`.`categoryid` = `categories`.`categoryid` WHERE `sheets_categories`.`sheetid` = ? ");

			foreach ($dbh->fetchAll(PDO::FETCH_ASSOC) as $row) {

				$dbh_cat->execute(array($row['sheetid']));
				$categories = $dbh_cat->fetchAll(PDO::FETCH_ASSOC);

				$sheets[] = array('sheet' =>$row, 'categories' => $categories);
			}

			return $sheets;

		}

		function update($data){

			if(!empty($data['sheet_title']) && !empty($data['sheet_desc']) && !empty($data['sheet_categories'])){
				$stmt = $this->db->prepare("INSERT INTO `sheets` (`title`, `description`) VALUES (?, ?)");
			
				try{
					$stmt->execute(array($data['sheet_title'], $data['sheet_desc']));
					$last_insert_sheet_id = $this->db->lastInsertId();
				} catch(PDOExecption $e){
					echo "Erreur lors de l'insertion de la catégorie: " . $e->getMessage(); 
				}


				$prepare_sql = "INSERT INTO `sheets_categories` (`categoryid`, `sheetid`) VALUES ";
				$prepare_value_sql = array();
				$values = array();

				foreach($data['sheet_categories'] as $categoryid){
					$prepare_value_sql[] = "(?,?)";
					$values[] = $categoryid;
					$values[] = $last_insert_sheet_id;
				}

				$prepare_sql .= join($prepare_value_sql, ","); 

				$stmt = $this->db->prepare($prepare_sql);
				return $stmt->execute($values);

			}
			return false;

		}

		function add($data){

			if(!empty($data['sheet_title']) && !empty($data['sheet_desc']) && !empty($data['sheet_categories'])){
				$stmt = $this->db->prepare("INSERT INTO `sheets` (`title`, `description`) VALUES (?, ?)");

				
				try{
					$stmt->execute(array($data['sheet_title'], $data['sheet_desc']));
					$last_insert_sheet_id = $this->db->lastInsertId();
				} catch(PDOExecption $e){
					echo "Erreur lors de l'insertion de la catégorie: " . $e->getMessage(); 
				}


				$prepare_sql = "INSERT INTO `sheets_categories` (`categoryid`, `sheetid`) VALUES ";
				$prepare_value_sql = array();
				$values = array();

				foreach($data['sheet_categories'] as $categoryid){
					$prepare_value_sql[] = "(?,?)";
					$values[] = $categoryid;
					$values[] = $last_insert_sheet_id;
				}

				$prepare_sql .= join($prepare_value_sql, ","); 

				$stmt = $this->db->prepare($prepare_sql);
				return $stmt->execute($values);

			}
			return false;

		}

		function delete($sheetid){

			if(!empty($sheetid)){
				return $this->db->query("DELETE FROM `sheets`  WHERE `sheetid` = '". $sheetid ."'");
			}
			return false;

		}

	}

	$this->Sheet = new Sheet();

?>