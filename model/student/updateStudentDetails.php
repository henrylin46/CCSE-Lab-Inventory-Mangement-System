<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	// Check if the POST query is received
	if(isset($_POST['studentDetailsStudentMatricNumber'])) {

		$studentDetailsStudentFullName = htmlentities($_POST['studentDetailsStudentFullName']);
		$studentDetailsStudentMobile = htmlentities($_POST['studentDetailsStudentMobile']);
		$studentDetailsStudentPassword = htmlentities($_POST['studentDetailsStudentPassword']);
		$studentDetailsStudentEmail = htmlentities($_POST['studentDetailsStudentEmail']);
		$studentDetailsStudentMatric = htmlentities($_POST['studentDetailsStudentMatricNumber']);
		$studentDetailsStudentAddress = htmlentities($_POST['studentDetailsStudentAddress']);
		$studentDetailsStatus = htmlentities($_POST['studentDetailsStatus']);
		$studentDetailsStudentID = htmlentities($_POST['studentDetailsStudentIdentification']);
		
		// Check if mandatory fields are not empty
		if(isset($studentDetailsStudentFullName) && isset($studentDetailsStudentMobile) && isset($studentDetailsStudentAddress))
		{
			// Validate mobile number
			if(filter_var($studentDetailsStudentMobile, FILTER_VALIDATE_INT) === 0 || filter_var($studentDetailsStudentMobile, FILTER_VALIDATE_INT)) {
				// Mobile number is valid
			} else {
				// Mobile number is not valid
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
				exit();
			}
			
			// Check if StudentID field is empty. If so, display an error message
			// We have to specifically tell this to user because the (*) mark is not added to that field
//			if(empty($studentDetailsStudentID)){
//				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the StudentID to update that student.</div>';
//				exit();
//			}
			
			// Validate matric number only if it's provided by user
			if(!empty($studentDetailsStudentMatric)){
				if(filter_var($studentDetailsStudentMatric, FILTER_VALIDATE_INT) === 0 || filter_var($studentDetailsStudentMatric, FILTER_VALIDATE_INT)) {
					// Phone number 2 is valid
				} else {
					// Phone number 2 is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for matric number.</div>';
					exit();
				}
			}
			
			// Validate email only if it's provided by user
			if(!empty($studentDetailsStudentEmail)) {
				if (filter_var($studentDetailsStudentEmail, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
					exit();
				}
			}

			$studentIDSelectSql = 'SELECT studentID FROM student WHERE matricNumber = :studentDetailsStudentMatric';
			$studentIDSelectStatement = $conn->prepare($studentIDSelectSql);
			$studentIDSelectStatement->execute(['studentDetailsStudentMatric' => $studentDetailsStudentMatric]);
			
			if($studentIDSelectStatement->rowCount() > 0) {

				// StudentID is available in DB. Therefore, we can go ahead and UPDATE its details
				// Construct the UPDATE query
				$updateStudentDetailsSql = 'UPDATE student SET fullName = :fullName, email = :email, mobile = :mobile, password = :password, address = :address, status = :status, identification = :identification WHERE matricNumber = :matricNumber';
				$updateStudentDetailsStatement = $conn->prepare($updateStudentDetailsSql);
				$updateStudentDetailsStatement->execute(['fullName' => $studentDetailsStudentFullName, 'email' => $studentDetailsStudentEmail, 'mobile' => $studentDetailsStudentMobile, 'password' => md5($studentDetailsStudentPassword), 'address' => $studentDetailsStudentAddress, 'status' => $studentDetailsStatus, 'identification' => $studentDetailsStudentID, 'matricNumber' => $studentDetailsStudentMatric]);

//				// UPDATE student name in sale table too
//				$updateStudentInSaleTableSql = 'UPDATE sale SET studentName = :studentName WHERE studentID = :studentID';
//				$updateStudentInSaleTableStatement = $conn->prepare($updateStudentInSaleTableSql);
//				$updateStudentInSaleTableStatement->execute(['studentName' => $studentDetailsStudentFullName, 'studentID' => $studentDetailsStudentID]);
				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Student details updated.</div>';
				exit();
			} else {
				// StudentID is not in DB. Therefore, stop the update and quit
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>StudentID does not exist in DB. Therefore, update not possible.</div>';
				exit();
			}
			
		} 
		
		else {
			// One or more mandatory fields are empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>