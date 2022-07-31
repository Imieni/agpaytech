<?php
	/**
	 * Class for country csv
	 */

	require_once 'auth.php';

	class Country extends Auth{

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
		        	    $continent_code = $column[0];
		                $currency_code  = $column[1];
		                $iso2_code = $column[2];
		                $iso3_code = $column[3];
		                $iso_numeric_code = $column[4];
		                $fips_code = $column[5];
		                $calling_code = $column[6];
		                $common_name = $column[7];
		                $official_name = $column[8];
		                $endonym = $column[9];
		                $demonym = $column[10];

		                // Insert country data in the database
		       			$stmt = $this->con->prepare("INSERT INTO country (continent_code, currency_code, iso2_code, iso3_code, iso_numeric_code, fips_code, calling_code, common_name, official_name, endonym, demonym) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		       			$stmt->bindValue(1, $continent_code, PDO::PARAM_STR);
		       			$stmt->bindValue(2, $currency_code, PDO::PARAM_STR);
		       			$stmt->bindValue(3, $iso2_code, PDO::PARAM_STR);
		       			$stmt->bindValue(4, $iso3_code, PDO::PARAM_STR);
		       			$stmt->bindValue(5, $iso_numeric_code, PDO::PARAM_STR);
		       			$stmt->bindValue(6, $fips_code, PDO::PARAM_STR);
		       			$stmt->bindValue(7, $calling_code, PDO::PARAM_STR);
		       			$stmt->bindValue(8, $common_name, PDO::PARAM_STR);
		       			$stmt->bindValue(9, $official_name, PDO::PARAM_STR);
		       			$stmt->bindValue(10, $endonym, PDO::PARAM_STR);
		       			$stmt->bindValue(11, $demonym, PDO::PARAM_STR);
		       			$stmt->execute();
		       			
		       		}

		       		return $stmt;
		        }
		    }
		}

		public function search($searchword, $start, $limit)
		{
			$stmt = "SELECT * FROM country";
			$where = "WHERE (continent_code LIKE :kw OR currency_code LIKE :kw OR iso2_code LIKE :kw OR iso3_code LIKE :kw OR iso_numeric_code LIKE :kw OR fips_code LIKE :kw OR calling_code LIKE :kw OR common_name LIKE :kw OR official_name LIKE :kw OR endonym LIKE :kw OR demonym LIKE :kw) ";
			//$where = "WHERE (common_name LIKE ?)";
			$orderby = "ORDER BY country_id ASC LIMIT :start, :limit";
			
				$stmt = $this->con->prepare("$stmt $where $orderby");
				$stmt->bindValue(":kw", '%' . $searchword. '%', PDO::PARAM_STR);
				$stmt->bindValue(":start", $start, PDO::PARAM_INT);
				$stmt->bindValue("limit", $limit, PDO::PARAM_INT);
				$stmt->execute();

				return $stmt;
		}

		
	}


?>