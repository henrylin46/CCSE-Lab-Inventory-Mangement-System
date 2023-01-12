<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// retrieve from the session value
	// determine the user group
	session_start();

	// separate sale search table for student and admin
	if ($_SESSION['loggedIn'] == 'student') {
		$saleDetailsSearchSql = 'SELECT * FROM sale WHERE customerID = "'.$_SESSION['matricNumber'].'"';
	} elseif ($_SESSION['loggedIn'] == 'admin') {
		$saleDetailsSearchSql = 'SELECT * FROM sale';
	}

	$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
	$saleDetailsSearchStatement->execute();

	$output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Sale ID</th>
							<th>Item Number</th>
							<th>Item Name</th>';

	// show matric no and student name only in admin page
	if ($_SESSION['loggedIn'] == "admin") {
		$output .=		   '<th>Matric No.</th>
							<th>Student Name</th>';
	}

	$output .= 			   '<th>Sale Date</th>
							<th>Quantity</th>
							<th>Purpose</th>
							<th>Request Status</th>
							<th>Operation</th>
						</tr>
					</thead>
					<tbody>';

	// Create table rows from the selected data
	while($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){

		// Only certains row will have button to cancle
		 $output .= '<tr>' .
						'<td>' . $row['saleID'] . '</td>' .
						'<td>' . $row['itemNumber'] . '</td>' .
						'<td>' . $row['itemName'] . '</td>';

		// show matric no and student name only in admin page
		if ($_SESSION['loggedIn'] == "admin") {
			$output .= 	'<td>' . $row['customerID'] . '</td>' .
						'<td>' . $row['customerName'] . '</td>';
		}

		$output .= 		'<td>' . $row['saleDate'] . '</td>' .
						'<td>' . $row['quantity'] . '</td>' .
						'<td>' . $row['purpose'] . '</td>' .
						'<td>' . $row['requestStatus'] . '</td>';

		// show matric no and student name only in admin page
		if ($_SESSION['loggedIn'] == "student" && $row['requestStatus'] == 'Requested'){
			$output .= '<td>' . '<button type="button" class="cancelBorrowRequestButton btn btn-danger">' . 'Cancel' . '</button>' .  '</td>';
		}
		elseif ($_SESSION['loggedIn'] == "student") {
			$output .= '<td>' . '<button type="button" class="btn">' . 'None' . '</button>' .  '</td>';
		}
		// add elseif for admin part

	 	$output .= '</tr>';
	}

	$saleDetailsSearchStatement->closeCursor();

	$output .= '</tbody>
						<tfoot>
							<tr>
								<th>Sale ID</th>
								<th>Item Number</th>
								<th>Item Name</th>';

	// show matric no and student name only in admin page
	if ($_SESSION['loggedIn'] == "admin") {
		$output .=		   	   '<th>Matric No.</th>
								<th>Student Name</th>';
	}

	$output .=				   '<th>Sale Date</th>
								<th>Quantity</th>
								<th>Purpose</th>
								<th>Request Status</th>
								<th>Operation</th>
							</tr>
						</tfoot>
					</table>';
	echo $output;
?>


