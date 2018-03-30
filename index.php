<?php 
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script type="text/javascript">
		var user;
		var customerArray_js = <?php echo json_encode($_SESSION['customerArray']); ?>;
		var employeeArray_js = <?php echo json_encode($_SESSION['employeeArray']); ?>;
    
		$(function() { //run on document.ready
			$("#userSelect").change(function() { //this occurs when select 1 changes
				console.log("detect");
				user =  document.getElementById("userSelect").value;
				if(user == 1){
					console.log("Customer");
					console.log(customerArray_js.length);
					var sel = document.getElementById('nameSelect');
					for(var i = 0; i < customerArray_js.length; i++) {
			    		var opt = document.createElement('option');
			    		opt.innerHTML = customerArray_js[i].ACCOUNT_NO;
			    		opt.value = customerArray_js[i].ACCOUNT_NO;
			    		sel.appendChild(opt);
					}
				}else if(user == 2){
					console.log("Employee");
					var sel = document.getElementById('nameSelect');
					for(var i = 0; i < employeeArray_js.length; i++) {
			    		var opt = document.createElement('option');
			    		opt.innerHTML = employeeArray_js[i].EMPLOYEE_ID;
			    		opt.value = employeeArray_js[i].EMPLOYEE_ID;
			    		sel.appendChild(opt);
					}
				}
			});
		});

		function AddProducts() {
    		$('#addProducts').toggle();
		}
		function CustomerPremium(){
			$('#CustomerPremium').toggle();
		}
		function OpenBuyProducts(){
			$('#BuyProducts').toggle();
		}
		function OpenAccount(){
			$('#Account').toggle();
		}
		function OpenRestockProducts(){
			$('#restockProducts').toggle();
		}
		function setUser(){
			user =  document.getElementById("userSelect").value;
			if(user == 1){
				$('#CustomerNav').show();
				$('#EmployeeNav').hide();
			}else if(user ==2){
				$('#CustomerNav').hide();
				$('#EmployeeNav').show();
			}
			var customerArray_js = <?php echo json_encode($_SESSION['customerArray']); ?>;
			var employeeArray_js = <?php echo json_encode($_SESSION['employeeArray']); ?>;
			console.log(customerArray_js);
			console.log(employeeArray_js);
		}
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark">
		<ul class="navbar-nav">
			<li id="EmployeeNav" class="nav-item dropdown" style="display: none;">
				<a class="nav-link" data-toggle="dropdown">
					<button class="btn btn-danger fa fa-bars"></button>
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenBuyProducts()">Buy Products</button></a>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="AddProducts()">Add Products</button></a>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="CustomerPremium()">Customer Premium</button></a>	
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenRestockProducts()">Restock Products</button></a>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenAccount()">Account</button></a>
				</div>
			</li>
			<li id="CustomerNav" class="nav-item dropdown" style="display: none;">
				<a class="nav-link" data-toggle="dropdown">
					<button class="btn btn-primary fa fa-bars"></button>
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenBuyProducts()">Buy Products</button></a>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenAccount()">Account</button></a>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item ">
				<a class="nav-link">
					<form method="POST" action="index.php">
						<input class="btn btn-primary" type="submit" value="Display All Products" name="displayall">
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
				<div class="col-md-5">
					<h5>User Type</h5>
				</div>
				<div class="col-md-5">
					<h5>User ID</h5>
				</div>
				<div class="col-md-2">
					<h5>&nbsp; </h5>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<Select id="userSelect" class="form-control">
						<option value="0">&nbsp;</option>
						<option value="1">Customer</option>
						<option value="2">Employee</option>
					</Select>
				</div>
				<div class="col-md-5">
					<Select id="nameSelect" class="form-control">
					</Select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-primary" onclick="setUser()">Submit</button>
				</div>
			</div>
		</div>
	</div>

	<div id="Account" class="card container" style="display: none;" >
		<div class="card-header">
			<h4>Account Settings</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container form-group">
					<div class="row">
						<div class="col-md-4">
							<h5>ID:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text" name="UserID">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Name:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="UserName">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Email:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="UserEmail">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Reward Points:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text" name="UserPoints">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Premium Status:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text" name="PremiumStatus">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
					<div class="row text-center">
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
							<input class="btn btn-success" type="submit" value="Save" name="AccountSave">
						</div>
						<div class="col-md-3">
							<input class="btn btn-danger" type="Submit" value="Cancel" name="AccountCancel">
						</div>
						<div class="col-md-3">&nbsp;</div>
					</div>
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
										<td><input class="form-control" type="text" name="pid" ></td>
										<td><input class="form-control" type="text" name="price" ></td>
										<td><input class="form-control" type="text" name="expire_date" ></td>
										<td><input class="form-control" type="text" name="ingredients" ></td>
										<td><input class="form-control" type="text" name="cfoot" ></td>
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
										<td><input class="form-control" type="text" name="origin" ></td>
										<td><input class="form-control" type="text" name="quantity" ></td>
										<td><input class="form-control" type="text" name="name" ></td>
										<td><input class="form-control" type="text" name="brand" ></td>
										<td><input class="form-control" type="text" name="description" ></td>
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
										<td><input class="form-control" type="text" name="rpoint" ></td>
										<td><input class="form-control" type="text" name="weight" ></td>
										<td><input class="form-control" type="text" name="allergies" ></td>
										<td><input class="form-control" type="text" name="volume" ></td>
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
	
	<div id="restockProducts" class=" card container" style="display: none;">
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
									<td><input class="form-control" type="text" name="id" ></td>
									<td><input class="form-control" type="text" name="addq" ></td>
								</tr>
							</tbody>
						</table>

						<input class="btn btn-primary" type="submit" value="update" name="RestockProductSubmit">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div id="BuyProducts" class="card container text-center" style="display: none;" >
		<div class="card-header">
			<h4>Add Products To Cart</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container">
					<div class="row">
						<div class="col-md-12" style="overflow-x: auto;">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Add To Cart</th>
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
										<th>Reward Points</th>
										<th>Weight</th>
										<th>Allergies</th>
										<th>Volume</th>
									</tr>
								</thead> 
								<tbody>
									<tr>
										<td><input class="btn btn-primary" type="submit" value="Add" name="AddToCart"></td>
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
					</div>
				</div>
			</form>
		</div>
	</div>

