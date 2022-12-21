<?php
	session_start();
	// Redirect the user to login page if he is not logged in.
	if(!isset($_SESSION['loggedIn'])){
		header('Location: login.php');
		exit();
	}
	
	require_once('inc/config/constants.php');
	require_once('inc/config/db.php');
	require_once('inc/header.html');

    // redirect the page view according to user group
    if($_SESSION['loggedIn'] == 'admin'){
        require_once('./admin.php');
    } elseif($_SESSION['loggedIn'] == 'student') {
        require_once('./student.php');
    }
?>
</html>
