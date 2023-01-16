<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// retrieve from the session value
	// determine the user group
	session_start();

	// confirm the request status
	$approvalHistoryDetailSql = 'SELECT borrowRequest.borrowRequestID, matricNumber, itemID, itemName, borrowQuantity, location, lendApproval.returnQuantity,
       							lendApproval.status,lendApproval.approvalDate, lendApproval.lendDate, lendApproval.returnDate, lendApproval.rejectDate, lendApproval.checkDate
								FROM borrowRequest 
								INNER JOIN item ON borrowRequest.itemNumber = item.itemNumber
								INNER JOIN lendApproval ON borrowRequest.borrowRequestID = lendApproval.borrowRequestID
								WHERE lendApproval.username = :username';
	$approvalHistoryDetailStatement = $conn->prepare($approvalHistoryDetailSql);
	$approvalHistoryDetailStatement->execute(['username'=>$_SESSION['username']]);

	$output = '<table id="approvalHistoryDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Borrow ID</th>
						<th>Matric No</th>
						<th>Item Name</th>
						<th>Quantity (r/b)</th>
						<th>LAB</th>
						<th>Status</th>
						<th>Operation Date</th>
						<th>Operation</th>
					</tr>
				</thead><tbody>';

	// Create table rows from the selected data
	while($row = $approvalHistoryDetailStatement->fetch(PDO::FETCH_ASSOC)){
//		$borrowStatusDetailsSql = 'SELECT borrowRequest.borrowRequestID, lendApproval.status from borrowRequest
//							   INNER JOIN lendApproval ON borrowRequest.borrowRequestID = lendApproval.borrowRequestID
//							   WHERE borrowRequest.borrowRequestID = :borrowRequestID;';
//		$borrowStatusStatement = $conn->prepare($borrowStatusDetailsSql);
//		$borrowStatusStatement->execute(['borrowRequestID'=>$row['borrowRequestID']]);

		$output .= '<tr>' .
			'<td>' . $row['borrowRequestID'] . '</td>' .
			'<td>' . $row['matricNumber'] . '</td>' .
			'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>' .
			'<td>' . $row['returnQuantity'] . '/'. $row['borrowQuantity'] . '</td>' .
			'<td>' . $row['location'] . '</td>'.
			'<td>' . $row['status'] . '</td>';
		if ($row['status'] == 'Approved') {
			$output .= '<td>' . $row['approvalDate'] . '</td>'.
					   '<td>' . '<button type="button" class="itemLendOutButton btn btn-primary">'. 'Lend' .'</button>' .
					   '</td></tr>';
		} elseif ($row['status'] == 'Lent') {
			$output .= '<td>' . $row['lendDate'] . '</td>'.
					   '<td>' . '<button type="button" class="itemReturnButton btn btn-primary">'. 'Return' .'</button>' .
					   '</td></tr>';
		} elseif ($row['status'] == 'Returned') {
			$output .= '<td>' . $row['returnDate'] . '</td>'.
					   '<td>' . '<button type="button" class="itemCheckButton btn btn-primary">'. 'Check' .'</button>' .
					   '</td></tr>';
		} elseif ($row['status'] == 'Rejected') {
			$output .= '<td>'. $row['rejectDate'] .'</button>' .
				 	   '<td>' . '<button type="button" class="btn">'. 'None' .'</button>' .
					   '</td></tr>';
		} elseif ($row['status'] == 'Checked') {
			$output .= '<td>'. $row['checkDate'] .'</button>' .
					   '<td>' . '<button type="button" class="btn">'. 'None' .'</button>' .
				       '</td></tr>';
		}
	}

	$approvalHistoryDetailStatement->closeCursor();
	$output .= '</tbody>
				<tfoot>
					<tr>
						<th>Borrow ID</th>
						<th>Matric No</th>
						<th>Item Name</th>
						<th>Quantity (r/b)</th>
						<th>LAB</th>
						<th>Status</th>
						<th>Operation Date</th>
						<th>Operation</th>
					</tr>
				</tfoot>
		</table>';

	echo $output;
?>