</body>
</html>


<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
// session_start();
//phpinfo();


//debugging info

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
$connectionController = ConnectionController::getConnectionInstance(); //Initializes connection to database

$SQLConnection = new SQLExecution(); //Executing SQL Statements
$Utility = new Utility(); //To print
$AccountInitializer = new AccountInitializer($SQLConnection, $Utility);


    $_SESSION['Begin_App'] = 1;
    //echo "<p>begin app is now == ".$_SESSION['Begin_App']."</p>";
    $AccountInitializer->start();

    $customerArray = array();
    $employeeArray = array();
    $counter = 0;
    while($tempEmployeeArray = OCI_Fetch_Array($AccountInitializer->getAllEmployees(), OCI_BOTH)){
        $employeeArray[$counter] = $tempEmployeeArray[0];
        $employee = $tempEmployeeArray[0];
        $counter++;
    }
    $counter = 0;
    while($tempCustomerArray = OCI_Fetch_Array($AccountInitializer->getAllCustomers(), OCI_BOTH)){
        $customerArray[$counter] = $tempCustomerArray[0];
        $customer = $tempCustomerArray[0];
        $counter++;
    }

    $_SESSION['customerArray'] = $customerArray;
    $_SESSION['employeeArray'] = $employeeArray;

    echo $_SESSION['customerArray'][0];
    echo $_SESSION['customerArray'][1];


    // echo $customerArray[0];
//$customer should be C0001 or some other
//Pretend we chose some account in the front end for $customer
    $customer = $customerArray[0];

    $_SESSION["AccountID"] = $customer;

    header("location: index.php");


}else if($_SESSION['Begin_App'] == 1){
    if($db_conn){
        if(array_key_exists('logon', $_POST)){
            //echo "loggin on in index.php\n\n";
           /* echo "<p>Logged On: </p>";
            echo "<p>".$_POST["accountNum"]." is the Logged On account </p>";*/
            $_SESSION["AccountID"] = $_POST["accountNum"];
            //echo ('<div class="card container text-center" ><div class="card-body"><h5>'.$_SESSION["AccountID"].'</h5></div></div>');


            $_SESSION['Begin_App'] = 2;
            $ApplicationController = ApplicationController::getApplicationInstance($SQLConnection, $Utility, $_SESSION["AccountID"]);//controls the application, checks when to create table/execute sql queriess
            $ApplicationController->start();
        }
    }else{
        echo "cannot connect";
        $e = OCI_Error(); // For OCILogon errors pass no handle
        echo htmlentities($e['message']);
    }
} else{
    // echo "application start";
    $ApplicationController = ApplicationController::getApplicationInstance($SQLConnection, $Utility, $_SESSION["AccountID"]);
    $ApplicationController->start();
}


//$ApplicationController = ApplicationController::getApplicationInstance($SQLConnection, $Utility, "C0001"); //controls the application, checks when to create table/execute sql queriess

// Connect Oracle...






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

