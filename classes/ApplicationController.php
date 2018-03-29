<?php

/**
 * Created by PhpStorm.
 * User: johnz
 * Date: 2018-03-27
 * Time: 12:06 PM
 */

class ApplicationController
{
    private $SQLExecution;
    private $Utility;
    private $EmployeeOrCustomer;
    private static $instance;

    //Includes all classes


    function ApplicationController($sqlExecution, $utility, $whichUser){

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;
        $this->accountNoToBool($whichUser);
        $_SESSION["AccountID"] = $whichUser;
    }

    // Takes in account number chosen and determines whether employee or customer
    private function accountNoToBool($whichUser){
        $cOrE = substr($whichUser, 0);
        switch($cOrE){ //If = 1, it is Employee, if = 0, it is Customer
            case "C":
                $this->EmployeeOrCustomer = 0;
                break;
            case "E":
                $this->EmployeeOrCustomer = 1;
                break;
        }

    }

    public static function getApplicationInstance($sqlExecution, $utility, $whichUser){
        if(!isset(self::$instance)){
            self::$instance = new ApplicationController($sqlExecution, $utility, $whichUser);
        }
        return self::$instance;
    }

    function start(){
        global $db_conn, $success;


        if ($db_conn) {

            echo "<p>Session begin";
            echo $_SESSION['Begin_App'];
            echo "</p>";


            if(array_key_exists('logoff', $_POST)){
                echo "<p>Log off</p>";
                //$_SESSION['Begin_App'] = null;
            }
            else if (array_key_exists('reset', $_POST)) {
                //$_SESSION['Initialized_table'] = null;
                //$_SESSION['Begin_App'] = null;
                $TablePopulator = new TablePopulation($this->SQLExecution);

                // Drop old table...
                echo ('<div class="card container text-center" ><div class="card-body"><h5>dropping table</h5></div></div>');
                $TablePopulator->dropAll();
                //$_SESSION['customerNo'] = null;
                // Create new table...
                echo ('<div class="card container text-center" ><div class="card-body"><h5>creating new table</h5></div></div>');
                $TablePopulator->populateAll();

                echo ('<div class="card container text-center" ><div class="card-body"><h5>importing existing Employees and Customers</h5></div></div>');
                $TablePopulator->insertEmployeeCustomer();


            } else if($this->EmployeeOrCustomer){


                $EmployeeExecution = EmployeeExecution::getEmployeeInstance($this->SQLExecution, $this->Utility);
/*=======
                echo ('<div class="card container text-center" ><div class="card-body"><h5>am employee</h5></div></div>');
                    $CustomerExecution = new CustomerExecution();
                    $CustomerExecution->start();
            }else if(!$this->EmployeeOrCustomer){
                echo ('<div class="card container text-center" ><div class="card-body"><h5>am customer</h5></div></div>');

                $EmployeeExecution = new EmployeeExecution();
>>>>>>> 9266fc2936ffd57fb0263a47f51d5802478e0195*/
                $EmployeeExecution->start();
            }else if(!$this->EmployeeOrCustomer){


                $CustomerExecution = CustomerExecution::getCustomerInstance($this->SQLExecution, $this->Utility);
                $CustomerExecution->start();
            }

            if ($_POST && $success) {
                //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
                $employeeResult = $this->SQLExecution->executePlainSQL("select * from Employee");
                $this->Utility->printResult($employeeResult);
                $customerResult = $this->SQLExecution->executePlainSQL("select * from Customer");
                $this->Utility->printResult($customerResult);
                $orderAllResult = $this->SQLExecution->executePlainSQL("select * from Order_placedby_shippedwith");
                $this->Utility->printResult($orderAllResult);
                header("location: index.php");
            }
            else {
                // Select data...
                echo ('<div class="card container text-center" ><div class="card-body"><h5>No action Idle Page</h5></div></div>');
                $result = $this->SQLExecution->executePlainSQL("select * from product");
                $this->Utility->printResult($result);
                $employeeResult = $this->SQLExecution->executePlainSQL("select * from Employee");
                $this->Utility->printResult($employeeResult);
                $customerResult = $this->SQLExecution->executePlainSQL("select * from Customer");
                $this->Utility->printResult($customerResult);
                $orderAllResult = $this->SQLExecution->executePlainSQL("select * from Order_placedby_shippedwith");
                $this->Utility->printResult($orderAllResult);
            }

            //Commit to save changes...
            OCILogoff($db_conn);
        } else {
            echo ('<div class="card container text-center" ><div class="card-body"><h5>cannot connect</h5></div></div>');

            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo ('<div class="card container text-center" ><div class="card-body"><h5>'.htmlentities($e['message']).'</h5></div></div>');

        }
    }


}