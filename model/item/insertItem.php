<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$initialStock = 0;
$baseImageFolder = '../../data/item_images/';
$itemImageFolder = '';

if(isset($_POST['itemDetailsItemNumber'])){

    $itemNumber = htmlentities($_POST['itemDetailsItemNumber']);
    $itemName = htmlentities($_POST['itemDetailsItemName']);
    $itemLocation = htmlentities($_POST['itemDetailsLocation']);
    $quantity = htmlentities($_POST['itemDetailsQuantity']);
    $description = htmlentities($_POST['itemDetailsDescription']);
    $status = htmlentities($_POST['itemDetailsStatus']);
    $barcode = htmlentities($_POST['itemDetailsBarcode']);

    // Check if mandatory fields are not empty
    if(!empty($itemNumber) && !empty($itemName) && !empty($quantity) ){

        // Sanitize item number
        $itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

        // Validate item quantity. It has to be a number
        if(filter_var($quantity, FILTER_VALIDATE_INT) === 0 || filter_var($quantity, FILTER_VALIDATE_INT)){
            // Valid quantity
        } else {
            // Quantity is not a valid number
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity</div>';
            exit();
        }



        // Validate discount only if it's provided
        if(!empty($itemLocation)){
            if(filter_var($itemLocation, FILTER_SANITIZE_STRING) === false){
                // Discount is not a valid floating point number
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid location amount</div>';
                exit();
            }
        }

        // Create image folder for uploading images
        $itemImageFolder = $baseImageFolder . $itemNumber;
        if(is_dir($itemImageFolder)){
            // Folder already exist. Hence, do nothing
        } else {
            // Folder does not exist, Hence, create it
            mkdir($itemImageFolder);
        }

        // Calculate the stock values
        $stockSql = 'SELECT stock FROM item WHERE itemNumber=:itemNumber';
        $stockStatement = $conn->prepare($stockSql);
        $stockStatement->execute(['itemNumber' => $itemNumber]);
        if($stockStatement->rowCount() > 0){
            //$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
            //$quantity = $quantity + $row['stock'];
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
            exit();
        } else {
            // Item does not exist, therefore, you can add it to DB as a new item
            // Start the insert process
            $insertItemSql = 'INSERT INTO item(itemNumber, itemName, location, stock, description, status, barcode) VALUES(:itemNumber, :itemName, :location, :stock, :description, :status, :barcode)';
            $insertItemStatement = $conn->prepare($insertItemSql);
            $insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'location' => $itemLocation, 'stock' => $quantity, 'description' => $description, 'status' => $status, 'barcode' => $barcode]);
            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item added to database.</div>';
            exit();
        }

    } else {
        // One or more mandatory fields are empty. Therefore, display a the error message
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
        exit();
    }
}
?>