<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$studentDetailsSearchSql = 'SELECT * FROM student';
	$studentDetailsSearchStatement = $conn->prepare($studentDetailsSearchSql);
	$studentDetailsSearchStatement->execute();

	$output = '<table id="studentReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
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
	while($row = $studentDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
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
	
	$studentDetailsSearchStatement->closeCursor();
	
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