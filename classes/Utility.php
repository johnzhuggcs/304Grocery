<?php
/**
 * Created by PhpStorm.
 * User: johnz
 * Date: 2018-03-27
 * Time: 11:49 AM
 */

class Utility
{
    //Prints results and others

    function Utility(){}

    function printResult($result) { //prints results from a select statement
        echo "<br>Got data from table product:<br>";
        echo "<table border ='1'>";
        echo "<tr><th>ID</th><th>Price</th><th>Expire_date</th><th>Ingredients</th><th>Carbon_Footprint</th><th>Origin</th><th>Stock_quantity</th><th>Name</th><th>Brand</th><th>Description</th><th>Reward_points</th><th>Weight</th><th>Allergies</th><th>Volume</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {

            echo "<tr>
		<td>" . $row[0] . "</td>
		<td>" . $row[1] . "</td>
		<td>" . $row[2] . "</td>
		<td>" . $row[3] . "</td>
		<td>" . $row[4] . "</td>
		<td>" . $row[5] . "</td>
		<td>" . $row[6] . "</td>
		<td>" . $row[7] . "</td>
		<td>" . $row[8] . "</td>
		<td>" . $row[9] . "</td>
		<td>" . $row[10] . "</td>
		<td>" . $row[11] . "</td>
		<td>" . $row[12] . "</td>
		<td>" . $row[13] . "</td>
		<td>" . $row[14] . "</td>
		</tr>"; //or just use "echo $row[0]"
        }
        echo "</table>";

    }

}