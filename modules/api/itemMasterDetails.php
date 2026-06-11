<?php
/***************************GG(08/07/2024)***************************/
header('Content-Type: application/JSON');	
require_once("../../settings/connect_db.php");

	global $con;

		
		$query1 = "SELECT *
		FROM   itemMaster 
		";
		$getItemmasterDetails = mysqli_query($con, $query1);

		$query2 = "SELECT *
		FROM   itemUnit 
		";
		$getitemUnitDetails = mysqli_query($con, $query2);

		$query3 = "SELECT *
		FROM   stock 
		";
		$getstockDetails = mysqli_query($con, $query3);

		$query4 = "SELECT *
		FROM   unit 
		";
		$getunitDetails = mysqli_query($con, $query4);

		


	while($rowDetails     =  mysqli_fetch_array($getItemmasterDetails)) {
/*******************************get itemmaster table details*****************/
		$itemMasterId	     = $rowDetails['itemMasterId'];
		$categoryId			 = $rowDetails['categoryId'];
		$SubcategoryId       = $rowDetails['SubcategoryId'];
		$brandId			 = $rowDetails['brandId'];
		$countryId			 = $rowDetails['countryId'];
		$partNo			 	 = $rowDetails['partNo'];
		$countryId			 = $rowDetails['countryId'];
		$itemCode			 = $rowDetails['itemCode'];
		$itemName		 	 = $rowDetails['itemName'];
		$itemNameArabic 	 = $rowDetails['itemNameArabic'];
		$escaped_text 		 = $itemNameArabic;
		// Convert escaped Unicode to JSON format (as PHP string)
		$json_string = '"' . $escaped_text . '"';
		// Decode JSON string with JSON_UNESCAPED_UNICODE flag
		$decoded_text = json_decode($json_string, JSON_UNESCAPED_UNICODE);
		// Output the decoded Arabic text
		$partNo			 	 = $rowDetails['partNo'];
		$wholsalePrice       = $rowDetails['wholsalePrice'];
		$maxretailPrice      = $rowDetails['maxretailPrice'];
		$agencyPrice         = $rowDetails['agencyPrice'];
		$minretailsPrice     = $rowDetails['minretailsPrice'];
		$costPrice           = $rowDetails['costPrice'];
		$vat 				 = $rowDetails['vat'];
		$remarks			 = $rowDetails['remarks'];
		$openingStock        = $rowDetails['openingStock'];
		$stock               = $rowDetails['stock'];
		$damageStock         = $rowDetails['damageStock'];
		$section			 = $rowDetails['section'];
		$expiryDate          = $rowDetails['expiryDate'];
		$branchId            = $rowDetails['branchId'];
		$importLocalStatus   = $rowDetails['importLocalStatus'];
		$status   			 = $rowDetails['status'];
		$branch1Stock		 = $rowDetails['1_B_stock'];
		$branch2Stock		 = $rowDetails['2_B_stock'];
		$branch3Stock		 = $rowDetails['3_B_stock'];
		$minimunQty = $rowDetails['minimunQty'];
		$reorderQty = $rowDetails['reorderQty'];
		$maximunQty= $rowDetails['maximunQty'];
		$profitLevel= $rowDetails['profitLevel'];
		$description= $rowDetails['description'];
		$generateBarcode = $rowDetails['generateBarcode'];
		$itemName =  $rowDetails['itemName'];
		$itemNameArabic =  $rowDetails['itemNameArabic'];
		$itemCode =  $rowDetails['itemCode'];

		$minimumRate =  $rowDetails['minimumRate'];    
		$packing =  $rowDetails['packing']; 
		$packingArabic =  $rowDetails['packingArabic'];
		$location =  $rowDetails['location'];
		$remarks =  $rowDetails['remarks'];
		$section =  $rowDetails['section'];
		$manufacturingDate =  $rowDetails['manufacturingDate'];
		$batchNo =  $rowDetails['batchNo'];
  
		$itemmasterDetails[] = array('itemMasterId' => $itemMasterId,'categoryId' => $categoryId,'SubcategoryId' => $SubcategoryId,'brandId' => $brandId,'countryId' => $countryId,'partNo' => $partNo,'wholsalePrice' => $wholsalePrice,'maxretailPrice' => $maxretailPrice,'agencyPrice' => $agencyPrice,'minretailsPrice' => $minretailsPrice,'costPrice' => $costPrice,'vat' => $vat,'openingStock' => $openingStock,'stock' => $stock,'damageStock' => $damageStock,'expiryDate' => $expiryDate,'branchId' => $branchId,'importLocalStatus' => $importLocalStatus,'status' => $status,'branch1Stock' => $branch1Stock,'branch2Stock' => $branch2Stock,'branch3Stock' => $branch3Stock,'minimunQty' =>$minimunQty ,'reorderQty' =>$reorderQty, 'maximunQty' =>$maximunQty ,'profitLevel' =>$profitLevel ,'description' =>$description ,'generateBarcode' =>$generateBarcode ,'itemName' =>$itemName ,'itemNameArabic' =>$itemNameArabic ,'itemCode' =>$itemCode,'minimumRate' =>$minimumRate ,'packing' =>$packing ,'packingArabic' =>$packingArabic,'location' => $location,'remarks' => $remarks ,'section' =>$section ,'manufacturingDate' =>$manufacturingDate, 'batchNo' =>$batchNo
	);
	/*******************************ends itemmaster table details*****************/
	}
	while($getitemUnitDetailsRow     =  mysqli_fetch_array($getitemUnitDetails)) {

	/*******************************get itemunit table details*****************/
		$itemUnitId          = $getitemUnitDetailsRow['itemUnitId'];
		$unitId            	 = $getitemUnitDetailsRow['unitId'];
		$multiple            = $getitemUnitDetailsRow['multiple'];
		$itemMasterId        = $getitemUnitDetailsRow['itemMasterId'];
		$statusUnitTable     = $getitemUnitDetailsRow['status'];

		$itemunitDetails[] = array('itemUnitId' => $itemUnitId,'unitId' => $unitId,'multiple' => $multiple,'itemMasterId' => $itemMasterId,'statusUnitTable' => $statusUnitTable);

	/*******************************ends itemunit table details*****************/
	}
	while($getunitDetailsRow     =  mysqli_fetch_array($getunitDetails)) {

	/*******************************get unit table details*****************/
		$unitId            	 = $getunitDetailsRow['unitId'];
		$unitName            = $getunitDetailsRow['unitName'];
		$status            	 = $getunitDetailsRow['status'];
		$unitDetails[] = array('unitId' => $unitId,'unitName' => $unitName,'status' => $status);

	/*******************************ends unit table details*************************/
	}
	/*******************************get stock table details*****************/
	while($getstockDetailsRow     =  mysqli_fetch_array($getstockDetails)) {

	$stockId            	= $getstockDetailsRow['stockId'];
	$itemMasterId			= $getstockDetailsRow['itemMasterId'];
	$expiryDate            	= $getstockDetailsRow['expiryDate'];
	$barcode            	= $getstockDetailsRow['barcode'];
	$importLocalStatus      =  $getstockDetailsRow['importLocalStatus'];
	$openingStockId         =  $getstockDetailsRow['openingStockId'];
	$activeStatus           = $getstockDetailsRow['activeStatus'];
	$stock_1_0            	= $getstockDetailsRow['stock_1_0'];
	$stock_2_1            	= $getstockDetailsRow['stock_2_1'];
	$stock_3_2            	= $getstockDetailsRow['stock_3_2'];
	$stock_3_3            	= $getstockDetailsRow['stock_3_3'];
	$stock_2_4            	= $getstockDetailsRow['stock_2_4'];
	$stock_6_5            	= $getstockDetailsRow['stock_6_5'];
	$stock_2_7            	= $getstockDetailsRow['stock_2_7'];
	

	$stockDetails[] 		= array('stockId' => $stockId,'itemMasterId'=>$itemMasterId,'expiryDate' => $expiryDate,'barcode' => $barcode,'activeStatus' => $activeStatus,'stock_1_0' => $stock_1_0,'stock_2_1' => $stock_2_1,'stock_3_2' => $stock_3_2,'stock_3_3' => $stock_3_3,'stock_2_4' => $stock_2_4,'stock_6_5' => $stock_6_5,'stock_2_7' => $stock_2_7,'importLocalStatus' => $importLocalStatus ,'openingStockId' => $openingStockId);
	/*******************************ends stock table details*************************/
	}
	$data=array('itemmasterDetails'=>$itemmasterDetails,'itemunitDetails'=>$itemunitDetails,'unitDetails'=>$unitDetails,'stockDetails'=>$stockDetails);
			

echo json_encode($data);
