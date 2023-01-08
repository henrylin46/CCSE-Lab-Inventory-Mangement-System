<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

// Check if the POST query is received
if(isset($_POST['itemNumber'])) {

    $itemNumber = htmlentities($_POST['itemNumber']);
    $itemName = htmlentities($_POST['itemDetailsItemName']);
    $location = htmlentities($_POST['itemDetailsLocation']);
    $itemDetailsQuantity = htmlentities($_POST['itemDetailsQuantity']);
    $status = htmlentities($_POST['itemDetailsStatus']);
    $barcode = htmlentities($_POST['itemDetailsBarcode']);
    $description = htmlentities($_POST['itemDetailsDescription']);

    $initialStock = 0;
    $newStock = 0;

    // Check if mandatory fields are not empty
    if(!empty($itemNumber) && !empty($itemName) && !empty($itemDetailsQuantity)){

        // Sanitize item number
        $itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

        // Validate item quantity. It has to be a number
        if(filter_var($itemDetailsQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($itemDetailsQuantity, FILTER_VALIDATE_INT)){
            // Valid quantity
        } else {
            // Quantity is not a valid number
            $errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity</div>';
            $data = ['alertMessage' => $errorAlert];
            echo json_encode($data);
            exit();
        }


        // Calculate the stock
        $stockSelectSql = 'SELECT stock FROM item WHERE itemNumber = :itemNumber';
        $stockSelectStatement = $conn->prepare($stockSelectSql);
        $stockSelectStatement->execute(['itemNumber' => $itemNumber]);
        if($stockSelectStatement->rowCount() > 0) {
            $row = $stockSelectStatement->fetch(PDO::FETCH_ASSOC);
            $initialStock = $row['stock'];
            $newStock = $initialStock + $itemDetailsQuantity;
        } else {
            // Item is not in DB. Therefore, stop the update and quit
            $errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item Number does not exist in DB. Therefore, update not possible.</div>';
            $data = ['alertMessage' => $errorAlert];
            echo json_encode($data);
            exit();
        }

        // Construct the UPDATE query
        $updateItemDetailsSql = 'UPDATE item SET itemName = :itemName, location = :location, stock = :stock, description = :description, status = :status, barcode = :barcode WHERE itemNumber = :itemNumber';
        $updateItemDetailsStatement = $conn->prepare($updateItemDetailsSql);
        $updateItemDetailsStatement->execute(['itemName' => $itemName, 'location' => $location, 'stock' => $newStock, 'description' => $description, 'status' => $status, 'barcode' => $barcode, 'itemNumber' => $itemNumber]);

        // UPDATE item name in sale table
        $updateItemInSaleTableSql = 'UPDATE sale SET itemName = :itemName WHERE itemNumber = :itemNumber';
        $updateItemInSaleTableSstatement = $conn->prepare($updateItemInSaleTableSql);
        $updateItemInSaleTableSstatement->execute(['itemName' => $itemName, 'itemNumber' => $itemNumber]);

        // UPDATE item name in purchase table
        $updateItemInPurchaseTableSql = 'UPDATE purchase SET itemName = :itemName WHERE itemNumber = :itemNumber';
        $updateItemInPurchaseTableSstatement = $conn->prepare($updateItemInPurchaseTableSql);
        $updateItemInPurchaseTableSstatement->execute(['itemName' => $itemName, 'itemNumber' => $itemNumber]);

        $successAlert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item details updated.</div>';
        $data = ['alertMessage' => $successAlert, 'newStock' => $newStock];
        echo json_encode($data);
        exit();

    } else {
        // One or more mandatory fields are empty. Therefore, display the error message
        $errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
        $data = ['alertMessage' => $errorAlert];
        echo json_encode($data);
        exit();
    }
}
?>