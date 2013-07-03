<?php
	class Sheet extends Model{

		function __construct(){
			parent::__construct();
		}

		function get_all(){

			$sheets = array();

			$dbh = $this->db->prepare("SELECT * FROM `sheets`");
			$dbh->execute();

			foreach ($dbh->fetchAll(PDO::FETCH_ASSOC) as $row) {
				$sheets[] = $row;
			}

			return $sheets;

		}

		function findByCategoryid($categoryid = ""){

			$sheets = array();

			$dbh = $this->db->prepare("SELECT `sheets`.* FROM `sheets_categories` LEFT JOIN `sheets` ON `sheets_categories`.`sheetid` = `sheets`.`sheetid` WHERE `categoryid` = ? ");

			//SELECT `sheets`.* , `categories`.*  FROM `sheets_categories` LEFT JOIN `sheets` ON `sheets_categories`.`sheetid` = `sheets`.`sheetid` LEFT JOIN `categories` ON `sheets_categories`.`categoryid` = `categories`.`categoryid` 
			$dbh->execute(array($categoryid));

			foreach ($dbh->fetchAll(PDO::FETCH_ASSOC) as $row) {
				$sheets[] = $row;
			}

			return $sheets;

		}

	}

	$this->Sheet = new Sheet();

?>