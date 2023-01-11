<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if(isset($_POST['id'])){

    $itemID = htmlentities($_POST['id']);


    $defaultImgFolder = 'data/item_images/';

    // Get all item details
    $sql = 'SELECT * FROM item WHERE itemID = :itemID';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['itemID' => $itemID]);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $output = '<p><img src="';

        if($row['imageURL'] === '' || $row['imageURL'] === 'imageNotAvailable.jpg'){
            $output .= 'data/item_images/imageNotAvailable.jpg" class="img-fluid"></p>';
        } else {
            $output .= 'data/item_images/' . $row['itemNumber'] . '/' . $row['imageURL'] . '" class="img-fluid"></p>';
        }

        $output .= '<span><strong>Name:</strong> ' . $row['itemName'] . '</span><br>';
        $output .= '<span><strong>Stock:</strong> ' . $row['stock'] . '</span><br>';
        $output .= '<span><strong>Status:</strong> ' . $row['status'] . '</span><br>';
    }

    echo $output;
}
?>