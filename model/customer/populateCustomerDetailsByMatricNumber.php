<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

session_start();

if(isset($_POST['matricNumber']) || $_SESSION['loggedIn'] == 'student') {
    $customerDetailsSql = 'SELECT * FROM customer WHERE matricNumber = :matricNumber';
    $customerDetailsStatement = $conn->prepare($customerDetailsSql);

    if ($_SESSION['loggedIn'] == 'admin'){
        $customerDetailsStatement->execute(['matricNumber' => htmlentities($_POST['matricNumber'])]);
    } elseif ($_SESSION['loggedIn'] == 'student') {
        $customerDetailsStatement->execute(['matricNumber' => $_SESSION['matricNumber']]);
    }

    // If data is found for the given item number, return it as a json object
    if($customerDetailsStatement->rowCount() > 0) {
        $row = $customerDetailsStatement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }
    $customerDetailsStatement->closeCursor();

}
?>