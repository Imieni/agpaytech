<?php
require_once ('connect.php');

	/**
	* Parent Class
	*/
	class Auth
	{
		private $db;
		
		function __construct()
		{
			$database = new Database();
			$db = $database -> db_connect();
			$this->con = $db;
		}

		public function runQuery($sql)
		{
			$stmt = $this->con->prepare($sql);
			return $stmt;
		}

		public function redirect($url) {
			header("Location:$url");
		}

		
		public function pagination($limit, $db_table, $start, $page) {

			//pagination 
			$stmt = $this->con->prepare("SELECT * FROM " . $db_table);
			$stmt->execute();
				 
			$total_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
				     
				        
			if($stmt->rowCount() > 0)
			{
				//get the ceiling value of the table data
				$total_page = ceil(count($total_records) / $limit);
				         
				echo '<ul class="pagination justify-content-end">';
				         
				if($page > 1)
				{        
					$previous_id = ($page - 1);
				  echo '<li class="page-item"><a class="page-link" href="'.$db_table.'.php?success&csv='.$db_table.'&page='.$previous_id.'" data-page_number="'.$previous_id.'">Previous</a></li>'; 
				}   

				//set the class of the current page to active    
				         
				for($i = 1; $i <= $total_page; $i++)
				{
				  if($i == $page){
				           
				   $active = "active"; 
				}
				else{
				           
				   $active = "";
				}
				          
				echo '<li class="page-item '.$active.' ">
				          <a class="page-link" href="'.$db_table.'.php?success&csv='.$db_table.'&page='.$i.'">'.$i.'</a> 
				     </li>';
				}
				  
				if($total_page > $page)
				{        
				  echo '<li class="page-item"><a class="page-link" href="'.$db_table.'.php?success&csv='.$db_table.'&page='.($page + 1).'">Next</a></li>';  
				}
				          
				echo '</ul>'; 
			}
		  
		}

		public function pagination_search($limit, $db_table, $start, $searchword, $page, $csv)		
		{
			//pagination 
			
			$stmt = $this->con->prepare("SELECT * FROM " . $db_table);
			//$stmt = '$stmt $where';
			$stmt->bindValue(":kw", '%' . $searchword. '%', PDO::PARAM_STR);
			$stmt->bindValue(":start", $start, PDO::PARAM_INT);
			$stmt->bindValue("limit", $limit, PDO::PARAM_INT);
			$stmt->execute();
				 
			$total_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
				     
				        
			if($stmt->rowCount() > 0)
			{
				//get the ceiling value of the table data
				$total_page = ceil(count($total_records) / $limit);
				         
				echo '<ul class="pagination justify-content-end">';
				         
				if($page > 1)
				{        
					$previous_id = ($page - 1);
				  echo '<li class="page-item"><a class="page-link" href="'.$csv.'.php?searchword='.$searchword.'&page='.$previous_id.'" data-page_number="'.$previous_id.'">Previous</a></li>'; 
				}   

				//set the class of the current page to active    
				         
				for($i = 1; $i <= $total_page; $i++)
				{
				  if($i == $page){
				           
				   $active = "active"; 
				}
				else{
				           
				   $active = "";
				}
				          
				echo '<li class="page-item '.$active.' ">
				          <a class="page-link" href="'.$csv.'.php?searchword='.$searchword.'&page='.$i.'">'.$i.'</a> 
				     </li>';
				}
				  
				if($total_page > $page)
				{        
				  echo '<li class="page-item"><a class="page-link" href="'.$csv.'.php?searchword='.$searchword.'&page='.($page + 1).'">Next</a></li>';  
				}
				          
				echo '</ul>'; 
			}
		  
		}
	}
?>