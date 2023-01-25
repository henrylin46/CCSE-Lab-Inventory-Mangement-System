<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['borrowDetailsBorrowRequestID'])){

		$borrowDetailsBorrowRequestID = htmlentities($_POST['borrowDetailsBorrowRequestID']);
//		SELECT * FROM borrowRequest INNER JOIN student ON borrowRequest.matricNumber = student.matricNumber;
		$saleDetailsSql = 'SELECT borrowRequest.matricNumber, borrowRequest.itemNumber, fullName, borrowRequestID, itemName, borrowQuantity, borrowPurpose, imageURL, location FROM borrowRequest 
                           INNER JOIN student ON borrowRequest.matricNumber = student.matricNumber
                           INNER JOIN item ON borrowRequest.itemNumber = item.itemNumber
                           WHERE borrowRequestID = :borrowRequestID';
		$saleDetailsStatement = $conn->prepare($saleDetailsSql);
		$saleDetailsStatement->execute(['borrowRequestID' => $borrowDetailsBorrowRequestID]);
		
		// If data is found for the given saleID, return it as a json object
		if($saleDetailsStatement->rowCount() > 0) {
			$row = $saleDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$saleDetailsStatement->closeCursor();
	}
?>