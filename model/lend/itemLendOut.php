<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');
date_default_timezone_set("Asia/Kuala_Lumpur");

if(isset($_POST['borrowRequestID'])){
    // Get value by post from js script
    $borrowRequestID = htmlentities($_POST['borrowRequestID']);
    // Check if the sale in the database
    $borrowRequestInLendTableSql = 'SELECT lendApproval.borrowRequestID FROM borrowRequest
                         INNER JOIN lendApproval ON lendApproval.borrowRequestID = borrowRequest.borrowRequestID
                         WHERE lendApproval.borrowRequestID = :borrowRequestID';
    $borrowRequestInLendTableStatement = $conn->prepare($borrowRequestInLendTableSql);
    $borrowRequestInLendTableStatement->execute(['borrowRequestID' => $borrowRequestID]);
    if($borrowRequestInLendTableStatement->rowCount() > 0){
        // DELETE data in borrowRequest table
        $itemLendOutSql = 'UPDATE lendApproval SET status = :status, lendDate = :lendDate WHERE borrowRequestID = :borrowRequestID';
        $itemLendOutStatement = $conn->prepare($itemLendOutSql);
        $itemLendOutStatement->execute(['status' => 'Lent', 'lendDate' => date("Y-m-d H:i:s"), 'borrowRequestID' => $borrowRequestID]);
        echo 'successful';
    }
} else{
    // saleID is empty. Therefore, display the error message
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Error occur</div>';
    exit();
}
?>