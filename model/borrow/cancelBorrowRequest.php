<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['borrowDetailsBorrowRequestID'])){
		
		// Get value by post from js script
		$borrowRequestID = htmlentities($_POST['borrowDetailsBorrowRequestID']);

		// Check if the sale in the database
		$borrowRequestSql = 'SELECT borrowRequestID FROM borrowRequest WHERE borrowRequestID = :borrowRequestID';
		$borrowRequestStatement = $conn->prepare($borrowRequestSql);
		$borrowRequestStatement->execute(['borrowRequestID' => $borrowRequestID]);
		if($borrowRequestStatement->rowCount() > 0){
			// DELETE data in borrowRequest table
			$cancelBorrowRequestSql = 'DELETE FROM borrowRequest WHERE borrowRequestID = :borrowRequestID';
			$cancelBorrowRequestStatement = $conn->prepare($cancelBorrowRequestSql);
			$cancelBorrowRequestStatement->execute(['borrowRequestID' => $borrowRequestID]);
		}
	} else{
			// saleID is empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Error occur</div>';
			exit();
	}
?>

			























	




















	
