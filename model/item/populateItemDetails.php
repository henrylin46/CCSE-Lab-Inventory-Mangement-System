<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	// Execute the script if the POST request is submitted
	if(isset($_POST['itemNumber'])){
		
		$itemNumber = htmlentities($_POST['itemNumber']);
		
		$itemDetailsSql = 'SELECT * FROM item WHERE itemNumber = :itemNumber';
		$itemDetailsStatement = $conn->prepare($itemDetailsSql);
		$itemDetailsStatement->execute(['itemNumber' => $itemNumber]);
		
		// If data is found for the given item number, return it as a json object
		if($itemDetailsStatement->rowCount() > 0) {
			$row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC);
            session_start();
            if ($_SESSION['loggedIn'] == 'student') {
                $studentInfo = array('fullName'=>$_SESSION['fullName'], 'matricNumber'=>$_SESSION['matricNumber']);
                $row = array_merge($row, $studentInfo);
            }
			echo json_encode($row);
		}
		$itemDetailsStatement->closeCursor();
	}
?>