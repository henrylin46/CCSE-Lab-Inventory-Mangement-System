<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	session_start();
	$itemDetailsSearchSql = 'SELECT * FROM item
							 INNER JOIN lab ON item.location = lab.labName
							 WHERE lab.username = :username';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute(['username' => $_SESSION['username']]);

	$output = '<table id="itemReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
              <thead>
                 <tr>
                     <th>Item Number</th>
                     <th>Item Name</th>
                     <th>Location</th>
                     <th>Barcode</th>
                     <th>Status</th>
                     <th>Stock</th>
                     <th>Description</th>
                 </tr>
             </thead>
                <tbody>';
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
        $output .= '<tr>' .
                    '<td>' . $row['itemNumber'] . '</td>' .
                    '<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['itemID'] . '">' . $row['itemName'] . '</a></td>' .
                    '<td>' . $row['location'] . '</td>' .
                    '<td>' . $row['barcode'] . '</td>' .
                    '<td>' . $row['status'] . '</td>'.
                    '<td>' . $row['stock'] . '</td>'.
                    '<td>' . $row['description'] . '</td>';
	}
	
	$itemDetailsSearchStatement->closeCursor();

    $output .= '</tbody>
                    <tfoot>
                        <tr>
                        <th>Item Number</th>
                        <th>Item Name</th>
                        <th>Location</th>
                        <th>Barcode</th>
                        <th>Status</th>
                        <th>Stock</th>
                        <th>Description</th>
                        </tr>
                    </tfoot>
                </table>';
	echo $output;
?>
