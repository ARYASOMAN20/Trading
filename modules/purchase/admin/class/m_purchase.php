<?php
require_once("../../../../settings/connect_db.php");
class M_Purchase
{
	function getMaxInvoiceNo()
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		
		global $con;
		 $query = "SELECT invoiceNo
				  FROM  purchaseItemBill
				  WHERE privilageId='$privilageId' AND branchId='$branchId' AND status='1'
				  ORDER BY purchaseItemBillId DESC LIMIT 1
				  ";
			  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;
	}
	
	function dropDownForvendorName()
	{
		global $con;
		$query = "SELECT vendorId, vendorName	       
				  FROM   vendor 
				";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;
	}
	function getMaterialsForAutoComplete($materialsName)
	{
		global $con; 
		$branchId        		=   	$_COOKIE['branchId'];
		if($branchId==2 || $branchId==3){
		 $query = "SELECT itemMasterId,itemName,itemCode,vat,packing,importLocalStatus		       
				  FROM  itemMaster 
				  WHERE (itemName LIKE '".$materialsName."%' OR itemCode LIKE '".$materialsName."%')
				  AND status='1' 
				   
				  LIMIT 50
				  ";
		}else{
			 $query = "SELECT itemMasterId,itemName,itemCode,vat,packing,importLocalStatus		       
				  FROM  itemMaster 
				  WHERE (itemName LIKE '".$materialsName."%' OR itemCode LIKE '".$materialsName."%')
				  AND status='1' 
				  AND branchId='".$branchId."' 
				  LIMIT 50
				  ";
		}
				 
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function getItemNameDetails($itemName)
	{
		global $con; 
		$query = "SELECT itemMasterId,itemName,itemCode,vat,packing,costPrice	       
				  FROM  itemMaster 
				  WHERE itemName LIKE '%".$itemName."%'
				  LIMIT 50
				 ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function getMaterialsUnitAutoComplete($itemMasterId)
	{
		global $con; 
		$query = "SELECT itemUnitId,unit.unitName,multiple		       
				  FROM  itemUnit 
				  JOIN unit ON itemUnit.unitId=unit.unitId
				  WHERE itemMasterId = '".$itemMasterId."' 
				   AND itemUnit.status='1'
				  order by multiple DESC 
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result; 
		
	}
	
	function getMaterialsUnitmultipleAutoComplete($itemMasterId)
	{
		global $con; 
		$query = "SELECT itemUnitId,unit.unitName,multiple		       
				  FROM  itemUnit 
				  JOIN unit ON itemUnit.unitId=unit.unitId
				  WHERE itemMasterId = '".$itemMasterId."' 
				   AND itemUnit.status='1'
				  order by multiple DESC LIMIT 1
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result; 
		
	}
	function insertToPurchaseItemBill($invoiceNo,$invoiceDate,$vendorId,$discount,$billTotalWithOutDiscount,$amountWithDiscountTotal,$totalVatAmount,
						$billTotalWithVat,$typeOfTransactionId,$userId,$currencyId,$exRate,$netAmountWithExRate,$customerPoNo,$deliveryOrderNo,
						$vatPercentTotal,$privilageId,$branchId,$mainBranch)
	{
		global $con;
		$query = "INSERT INTO purchaseItemBill (invoiceNo, invoiceDate, vendorId, discount, billTotalWithDiscount,billTotal,totalVatAmount,billTotalWithVat,
					typeOfTransactionId, userId,currencyId,exRate,netAmountWithExRate,customerPoNo,deliveryOrderNo,vatPercentTotal,privilageId,branchId,mainBranch) 
				  VALUES ( '".$invoiceNo."', '". $invoiceDate ."', '". $vendorId ."', '". $discount ."','".$amountWithDiscountTotal."' 
				  		   ,'". $billTotalWithOutDiscount ."','". $totalVatAmount ."','". $billTotalWithVat ."','". $typeOfTransactionId ."', 
						   '". $userId ."','".$currencyId."','".$exRate."','".$netAmountWithExRate."','".$customerPoNo."','".$deliveryOrderNo."',
						   '".$vatPercentTotal."','".$privilageId."','".$branchId."','".$mainBranch."'
						  ) ";
	
		$result = mysqli_query($con,$query);
		return mysqli_insert_id($con);
	}
	function insertToPurchaseItem($purchaseItemBillId,$itemMasterId,$quantityRow,$unitPriceRow,$amountRow,$discountRow,$amountAfterDiscountRow,$vatPercentRow,$vatAmountRow,$totalWithVatAmountRow,$itemUnitId,$expiryDate,$netWeightRow,$barcodeId)
	{
		global $con;
		 $query = "INSERT INTO purchaseItem(purchaseItemBillId,materialsId,quantity,unitPrice,purchasePriceWithOutDiscount,discountAmount,purchaseAmountWithDiscount,vatPercentage,vatAmount,totalAmountWithVat,itemUnitId,expiryDate,netWeight,barcodeId) 
				  VALUES('".$purchaseItemBillId."','".$itemMasterId."','".$quantityRow."','".$unitPriceRow."','".$amountRow."','".$discountRow."','".$amountAfterDiscountRow."','".$vatPercentRow."','".$vatAmountRow."','".$totalWithVatAmountRow."','".$itemUnitId."','".$expiryDate."','".$netWeightRow."','".$barcodeId."')";
	
		$result = mysqli_query($con,$query);
		return mysqli_insert_id($con);
	}
	
	function  insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$quantityRow,$netWeightRow,$expiryDateItem,$itemUnitId,
							$purchaseItemId,$venderName,$stock,$privilageId,$branchId,$userId)
	{
		$transactionType 	= 'Local Purchase';
		$stockStatus 		= 'IN';
		$type				=	3;
		$mainBranch     	= 	$_COOKIE['mainBranch'];	

		global $con;
		 $query = "INSERT INTO itemTransferDetails(invoiceDetailsId,date,transactionNo,itemMasterId,quantity,itemUnitId,totalQuanity,transactionType,stockStatus,vendorOrCustomerName,remainingStock,expiryDate,type,branchId,privilageId,userId,mainBranch) 
				  VALUES('".$purchaseItemId."','".$invoiceDate."','".$invoiceNo."','".$itemMasterId."','".$quantityRow."','".$itemUnitId."','".$netWeightRow."','".$transactionType."','".$stockStatus."','".$venderName."','".$stock."','".$expiryDateItem."','".$type."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')";
		
		$result = mysqli_query($con,$query);
		//return mysqli_insert_id($con);
	}
	
	
	function checkInvoiceNoExistOrNot($invoiceNo,$vendorId,$privilageId,$branchId) 
	{	 
		global $con;
		$query = "SELECT invoiceNo 
				  FROM purchaseItemBill 
				  WHERE invoiceNo = '".$invoiceNo."'
				  AND vendorId='".$vendorId."' AND privilageId='$privilageId' AND branchId='$branchId'";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$numOfRows	=	mysqli_num_rows($result);
		return $numOfRows;
		
	}
	function updateStockInItemMaster($itemMasterId,$quantityRow,$expiryDate,$privilageId,$branchId)
	{
		global $con;
		  $query = "UPDATE stock 
				  SET stock_".$privilageId."_".$branchId." = stock_".$privilageId."_".$branchId." + '". $quantityRow ."'
				  WHERE itemMasterId = '".$itemMasterId."' AND expiryDate='".$expiryDate."'  AND activeStatus='1'
				  ";
			  
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		$numrows	=	mysqli_affected_rows($con);
		return  $numrows;
	}
	function updateStockInStockTable($itemMasterId,$stockQuantity,$expiryDateItem,$privilageId,$branchId)
	{
		global $con;
		   $query = "UPDATE stock 
				  SET stock_".$privilageId."_".$branchId." = stock_".$privilageId."_".$branchId." + '". $stockQuantity ."',
				  expiryDate = '".$expiryDateItem."',importLocalStatus='LOC'
				  WHERE itemMasterId = '".$itemMasterId."' AND (expiryDate = '0000-00-00' OR expiryDate  IS NULL)
				  ";  
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		$numrows	=	mysqli_affected_rows($con);
		return  $numrows;
	}
	function checkExistInStockTable($itemMasterId,$expiryDateItem,$importLocalStatus)
	{
		global $con;
		 $query = "SELECT stockId
					FROM stock
					WHERE itemMasterId = '".$itemMasterId."' AND expiryDate='".$expiryDateItem."'  AND activeStatus='1'
				  ";
		 
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		$numrows	=	mysqli_num_rows($result);
		return  $numrows;
	}
	
	function checkStockWithNull($itemMasterId){
		global $con; 
		 $query = "SELECT stockId   
				  FROM  stock 
				  WHERE itemMasterId = '".$itemMasterId."' AND (expiryDate = '0000-00-00' OR expiryDate  IS NULL)
				 ";
			  
		$result = mysqli_query($con,$query);
		$numrows	=	mysqli_num_rows($result);
		return  $numrows;
		
	}
	
	
	function getCurrencyData()
	{
		global $con;
		$query = "SELECT currencyId,currencyName,exRate 
				  FROM currency WHERE status=1
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;
	}
	function insertAccountjournal($purchaseItemBillId, $invoiceDate,$vendorId,$amountWithDiscountTotal,$discount,$totalVatAmount,$billTotalWithVat,$invoiceNo,$userId,$privilageId,$branchId){
		global $con;
		$subAccountHeadId='';
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		$subAccountData    = $this->SubaccountHead($vendorId);
		$supplier          = $this->suppliername($vendorId);
		$subAccountHeadId  = $subAccountData['subAccountHeadId'];
		$suppliername      = $supplier['vendorName'];
		$narration         = 'Purchase Invoice of'.$suppliername.' '.'By Purchase No '.' '.$invoiceNo;
		$partyAmount       = $billTotalWithVat;
		$amountAfterDiscount = $amountWithDiscountTotal-$discount;
		$query = "INSERT INTO accountJournal 
		       ( j_debit, j_credit, j_account_id, j_sub_account_id, j_particulars, j_remarks, j_dateOfPayment, j_referenceId, j_invoiceId, j_narration,j_branchId,j_privillageId,j_userId,j_mainBranch) 
		       
			 VALUES ( '', '".$partyAmount."', '6','".$subAccountHeadId."','".$suppliername."','".$purchaseItemBillId."',
					'".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch ."'),
			 
				('".$amountWithDiscountTotal."','','18','3','Local Purchase',
					'".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch ."'),
					
				( '". $totalVatAmount ."','', '6','22','Purchase  Vat Account',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch ."') ,
						   
				( '', '".$discount."', '16','372','Discount Received',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch ."'),
				( '', '".$amountAfterDiscount."', '18','2393','Cost',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch ."'),
				( '".$amountAfterDiscount."','','1','2394','Stock',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch ."')";
		//print_r($query);
		$result = mysqli_query($con,$query);

	}
	
	
	public function SubaccountHead($vendorId)
	{
		global $con;
		$query="SELECT subAccountHeadId  FROM subAccountHead   WHERE subAccountSupplierId='$vendorId'";
		$subAccountHead=mysqli_query($con,$query);
		$subAccountHead_detail=mysqli_fetch_array($subAccountHead);	
		return $subAccountHead_detail;	 
	}
	
	function suppliername($vendorId)
	{
		global $con;
		$query = "SELECT  vendorName	       
				  FROM   vendor  WHERE vendorId='$vendorId'
				";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$vendorName=mysqli_fetch_array($result);	
		return $vendorName;	 
	}
	 function insertAccountjournalForPayment($purchaseItemBillId, $invoiceDate,$vendorId,$billTotalWithVat,$invoiceNo,$userId,$privilageId,$branchId,$mainBranch)
	{
		global $con;
		$subAccountHeadId   ='';
		$subAccountData     = $this->SubaccountHead($vendorId);
		$supplier           = $this->suppliername($vendorId);
		$subAccountHeadId   = $subAccountData['subAccountHeadId'];
		$suppliername       = $supplier['vendorName'];
		$narration          = $suppliername.' '.'of Purchase Payment of invoice no'.' '.$invoiceNo;
		
		$subAccountHeadIdForBranch = $this->subAccountHeadIdForBranch($branchId);
		$branchSubAccountHeadName = $subAccountHeadIdForBranch['subAccountHeadName'];
		$branchSubAccountHeadId = $subAccountHeadIdForBranch['subAccountHeadId'];
		
		 $query              = "INSERT INTO accountJournal( j_debit, j_credit, j_account_id, j_sub_account_id, j_particulars, j_remarks, j_dateOfPayment, j_referenceId, j_invoiceId, j_narration,j_branchId,j_privillageId,j_userId,j_mainBranch) 
			 VALUES ('". $billTotalWithVat ."','', '6','". $subAccountHeadId."','".$suppliername."',
						   '".$purchaseItemBillId."','".$invoiceDate."','4','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
						   ('','".$billTotalWithVat."','1','".$branchSubAccountHeadId."','".$branchSubAccountHeadName."',
						   '".$purchaseItemBillId."','".$invoiceDate."','4','".$purchaseItemBillId."','".$narration."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')";
	
		$result = mysqli_query($con,$query);
		//return $query;
	}
	function subAccountHeadIdForBranch($branchId){
		global $con; 
		  $query = "SELECT subAccountHeadId,subAccountHeadName 
					FROM  subAccountHead 
					WHERE subAccountSalesareaId='$branchId'";
				
		$result = mysqli_query($con,$query);
		$subAccountHead=mysqli_fetch_array($result);	
		return $subAccountHead;	 
	}
	
	function getPurchasePrice($itemMasterId)
	{
		global $con; 
		 $query = "SELECT (purchaseItem.totalAmountWithVat/(purchaseItem.quantity*itemUnit.multiple)) AS purchasePrice       
				  FROM  purchaseItem 
				  inner join itemUnit on itemUnit.itemUnitId=purchaseItem.itemUnitId
				  WHERE materialsId = '".$itemMasterId."' AND purchaseItem.status=1
				  ORDER BY purchaseItemId
				
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	}   
	function getCostPrice($itemMasterId)
	{
		$costPrices=0;
		global $con; 
		 $query = "SELECT costPrice      
				  FROM  itemMaster 
				  WHERE itemMasterId = '".$itemMasterId."' AND status=1
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		while($row = mysqli_fetch_array($result))
			{
				$costPrices=$row['costPrice'];
			}
		//echo "helo";
		return $costPrices;	
		
	} 
	function getPurcahsePaymentVoucherNo()
	{
		global $con;
		  $query = "SELECT IFNULL(MAX(purchaseVoucherNo)+1,1) AS purchaseVoucherNo  
				   FROM    purchaseAmount 
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertTopuchaseAmountPayment($purchaseItemBillId,$invoiceDate,$billTotalWithVat,$getPurcahsePaymentVoucherNo,$userId,$privilageId,$branchId)
	{
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		global $con;
		$query = "INSERT INTO purchaseAmount
					(purchaseItemBillId,paymentModeId,paidDate,amountPaid,purchaseVoucherNo,userId,privilageId,branchId,mainBranch)
					VALUES('".$purchaseItemBillId."','1','".$invoiceDate."','".$billTotalWithVat."','".$getPurcahsePaymentVoucherNo."','".$userId."','".$privilageId."','".$branchId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$customerSalesPaymentId	=	mysqli_insert_id($con);
		//echo "helo";
		return $customerSalesPaymentId;
		
	}
	
	
	function getRemainingStock($itemMasterId,$expiryDate,$privilageId,$branchId)
	{
		
		
		$stock=0;
		global $con; 
		 $query = "SELECT stock_".$privilageId."_".$branchId." as stock
				  FROM  stock 
				  WHERE itemMasterId = '".$itemMasterId."' AND expiryDate='".$expiryDate."'
				  ";
			  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		while($row = mysqli_fetch_array($result))
			{
				$stock=$row['stock'];
			}
		//echo "helo";
		return $stock;
		
	} 
	
	/*function getBarcode($itemMasterId)
	{
		global $con; 
		 $query = "SELECT itemCode   
				  FROM  itemMaster 
				  WHERE itemMasterId = '".$itemMasterId."'
				  AND status='1'
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		while($row = mysqli_fetch_array($result))
			{
				$itemCode=$row['itemCode'];
			}
		//echo "helo";
		return $itemCode;
	}*/
	function insertStockInStockTable($itemMasterId,$stockQuantity,$expiryDate,$barcode,$privilageId,$branchId)
	{
		global $con;
		   $query = "INSERT INTO stock
					(itemMasterId,barcode,expiryDate,stock_".$privilageId."_".$branchId.",importLocalStatus)
					  VALUES('$itemMasterId','$barcode','$expiryDate','$stockQuantity','LOC')
					  ";	
		
		$result = mysqli_query($con,$query);
		return $result;
	}
		function vendorNameAutocomplete($my_data){
			global $con;
			$branchId=$_COOKIE['branchId'];
	       $query   = "SELECT vendorId,`vendorName` 
					 	FROM vendor 
						WHERE vendorName LIKE '$my_data%' AND branchId='".$branchId."'
						AND type='1' AND vendorStatus='1'
         				LIMIT 50";
			$result  = mysqli_query($con,$query);
			return $result;
		}
	function checkBarcodeExitsOrNot($itemMasterId,$expiryDate,$importLocalStatus)
	{
	global $con; 
	 $query = "SELECT * FROM  barcode 
				WHERE itemMasterId = '$itemMasterId' AND expiryDate='$expiryDate'
				AND status=1";
	$result = mysqli_query($con,$query);
	return mysqli_num_rows($result);
	}	
	function  insertIntoBarcode($barcodeRow,$itemMasterId,$expiryDate,$importLocalStatus){
	
	global $con;
	 $query = "INSERT INTO barcode
					(barcode,itemMasterId,expiryDate,importLocalStatus,status)
					VALUES('".$barcodeRow."','".$itemMasterId."','".$expiryDate."','".$importLocalStatus."',1)";		  
	$result = mysqli_query($con,$query);
	return mysqli_insert_id($con);
}
function getBarcode($itemMasterId,$expiryDate,$importLocalStatus){
	global $con; 
	 $query = "SELECT barcodeId,barcode FROM  barcode 
				WHERE itemMasterId = '$itemMasterId' AND expiryDate='$expiryDate' 
				AND status=1";
	$result = mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result))
	{
		$barcodeId	=	$row['barcodeId'];
		
	}
	return $barcodeId;
}
function getNewItemDetails($itemMasterId)
	{
		global $con; 
		 $query = "SELECT itemName,itemCode,vat,importLocalStatus       
				  FROM  itemMaster 
				  WHERE itemMasterId='$itemMasterId'
				  AND status='1'
				  ";
				 
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function getBasicPurchaseDetails($purchaseItemBillId)
	{
		global $con; 
		 $query = "SELECT invoiceNo,invoiceDate,billTotal,discount,billTotalWithDiscount,vatPercentTotal,totalVatAmount,billTotalWithVat,
					customerPoNo,deliveryOrderNo,vendor.vendorName
				  FROM  purchaseItemBill 
				  LEFT JOIN vendor ON purchaseItemBill.vendorId=vendor.vendorId
				  WHERE purchaseItemBillId='$purchaseItemBillId'
				  AND status='1'
				  ";
	
		$result = mysqli_query($con,$query);
		return $result;
	}
	function getPurchaseItemDetails($purchaseItemBillId)
	{
		global $con; 
		 $query = "SELECT IM.itemCode,IM.itemName,IM.itemNameArabic,PI.quantity,PI.netWeight,PI.unitPrice,PI.purchasePriceWithOutDiscount,
					PI.expiryDate,U.unitName
				  FROM  purchaseItem PI 
				  LEFT JOIN itemMaster IM  ON PI.materialsId=IM.itemMasterId
				  LEFT JOIN itemUnit IU  ON PI.itemUnitId=IU.itemUnitId
				  LEFT JOIN unit U  ON IU.unitId=U.unitId
				  WHERE purchaseItemBillId='$purchaseItemBillId'
				  AND PI.status='1'
				  ";
		$result = mysqli_query($con,$query);
		return $result;
	}
	function getBranchCode()
	{
		$branchId       =   	$_COOKIE['branchId'];
		$salesmanCode	=	'';
		global $con; 
		 $query = "SELECT salesmanCode	       
				  FROM  branch 
				  WHERE branchId='$branchId'
				  AND status='1' 
				  ";
				 
		$result = mysqli_query($con,$query);
		while($row=mysqli_fetch_array($result))
		{
			$salesmanCode	=	$row['salesmanCode'];
		}
		return $salesmanCode;
	}
}
?>