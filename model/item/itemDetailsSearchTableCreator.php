<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

// retrieve from the session value
// determine the user group
session_start();

$itemDetailsSearchSql = 'SELECT * FROM item';
$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
$itemDetailsSearchStatement->execute();
$output = '';

if ($_SESSION['loggedIn'] == 'student'){
    $output = '<table id="itemDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
                         <thead>
                             <tr>
                                 <th hidden>Item Number</th>
                                 <th>Item Name</th>
                                 <th>Location</th>
                                 <th>Status</th>
                                 <th>Stock</th>
                                 <th>Operation</th>
                             </tr>
                         </thead>
                     <tbody>';
} elseif ($_SESSION['loggedIn'] == 'admin') {
    $output = '<table id="itemDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
                         <thead>
                             <tr>
                                 <th>Item Number</th>
                                 <th>Item Name</th>
                                 <th>Location</th>
                                 <th>Status</th>
                                 <th>Stock</th>
                             </tr>
                         </thead>
                     <tbody>';
}

// Create table rows from the selected data
while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){

    if ($_SESSION['loggedIn'] == 'student') {
        $output .= '<tr>' .
                   '<td hidden>' . $row['itemNumber'] . '</td>'.
                   '<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>' .
                   '<td>' . $row['location'] . '</td>' .
                   '<td>' . $row['status'] . '</td>'.
                   '<td>' . $row['stock'] . '</td>';
        if ($row['status'] == "Active" && $row['stock'] > 0){
            $output .= '<td>' . '<button type="button" class="requestBorrowButton btn btn-success">' . 'Request' . '</button>' .  '</td>' . '</tr>';
        } else {
            $output .= '<td>' . '<button type="button" class="btn">' . 'None' . '</button>' .  '</td>'. '</tr>';
        }
    } elseif ($_SESSION['loggedIn'] == 'admin') {
        $output .= '<tr>' .
                   '<td>' . $row['itemNumber'] . '</td>' .
                   '<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>' .
                   '<td>' . $row['location'] . '</td>' .
                   '<td>' . $row['status'] . '</td>'.
                   '<td>' . $row['stock'] . '</td>';
    }
}

$itemDetailsSearchStatement->closeCursor();

if ($_SESSION['loggedIn'] == 'student'){
    $output .= '</tbody>
					<tfoot>
						<tr>
						<th hidden>Item Number</th>
						<th>Item Name</th>
						<th>Location</th>
						<th>Status</th>
						<th>Stock</th>
						<th>Operation</th>
						</tr>
					</tfoot>
				</table>';
} elseif ($_SESSION['loggedIn'] == 'admin') {
    $output .= '</tbody>
					<tfoot>
						<tr>
						<th>Item Number</th>
						<th>Item Name</th>
						<th>Location</th>
						<th>Status</th>
						<th>Stock</th>
						</tr>
					</tfoot>
				</table>';
}

echo $output;
?>