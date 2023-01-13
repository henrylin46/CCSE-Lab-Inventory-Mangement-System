<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// retrieve from the session value
	// determine the user group
	session_start();

	// confirm the request status
	if ($_SESSION['loggedIn'] == 'student') {
		$borrowRequestDetailsSql = 'SELECT borrowRequestID, itemID, itemName, borrowQuantity, borrowRequestDate FROM borrowRequest 
                           			INNER JOIN customer ON borrowRequest.matricNumber = customer.matricNumber
                           			INNER JOIN item ON borrowRequest.itemNumber = item.itemNumber
                           			WHERE borrowRequest.matricNumber = :matricNumber';
		$borrowRequestDetailStatement = $conn->prepare($borrowRequestDetailsSql);
		$borrowRequestDetailStatement->execute(['matricNumber'=>$_SESSION['matricNumber']]);
	} else {
		// for admin
	}

	$output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Borrow ID</th>
							<th>Item Name</th>
							<th>Quantity</th>
							<th>Request Date</th>
							<th>Status</th>
							<th>Admin</th>
							<th>Operation</th>
						</tr>
					</thead><tbody>';
	// Create table rows from the selected data
	while($row = $borrowRequestDetailStatement->fetch(PDO::FETCH_ASSOC)){
		
		// Only certains row will have button to cancle
		$output .= '<tr>' .
					   '<td>' . $row['borrowRequestID'] . '</td>' .
					   '<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>' .
					   '<td>' . $row['borrowQuantity'] . '</td>' .
					   '<td>' . $row['borrowRequestDate'] . '</td>';

		$borrowStatusDetailsSql = 'SELECT borrowRequest.borrowRequestID, admin.fullName,lendApproval.status from borrowRequest
    							   INNER JOIN lendApproval ON borrowRequest.borrowRequestID = lendApproval.borrowRequestID
                                   INNER JOIN admin ON lendApproval.username = admin.username
                                   WHERE borrowRequest.matricNumber = :matricNumber AND borrowRequest.borrowRequestID = :borrowRequestID;';
		$borrowStatusStatement = $conn->prepare($borrowStatusDetailsSql);
		$borrowStatusStatement->execute(['matricNumber'=>$_SESSION['matricNumber'], 'borrowRequestID'=>$row['borrowRequestID']]);

		if ($rowApproval = $borrowStatusStatement->fetch(PDO::FETCH_ASSOC)) {
			$output .= '<td>' . $rowApproval['status'] . '</td>'.
				       '<td>' . $rowApproval['fullName'] . '</td>'.
				       '<td>' . '<button type="button" class="btn">' . 'None' . '</button>' .  '</td></tr>';
			$borrowStatusStatement->closeCursor();
		} else {
			$output .= '<td>Pending</td>'.
				       '<td>None</td>'.
					   '<td>' . '<button type="button" class="cancelBorrowRequestButton btn btn-danger">' . 'Cancel' . '</button>' .  '</td></tr>';
		}
//	 	$output .= '</tr>';
	}

	$borrowRequestDetailStatement->closeCursor();

	$output .= '</tbody>
					<tfoot>
						<tr>
							<th>Borrow ID</th>
							<th>Item Name</th>
							<th>Quantity</th>
							<th>Request Date</th>
							<th>Status</th>
							<th>Admin</th>
							<th>Operation</th>
						</tr>
					</tfoot>
			</table>';

	echo $output;
?>


