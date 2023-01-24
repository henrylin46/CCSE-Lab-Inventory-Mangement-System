<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['customerID'])){
		
		$studentID = htmlentities($_POST['customerID']);
		
		$studentDetailsSql = 'SELECT * FROM student WHERE matricNumber = :matricNumber';
		$studentDetailsStatement = $conn->prepare($studentDetailsSql);
		$studentDetailsStatement->execute(['matricNumber' => $studentID]);
		
		// If data is found for the given item number, return it as a json object
		if($studentDetailsStatement->rowCount() > 0) {
			$row = $studentDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$studentDetailsStatement->closeCursor();
	}
?>