<?php
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
?>
<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>
<form method="POST" action="index.php">
   
<p><input type="submit" value="Reset" name="reset"></p>
</form>

<p>Insert values into product below:</p>
<p><font size="2"> ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Expire_date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Ingredients&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Carbon_Footprint&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Origin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Stock_quantity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Brand&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
description&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Reward_points&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Weight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Allergies&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Volume</font></p>
<form method="POST" action="index.php">
<!--refresh page when submit-->

   <p><input type="text" name="pid" size="3">
   <input type="text" name="price" size="4">
   <input type="text" name="expire_date" size="11">
   <input type="text" name="ingredients" size="10">
   <input type="text" name="cfoot" size="14">
   <input type="text" name="origin" size="6">
   <input type="text" name="quantity" size="13">
   <input type="text" name="name" size="5">
   <input type="text" name="brand" size="6">
   <input type="text" name="description" size="10">
   <input type="text" name="rpoint" size="12">
   <input type="text" name="weight" size="6">
   <input type="text" name="allergies" size="8">
   <input type="text" name="volume" size="8">
	</p>
<!--define two variables to pass the value-->
      
<input type="submit" value="insert" name="AddNewProduct"></p>
</form>

<form method="POST" action="index.php">

    <p>
    <input type="text" name="accountNum" size="8"></p>
    <!--define two variables to pass the value-->

    <input type="submit" value="Log On" name="logon"></p>
</form>

<form method="POST" action="index.php">


    </p>
    <!--define two variables to pass the value-->

    <input type="submit" value="Log Off" name="logoff"></p>
</form>


<p><font size="2"> Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Reward Points&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Premium&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </font></p>

<form method = "POST" action = "index.php">
    <p><input type="text" name="Name" size="3">
        <input type="email" name="Email" size="4">
        <input type="number" name="Reward_Points" size="11">
        <input type="number" name="Premium" size="10">
    </p>
    <input type = "submit" value = "Create Customer" name = 'create_customer'></form>



<!-- Restock quantity by some number--> 

<p> Restock products: </p>
<p><font size="2"> ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
AddedQuantity</font></p>
<form method="POST" action="index.php">
<!--refresh page when submit-->

   <p><input type="text" name="id" size="6"><input type="text" name="addq" 
size="18">
<!--define two variables to pass the value-->
      
<input type="submit" value="update" name="RestockProductSubmit"></p>
<p> Display all the products: </p>
<input type="submit" value="display" name="displayall"></p>
</form>

<?php
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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

echo "before begin app\n\n";
if (!isset($_SESSION['Begin_App']) || array_key_exists('reset', $_POST)){
    if(array_key_exists('reset', $_POST)){
        $_SESSION['Initialized_table'] = null;
    }
    $_SESSION['Begin_App'] = 1;
    echo "<p>begin app is now == ".$_SESSION['Begin_App']."</p>";
    $AccountInitializer->start();
    $customerArray = OCI_Fetch_Array($AccountInitializer->getAllCustomers(), OCI_BOTH);
    $employeeArray = OCI_Fetch_Array($AccountInitializer->getAllEmployees(), OCI_BOTH);

//$customer should be C0001 or some other
//Pretend we chose some account in the front end for $customer
    $customer = $customerArray[0];

    print_r($customerArray);
    echo "<p></p>";
    echo "<p>Customer '.$customerArray.' </p>";
    echo "<p>Customer '.$customer.' </p>";

    $_SESSION["AccountID"] = $customer;

    header("location: index.php");


}else if($_SESSION['Begin_App'] == 1){
    if($db_conn){
        if(array_key_exists('logon', $_POST)){
            //echo "loggin on in index.php\n\n";
            echo "<p>Logged On: </p>";
            echo "<p>".$_POST["accountNum"]." is the Logged On account </p>";
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
    echo "application start";
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

