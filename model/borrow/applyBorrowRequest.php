<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if(isset($_POST['borrowDetailsItemNumber'])){

    $borrowDetailsStudentMatricNumber = htmlentities($_POST['borrowDetailsStudentMatricNumber']);
    $borrowDetailsItemNumber = htmlentities($_POST['borrowDetailsItemNumber']);
    $borrowDetailsQuantity = htmlentities($_POST['borrowDetailsQuantity']);
    $borrowDetailsPurpose = htmlentities($_POST['borrowDetailsPurpose']);

    // Check if mandatory fields are not empty
    if(!empty($borrowDetailsStudentMatricNumber) && isset($borrowDetailsItemNumber) && isset($borrowDetailsQuantity) && isset($borrowDetailsPurpose)){

        // Check if matricNumber is empty
        $borrowDetailsStudentMatricNumber = filter_var($borrowDetailsStudentMatricNumber, FILTER_SANITIZE_STRING);
        if($borrowDetailsStudentMatricNumber == ''){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a Matric No.</div>';
            exit();
        }

        // Sanitize item number
        $borrowDetailsItemNumber = filter_var($borrowDetailsItemNumber, FILTER_SANITIZE_STRING);
        // Check if itemNumber is empty
        if($borrowDetailsItemNumber == ''){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Number.</div>';
            exit();
        }

        // Validate item quantity. It has to be a number
        if(filter_var($borrowDetailsQuantity, FILTER_VALIDATE_INT) <= 0) {
            // Quantity is not a valid number
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity</div>';
            exit();
        }

        // Check if borrowDetailPurpose is empty
        if($borrowDetailsPurpose == ''){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter borrow purpose.</div>';
            exit();
        }

        // Calculate the stock values
        $stockSql = 'SELECT stock FROM item WHERE itemNumber = :itemNumber';
        $stockStatement = $conn->prepare($stockSql);
        $stockStatement->execute(['itemNumber' => $borrowDetailsItemNumber]);
        if($stockStatement->rowCount() > 0){
            // Item exits in DB, therefore, can proceed to a sale
            $row = $stockStatement->fetch(PDO::FETCH_ASSOC);
            $currentQuantityInItemsTable = $row['stock'];

            if($currentQuantityInItemsTable <= 0) {
                // If currentQuantityInItemsTable is <= 0, stock is empty! that means we can't make a sell. Hence abort.
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Stock is empty. Therefore, can\'t make a borrow request. Please select a different item.</div>';
                exit();
            } elseif ($currentQuantityInItemsTable < $borrowDetailsQuantity) {
                // Requested sale quantity is higher than available item quantity. Hence abort
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Not enough stock available for this borrow request. Therefore, can\'t make a sale. Please select a different item.</div>';
                exit();
            }
            else {
                // Has at least 1 or more in stock, hence proceed to next steps
                // $newQuantity = $currentQuantityInItemsTable - $borrowDetailsQuantity;

                // Check if the customer is in DB
                $customerSql = 'SELECT * FROM customer WHERE matricNumber = :matricNumber';
                $customerStatement = $conn->prepare($customerSql);
                $customerStatement->execute(['matricNumber' => $borrowDetailsStudentMatricNumber]);

                if($customerStatement->rowCount() > 0){
                    // Customer exits. That means both customer, item, and stocks are available. Hence start INSERT and UPDATE
                    $customerRow = $customerStatement->fetch(PDO::FETCH_ASSOC);

                    // INSERT data to sale table
                    // INSERT INTO `borrowRequest`(`matricNumber`, `itemNumber`, `borrowQuantity`, `borrowPurpose`) VALUES (200000, '3', 5, 'test')
                    $newBorrowRequestSql = 'INSERT INTO borrowRequest(matricNumber, itemNumber, borrowQuantity, borrowPurpose) VALUES(:matricNumber, :itemNumber, :borrowQuantity, :borrowPurpose)';
                    $newBorrowRequestStatement = $conn->prepare($newBorrowRequestSql);
                    $newBorrowRequestStatement->execute(['matricNumber' => $borrowDetailsStudentMatricNumber, 'itemNumber' => $borrowDetailsItemNumber, 'borrowQuantity' => $borrowDetailsQuantity, 'borrowPurpose' => $borrowDetailsPurpose]);

                    // UPDATE the stock in item table
                    //$stockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
                    //$stockUpdateStatement = $conn->prepare($stockUpdateSql);
                    //$stockUpdateStatement->execute(['stock' => $newQuantity, 'itemNumber' => $borrowDetailsItemNumber]);

                    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Borrow request details added to DB and stocks updated.</div>';
                    exit();

                } else {
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Student does not exist.</div>';
                    exit();
                }
            }
        } else {
            // Item does not exist, therefore, you can't make a sale from it
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in DB.</div>';
            exit();
        }

    } else {
        // One or more mandatory fields are empty. Therefore, display a the error message
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
        exit();
    }
}
?>