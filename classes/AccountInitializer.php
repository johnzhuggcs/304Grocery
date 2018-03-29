<?php
/**
 * Created by PhpStorm.
 * User: johnz
 * Date: 2018-03-28
 * Time: 11:21 PM
 */

class AccountInitializer
{
    private $SQLExecution;
    private $Utility;
    private $EmployeeResults;
    private $CustomerResults;



    function AccountInitializer($sqlExecution, $utility){

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;
    }

    function start(){
        global $db_conn, $success;
        if($db_conn){

            if (!isset($_SESSION['Initialized_table'])){
                $_SESSION['Initialized_table'] = 1;
                $TablePopulator = new TablePopulation($this->SQLExecution);

                // Drop old table...
                echo "<br> New Session <br>";
                $TablePopulator->dropAll();

                echo "<br> Delete Session Variables <br>";
                $_SESSION['customerNo'] = null;
                // Create new table...
                echo "<br> creating new table <br>";
                $TablePopulator->populateAll();

                echo "<br> importing existing Employees and Customers <br>";
                $TablePopulator->insertEmployeeCustomer();


            }
            $this->EmployeeResults = $this->SQLExecution->executePlainSQL("select Employee_ID from Employee");
            $this->CustomerResults = $this->SQLExecution->executePlainSQL("select Account_no from Customer");

            OCICommit($db_conn);

            if ($_POST && $success) {

                header("location: index.php");
            }else{
                echo "<p>In the AccountInitializer</p>";
            }
            //Commit to save changes...
            OCILogoff($db_conn);
        }else {
            echo "cannot connect";
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
        }

    }

    function getAllEmployees(){
        return $this->EmployeeResults;
    }

    function getAllCustomers(){
        return $this->CustomerResults;
    }
}