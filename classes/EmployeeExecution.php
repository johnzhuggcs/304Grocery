
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
    private $ProductId;
    private static $instance;

    //Includes all classes


    function EmployeeExecution($sqlExecution, $utility)
    {

        $this->SQLExecution = $sqlExecution;
        $this->Utility = $utility;

        if (isset($_SESSION['ProductId'])) {

            $this->ProductId = $_SESSION['ProductId'];
        } else {
            $_SESSION['ProductId'] = 2;
            $this->ProductId = $_SESSION['ProductId'];
        }
    }

    public static function getEmployeeInstance($sqlExecution, $utility)
    {
        if (!isset(self::$instance)) {
            self::$instance = new EmployeeExecution($sqlExecution, $utility);
        }
        return self::$instance;
    }

    function start()
    {
        global $db_conn, $success;
        $tempProductNum = strval($this->ProductId);
        $tempProductNum = str_pad($tempProductNum, 4, '0', STR_PAD_LEFT);
        $newCustomerID = "P" . $tempProductNum;

        if (array_key_exists('AddProduct', $_POST)) {

            //Getting the values from user and insert data into the table
            $tuple = array(
                ":bind1" => $_SESSION["ProductId"],
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

            $alltuples = array(
                $tuple
            );
            $this->SQLExecution->executeBoundSQL("insert into product values (:bind1,:bind2,:bind3,:bind4,:bind5,:bind6,:bind7,:bind8,:bind9,:bind10,:bind11,:bind12)", $alltuples);
            switch ($_POST['category']) {
                case "food":
                    $this->SQLExecution->executeBoundSQL("insert into food values (:bind1,:bind14,:bind15)", $alltuples);
                    break;
                case "beverage":
                    $this->SQLExecution->executeBoundSQL("insert into beverage values (:bind1,:bind15,:bind16)", $alltuples);
                    break;
                case "personal_care":
                    $this->SQLExecution->executeBoundSQL("insert into beverage values (:bind1,:bind17)", $alltuples);

            }
            $_SESSION["ProductId"] = $_SESSION["ProductId"] + 1;

            OCICommit($db_conn);


        } //delete product
        else if (array_key_exists('deleteProduct', $_POST)) {
            $tuple = array(
                ":bind1" => $_POST['PID']
            );
            $alltuples = array(
                $tuple
            );
            $this->SQLExecution->executeBoundSQL("delete from product_discount where pid=:bind1", $alltuples);
            OCICommit($db_conn);
        } // restock product quantity
        else if (array_key_exists('restock', $_POST)) {

            // Update tuple using data from user
            $tuple = array(
                ":bind1" => $_POST['id'],
                ":bind2" => $_POST['addq']
            );
            $alltuples = array(
                $tuple
            );
            //insert into product table
            $this->SQLExecution->executeBoundSQL("update product_discount set stock_quantity=stock_quantity+:bind2 where pid=:bind1", $alltuples);
            //insert into stock table
            //todo
            OCICommit($db_conn);

        } // employee create new deal
        else if (array_key_exists('insertDeal', $_POST)) {
            $tuple = array(
                ":bind1" => $_POST['DID'],
                ":bind2" => $_POST['start_date'],
                ":bind3" => $_POST['end_date'],
                ":bind4" => $_POST['shared_link'],
                ":bind5" => $_POST['discount'],
                ":bind6" => $_POST['Premium_only']
            );
            $alltuples = array(
                $tuple
            );
            $this->SQLExecution->executeBoundSQL("insert into deal values (:bind1,:bind2,:bind3,:bind4,:bind5,:bind6)", $alltuples);

            OCICommit($db_conn);
        } // employee delete a deal
        else if (array_key_exists('deleteDeal', $_POST)) {
            $tuple = array(
                ":bind1" => $_POST['DID']
            );
            $alltuples = array(
                $tuple
            );
            //insert into deal table
            $this->SQLExecution->executeBoundSQL("delete from product_discount where did=:bind1", $alltuples);

            OCICommit($db_conn);
        } // employee delete a deal
        else if (array_key_exists('deleteDeal', $_POST)) {
            $tuple = array(
                ":bind1" => $_POST['DID']
            );
            $alltuples = array(
                $tuple
            );
            //insert into deal table
            $this->SQLExecution->executeBoundSQL("delete from product_discount where did=:bind1", $alltuples);
            OCICommit($db_conn);
        } //find the item in every order
        else if (array_key_exists('item_all_order', $_POST)) {
            $result = $this->SQLExecution->executePlainSQL("select PID, name from product_discount p where p.PID = (Select PID from Product_discount where PID not in (SELECT PID FROM ((select order_no,PID from (select PID from product_discount) cross join (select order_no from Contains)) Minus (select order_no, PID from Contains))))");

            echo "<br> The item in every order is: <br>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["PID"] . "</td><td>" . $row["name"] . "</td></tr>";
            }
            OCICommit($db_conn);

        } //find the most popular item / most purchased item
        else if (array_key_exists('item_popular', $_POST)) {
            $result = $this->SQLExecution->executeBoundSQL("select PID, name from product_discount p where p.PID = (select PID from Contains group by PID HAVING count(order_no) >= all (select count(order_no) from Contains group by PID))");
            echo "<br> The item in every order is: <br>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["PID"] . "</td><td>" . $row["name"] . "</td></tr>";
            }
            OCICommit($db_conn);
        } //find the most expensive / cheapest  / average price item
        else if (array_key_exists('item_price_bound', $_POST)) {
            $tuple = array(
                ":bind1" => $_POST['BOUND']
            );
            $alltuples = array(
                $tuple
            );

            $result = $this->SQLExecution->executeBoundSQL("select PID, name, price from product_discount where price = (SELECT :bind1(price) from product_discount)", $alltuples);

            switch ($tuple[":bind1"]) {
                case "MAX":
                    echo "<br> The MAX price item: <br>";
                    break;
                case "MIN":
                    echo "<br> The MIN price item: <br>";
                    break;
                case "AVG":
                    echo "<br> The AVG price item: <br>";
            }

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["PID"] . "</td><td>" . $row["name"] . "</td><td>" . $row["price"] . "</td></tr>";
            }

            OCICommit($db_conn);
        } // find the most and least expensive brand
        else if (array_key_exists('brand_price_bound', $_POST)) {
            $tuple = array(
                ":bind1" => $_POST['BOUND']
            );
            $alltuples = array(
                $tuple
            );

            $result = $this->SQLExecution->executeBoundSQL("select * 
                        from (select brand, avg(price) as av
                        from product_discount
                        group by brand)
                        where av= (select :bind1(avgprice) from (select brand, avg(price) as avgprice
                        from product_discount
                        group by brand))", $alltuples);

            switch ($_POST['BOUND']) {
                case "MAX":
                    echo "<br> The most expensive brand: <br>";
                    break;
                case "MIN":
                    echo "<br> The least expensive brand: <br>";

            }

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["brand"] . "</td><td>" . $row["av"] . "</td></tr>";
            }

            OCICommit($db_conn);
        } //update deal DID then update product's DID : on update cascade
        else if (array_key_exists('update_deal', $_POST)) {
            $tuple = array(
                ":bind1" => $_POST['old_did'],
                ":bind2" => $_POST['new_did'],
            );
            $alltuples = array(
                $tuple
            );
            $this->SQLExecution->executeBoundSQL("update deal set did=:bind2 where did=:bind1", $alltuples);
            $this->SQLExecution->executeBoundSQL("update Access_to set did=:bind2 where did=:bind1", $alltuples);
            $this->SQLExecution->executeBoundSQL("update product_discount set did=:bind2 where did=:bind1", $alltuples);

            OCICommit($db_conn);
        }


    }
}