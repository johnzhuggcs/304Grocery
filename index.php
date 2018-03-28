<html>
<head>
	<link href="css/bootstrap.min.css" rel="stylesheet"/>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<h2>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</h2>
			<form method="POST" action="index.php">
				<input class="btn btn-primary" type="submit" value="Reset" name="reset">
			</form>
		</div>
	</div>
	<form method="POST" action="index.php">
		<div class="container">
			<div class="row">
				<h4>Add Products</h4>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Price</th>
							<th>Expire date</th>
							<th>Ingredients</th>
							<th>Carbon Footprint</th>
							<th>Origin</th>
							<th>Stock_quantity</th>
							<th>Name</th>
							<th>Brand</th>
							<th>description</th>
							<th>Reward points</th>
							<th>Weight</th>
							<th>Allergies</th>
							<th>Volume</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="text" name="pid" ></td>
							<td><input type="text" name="price" ></td>
							<td><input type="text" name="expire_date" ></td>
							<td><input type="text" name="ingredients" ></td>
							<td><input type="text" name="cfoot" ></td>
							<td><input type="text" name="origin" ></td>
							<td><input type="text" name="quantity" ></td>
							<td><input type="text" name="name" ></td>
							<td><input type="text" name="brand" ></td>
							<td><input type="text" name="description" ></td>
							<td><input type="text" name="rpoint" ></td>
							<td><input type="text" name="weight" ></td>
							<td><input type="text" name="allergies" ></td>
							<td><input type="text" name="volume" ></td>
						</tr>
					</tbody>
				</table>
			</div>
			<input class="btn btn-primary" type="submit" value="insert" name="AddNewProduct"></p>
		</div>
	</form>
	<!-- Restock quantity by some number--> 
	<form method="POST" action="index.php">
		<div class="container">
			<div class="row">
				<h4> Restock products: </h4>
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
				<input type="submit" value="update" name="RestockProductSubmit">
				<h4> Display all the products: </h4>
				<input type="submit" value="display" name="displayall"></p>
			</div>
		</div>
	</form>
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
$ApplicationController = new ApplicationController($SQLConnection, $Utility); //controls the application, checks when to create table/execute sql queriess

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

