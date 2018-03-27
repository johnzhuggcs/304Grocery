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

    //Includes all classes


    function ApplicationController($sqlExecution, $utility){

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;
    }

    function start(){
        global $db_conn, $success;


        if ($db_conn) {

            if (array_key_exists('reset', $_POST)) {

                $TablePopulator = new TablePopulation($this->SQLExecution);

                // Drop old table...
                echo "<br> dropping table <br>";
                $TablePopulator->dropAll();

                // Create new table...
                echo "<br> creating new table <br>";
                $TablePopulator->populateAll();



            } else
                if (array_key_exists('AddNewProduct', $_POST)) {

                    //Getting the values from user and insert data into the table
                    $tuple = array (
                        ":bind1" => $_POST['pid'],
                        ":bind2" => $_POST['price'],
                        ":bind3" => $_POST['expire_date'],
                        ":bind4" => $_POST['ingredients'],
                        ":bind5" => $_POST['cfoot'],
                        ":bind6" => $_POST['origin'],
                        ":bind7" => $_POST['quantity'],
                        ":bind8" => $_POST['name'],
                        ":bind9" => $_POST['brand'],
                        ":bind10" => $_POST['description'],
                        ":bind11" => $_POST['rpoint'],
                        ":bind12" => $_POST['weight'],
                        ":bind13" => $_POST['allergies'],
                        ":bind14" => $_POST['volume']
                    );



                    $alltuples = array (
                        $tuple
                    );
                    $this->SQLExecution->executeBoundSQL("insert into product values (:bind1,:bind2,:bind3,:bind4,:bind5,:bind6,:bind7,:bind8,:bind9,:bind10,:bind11,:bind12,:bind13,:bind14)", $alltuples);
                    OCICommit($db_conn);

                } else
                    if (array_key_exists('updatesubmit', $_POST)) {

                        // Update tuple using data from user
                        $tuple = array (
                            ":bind1" => $_POST['id'],
                            ":bind2" => $_POST['addq']
                        );
                        $alltuples = array (
                            $tuple
                        );
                        $this->SQLExecution->executeBoundSQL("update product set quantity=quantity+:bind2 where pid=:bind1", $alltuples);
                        OCICommit($db_conn);

                    } else
                        if (array_key_exists('displayall', $_POST)) {
                            $result = $this->SQLExecution->executePlainSQL("select * from product");
                            $this->Utility->printResult($result);

                            OCICommit($db_conn);
                        }

            if ($_POST && $success) {
                //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
                header("location: index.php");
            }
            else {
                // Select data...
                $result = $this->SQLExecution->executePlainSQL("select * from product");
                $this->Utility->printResult($result);
            }

            //Commit to save changes...
            OCILogoff($db_conn);
        } else {
            echo "cannot connect";
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
        }
    }


}