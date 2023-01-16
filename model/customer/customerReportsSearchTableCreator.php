<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$customerDetailsSearchSql = 'SELECT * FROM customer';
	$customerDetailsSearchStatement = $conn->prepare($customerDetailsSearchSql);
	$customerDetailsSearchStatement->execute();

	$output = '<table id="customerReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Matric No</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>ID</th>
						<th>Address</th>
						<th>Status</th>
						<th>Create Date</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $customerDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td>' . $row['matricNumber'] . '</td>' .
						'<td>' . $row['fullName'] . '</td>' .
						'<td>' . $row['email'] . '</td>' .
						'<td>' . $row['mobile'] . '</td>' .
						'<td>' . $row['identification'] . '</td>' .
						'<td>' . $row['address'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
                        '<td>' . $row['createdOn'] . '</td>' .
					'</tr>';
	}
	
	$customerDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
							<th>Matric No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Create Date</th>
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>