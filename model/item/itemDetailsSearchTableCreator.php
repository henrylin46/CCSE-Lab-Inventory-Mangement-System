<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

// retrieve from the session value
// determine the user group
session_start();

$itemDetailsSearchSql = 'SELECT * FROM item';
$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
$itemDetailsSearchStatement->execute();

$output = '<table id="itemDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Item Number</th>
						<th>Item Name</th>
						<th>Location</th>
						<th>Barcode</th>
						<th>Stock</th>
						<th>Description</th>
						<th>Status</th>';
if ($_SESSION['loggedIn'] == 'student'){
    $output .= '<th>Operation</th>';
}
$output .= 		'</tr>
				</thead>
				<tbody>';

// Create table rows from the selected data
while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){

    $output .= '<tr>' .
        '<td>' . $row['itemNumber'] . '</td>' .
        '<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>' .
        '<td>' . $row['location'] . '</td>'.
        '<td>' . $row['barcode'] . '</td>' .
        '<td>' . $row['stock'] . '</td>' .
        '<td>' . $row['description'] . '</td>' .
        '<td>' . $row['status'] . '</td>' ;
    if ($_SESSION['loggedIn'] == 'student' && $row['status'] == "Active" && $row['stock'] > 0){
        $output .= '<td>' . '<button type="button" class="requestBorrowButton btn btn-success">' . 'Request' . '</button>' .  '</td>';
    } elseif ($_SESSION['loggedIn'] == 'student' && $row['status'] == "Disabled"){
        $output .= '<td>' . '<button type="button" class="btn">' . 'None' . '</button>' .  '</td>';
    }
    $output .= '</tr>';
}

$itemDetailsSearchStatement->closeCursor();

$output .= '</tbody>
					<tfoot>
						<tr>
						<th>Item Number</th>
						<th>Item Name</th>
						<th>Location</th>
						<th>Barcode</th>
						<th>Stock</th>
						<th>Description</th>
						<th>Status</th>';
if ($_SESSION['loggedIn'] == 'student'){
    $output .= '<th>Operation</th>';
}
$output .= '         </tr>
					</tfoot>
				</table>';
echo $output;
?>