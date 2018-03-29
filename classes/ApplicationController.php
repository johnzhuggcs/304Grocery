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

    //Includes all classes


    function ApplicationController($sqlExecution, $utility, $whichUser){

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;
        $this->EmployeeOrCustomer = $whichUser; //If = 1, it is Employee, if = 0, it is Customer
    }

    function start(){
        global $db_conn, $success;


        if ($db_conn) {

            if (array_key_exists('reset', $_POST)) {

                $TablePopulator = new TablePopulation($this->SQLExecution);

                // Drop old table...
                echo ('<div class="card container text-center" ><div class="card-body"><h5>dropping table</h5></div></div>');
                $TablePopulator->dropAll();

                // Create new table...
                echo ('<div class="card container text-center" ><div class="card-body"><h5>creating new table</h5></div></div>');
                $TablePopulator->populateAll();

                echo ('<div class="card container text-center" ><div class="card-body"><h5>importing existing Employees and Customers</h5></div></div>');
                $TablePopulator->insertEmployeeCustomer();


            } else if($this->EmployeeOrCustomer){
                echo ('<div class="card container text-center" ><div class="card-body"><h5>am employee</h5></div></div>');
                    $CustomerExecution = new CustomerExecution();
                    $CustomerExecution->start();
            }else if(!$this->EmployeeOrCustomer){
                echo ('<div class="card container text-center" ><div class="card-body"><h5>am customer</h5></div></div>');

                $EmployeeExecution = new EmployeeExecution();
                $EmployeeExecution->start();
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