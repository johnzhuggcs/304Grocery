<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script type="text/javascript">

		function AddProducts() {
    		$('#addProducts').toggle();
		}
		function CustomerPremium(){
			$('#CustomerPremium').toggle();
		}


	</script>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link"><button class="btn btn-primary" onclick="AddProducts()">Add Products</button></a>
			</li>
			<li class="nav-item">
				<a class="nav-link"><button class="btn btn-primary" onclick="CustomerPremium()">Customer Premium</button></a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item ">
				<a class="nav-link">
					<form method="POST" action="index.php">
					<input class="btn btn-primary" type="submit" value="Display All Products" name="displayall"></p>
				</form>
				</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link">
					<form method="POST" action="index.php">
						<input class="btn btn-primary" type="submit" value="Reset" name="reset">
					</form>
				</a>
			</li>
		</ul>
	</nav>

	<div class="container card text-center">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h4>Select User </h4>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<h5>User Type</h5>
				</div>
				<div class="col-md-6">
					<h5>Name </h5>
				</div>
			</div>
			<form method="POST" action="index.php">
				<div class="row">
					<div class="col-md-6">
						<Select class="col-md-6">
							<option>&nbsp;</option>
							<option>Customer</option>
							<option>Employee</option>
						</Select>
					</div>
					<div class="col-md-6">
						<Select class="col-md-6">
							<option>&nbsp;</option>
							<option>John Smith</option>
							<option>Ryan Reynolds</option>
							<option>Emma Watson</option>
						</Select>
					</div>
					<input class="btn btn-primary" type="submit" value="Submit" name="UserSubmit">
				</div>
			</form>
		</div>
	</div>

	<div id="CustomerPremium" class="container card text-center" style="display: none;">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h4>Upgrade Customer Accounts To Premium </h4>
				</div>
			</div>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="row">
					<div class="col-md-12">
						<input class="btn btn-primary" type="submit" value="Submit" name="CustomerPremium">
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="addProducts" class="card container text-center" style="display: none;" >
		<div class="card-header">
			<h4>Add Products</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Price</th>
										<th>Expire date</th>
										<th>Ingredients</th>
										<th>Carbon Footprint</th>
									</tr>
								</thead> 
								<tbody>
									<tr>
										<td><input type="text" name="pid" ></td>
										<td><input type="text" name="price" ></td>
										<td><input type="text" name="expire_date" ></td>
										<td><input type="text" name="ingredients" ></td>
										<td><input type="text" name="cfoot" ></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Origin</th>
										<th>Stock_quantity</th>
										<th>Name</th>
										<th>Brand</th>
										<th>description</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" name="origin" ></td>
										<td><input type="text" name="quantity" ></td>
										<td><input type="text" name="name" ></td>
										<td><input type="text" name="brand" ></td>
										<td><input type="text" name="description" ></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Reward Points</th>
										<th>Weight</th>
										<th>Allergies</th>
										<th>Volume</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="text" name="rpoint" ></td>
										<td><input type="text" name="weight" ></td>
										<td><input type="text" name="allergies" ></td>
										<td><input type="text" name="volume" ></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<input class="btn btn-primary" type="submit" value="insert" name="AddNewProduct"></p>
				</div>
			</form>
		</div>
	</div>
	
	<div class=" card container">
		<div class="card-header">
			<h4> Restock products: </h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<form method="POST" action="index.php">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Added Quantity</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" name="id" ></td>
									<td><input type="text" name="addq" ></td>
								</tr>
							</tbody>
						</table>

						<input class="btn btn-primary" type="submit" value="update" name="RestockProductSubmit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class=" card container">
		<div class="card-header">
			<h4> Display all the products: </h4>
		</div>
		<div class="card-body">
			<div class="row">
				<form method="POST" action="index.php">
				<div class="col-md-12"
					<h4> Display all the products: </h4>
					<input class="btn btn-primary" type="submit" value="display" name="displayall"></p>
				</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>

<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

//Includes all classes
set_include_path ( "./classes" );
spl_autoload_register(function ($class) {
	include 'classes/' . $class . '.php';
});

//class is automatically loaded from ./classes/myclass.php
$success = true;
$db_conn;
$connectionController = new ConnectionController(); //Initializes connection to database

$SQLConnection = new SQLExecution(); //Executing SQL Statements
$Utility = new Utility(); //To print
$ApplicationController = new ApplicationController($SQLConnection, $Utility, 0); //controls the application, checks when to create table/execute sql queriess

// Connect Oracle...
$ApplicationController->start();





/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */

/* OCIParse() Prepares Oracle statement for execution
The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode */

/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
     ?>

