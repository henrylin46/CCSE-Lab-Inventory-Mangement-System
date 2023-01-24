<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

session_start();

if(isset($_POST['matricNumber']) || $_SESSION['loggedIn'] == 'student') {
    $studentDetailsSql = 'SELECT * FROM student WHERE matricNumber = :matricNumber';
    $studentDetailsStatement = $conn->prepare($studentDetailsSql);

    if ($_SESSION['loggedIn'] == 'admin'){
        $studentDetailsStatement->execute(['matricNumber' => htmlentities($_POST['matricNumber'])]);
    } elseif ($_SESSION['loggedIn'] == 'student') {
        $studentDetailsStatement->execute(['matricNumber' => $_SESSION['matricNumber']]);
    }

    // If data is found for the given item number, return it as a json object
    if($studentDetailsStatement->rowCount() > 0) {
        $row = $studentDetailsStatement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }
    $studentDetailsStatement->closeCursor();

}
?>