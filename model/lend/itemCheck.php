<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');
date_default_timezone_set("Asia/Kuala_Lumpur");

if(isset($_POST['itemCheckQuantity']) && isset($_POST['itemCheckQuantity'])){
    // Get value by post from js script
    $borrowRequestID = htmlentities($_POST['borrowRequestID']);
    $itemCheckQuantity = htmlentities($_POST['itemCheckQuantity']);
    // Check if the sale in the database
    $borrowRequestInLendTableSql = 'SELECT lendApproval.borrowRequestID FROM borrowRequest
                                    INNER JOIN lendApproval ON lendApproval.borrowRequestID = borrowRequest.borrowRequestID
                                    WHERE lendApproval.borrowRequestID = :borrowRequestID';
    $borrowRequestInLendTableStatement = $conn->prepare($borrowRequestInLendTableSql);
    $borrowRequestInLendTableStatement->execute(['borrowRequestID' => $borrowRequestID]);

    if($borrowRequestInLendTableStatement->rowCount() > 0){

        // Calculate the stock values
        $stockSql = 'SELECT borrowRequest.itemNumber, stock, borrowQuantity, matricNumber FROM borrowRequest
                     INNER JOIN item ON borrowRequest.itemNumber = item.itemNumber
                     WHERE borrowRequest.borrowRequestID = :borrowRequestID';
        $stockStatement = $conn->prepare($stockSql);
        $stockStatement->execute(['borrowRequestID' => $borrowRequestID]);

        if($stockStatement->rowCount() > 0){
            $row = $stockStatement->fetch(PDO::FETCH_ASSOC);
            $currentQuantityInItemsTable = $row['stock'];
            $itemNumber = $row['itemNumber'];
            if($itemCheckQuantity >= 0) {

                $newStock = intval($currentQuantityInItemsTable) + intval($itemCheckQuantity);

                // update the lend table
                $itemCheckSql = 'UPDATE lendApproval SET status = :status, checkDate = :checkDate, returnQuantity = :checkQuantity WHERE borrowRequestID = :borrowRequestID';
                $itemCheckStatement = $conn->prepare($itemCheckSql);
                $itemCheckStatement->execute(['status' => 'Checked', 'checkDate' => date("Y-m-d H:i:s"), 'checkQuantity'=>$itemCheckQuantity, 'borrowRequestID' => $borrowRequestID]);
                // update stock in item table
                $stockUpdateSql = 'UPDATE item SET stock = :newStock WHERE itemNumber = :itemNumber';
                $stockUpdateStatement = $conn->prepare($stockUpdateSql);
                $stockUpdateStatement->execute(['newStock'=>$newStock, 'itemNumber'=>$itemNumber]);
                echo 'successful';
            } else {
                echo 'invalid input';
            }
        } else {
            echo 'no item found';
        }
    }
}
?>