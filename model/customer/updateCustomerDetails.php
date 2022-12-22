<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	// Check if the POST query is received
	if(isset($_POST['customerDetailsCustomerID'])) {
		
		$customerDetailsCustomerID = htmlentities($_POST['customerDetailsCustomerID']);
		$customerDetailsCustomerFullName = htmlentities($_POST['customerDetailsCustomerFullName']);
		$customerDetailsCustomerMobile = htmlentities($_POST['customerDetailsCustomerMobile']);
		$customerDetailsCustomerPassword = htmlentities($_POST['customerDetailsCustomerPassword']);
		$customerDetailsCustomerEmail = htmlentities($_POST['customerDetailsCustomerEmail']);
		$customerDetailsCustomerMatric = htmlentities($_POST['customerDetailsCustomerMatricNumber']);
		$customerDetailsCustomerAddress = htmlentities($_POST['customerDetailsCustomerAddress']);
		$customerDetailsCustomerCity = htmlentities($_POST['customerDetailsCustomerCity']);
		$customerDetailsCustomerDistrict = htmlentities($_POST['customerDetailsCustomerDistrict']);
		$customerDetailsStatus = htmlentities($_POST['customerDetailsStatus']);
		$customerDetailsCustomerIdentification = htmlentities($_POST['customerDetailsCustomerIdentification']);
		
		// Check if mandatory fields are not empty
		if(isset($customerDetailsCustomerFullName) && isset($customerDetailsCustomerMobile) && isset($customerDetailsCustomerAddress))
		{
			// Validate mobile number
			if(filter_var($customerDetailsCustomerMobile, FILTER_VALIDATE_INT) === 0 || filter_var($customerDetailsCustomerMobile, FILTER_VALIDATE_INT)) {
				// Mobile number is valid
			} else {
				// Mobile number is not valid
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
				exit();
			}
			
			// Check if CustomerID field is empty. If so, display an error message
			// We have to specifically tell this to user because the (*) mark is not added to that field
			if(empty($customerDetailsCustomerID)){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the CustomerID to update that customer.</div>';
				exit();
			}
			
			// Validate matric number only if it's provided by user
			if(!empty($customerDetailsCustomerMatric)){
				if(filter_var($customerDetailsCustomerMatric, FILTER_VALIDATE_INT) === 0 || filter_var($customerDetailsCustomerMatric, FILTER_VALIDATE_INT)) {
					// Phone number 2 is valid
				} else {
					// Phone number 2 is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for matric number.</div>';
					exit();
				}
			}
			
			// Validate email only if it's provided by user
			if(!empty($customerDetailsCustomerEmail)) {
				if (filter_var($customerDetailsCustomerEmail, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
					exit();
				}
			}

			// Check if the given CustomerID is in the DB
			$customerIDSelectSql = 'SELECT customerID FROM customer WHERE customerID = :customerDetailsCustomerID';
			$customerIDSelectStatement = $conn->prepare($customerIDSelectSql);
			$customerIDSelectStatement->execute(['customerDetailsCustomerID' => $customerDetailsCustomerID]);
			
			if($customerIDSelectStatement->rowCount() > 0) {
				
				// CustomerID is available in DB. Therefore, we can go ahead and UPDATE its details
				// Construct the UPDATE query
				$updateCustomerDetailsSql = 'UPDATE customer SET fullName = :fullName, email = :email, mobile = :mobile, password = :password, matricNumber = :matricNumber, address = :address, status = :status, identification = :identification WHERE customerID = :customerID';
				$updateCustomerDetailsStatement = $conn->prepare($updateCustomerDetailsSql);
				$updateCustomerDetailsStatement->execute(['fullName' => $customerDetailsCustomerFullName, 'email' => $customerDetailsCustomerEmail, 'mobile' => $customerDetailsCustomerMobile, 'password' => md5($customerDetailsCustomerPassword), 'matricNumber' => $customerDetailsCustomerMatric, 'address' => $customerDetailsCustomerAddress, 'status' => $customerDetailsStatus, 'identification' => $customerDetailsCustomerIdentification, 'customerID' => $customerDetailsCustomerID]);
				
				// UPDATE customer name in sale table too
				$updateCustomerInSaleTableSql = 'UPDATE sale SET customerName = :customerName WHERE customerID = :customerID';
				$updateCustomerInSaleTableStatement = $conn->prepare($updateCustomerInSaleTableSql);
				$updateCustomerInSaleTableStatement->execute(['customerName' => $customerDetailsCustomerFullName, 'customerID' => $customerDetailsCustomerID]);
				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer details updated.</div>';
				exit();
			} else {
				// CustomerID is not in DB. Therefore, stop the update and quit
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>CustomerID does not exist in DB. Therefore, update not possible.</div>';
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