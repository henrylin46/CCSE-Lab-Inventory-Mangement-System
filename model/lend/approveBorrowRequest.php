<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if(isset($_POST['borrowRequestID'])){
    session_start();
    $borrowRequestID = htmlentities($_POST['borrowRequestID']);
    $adminUsername = $_SESSION['username'];
    // Check if mandatory fields are not empty
    if(!empty($borrowRequestID)){
        // Sanitize item number
        $borrowRequestID = filter_var($borrowRequestID, FILTER_SANITIZE_STRING);

        // Calculate the stock values
        $stockSql = 'SELECT borrowRequest.itemNumber, stock, borrowQuantity, matricNumber FROM borrowRequest
                     INNER JOIN item ON borrowRequest.itemNumber = item.itemNumber
                     WHERE borrowRequest.borrowRequestID = :borrowRequestID';
        $stockStatement = $conn->prepare($stockSql);
        $stockStatement->execute(['borrowRequestID' => $borrowRequestID]);
        if($stockStatement->rowCount() > 0){
            // Item exits in DB, therefore, can proceed to a sale
            $row = $stockStatement->fetch(PDO::FETCH_ASSOC);
            $itemNumber = $row['itemNumber'];
            $currentQuantityInItemsTable = $row['stock'];
            $borrowQuantity = $row['borrowQuantity'];
            $studentMatricNumber = $row['matricNumber'];

            if($currentQuantityInItemsTable <= 0) {
                // If currentQuantityInItemsTable is <= 0, stock is empty! that means we can't make a sell. Hence abort.
                echo 'no stock';
                exit();
            } elseif ($currentQuantityInItemsTable < $borrowQuantity) {
                // Requested sale quantity is higher than available item quantity. Hence abort
                echo 'not enough stock';
                exit();
            }
            else {
                // Has at least 1 or more in stock, hence proceed to next steps
                $newQuantity = $currentQuantityInItemsTable - $borrowQuantity;

                // Check if the customer is in DB
                $studentSql = 'SELECT * FROM customer WHERE matricNumber = :matricNumber';
                $studentStatement = $conn->prepare($studentSql);
                $studentStatement->execute(['matricNumber' => $studentMatricNumber]);

                if($studentStatement->rowCount() > 0){
                    // student exits. That means both student, item, and stocks are available. Hence start INSERT and UPDATE
//                    $studentRow = $studentStatement->fetch(PDO::FETCH_ASSOC);
//                    $studentName = $studentRow['fullName'];

                    // INSERT data to sale table
                    $approveBorrowRequestSql = 'INSERT INTO lendApproval(borrowRequestID, username) VALUES (:borrowRequestID, :username)';
                    $approveBorrowRequestStatement = $conn->prepare($approveBorrowRequestSql);
                    $approveBorrowRequestStatement->execute(['borrowRequestID' => $borrowRequestID, 'username' => $adminUsername]);

                    // UPDATE the stock in item table
                    $stockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
                    $stockUpdateStatement = $conn->prepare($stockUpdateSql);
                    $stockUpdateStatement->execute(['stock' => $newQuantity, 'itemNumber' => $itemNumber]);

                    echo 'successful';
                    exit();

                } else {
                    echo 'student not exist';
                    exit();
                }
            }
        } else {
            // Item does not exist, therefore, you can't make a sale from it
            echo 'invalid item';
            exit();
        }

    }
}
?>