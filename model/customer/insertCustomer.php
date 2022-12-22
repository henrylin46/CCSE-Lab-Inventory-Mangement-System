<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['customerDetailsCustomerFullName'])){
		
		$fullName = htmlentities($_POST['customerDetailsCustomerFullName']);
		$email = htmlentities($_POST['customerDetailsCustomerEmail']);
		$mobile = htmlentities($_POST['customerDetailsCustomerMobile']);
		$password = htmlentities($_POST['customerDetailsCustomerPassword']);
		$matricNumber = htmlentities($_POST['customerDetailsCustomerMatricNumber']);
		$address = htmlentities($_POST['customerDetailsCustomerAddress']);
		$status = htmlentities($_POST['customerDetailsStatus']);
		$identification = htmlentities($_POST['customerDetailsCustomerIdentification']);
		
		if(isset($fullName) && isset($mobile) && isset($address)) 
		{
			// Validate mobile number
			if(filter_var($mobile, FILTER_VALIDATE_INT) === 0 || filter_var($mobile, FILTER_VALIDATE_INT)) {
				// Valid mobile number
			} else {
				// Mobile is wrong
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
				exit();
			}
			
			// Validate second phone number only if it's provided by user
			if(!empty($matricNumber)){
				if(filter_var($matricNumber, FILTER_VALIDATE_INT) === false) {
					// Phone number 2 is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid matric number</div>';
					exit();
				}
			}
			
			// Validate email only if it's provided by user
			if(!empty($email)) {
				if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
					exit();
				}
			}
			
			// check if address is empty or not
			if($address == ''){
				// Address 1 is empty
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Address</div>';
				exit();
			}
			
			// Check if full name is empty or not
			if($fullName == ''){
				// Full Name is empty
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Full Name.</div>';
				exit();
			}
			
			// Start the insert process
			$sql = 'INSERT INTO customer(fullName, email, mobile, password, matricNumber, address, status, identification) VALUES(:fullName, :email, :mobile, :password, :matricNumber, :address, :status, :identification)';
			$stmt = $conn->prepare($sql);
			$stmt->execute(['fullName' => $fullName, 'email' => $email, 'mobile' => $mobile, 'password' => md5($password), 'matricNumber' => $matricNumber, 'address' => $address, 'status' => $status, 'identification' => $identification]);
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer added to database</div>';
		} 
		else {
			// One or more fields are empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>