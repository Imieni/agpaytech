<?php
	/**
	 * Class for currency csv
	 */

	require_once 'auth.php';

	class Currency extends Auth{

	    public function readCSVFile()
	    {
	    	//allowed CSV extensions
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

			// Validate whether selected file is a CSV file
			if(!empty($_FILES['csvfile']['name']) && in_array($_FILES['csvfile']['type'], $csvMimes)){

		    	// Validate whether selected file is greater than 0KB
		        if ($_FILES["csvfile"]["size"] > 0) {

		        	// Open uploaded CSV file with read-only mode
		    		$fileName = $_FILES["csvfile"]["tmp_name"];
		            $file = fopen($fileName, "r");

		             // Skip the first line
		            fgetcsv($file);
		            // Parse data from CSV file line by line
		            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

		            	// Get row data
		        	    $iso_code = $column[0];
		                $iso_numeric_code  = $column[1];
		                $common_name = $column[2];
		                $official_name = $column[3];
		                $symbol = $column[4];
		                

		                // Insert country data in the database
		       			$stmt = $this->con->prepare("INSERT INTO currency (iso_code, iso_numeric_code, common_name, official_name, symbol) VALUES (?, ?, ?, ?, ?)");
		       			$stmt->bindValue(1, $iso_code, PDO::PARAM_STR);
		       			$stmt->bindValue(2, $iso_numeric_code, PDO::PARAM_INT);
		       			$stmt->bindValue(3, $common_name, PDO::PARAM_STR);
		       			$stmt->bindValue(4, $official_name, PDO::PARAM_STR);
		       			$stmt->bindValue(5, $symbol, PDO::PARAM_STR);
		       			$stmt->execute();

		       			
		       		}
		       		return $stmt;

		       		//return header("Location:currency.php?success&csv=currency");
		        }
		    }
		}


		public function search($searchword, $start, $limit)
		{
			$stmt = "SELECT * FROM currency";
			$where = "WHERE (iso_code LIKE :kw OR iso_numeric_code LIKE :kw OR common_name LIKE :kw OR official_name LIKE :kw OR symbol LIKE :kw) ";
			//$where = "WHERE (common_name LIKE ?)";
			$orderby = "ORDER BY currency_id ASC LIMIT :start, :limit";
			
				$stmt = $this->con->prepare("$stmt $where $orderby");
				$stmt->bindValue(":kw", '%' . $searchword. '%', PDO::PARAM_STR);
				$stmt->bindValue(":start", $start, PDO::PARAM_INT);
				$stmt->bindValue("limit", $limit, PDO::PARAM_INT);
				$stmt->execute();

				return $stmt;
		}

		 
	}


?>