<?php

require "vendor/autoload.php";

use Agpay\Currency;


$currencycsv = new Currency();
if (isset($_POST["submit-currency"] ) 	) {
   $stmt = $currencycsv->readCSVFile();

   $currencycsv->redirect("currency.php?success&csv=currency");
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agpaytech Assignment - Currency CSV</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/bootstrap.bundle.js"></script>
	
</head>
<body>
	<div class="p-3 ">	

		<div class="row justify-content-center">
			<div class="col-md-3 p-4">
				<a href="index.php" class="btn btn-primary">Home</a>
		    </div>
			<div class="col-md-3 p-4">
				<a href="country.php" class="btn btn-primary">Country CSV</a>
		    </div>
		    <div class="col-md-3 p-4">
				<a href="#" class="btn btn-primary">Currency CSV</a>
		    </div>
		</div>


		<!-- Code for currency CSV -->
		<div class="row" id="csvcurrency" >
			<div class="d-flex search-panel justify-content-end">
		    <div class="form-row">
		        <div class="form-group col-md-12">
		        	<form method="get" action="#">
		            	<input type="text" class="form-control" id="search" placeholder="Search..." name="searchword" >
		            	<input type="submit" class="btn btn-primary btn-large" value="Search Currency Table"  name="searchcurrency">
		        </div>
		        
		    </div>
			</div>
			<h3>Imported Records for Currency CSV</h3>
			<table class="table table-striped table-bordered" id="csvTable" >

    			<thead class="thead-dark">
					<tr style="text-transform: uppercase;" class="text-secondary">
						<th>iso code</th>
						<th>iso numeric code</th>
						<th>common name</th>
						<th>Official Name</th>
						<th>symbol</th>
					</tr>
				</thead>
				<tbody>
				
				<?php

					if (isset($_GET['searchword'])) {
						$searchword = $_GET['searchword'];
						
						$_SESSION['csv'] = 'currency';
						//set the number of rows to display
						$limit = 15;

						//check if page is called in url else set page to 1
					 	if(isset($_GET['page']))
						{
						  $page = $_GET['page'];

						}
						else $page = 1;
							//compute for starting row   
						$start = ($page - 1) * $limit;

						
						$stmt =$currencycsv->search($searchword, $start, $limit);
							
						if ($stmt->rowCount() > 0) {
							
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	        				?>
					    		<tr>
									
									<td><?php  echo $row['iso_code']; ?></td>
									<td><?php  echo $row['iso_numeric_code']; ?></td>
									<td><?php  echo $row['common_name']; ?></td>
									<td><?php  echo $row['official_name']; ?></td>
									<td><?php  echo $row['symbol']; ?></td>
									
								</tr>
								<?php
			
							    }

							    $where = "WHERE (iso_code LIKE :kw OR iso_numeric_code LIKE :kw OR common_name LIKE :kw OR official_name LIKE :kw OR symbol LIKE :kw ) ";
							    $csv = 'currency';
							    $db_table = "currency ".$where;
							    
								$currencycsv->pagination_search($limit, $db_table, $start, $searchword, $page, $csv);
						}
						else{
							?>
							<tr>
								<td>No result found</td>
							</tr><?php
						}
					}
					else{

						//read from db table
						$stmt = $currencycsv->runQuery("SELECT * FROM currency");
						$stmt->execute();

							
						//set the number of rows to display
						$limit = 15;

						//check if page is called in url else set page to 1
					 	if(isset($_GET['page']))
						{
						  $page = $_GET['page'];

						}
						else $page = 1;
						
						
						
						//compute for starting row   
						$start = ($page - 1) * $limit;

						//display from db 
						$stmt = $currencycsv->runQuery("SELECT * FROM currency ORDER BY currency_id ASC LIMIT ?,? ");
						$stmt->bindValue(1, $start, PDO::PARAM_INT); 
						$stmt->bindValue(2, $limit, PDO::PARAM_INT); 
						$stmt->execute();

					   if($stmt->rowCount() != 0){
						   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						      ?>
						   		 
									<tr>
										
										<td><?php  echo $row['iso_code']; ?></td>
										<td><?php  echo $row['iso_numeric_code']; ?></td>
										<td><?php  echo $row['common_name']; ?></td>
										<td><?php  echo $row['official_name']; ?></td>
										<td><?php  echo $row['symbol']; ?></td>
										
									</tr>
								<?php
								
							}

							$db_table = "currency";
							$currencycsv->pagination($limit, $db_table, $start, $page);
						}
						else {
							?>
							<tr> <td>No row found</td></tr>
						<?php
						}

					}
				?>
				
				</tbody>

			</table>
		</div>