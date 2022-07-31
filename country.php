<?php
require_once('classes/country.php');


$countrycsv = new Country();


if (isset($_POST["submit-country"] ) 	) {
   $stmt = $countrycsv->readCSVFile();
   $countrycsv->redirect("country.php?success&csv=country");

}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agpaytech Assignment - Country CSV</title>
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
				<a href="#" class="btn btn-primary">Country CSV</a>
		    </div>
		    <div class="col-md-3 p-4">
				<a href="currency.php" class="btn btn-primary">Currency CSV</a>
		    </div>
		</div>


		<!-- Code for country CSV -->
		<div class="row" id="csvcountry" >
			<div class="d-flex search-panel justify-content-end">
		    <div class="form-row">
		        <div class="form-group col-md-12">
		        	<form method="get" action="#">
		            	<input type="text" class="form-control" id="search" placeholder="Search..." name="searchword" >
		            	<input type="submit" class="btn btn-primary btn-large" value="Search Country Table"  name="searchcountry">
		        </div>
		        
		    </div>
			</div>
		
			<h3>Imported Records for Country CSV</h3>
			<table class="table table-striped table-bordered" id="csvTable" >

    			<thead class="thead-dark">
					<tr style="text-transform: uppercase;" class="text-secondary">
						<th>Continent Code</th>
						<th>Currency Code</th>
						<th>Iso2 Code</th>
						<th>iso3 code</th>
						<th>iso numeric code</th>
						<th>fips code</th>
						<th>calling code</th>
						<th>Common Name</th>
						<th>Official Name</th>
						<th>Endonym</th>
						<th>Demonym</th>
					</tr>
				</thead>
				<tbody>
				
				<?php

					if (isset($_GET['searchword'])) {
						$searchword = $_GET['searchword'];

						
						
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

							$stmt =$countrycsv->search($searchword, $start, $limit);
							
						if ($stmt->rowCount() > 0) {
							
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								
	        				?>
					    		<tr>
									<td><?php  echo $row['continent_code']; ?></td>
									<td><?php  echo $row['currency_code']; ?></td>
									<td><?php  echo $row['iso2_code']; ?></td>
									<td><?php  echo $row['iso3_code']; ?></td>
									<td><?php  echo $row['iso_numeric_code']; ?></td>
									<td><?php  echo $row['fips_code']; ?></td>
									<td><?php  echo $row['calling_code']; ?></td>
									<td><?php  echo $row['common_name']; ?></td>
									<td><?php  echo $row['official_name']; ?></td>
									<td><?php  echo $row['endonym']; ?></td>
									<td><?php  echo $row['demonym']; ?></td>
								</tr>
								<?php
			
							    }
							    $where = "WHERE (continent_code LIKE :kw OR currency_code LIKE :kw OR iso2_code LIKE :kw OR iso3_code LIKE :kw OR iso_numeric_code LIKE :kw OR fips_code LIKE :kw OR calling_code LIKE :kw OR common_name LIKE :kw OR official_name LIKE :kw OR endonym LIKE :kw OR demonym LIKE :kw) ";

							    $csv = 'country';
							    $db_table = "country ".$where;
							    
							    
								$countrycsv->pagination_search($limit, $db_table, $start, $searchword, $page, $csv);
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
						$stmt = $countrycsv->runQuery("SELECT * FROM country");
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
						$stmt = $countrycsv->runQuery("SELECT * FROM country ORDER BY country_id ASC LIMIT ?,? ");
						$stmt->bindValue(1, $start, PDO::PARAM_INT); 
						$stmt->bindValue(2, $limit, PDO::PARAM_INT); 
						$stmt->execute();

						if($stmt->rowCount()!=0){

						    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						      ?>
						   		 
									<tr>
										<td><?php  echo $row['continent_code']; ?></td>
										<td><?php  echo $row['currency_code']; ?></td>
										<td><?php  echo $row['iso2_code']; ?></td>
										<td><?php  echo $row['iso3_code']; ?></td>
										<td><?php  echo $row['iso_numeric_code']; ?></td>
										<td><?php  echo $row['fips_code']; ?></td>
										<td><?php  echo $row['calling_code']; ?></td>
										<td><?php  echo $row['common_name']; ?></td>
										<td><?php  echo $row['official_name']; ?></td>
										<td><?php  echo $row['endonym']; ?></td>
										<td><?php  echo $row['demonym']; ?></td>
									</tr>
								<?php
								
							}

							$db_table = "country";
							$countrycsv->pagination($limit, $db_table, $start, $page);

						}
						else {?>
						
							<tr/>
								<td>No row found</td>
							</tr>

							<?php
						}
					}
								
				?>
				
				</tbody>

			</table>
		</div>
	</body>
</html>