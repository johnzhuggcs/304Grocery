<?php

class CustomerExecution
{
    private $SQLExecution;
    private $Utility;
    private static $instance;
    private $shippingCounter;
    private $orderCounter;

    //Includes all classes


    function CustomerExecution($sqlExecution, $utility){

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;
        if (isset($_SESSION['order_no'])) {

            $this->orderCounter = $_SESSION['order_no'];
        } else {
            $_SESSION['order_no'] = 1;
            $this->orderCounter = $_SESSION['order_no'];
        }

        if (isset($_SESSION['shipping_info_no'])) {

            $this->shippingCounter = $_SESSION['shipping_info_no'];
        } else {
            $_SESSION['shipping_info_no'] = 0;
            $this->shippingCounter = $_SESSION['shipping_info_no'];
        }

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

        $tempOrderNum = strval($this->orderCounter);
        $tempOrderNum = str_pad($tempOrderNum, 4, '0', STR_PAD_LEFT);
        $newOrderID = "O" . $tempOrderNum;

        $tempShippingNum = strval($this->orderCounter);
        $tempShippingNum = str_pad($tempShippingNum, 4, '0', STR_PAD_LEFT);
        $newShippingID = "S" . $tempShippingNum;

        if(array_key_exists('create_shipinfo', $_POST)){
            $tuple = array (
                //this needs shipping info no
                ":bind0" => $newShippingID,
                ":bind1" => $_POST['Phone_number'],
                ":bind2" => $_POST['Billing_address'],
                ":bind3" => $_POST['Shipping_address'],
                ":bind4" => $_POST['Shipping_method'],
                ":bind5" => $_POST['delivery_type']
            );
            $alltuples = array (
                $tuple
            );

            $shippingArray = array(
                ":bind0" => $_SESSION['AccountID'],
                ":bind1" => $tempShippingNum
            );

            $bigShippingTuple = array(
                $shippingArray
            );

            //insert into ship info table
            $this->SQLExecution->executeBoundSQL("insert into shipping_info values (:bind0,:bind1,:bind2,:bind3,:bind4,:bind5)", $alltuples);
            //insert into owns table

            // this need shipping no
            $this->SQLExecution->executeBoundSQL("insert into owns values (:bind0, :bind1)", $bigShippingTuple);

            $_SESSION["shipping_info_no"] = $_SESSION["shipping_info_no"]+1;
            OCICommit($db_conn);

            // place order
        } else if(array_key_exists('place_order', $_POST)){

            //here needs order_no ???
            //get orginal price
            $original_price = $this->SQLExecution->executePlainSQL
            ("Select sum(price) from Product_discount p,Contain c,Order_placedby_shippedwith os 
					Where p.pid = c.pid and c.Order_no=os.Order_no and os.Order_no =".$newOrderID."");
            $price = OCI_Fetch_Array($original_price);

            //get shipping info no
            //here needs customer id
            $shipping_info = $this->SQLExecution->executePlainSQL
            ("Select shipping_info_no from Owns Where Account_no = ".$_SESSION['AccountID']."");
            $ship = OCI_Fetch_Array($shipping_info);

            $tuple = array (
                //this needs shipping info no
                ":bind0" => $_SESSION["order_no"],
                ":bind1" => 18-04-04,
                ":bind2" => $_POST['Free_shipping'],
                ":bind3" => $_POST['Status'],
                ":bind4" => $_POST['Payment_method'],
                ":bind5" => $_POST['delivery_type']
            );

            if($price>100){
                $freeshipping = 1;
                //needs both cid and order no
                $this->SQLExecution->executeBoundSQL
                ("insert into Order_placedby_shippedwith values(".$_SESSION["order_no"].",:bind1,'1','Processing',price[0],price[0],:bind2,".$_SESSION['AccountID'].",$ship[0])", $alltuples);
            }else{
                $freeshipping = 0;
                //needs both cid and order no
                $this->SQLExecution->executeBoundSQL
                ("insert into Order_placedby_shippedwith values(".$_SESSION["order_no"].",:bind1,'0','Processing',price[0],price[0],:bind2,".$_SESSION['AccountID'].",$ship[0])", $alltuples);
            }

            $tuple = array (
                //this needs shipping info no
                ":bind0" => $_SESSION["order_no"],
                ":bind1" => 18-04-04,
                ":bind2" => $freeshipping,
                ":bind3" => "processing",
                ":bind4" => $_POST['Payment_method'],
                ":bind5" => $_POST['delivery_type']
            );

            $alltuples = array (
                $tuple
            );

            $this->SQLExecution->executeBoundSQL
            ("insert into Order_placedby_shippedwith values(:bind0,:bind1,:bind2,:bind3,:bind4,:bind5)", $alltuples);

            //update stock_quantity after decrement
            //needs order no ???
            $this->SQLExecution->executeBoundSQL
            ("update Product_discount set stock_quantity=stock_quantity-1
					where pid in(select pid from Contains where Order_no =".$_SESSION["order_no"].")");
            $_SESSION["order_no"] = $_SESSION["order_no"]+1;
            OCICommit($db_conn);

            //update shipping address
            //TODO: Get shipping_info_no from the customer
        } else if(array_key_exists('update_shipping_address', $_POST)){
            $tuple = array (
                ":bind1" => $_POST['new_address'],
                ":bind2" => $_POST['shipping_info_no']
            );
            $alltuples = array (
                $tuple
            );

            $tempCustomerArray = $this->SQLExecution->executePlainSQL("select Shipping_info from owns where Account_no = ".$_SESSION['AccountID']."");
            $tempCustomer = OCI_Fetch_Array($tempCustomerArray, OCI_BOTH);
            ;

            $this->SQLExecution->executeBoundSQL("update Shipping_info set shipping_address=".$_POST['new_address']." where shipping_info_no=$tempCustomer[0]", $alltuples);

            // Modify Customer Premium qualification
        } else if(array_key_exists('modify_prem', $_POST)){

            //TODO: must do on specific customer
            $this->SQLExecution->executePlainSQL("Update Customer set Premium = 1 where Reward_Points >= 1000 and Account_no = ".$_SESSION['AccountID']." ");
            $this->SQLExecution->executePlainSQL("Update Customer set Premium = 0 where Reward_Points < 1000 and Account_no = ".$_SESSION['AccountID']."");


            // Select product into shopping cart
        } else if(array_key_exists('add_to_cart', $_POST)){

            $tuple = array (
                ":bind1" => $_POST['pid'],
                ":bind2" => $_POST['pid']
            );
            $alltuples = array (
                $tuple
            );
            //this needs order_no in ???
            $this->SQLExecution->executeBoundSQL("Insert into Contains values(:bind1,".$_SESSION["order_no"].")", $alltuples);
        }
        //select an attribute where the products are lower than selected price
        else if(array_key_exists('select_view', $_POST)){
            $tuple = array (
                ":bind1" => $_POST['attr'],
                ":bind2" => $_POST['sel_price'],
            );
            $alltuples = array (
                $tuple
            );
            $result= $this->SQLExecution->executePlainSQL("select :bind1 from product_discount where price< :bind2", $alltuples);
            //print result

            OCICommit($db_conn);
        }

            //Commit to save changes...
            //OCILogoff($db_conn);

    }


}