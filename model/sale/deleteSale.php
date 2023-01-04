<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['saleDetailsSaleID'])){
		
		// Get 
		$saleID = htmlentities($_POST['saleDetailsSaleID']);
		$quantity = htmlentities($_POST['saleDetailsQuantity']);
		$itemNumber = htmlentities($_POST['saleDetailsItemNumber']);
		

		if(!empty($saleID)){
			
			// Check if the sale in the database
			$saleSql = 'SELECT saleID FROM sale WHERE saleID=:saleID';
			$saleStatement = $conn->prepare($saleSql);
			$saleStatement->execute(['saleID' => $saleID]);

			$stockSql = 'SELECT stock FROM item WHERE itemNumber = :itemNumber';
			$stockStatement = $conn->prepare($stockSql);
			$stockStatement->execute(['itemNumber' => $itemNumber]);
			if($stockStatement->rowCount() > 0){
				// Item exists in DB, therefore proceed 
				$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
				$currentQuantityInItemsTable = $row['stock'];

				// Back the quantity to the database
				$newQuantity = $currentQuantityInItemsTable + $quantity;
				
				// Check if the sale in the database
				$saleSql = 'SELECT saleID FROM sale WHERE saleID=:saleID';
				$saleStatement = $conn->prepare($saleSql);
				$saleStatement->execute(['saleID' => $saleID]);
				if($saleStatement->rowCount() > 0){

					// DELETE data in sale table
					$deleteSaleSql = 'DELETE FROM sale WHERE saleID=:saleID';
					$deleteSaleStatement = $conn->prepare($deleteSaleSql);
					$deleteSaleStatement->execute(['saleID' => $saleID]);

					// UPDATE the stock in item table
					$stockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
                    $stockUpdateStatement = $conn->prepare($stockUpdateSql);
                    $stockUpdateStatement->execute(['stock' => $newQuantity, 'itemNumber' => $itemNumber]);
				}
			}


		} 
		else{
			// saleID is empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Error occur</div>';
			exit();
		}
	}
?>

			























	




















	
