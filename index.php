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
		var BuyProductsView;
		var customerArray_js = <?php echo json_encode($_SESSION['customerArray']); ?>;
		var employeeArray_js = <?php echo json_encode($_SESSION['employeeArray']); ?>;

		$(function() { //run on document.ready
			if(localStorage.getItem("userType", user) !== undefined){
	   			if(localStorage.getItem("userType") == 1){
			    	$('#CustomerNav').show();
			    	$('#EmployeeNav').hide();
			    	$('#createUser').hide();
			    	$('#logon').hide();
					$('#logoutButton').show();
				}else if (localStorage.getItem("userType") == 2){
					$('#CustomerNav').hide();
					$('#EmployeeNav').show();
					$('#createUser').hide();
					$('#logon').hide();
					$('#logoutButton').show();
				}else{
					$('#CustomerNav').hide();
					$('#EmployeeNav').hide();
					$('#createUser').show();
					$('#logon').show();
					$('#logoutButton').hide();
				}
			}

			if(localStorage.getItem("BuyProductsView") == 1){
				$('#BuyProducts').show();
			}

			$("#userSelect").change(function() { //this occurs when select 1 changes
				console.log("detect");
				user =  document.getElementById("userSelect").value;
				$('#nameSelect')
    				.find('option')
    				.remove();
				if(user == 1){
					console.log("Customer");
					console.log(customerArray_js.length);
					var sel = document.getElementById('nameSelect');
					for(var i = 0; i < customerArray_js.length; i++) {
			    		var opt = document.createElement('option');
			    		opt.innerHTML = customerArray_js[i];
			    		opt.value = customerArray_js[i];
			    		sel.appendChild(opt);
					}
				}else if(user == 2){
					console.log("Employee");
					var sel = document.getElementById('nameSelect');
					for(var i = 0; i < employeeArray_js.length; i++) {
			    		var opt = document.createElement('option');
			    		opt.innerHTML = employeeArray_js[i];
			    		opt.value = employeeArray_js[i];
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
			localStorage.setItem("BuyProductsView",1);
		}
		function OpenAccount(){
			$('#Account').toggle();
		}
		function OpenRestockProducts(){
			$('#restockProducts').toggle();
		}
		function OpenShippingInfo(){
			$('#shippingInfo').toggle();
		}
		function OpenUpdateShippingInfo(){
			$('#UpdateShippingInfo').toggle();
		}
		function createUser(){
			user = 1;
			localStorage.setItem("userType",user);
		}
		function OpenFilter(){
			$('#Filter').toggle();
		}
		function OpenViewCart(){
			$('#viewCart').toggle();
		}
		function closeBuyProduct(){
			$('#BuyProducts').toggle();
			localStorage.setItem("BuyProductsView",0);
		}
		function logout(){
			delete localStorage.clear();
			location.reload();
		}
		function setUser(){
			user =  document.getElementById("userSelect").value;
			if(user == 1){
				$('#CustomerNav').show();
				$('#EmployeeNav').hide();
			}else if(user == 2){
				$('#CustomerNav').hide();
				$('#EmployeeNav').show();
			}
			localStorage.setItem("userType", user);
		}
		function resetLS() {
			delete localStorage.clear();
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
					<form method="POST" action="index.php">
						<a class="dropdown-item nav-link">
							<input class="btn btn-primary" Type="submit" name="getProducts" value="Buy Products" onclick="OpenBuyProducts()">
						</a>
					</form>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenViewCart()">View Cart</button></a>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenShippingInfo()">Shipping Info</button></a>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenUpdateShippingInfo()">Update Shipping Info</button></a>
					<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenFilter()">Filter Attribute</button></a>
				</div>
			</li>
			<li id="createUser">
				<a class="dropdown-item nav-link"><button class="btn btn-primary" onclick="OpenAccount()">Create User</button></a>
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
						<input class="btn btn-primary" type="submit" onclick="resetLS()" value="Reset" name="reset">
					</form>
				</a>
			</li>
			<li class="nav-item " id="logoutButton" >
				<a class="nav-link">
					<form method="POST" action="index.php">
						<input class="btn btn-danger" type="submit" onclick="logout()" value="Logout" name="logoff">
					</form>
				</a>
			</li>
		</ul>
	</nav>

	<div id="logon" class="container card text-center">
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
					<form method="POST" action="index.php">
						<input class="btn btn-primary" Type="submit" name="selectAccount" value="Submit" onclick="setUser()">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div id="Filter" class="card container" style="display: none;" >
		<div class="card-header">
			<h4>Create User</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container form-group">
					<div class="row">
						<div class="col-md-4">
							<h5>Attribute:</h5>
						</div>
						<div class="col-md-8">
							<Select name="attr" class="form-control">
								<option value="0">&nbsp;</option>
								<option value="pid">ID</option>
								<option value="price">Price</option>
								<option value="expire_date">Expire Date</option>
								<option value="ingredients">Ingredients</option>
								<option value="cfoot">Carbon Footprint</option>
								<option value="origin">Origin</option>
								<option value="quantity">Stock Quantity</option>
								<option value="name">Name</option>
								<option value="brand">Brand</option>
								<option value="description">Description</option>
								<option value="rpoint">Reward Points</option>
							</Select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Price <  :</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="sel_price">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
					<div class="row text-center">
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
							<input class="btn btn-success" type="submit" value="Save" name="select_view">
						</div>
						<div class="col-md-3">
							<input class="btn btn-danger" type="Submit" value="Cancel" onclick="OpenFilter()">
						</div>
						<div class="col-md-3">&nbsp;</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="Account" class="card container" style="display: none;" >
		<div class="card-header">
			<h4>Create User</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container form-group">
					<div class="row">
						<div class="col-md-4">
							<h5>Name:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="Name">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Email:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="Email">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
					<div class="row text-center">
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
							<input class="btn btn-success" type="submit" value="Save" onclick="createUser()" name="create_customer">
						</div>
						<div class="col-md-3">
							<input class="btn btn-danger" type="Submit" value="Cancel" onclick="OpenAccount()">
						</div>
						<div class="col-md-3">&nbsp;</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="UpdateShippingInfo" class="card container" style="display: none;" >
		<div class="card-header">
			<h4>Add Shipping Info</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container form-group">
					<div class="row">
						<div class="col-md-4">
							<h5>New Shipping Address:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="new_address">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Shipping Info Number:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="shipping_info_no">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
					<div class="row text-center">
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
							<input class="btn btn-success" type="submit" value="Save" name="update_shipping_address">
						</div>
						<div class="col-md-3">
							<input class="btn btn-danger" type="Submit" value="Cancel" onclick="OpenUpdateShippingInfo()">
						</div>
						<div class="col-md-3">&nbsp;</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="shippingInfo" class="card container" style="display: none;" >
		<div class="card-header">
			<h4>Add Shipping Info</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container form-group">
					<div class="row">
						<div class="col-md-4">
							<h5>Billing Adress:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="Billing_address">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Shipping Address:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="Shipping_address">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Phone Number:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="Phone_number">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Shipping Method:</h5>
						</div>
						<div class="col-md-8">
							<select name="Shipping_method" class="form-control">
								<option>Express (1-2 Days)</option>
								<option>Business (3-5 Days)</option>
								<option>Ground (10-20 Days)</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Delivery Type:</h5>
						</div>
						<div class="col-md-8">
							<select name="delivery_type" class="form-control">
								<option>Home Delivery</option>
								<option>In Store Pick Up</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
					<div class="row text-center">
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
							<input class="btn btn-success" type="submit" value="Save" name="create_shipinfo">
						</div>
						<div class="col-md-3">
							<input class="btn btn-danger" type="Submit" value="Cancel" onclick="OpenShippingInfo()">
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
					<h4>Upgrade Customers Accounts To Premium </h4>
				</div>
			</div>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="row">
					<div class="col-md-12">
						<input class="btn btn-primary" type="submit" value="Submit" name="modify_prem">
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
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-12">&nbsp;</div>
			</div>
			<div class="row text-center">
				<div class="col-md-12">
					<input class="btn btn-danger" type="Submit" value="Cancel" onclick="closeBuyProduct()">
				</div>
			</div>
		</div>
	</div>

	<div id="viewCart" class="card container" style="display: none;" >
		<div class="card-header text-center">
			<h4>Veiw Cart</h4>
		</div>
		<div class="card-body">
			<form method="POST" action="index.php">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<h5>Date:</h5>
						</div>
						<div class="col-md-8">
							<input class="form-control" type="text"  name="order_date">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h5>Purchase Method:</h5>
						</div>
						<div class="col-md-8">
							<select class="form-control" name="Payment_method">
								<option>Visa</option>
								<option>Mastercard</option>
								<option>American Express</option>
								<option>PayPal</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" style="overflow-x: auto;">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Price</th>
										<th>Expire date</th>
										<th>Name</th>
										<th>Brand</th>
										<th>description</th>
										<th>Reward Points</th>
									</tr>
								</thead> 
								<tbody>
									<tr>
										<td><input type="text" name="pid" ></td>
										<td><input type="text" name="price" ></td>
										<td><input type="text" name="expire_date" ></td>
										<td><input type="text" name="name" ></td>
										<td><input type="text" name="brand" ></td>
										<td><input type="text" name="description" ></td>
										<td><input type="text" name="rpoint" ></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
						<div class="col-md-12">&nbsp;</div>
				</div>
				<div class="row text-center">
					<div class="col-md-3">&nbsp;</div>
					<div class="col-md-3">
						<input class="btn btn-success" type="submit" value="Submit Order" name="place_order">
					</div>
					<div class="col-md-3">
						<input class="btn btn-danger" type="Submit" value="Cancel" onclick="OpenViewCart()">
					</div>
					<div class="col-md-3">&nbsp;</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>


<?php
// orting(-1);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);*/

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

//echo "before begin app\n\n";
if (!isset($_SESSION['Begin_App']) || array_key_exists('reset', $_POST)){
    if(array_key_exists('reset', $_POST)){
        $_SESSION['Initialized_table'] = null;
    }
    $_SESSION['Begin_App'] = 1;
    //echo "<p>begin app is now == ".$_SESSION['Begin_App']."</p>";
    $AccountInitializer->start();

    $_SESSION['customerArray'] = $Utility->sessionResult($AccountInitializer->getAllCustomers());
    $_SESSION['employeeArray'] = $Utility->sessionResult($AccountInitializer->getAllEmployees());


    //echo ('<div class="card container text-center" ><div class="card-body"><h5>'.$_SESSION['customerArray'].'</h5></div></div>');

    // echo $customerArray[0];
//$customer should be C0001 or some other
//Pretend we chose some account in the front end for $customer
    $customer = $_SESSION['customerArray'][0];

    $_SESSION["AccountID"] = $customer;


    header("location: index.php");


}else if($_SESSION['Begin_App'] == 1){
    if($db_conn){

        if(array_key_exists("create_customer", $_POST)){

            $CustomerCreator = new CustomerCreation($SQLConnection, $Utility);
            $CustomerCreator->start();
            echo "loggin on in index.php\n\n";
            echo "<p>Logged On: </p>";
            echo "<p>".$_SESSION["AccountID"]." is the Logged On account </p>";
            $_SESSION['Begin_App'] = 2;
            $ApplicationController = ApplicationController::getApplicationInstance($SQLConnection, $Utility, $_SESSION["AccountID"]);//controls the application, checks when to create table/execute sql queriess
            $ApplicationController->start();
        }else
        if(array_key_exists('selectAccount', $_POST)){
            //echo "loggin on in index.php\n\n";
           /* echo "<p>Logged On: </p>";
            echo "<p>".$_POST["accountNum"]." is the Logged On account </p>";*/
            $_SESSION["AccountID"] = $_POST["nameSelect"];
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

