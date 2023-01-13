<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');
date_default_timezone_set("Asia/Kuala_Lumpur");

if(isset($_POST['borrowRequestID']) && isset($_POST['itemReturnQuantity'])){
    // Get value by post from js script
    $borrowRequestID = htmlentities($_POST['borrowRequestID']);
    $itemReturnQuantity = htmlentities($_POST['itemReturnQuantity']);
    // Check if the sale in the database
    $borrowRequestInLendTableSql = 'SELECT lendApproval.borrowRequestID FROM borrowRequest
                                    INNER JOIN lendApproval ON lendApproval.borrowRequestID = borrowRequest.borrowRequestID
                                    WHERE lendApproval.borrowRequestID = :borrowRequestID';
    $borrowRequestInLendTableStatement = $conn->prepare($borrowRequestInLendTableSql);
    $borrowRequestInLendTableStatement->execute(['borrowRequestID' => $borrowRequestID]);

    if($borrowRequestInLendTableStatement->rowCount() > 0){

        if($itemReturnQuantity >= 0) {
            // update the lend table
            $itemReturnSql = 'UPDATE lendApproval SET status = :status, returnDate = :returnDate, returnQuantity = :returnQuantity WHERE borrowRequestID = :borrowRequestID';
            $itemReturnStatement = $conn->prepare($itemReturnSql);
            $itemReturnStatement->execute(['status' => 'Returned', 'returnDate' => date("Y-m-d H:i:s"), 'returnQuantity'=>$itemReturnQuantity, 'borrowRequestID' => $borrowRequestID]);
            echo 'successful';
        } else {
            echo 'invalid input';
        }
    }
}
?>