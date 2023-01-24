<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	// Check if the POST query is received
	if(isset($_POST['customerDetailsCustomerMatricNumber'])) {

		$studentDetailsStudentFullName = htmlentities($_POST['customerDetailsCustomerFullName']);
		$studentDetailsStudentMobile = htmlentities($_POST['customerDetailsCustomerMobile']);
		$studentDetailsStudentPassword = htmlentities($_POST['customerDetailsCustomerPassword']);
		$studentDetailsStudentEmail = htmlentities($_POST['customerDetailsCustomerEmail']);
		$studentDetailsStudentMatric = htmlentities($_POST['customerDetailsCustomerMatricNumber']);
		$studentDetailsStudentAddress = htmlentities($_POST['customerDetailsCustomerAddress']);
		$studentDetailsStatus = htmlentities($_POST['customerDetailsStatus']);
		$studentDetailsStudentID = htmlentities($_POST['customerDetailsCustomerIdentification']);
		
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
			
			// Check if CustomerID field is empty. If so, display an error message
			// We have to specifically tell this to user because the (*) mark is not added to that field
//			if(empty($customerDetailsCustomerID)){
//				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the CustomerID to update that customer.</div>';
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

			$studentIDSelectSql = 'SELECT studentID FROM student WHERE matricNumber = :customerDetailsCustomerMatric';
			$studentIDSelectStatement = $conn->prepare($studentIDSelectSql);
			$studentIDSelectStatement->execute(['customerDetailsCustomerMatric' => $studentDetailsStudentMatric]);
			
			if($studentIDSelectStatement->rowCount() > 0) {

				// CustomerID is available in DB. Therefore, we can go ahead and UPDATE its details
				// Construct the UPDATE query
				$updateCustomerDetailsSql = 'UPDATE student SET fullName = :fullName, email = :email, mobile = :mobile, password = :password, address = :address, status = :status, identification = :identification WHERE matricNumber = :matricNumber';
				$updateCustomerDetailsStatement = $conn->prepare($updateCustomerDetailsSql);
				$updateCustomerDetailsStatement->execute(['fullName' => $studentDetailsStudentFullName, 'email' => $studentDetailsStudentEmail, 'mobile' => $studentDetailsStudentMobile, 'password' => md5($studentDetailsStudentPassword), 'address' => $studentDetailsStudentAddress, 'status' => $studentDetailsStatus, 'identification' => $studentDetailsStudentID, 'matricNumber' => $studentDetailsStudentMatric]);

//				// UPDATE customer name in sale table too
//				$updateCustomerInSaleTableSql = 'UPDATE sale SET customerName = :customerName WHERE customerID = :customerID';
//				$updateCustomerInSaleTableStatement = $conn->prepare($updateCustomerInSaleTableSql);
//				$updateCustomerInSaleTableStatement->execute(['customerName' => $studentDetailsStudentFullName, 'customerID' => $customerDetailsCustomerID]);
				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Student details updated.</div>';
				exit();
			} else {
				// CustomerID is not in DB. Therefore, stop the update and quit
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