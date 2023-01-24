<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// retrieve from the session value
	// determine the user group
	session_start();

	// confirm the request status
	if ($_SESSION['loggedIn'] == 'student') {
		$borrowRequestDetailsSql = 'SELECT borrowRequestID, itemID, itemName, location, borrowQuantity, borrowRequestDate FROM borrowRequest 
                           			INNER JOIN student ON borrowRequest.matricNumber = student.matricNumber
                           			INNER JOIN item ON borrowRequest.itemNumber = item.itemNumber
                           			WHERE borrowRequest.matricNumber = :matricNumber';
		$borrowRequestDetailStatement = $conn->prepare($borrowRequestDetailsSql);
		$borrowRequestDetailStatement->execute(['matricNumber'=>$_SESSION['matricNumber']]);
		$output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Borrow ID</th>
							<th>Item Name</th>
							<th>Quantity (r/b)</th>
							<th>Request Date</th>
							<th>LAB</th>
							<th>Status</th>
							<th>Admin</th>
							<th>Operation</th>
						</tr>
					</thead><tbody>';
	} else {
		$borrowRequestDetailsSql = 'SELECT borrowRequestID, itemID, itemName, location, matricNumber, borrowQuantity, borrowRequestDate FROM borrowRequest 
                           			INNER JOIN item ON borrowRequest.itemNumber = item.itemNumber
                                    INNER JOIN lab ON location = labName
                                    WHERE lab.username = :username';
		$borrowRequestDetailStatement = $conn->prepare($borrowRequestDetailsSql);
		$borrowRequestDetailStatement->execute(['username'=>$_SESSION['username']]);
		$output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Borrow ID</th>
							<th>Matric No</th>
							<th>Item Name</th>
							<th>Quantity</th>
							<th>LAB</th>
							<th>Request Date</th>
							<th>Operation</th>
						</tr>
					</thead><tbody>';
	}

	// Create table rows from the selected data
	while($row = $borrowRequestDetailStatement->fetch(PDO::FETCH_ASSOC)){
		if ($_SESSION['loggedIn'] == 'student') {

			$borrowStatusDetailsSql = 'SELECT borrowRequest.borrowRequestID, admin.fullName,lendApproval.status, lendApproval.returnQuantity from borrowRequest
    							   INNER JOIN lendApproval ON borrowRequest.borrowRequestID = lendApproval.borrowRequestID
                                   INNER JOIN admin ON lendApproval.username = admin.username
                                   WHERE borrowRequest.matricNumber = :matricNumber AND borrowRequest.borrowRequestID = :borrowRequestID;';
			$borrowStatusStatement = $conn->prepare($borrowStatusDetailsSql);
			$borrowStatusStatement->execute(['matricNumber'=>$_SESSION['matricNumber'], 'borrowRequestID'=>$row['borrowRequestID']]);
			$rowApproval = $borrowStatusStatement->fetch(PDO::FETCH_ASSOC);

			// Only certains row will have button to cancle
			$output .= '<tr>' .
				'<td>' . $row['borrowRequestID'] . '</td>' .
				'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>';
			if ($rowApproval) {
				$output .= '<td>' . $rowApproval['returnQuantity'] . '/' . $row['borrowQuantity'] . '</td>';
			} else {
				$output .= '<td>' . '0/' . $row['borrowQuantity'] . '</td>';
			}
			$output .= '<td>' . $row['borrowRequestDate'] . '</td>'.
					   '<td>' . $row['location'] . '</td>';

			if ($rowApproval) {
				$output .= '<td>' . $rowApproval['status'] . '</td>'.
					'<td>' . $rowApproval['fullName'] . '</td>'.
					'<td>' . '<button type="button" class="btn">' . 'None' . '</button>' .  '</td></tr>';
				$borrowStatusStatement->closeCursor();
			} else {
				$output .= '<td>Pending</td>'.
					'<td>None</td>'.
					'<td>' . '<button type="button" class="cancelBorrowRequestButton btn btn-danger">' . 'Cancel' . '</button>' .  '</td></tr>';
			}
		} else {
			$borrowStatusDetailsSql = 'SELECT borrowRequest.borrowRequestID, lendApproval.status from borrowRequest
    							   INNER JOIN lendApproval ON borrowRequest.borrowRequestID = lendApproval.borrowRequestID
                                   WHERE borrowRequest.borrowRequestID = :borrowRequestID;';
			$borrowStatusStatement = $conn->prepare($borrowStatusDetailsSql);
			$borrowStatusStatement->execute(['borrowRequestID'=>$row['borrowRequestID']]);

			if ($rowApproval = $borrowStatusStatement->fetch(PDO::FETCH_ASSOC)) {
				continue;
			} else {
				$output .= '<tr>' .
					'<td>' . $row['borrowRequestID'] . '</td>' .
					'<td>' . $row['matricNumber'] . '</td>' .
					'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>' .
					'<td>' . $row['borrowQuantity'] . '</td>' .
					'<td>' . $row['location'] . '</td>'.
					'<td>' . $row['borrowRequestDate'] . '</td>'.
					'<td>' . '<button type="button" class="approveBorrowRequestButton btn btn-primary">' . 'Approve' . '</button>&nbsp' .
						     '<button type="button" class="rejectBorrowRequestButton btn btn-danger">' . 'Reject' . '</button>' .
					'</td></tr>';
			}
		}
	}

	$borrowRequestDetailStatement->closeCursor();
	if ($_SESSION['loggedIn'] == 'student') {
		$output .= '</tbody>
					<tfoot>
						<tr>
							<th>Borrow ID</th>
							<th>Item Name</th>
							<th>Quantity</th>
							<th>LAB</th>
							<th>Request Date</th>
							<th>Status</th>
							<th>Admin</th>
							<th>Operation</th>
						</tr>
					</tfoot>
			</table>';
	} else {
		$output .= '</tbody>
					<tfoot>
						<tr>
							<th>Borrow ID</th>
							<th>Matric No</th>
							<th>Item Name</th>
							<th>Quantity (r/b)</th>
							<th>LAB</th>
							<th>Request Date</th>
							<th>Operation</th>
						</tr>
					</tfoot>
			</table>';
	}

	echo $output;
?>


