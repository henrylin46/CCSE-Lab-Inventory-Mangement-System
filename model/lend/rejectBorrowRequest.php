<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if(isset($_POST['borrowRequestID'])){
    session_start();
    // Get value by post from js script
    $borrowRequestID = htmlentities($_POST['borrowRequestID']);
    $adminUsername = $_SESSION['username'];
    // Check if the sale in the database
    $borrowRequestSql = 'SELECT borrowRequestID FROM borrowRequest WHERE borrowRequestID = :borrowRequestID';
    $borrowRequestStatement = $conn->prepare($borrowRequestSql);
    $borrowRequestStatement->execute(['borrowRequestID' => $borrowRequestID]);
    if($borrowRequestStatement->rowCount() > 0){
        // DELETE data in borrowRequest table
        $rejectBorrowRequestSql = 'INSERT INTO lendApproval(borrowRequestID, username, status, approvalDate, rejectDate) VALUES (:borrowRequestID, :username, :reject, :approveDate, :rejectDate)';
        $rejectBorrowRequestStatement = $conn->prepare($rejectBorrowRequestSql);
        $rejectBorrowRequestStatement->execute(['borrowRequestID' => $borrowRequestID, 'username' => $adminUsername, 'reject' => 'Rejected', 'approveDate' => NULL, 'rejectDate' => date("Y-m-d H:i:s")]);
        echo 'successful';
    }
} else{
    // saleID is empty. Therefore, display the error message
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Error occur</div>';
    exit();
}
?>