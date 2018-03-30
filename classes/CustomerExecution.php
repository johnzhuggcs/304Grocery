<?php

class CustomerExecution
{
    private $SQLExecution;
    private $Utility;
    private static $instance;

    //Includes all classes


    function CustomerExecution($sqlExecution, $utility){

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;

    }

    public static function getCustomerInstance($sqlExecution, $utility){
        if(!isset(self::$instance)){
            self::$instance = new CustomerExecution($sqlExecution, $utility);
        }
        return self::$instance;
    }

    function start(){
        global $db_conn, $success;
			// reset all the tables

            if(array_key_exists('create_shipinfo', $_POST)){
					$tuple = array (
                            ":bind1" => $_POST['Shipping_info_no'],
                            ":bind2" => $_POST['Phone_number'],
                            ":bind3" => $_POST['Billing_address'],
                            ":bind4" => $_POST['Shipping_address'],
                            ":bind5" => $_POST['Shipping_method'],
                            ":bind6" => $_POST['delivery_type']
                        );
                        $alltuples = array (
                            $tuple
                        );
						//insert into ship info table
                        //$this->SQLExecution->executeBoundSQL("insert into shipping_info values (:bind1,:bind2,:bind3,:bind4,:bind5,:bind6)", $alltuples);
                        //insert into owns table
						//	todo 
						// this need customer id 
						//$this->SQLExecution->executeBoundSQL("insert into owns values (:bind1, ???)", $alltuples);
                        
						OCICommit($db_conn);
						
				// place order
				} else if(array_key_exists('place_order', $_POST)){
					$tuple = array (
                            ":bind1" => $_POST['order_no'],
                            ":bind2" => $_POST['order_date'],
                            ":bind3" => $_POST['Free_shipping'],
                            ":bind4" => $_POST['Status'],
                            ":bind6" => $_POST['Payment_method']
                        );
                        $alltuples = array (
                            $tuple
                        );
						//insert into Order_placedby_shippedwith table 
						// this need customer id 
						
                        //insert into owns table
						//	todo 
						//$Shipping_info_no = $this->SQLExecution->executePlainSQL("select Shipping_info_no from owns where Account_no = ???");
						
						// payment need connect to contains table and include the deal discount
						//$Order_total = $this->SQLExecution->executePlainSQL("select sum() from shipping_info s,Contains c where s.order_no= ")
						
						//$this->SQLExecution->executeBoundSQL("insert into shipping_info values (:bind1,:bind2,:bind3,:bind4,:bind5,:bind6)", $alltuples);

						// this need customer id 
						//$this->SQLExecution->executeBoundSQL("insert into owns values (:bind1, ???)", $alltuples);
                        
						OCICommit($db_conn);
				}

            //Commit to save changes...
            //OCILogoff($db_conn);

    }


}