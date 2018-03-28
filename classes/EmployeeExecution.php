
<?php
/**
 * Created by PhpStorm.
 * User: johnz
 * Date: 2018-03-27
 * Time: 12:06 PM
 */

class EmployeeExecution
{
    private $SQLExecution;
    private $Utility;

    //Includes all classes


    function EmployeeExecution($sqlExecution, $utility){

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;
    }

    function start(){
        global $db_conn, $success;



            if(array_key_exists('AddProduct', $_POST)) {

                    //Getting the values from user and insert data into the table
                    $tuple = array (
                        ":bind1" => $_POST['PID'],
                        ":bind2" => $_POST['price'],
                        ":bind3" => $_POST['expire_date'],
                        ":bind4" => $_POST['Ingredients'],
                        ":bind5" => $_POST['carbon_footprint'],
                        ":bind6" => $_POST['origin'],
                        ":bind7" => $_POST['stock_quantity'],
                        ":bind8" => $_POST['name'],
                        ":bind9" => $_POST['brand'],
                        ":bind10" => $_POST['description'],
                        ":bind11" => $_POST['reward_points'],
                        ":bind12" => $_POST['DID'],
                        ":bind13" => $_POST['category'],
                        ":bind14" => $_POST['Weight'],
                        ":bind15" => $_POST['Allergies'],
                        ":bind16" => $_POST['Volume'],
                        ":bind17" => $_POST['instruction']
						
                    );

                    $alltuples = array (
                        $tuple
                    );
                    $this->SQLExecution->executeBoundSQL("insert into product values (:bind1,:bind2,:bind3,:bind4,:bind5,:bind6,:bind7,:bind8,:bind9,:bind10,:bind11,:bind12)", $alltuples);
                    switch($tuple["::bind13"]){
						case "food":
							$this->SQLExecution->executeBoundSQL("insert into food values (:bind1,:bind14,:bind15)", $alltuples);
							break;
						case "beverage":
							$this->SQLExecution->executeBoundSQL("insert into beverage values (:bind1,:bind15,:bind16)", $alltuples);
							break;
						case "personal_care":
							$this->SQLExecution->executeBoundSQL("insert into beverage values (:bind1,:bind17)", $alltuples);
							
					}						
                    
					OCICommit($db_conn);
			
				// employee restock the product quantity
            } else if(array_key_exists('restock', $_POST)) {

                        // Update tuple using data from user
                        $tuple = array (
                            ":bind1" => $_POST['id'],
                            ":bind2" => $_POST['addq']
                        );
                        $alltuples = array (
                            $tuple
                        );
						//insert into product table
                        $this->SQLExecution->executeBoundSQL("update product set quantity=quantity+:bind2 where pid=:bind1", $alltuples);
						//insert into stock table
						//todo
                        OCICommit($db_conn);

				// employee insert deal and update DID in product table
			} else if(array_key_exists('insert_deal', $_POST)){
					$tuple = array (
                            ":bind1" => $_POST['DID'],
                            ":bind2" => $_POST['start_date'],
                            ":bind3" => $_POST['end_date'],
                            ":bind4" => $_POST['shared_link'],
                            ":bind5" => $_POST['discount'],
                            ":bind6" => $_POST['Premium_only']
                        );
                        $alltuples = array (
                            $tuple
                        );
						//insert into deal table
                        $this->SQLExecution->executeBoundSQL("insert into deal values (:bind1,:bind2,:bind3,:bind4,:bind5,:bind6)", $alltuples);
						//insert into manage table 
						//todo
						
                        OCICommit($db_conn);
				
				
			}

            //Commit to save changes...
            OCILogoff($db_conn);

    }


}