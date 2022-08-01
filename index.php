<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agpaytech Assignment - Home</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/bootstrap.bundle.js"></script>
	
	
</head>
<body>
	<div class="p-3 ">
		<h2 class="bg-light col-md-6">Import CSV into Database</h2>
		<div class="row">
			<div class="dropdown">
			 	<!-- Button to Open the Modal -->
			  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
			    Select CSV to upload
			  </button>
			  <ul class="dropdown-menu p-2">
			    <li ><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#country">Country</a></li>
			    <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#currency" >Currency</a></li>
			   </ul>
			</div> 

		</div>	

		<!-- Country Modal -->
		<div class="modal" id="country" >
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">Import Country CSV</h4>
		        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
		      </div>

		      <!-- Modal body -->
		      <div class="modal-body">
		         <form action="country.php" method="POST" enctype="multipart/form-data" id="country">
		            <input type="file" name="csvfile" />
		            <input type="submit" class="btn btn-primary" name="submit-country" value="Import">
		        </form>
		      </div>

		      <!-- Modal footer -->
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
		      </div>

		    </div>
		  </div>
		</div>

		<!-- Currency Modal -->
		<div class="modal" id="currency">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">Import Currency CSV</h4>
		        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
		      </div>

		      <!-- Modal body -->
		      <div class="modal-body">
		        <form action="currency.php" method="POST" enctype="multipart/form-data" id="currency" >
		            <input type="file" name="csvfile" />
		            <input type="submit" class="btn btn-primary" name="submit-currency" value="Import">
		        </form>
		      </div>

		      <!-- Modal footer -->
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
		      </div>

		    </div>
		  </div>
		</div>
		
		<div class="row justify-content-center">
			
			<div class="col-md-3 p-4">
				<a href="country.php" class="btn btn-primary">Country CSV</a>
		    </div>
		    <div class="col-md-3 p-4">
				<a href="currency.php" class="btn btn-primary">Currency CSV</a>
		    </div>
		</div>
		
	</body>


</html>