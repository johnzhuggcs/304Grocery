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
        echo('<div class="card container text-center" >
		<div class="card-body">
				<div class="container">
					<div class="row">
						<div class="col-md-12" style="overflow-x: auto;">
							<table class="table table-bordered" >
								<thead>
									<tr>
										<th>ID</th>
										<th>Price</th>
										<th>Expire date</th>
										<th>Ingredients</th>
										<th>Carbon Footprint</th>
										<th>Origin</th>
										<th>Stock_quantity</th>
										<th>Name</th>
										<th>Brand</th>
										<th>description</th>
										<th>Reward Points</th>
										<th>Weight</th>
										<th>Allergies</th>
										<th>Volume</th>
									</tr>
								</thead>');

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {

            echo('<tbody>
            <tr>
		<td>' . $row[0] . '</td>
		<td>' . $row[1] . '</td>
		<td>' . $row[2] . '</td>
		<td>' . $row[3] . '</td>
		<td>' . $row[4] . '</td>
		<td>' . $row[5] . '</td>
		<td>' . $row[6] . '</td>
		<td>' . $row[7] . '</td>
		<td>' . $row[8] . '</td>
		<td>' . $row[9] . '</td>
		<td>' . $row[10] . '</td>
		<td>' . $row[11] . '</td>
		<td>' . $row[12] . '</td>
		<td>' . $row[13] . '</td>
		</tr>'); //or just use "echo $row[0]"
        }
        echo('</tbody>
							</table>
						</div>
					</div>
				</div>
		</div>
	</div>');

    }

    function sessionResult($result){
        $resultArray = array();
        $counter = 0;
        while($tempResultArray = OCI_Fetch_Array($result, OCI_BOTH)){
            $resultArray[$counter] = $tempResultArray[0];
            $counter++;
            //echo ('<div class="card container text-center" ><div class="card-body"><h5>'.$tempResultArray[0].'</h5></div></div>');
        }

        //echo ('<div class="card container text-center" ><div class="card-body"><h5>'.$resultArray.'</h5></div></div>');
        return $resultArray;
    }



}