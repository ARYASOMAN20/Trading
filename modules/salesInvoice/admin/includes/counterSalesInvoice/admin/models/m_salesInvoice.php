<?php
require_once("../../../../settings/connect_db.php");
class M_salesInvoice
{
	function getMaxInvoiceNo()
	{
		$branchId        		=   	$_COOKIE['branchId'];
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		global $con;
		 $query = "SELECT  MAX(invoiceNumericNo) as maxOfIncoiceNo
				  FROM  invoice
				  WHERE branchId='$branchId' AND privilageId='$privilageId'
				  AND status='1'
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		
		return $result;
	}
	function getCustomerForAutoComplete($customerCode)
	{
		$branchId        		=   	$_COOKIE['branchId'];
		global $con; 
		 $query = "SELECT regularCustomerId,customerName,customerNo,vatNumber,contactNo_1      
				  FROM  regularCustomer 
				  WHERE (customerNo LIKE '".$customerCode."%' OR customerName LIKE '".$customerCode."%')
				  AND salesAreaBranchId= '".$branchId."' and status=1
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
	}
	function getSellingPrize($regularCustomerId,$itemMasterId)
	{
		global $con; 
		 $query = "SELECT sellingPrice       
				  FROM  customerItem 
				  WHERE customerId = '".$regularCustomerId."' AND companyItemCodeId='".$itemMasterId."'
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	}  
	
	function getPurchasePrice($itemMasterId)
	{
		global $con; 
		 $query = "SELECT (purchaseItem.totalAmountWithVat/(purchaseItem.quantity*itemUnit.multiple)) AS purchasePrice       
				  FROM  purchaseItem 
				  inner join itemUnit on itemUnit.itemUnitId=purchaseItem.itemUnitId
				  WHERE materialsId = '".$itemMasterId."'  AND purchaseItem.status=1
				  ORDER BY purchaseItemId
				
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	} 
	function getPurchasePriceForLocalPurchase($itemMasterId)	
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		global $con; 
		 $query = "SELECT purchasePriceWithOutDiscount/netWeight AS purchasePrice       
				  FROM  purchaseItem 
				  inner join purchaseItemBill PIB ON PIB.purchaseItemBillId=purchaseItem.purchaseItemBillId
				  WHERE materialsId = '".$itemMasterId."' 
				  AND purchaseItem.status=1
				  ORDER BY purchaseItemId DESC LIMIT 1
				
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function getPurchasePriceForImportPurchase($itemMasterId)	
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		global $con; 
		  $query = "SELECT IFNULL(SUM(costPerCtnRow),0)  as avgPurchasePrice     
				  FROM  importPurchaseDetails
				  inner join importPurchase IP  ON IP.importPurchaseId=importPurchaseDetails.importPurchaseId
				  WHERE itemMasterId = '".$itemMasterId."'
				  AND IP.privilageId='".$privilageId."' 
				  AND IP.branchId='".$branchId."' 
				  AND importPurchaseDetails.status=1
				  ORDER BY importPurchaseDetailsId DESC
				  LIMIT 3
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
				  WHERE itemMasterId = '".$itemMasterId."'  AND status=1
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
	function getImportLocalStatus($itemMasterId){
		$importLocalStatus=0;
		global $con; 
		 $query = "SELECT importLocalStatus      
				  FROM  itemMaster 
				  WHERE itemMasterId = '".$itemMasterId."' 
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		while($row = mysqli_fetch_array($result))
			{
				$importLocalStatus=$row['importLocalStatus'];
			}
		//echo "helo";
		return $importLocalStatus;	
	}
	function getBranchId($userId){
		global $con; 
		 $query = "SELECT branchId     
				  FROM  branch 
				  WHERE branch.userId = '".$userId."'
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
	}
	
	function getVesselData()
	{
		global $con; 
		 $query = "SELECT vesselName,vesselId      
				  FROM  vessel ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	}
		function insertToInvoiceTable($invoiceNo,$regularCustomerId,$invoiceDate,$poNo,$quotationNo,$currencyId,$vesselId,$totalAmount,
				$discountInPercent,$discountInAmount,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,$transactionType,
				$deliveryNoteId,$exRate,$netAmountWithExRate,$userId,$branchId,$discountId,$privilageId,$damagedGoodsReturn,
				$damagedGoodsAmount,$customerPhone,$customerName,$cuttingCharge,$invType,$maxOfinvoiceNumericNo,$roundOff,$roundAmount,$vatNumber,$zakatInvoiceType)
								
	{
		global $con; 
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		$privilageId       	 	=   	$_COOKIE['privillegeId'];

	/*if($privilageId==2)
		{
			$regularCustomerId	=	0;
		}*/
		
	date_default_timezone_set('Asia/Riyadh');
		$time = date('h:ia', time());
		$invoiceTime = date('h:i:s a', time());
		
		   $query = "INSERT INTO invoice
					(invoiceNo,regularCustomerId,invoiceDate,poNo,quotationNo,currencyId,vesselId,totalAmount,discountAmount,
					discountPercent,totalAmountAfterDiscount,vatPercent,vatAmount,totalAmountWithVat,transactionType,deliveryNoteId,
					exRate,netAmountWithExRate,userId,discountId,branchId,privilageId,mainBranch,damagedGoodsReturn,damagedGoodsAmount,
					customerPhone,customerName,appStatus,cuttingCharge,wholesaleOrRetail,invoiceNumericNo,round,roundAmount,customerVatNo,time,invoiceTime,zakatInvoiceType)
					VALUES ('".$invoiceNo."', '".$regularCustomerId."','".$invoiceDate."','".$poNo."','".$quotationNo."','".$currencyId."',
					'".$vesselId."','".$totalAmount."','".$discountInAmount."','".$discountInPercent."','".$totalAfterDiscount."',
					'".$vatPercent."','".$vatAmount."','".$netAmount."','".$transactionType."','".$deliveryNoteId."','".$exRate."',
					'".$netAmountWithExRate."','".$userId."','".$discountId."','".$branchId."','".$privilageId."','".$mainBranch."',
					'".$damagedGoodsReturn."','".$damagedGoodsAmount."','".$customerPhone."','".$customerName."','0','".$cuttingCharge."',
					'".$invType."','".$maxOfinvoiceNumericNo."','".$roundOff."','".$roundAmount."','".$vatNumber."','".$time."','".$invoiceTime."','".$zakatInvoiceType."')
					";
								
		//echo "<br>".$query."<br>";
		$result 	=	mysqli_query($con,$query);
		$invoiceId	=	mysqli_insert_id($con);
		//echo "helo";
		return $invoiceId;	
	}
	
	function insertToInvoiceDetails($invoiceId,$itemMasterId,$itemUnitId,$quantityRow,$unitPriceRow,$discountPercentRow,
			$amountAfterDiscountRow,$itemCodeRow,$descriptionRow,$packageSizeRow,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,
				$amountWithOutDiscountRow,$discountIdRow,$discountAmountRow,$stockId,$netWeightRow)
	{
		global $con; 
		  $query = "INSERT INTO invoiceDetails
					(invoiceId,itemMasterId,itemUnitId,quantity,unitPrice,discountPercent,amount,amountAfterDiscount,itemCode,description,packageSize,vatPercent,vatAmount,amountWithVat,discountId,discountAmount,stockId,netWeight)
					VALUES ('".$invoiceId."','".$itemMasterId."','".$itemUnitId."','".$quantityRow."','".$unitPriceRow."','".$discountPercentRow."','".$amountWithOutDiscountRow."','".$amountAfterDiscountRow."','".$itemCodeRow."','".$descriptionRow."','".$packageSizeRow."','".$vatPercentRow."','".$vatAmountRow."','".$amountWithWithVatRow."','".$discountIdRow."','".$discountAmountRow."','".$stockId."','".$netWeightRow."')";
		
		//echo "<br>".$query."<br>";
		$result 			=	mysqli_query($con,$query);
		$invoiceDetailsId	=	mysqli_insert_id($con);
		//echo "helo";
		return $invoiceDetailsId;	
	}
	
	function insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$quantityRow,$itemUnitId,$stockQuantity,$invoiceDetailsId,$customerName,$branchId,$stock,$privilageId,$userId,$stockId)
	{
		$transactionType = 'Sales';
		$stockStatus = 'OUT';
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		global $con;
		 $query = "INSERT INTO itemTransferDetails(invoiceDetailsId,date,transactionNo,itemMasterId,quantity,itemUnitId,totalQuanity,
								transactionType,stockStatus,vendorOrCustomerName,branchId,remainingStock,privilageId,userId,stockId,mainBranch,type) 
				  VALUES('".$invoiceDetailsId."','".$invoiceDate."','".$invoiceNo."','".$itemMasterId."','".$quantityRow."','".$itemUnitId."',
				  '".$stockQuantity."','".$transactionType."','".$stockStatus."','".$customerName."','".$branchId."','".$stock."',
				  '".$privilageId."','".$userId."','".$stockId."','".$mainBranch."','1')";
		
		$result = mysqli_query($con,$query);
	}
	
	
	function checkInvoiceNoExistOrNot($invoiceNo)
	{
		global $con;
		$branchId        		=   	$_COOKIE['branchId'];
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$query = "SELECT invoiceNo 
				  FROM invoice 
				  WHERE invoiceNo = '".$invoiceNo."'
				  AND branchId='$branchId' AND privilageId='$privilageId'
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$numOfRows	=	mysqli_num_rows($result);
		return $numOfRows;
	}
	
	function updateStockInStockTable($stockId,$quantityRow)
	{
		global $con;
		$privilageId    =   	$_COOKIE['privillegeId'];
		$branchId       =   	$_COOKIE['branchId'];
		
		$query = "UPDATE stock 
				  SET 	stock_".$privilageId."_".$branchId." =stock_".$privilageId."_".$branchId." - '". $quantityRow ."'
				  WHERE stockId = '".$stockId."' ";
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
	}
	
	function updateStockInItemMasterBranch($itemMasterId,$stockQuantity,$branchId){
		global $con;
		$query = "UPDATE itemMaster 
				  SET ".$branchId."_B_stock = ".$branchId."_B_stock - '". $stockQuantity ."'
				  WHERE itemMasterId = '".$itemMasterId."' ";
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
		
		
	}
	
	function getDelNoteNoComplete($delNoteNo)
	{
		global $con; 
		 $query = "SELECT deliveryNoteId,delNoteNo	       
				  FROM   deliveryNote 
				  WHERE delNoteNo LIKE '".$delNoteNo."%'
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	}
	function getDeliveryNoteDetails($deliveryNoteId)
	{
		global $con; 
		  $query = "SELECT DNI.customerItemCode,DNI.title,quantity,DNI.itemMasterId,DNI.packageSize,DNI.unitPrice,unit.unitName,itemUnit.itemUnitId,itemUnit.multiple	       
				  FROM   deliveryNoteItems DNI
				  LEFT JOIN itemUnit ON itemUnit.itemUnitId=DNI.itemUnitId
				  LEFT JOIN unit ON unit.unitId=itemUnit.unitId
				  WHERE DNI.deliveryNoteId = '".$deliveryNoteId."'
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	}
	function deliveryNoteBasicDetails($deliveryNoteId)
	{
		global $con; 
		  $query = "SELECT DN.currencyId,DN.regularCustomerId,DN.modeOfPayment,DN.vesselId,DN.poNo,DN.quotation,RC.customerName,RC.customerNo,RC.vatNumber,DN.modeOfPayment,DN.vesselId     
				  FROM   deliveryNote DN
				  LEFT JOIN regularCustomer RC ON DN.regularCustomerId=RC.regularCustomerId
				  WHERE deliveryNoteId = '".$deliveryNoteId."' AND deliveryNoteStatus='1'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
	}
	function getCurrencyData()
	{
		global $con; 
		  $query = "SELECT currencyId,currencyName,exRate 
				  FROM  currency 
				  WHERE status=1
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	}
	function getMaterialsForAutoComplete($materialsName,$regularCustomerId,$privilageId,$branchId)
	{
		global $con; 
		if($privilageId==1 || $branchId==2 || $branchId==3){
			 $query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate		       
			FROM  stock S
			JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
			WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
			AND activeStatus='1' AND stock_".$privilageId."_".$branchId.">0
			AND IM.status=1 ORDER BY S.expiryDate ASC
			LIMIT 50
			";

			
		}
		else{
			$query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate		       
			FROM  stock S
			JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
			WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
			AND activeStatus='1' AND stock_".$privilageId."_".$branchId.">0 AND IM.branchId='".$branchId."'
			AND IM.status=1 ORDER BY S.expiryDate ASC
			LIMIT 50
			";
		}
		/*if($privilageId==3)
		{
			 $query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate		       
				  FROM  stock S
				  JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
				  WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
				  AND activeStatus='1' AND stock_".$privilageId."_".$branchId.">0
				  AND IM.status=1 ORDER BY S.expiryDate ASC
				  LIMIT 50
				  ";
				  
		}else{
		  $query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate	       
				  FROM  stock S
				  JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
				  WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
				  AND activeStatus='1' AND IM.status=1 AND stock_".$privilageId."_".$branchId.">0 ORDER BY S.expiryDate ASC
				  LIMIT 50
				  ";
		 		  
		}*/
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
	
	function getInvoiceBasicDetails($invoiceId)
	{
		global $con;
        $privilageId    =   	$_COOKIE['privillegeId'];		
		if($privilageId==3){
		   $query = "SELECT I.invoiceNo,I.invoiceDate,I.totalAmount,I.discountAmount,I.discountPercent,I.totalAmountAfterDiscount,
							I.vatPercent,I.vatAmount,I.totalAmountWithVat,I.poNo,I.damagedGoodsAmount,I.customerName as warehouseCustName,time,
							RC.*,V.vesselName,I.cuttingCharge,I.customerVatNo,transactionType,invoiceRefId,I.qrValue,I.zakatInvoiceType,I.branchId,I.privilageId
				  FROM    invoice I
				 LEFT JOIN regularCustomer RC ON I.regularCustomerId=RC.regularCustomerId
				 LEFT JOIN vessel V ON I.vesselId=V.vesselId
				  WHERE invoiceId='".$invoiceId."'
				  ";	
		}else{

             $query = "SELECT I.invoiceNo,I.invoiceDate,I.totalAmount,I.discountAmount,I.discountPercent,I.totalAmountAfterDiscount,
							I.vatPercent,I.vatAmount,I.totalAmountWithVat,I.poNo,I.damagedGoodsAmount,I.customerName as warehouseCustName,time,
							RC.*,V.vesselName,I.cuttingCharge,I.customerVatNo,transactionType,invoiceRefId,I.qrValue,I.zakatInvoiceType,I.branchId,I.privilageId
				  FROM    invoice I
				 LEFT JOIN regularCustomer RC ON I.regularCustomerId=RC.regularCustomerId
				 LEFT JOIN vessel V ON I.vesselId=V.vesselId
				  WHERE invoiceId='".$invoiceId."'
				  ";	
		}	
	
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function getInvoiceDetails($invoiceId)
	{
		global $con; 
		  $query = "SELECT itemMaster.itemCode,itemMaster.itemName,itemMaster.itemNameArabic,invoiceDetails.description,invoiceDetails.packageSize,invoiceDetails.itemUnitId,invoiceDetails.quantity,invoiceDetails.unitPrice,invoiceDetails.discountPercent,invoiceDetails.amount,invoiceDetails.vatPercent,invoiceDetails.vatAmount,invoiceDetails.amountWithVat,invoiceDetails.netWeight,unit.unitName  
				  FROM    invoiceDetails 
				  LEFT JOIN itemMaster ON itemMaster.itemMasterId=invoiceDetails.itemMasterId
				  LEFT JOIN itemUnit ON itemUnit.itemUnitId=invoiceDetails.itemUnitId
				  LEFT JOIN unit ON unit.unitId=itemUnit.unitId
				  WHERE invoiceDetails.invoiceId='".$invoiceId."'
				  AND invoiceDetails.status=1";		  
				
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
	function getSubAccountId($regularCustomerId)
	{
		global $con;
		  $query = "SELECT subAccountHeadId  
				   FROM    subAccountHead 
				   WHERE subAccountClientId='".$regularCustomerId."'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertNetAmountToAccountJournelDebit($invoiceDate,$netAmount,$subAccountHeadId,$invoiceNo,$customerName,$invoiceId,$regularCustomerId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		if($regularCustomerId>0)
		{
		    $j_account_id		=	1;
			$j_sub_account_id	=	$subAccountHeadId	;
			$SalesAccount		=	$customerName;
		
		}else{
				$subaccountData			=		$this->getSubAccountDetails($branchId);
			while($row	=	mysqli_fetch_array($subaccountData))
			{
				$j_account_id		=	$row['accountHeadId'];
				$j_sub_account_id	=	$row['subAccountHeadId'];
				$SalesAccount		=	$row['subAccountHeadName'];
			}
		}
		$j_referenceId=1;
	
		$j_narration="Sales Invoice of ".$customerName." By Invoice No ".$invoiceNo."";
		
		global $con;
		  $query = "INSERT INTO accountJournal 
				   (j_debit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$netAmount."','".$j_account_id."','".$j_sub_account_id."','".$SalesAccount."','".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
	function insertDiscountToAccountJournelDebit($invoiceDate,$discountInAmount,$invoiceNo,$customerName,$invoiceId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];


		$j_account_id=18;
		$j_referenceId=1;
		$j_narration="Sales Invoice of ".$customerName." By Invoice No ".$invoiceNo."";
		
		global $con;
		  $query = "INSERT INTO accountJournal 
				   (j_debit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$discountInAmount."','".$j_account_id."','382','Discount Allowed','".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertSalesPaymentToAccountJurnalDebit($netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		
		
		$subaccountData			=		$this->getSubAccountDetails($branchId);
		while($row	=	mysqli_fetch_array($subaccountData))
		{
			$j_account_id		=	$row['accountHeadId'];
			$j_sub_account_id	=	$row['subAccountHeadId'];
			$SalesAccount		=	$row['subAccountHeadName'];
		}
		$j_referenceId	=	'2';
		$j_narration="Cash From Invoice No ".$invoiceNo;
		global $con;
		  $query = "INSERT INTO accountJournal 
				   (j_debit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$netAmount."','".$j_account_id."','".$j_sub_account_id."','".$SalesAccount."','".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertWuthoutVatTotalToAccountJournelCredit($invoiceDate,$totalAmount,$invoiceNo,$invoiceId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
			
			$j_account_id		=	16;
			$j_sub_account_id	=	20;
			$SalesAccount		=	'Sales Account';
		
		$j_referenceId=1;
		$j_narration="Sales Account of ".$invoiceNo."";
		global $con;
		  $query = "INSERT INTO accountJournal 
				   (j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$totalAmount."','".$j_account_id."','".$j_sub_account_id."','".$SalesAccount."','".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
	function getSubAccountDetails($branchId)
	{
		global $con;
		  $query = "SELECT subAccountHeadId,accountHeadId,subAccountHeadName
					FROM subAccountHead
					WHERE subAccountSalesareaId='$branchId'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertVatAmountToAccountJournelCredit($invoiceDate,$vatAmount,$invoiceNo,$invoiceId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		
		$j_account_id=6;
		$j_sub_account_id=21;
		$SalesAccount='Sales Vat Amount';
		$j_referenceId=1;
		$j_narration="Sales Vat Amount of ".$invoiceNo."";
		global $con;
		  $query = "INSERT INTO accountJournal 
				   (j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$vatAmount."','".$j_account_id."','".$j_sub_account_id."','".$SalesAccount."','".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertSalesPaymentToAccountJurnalCredit($subAccountHeadId,$customerName,$netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		
		$j_account_id=1;
		$j_referenceId=2;
		$j_narration=$customerName."From Invoice No ".$invoiceNo;
		global $con;
		  $query = "INSERT INTO accountJournal 
				   (j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$netAmount."','".$j_account_id."','".$subAccountHeadId."','".$customerName."','".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertCostAndStockValue($invoiceDate,$customerName,$totalCostValue,$invoiceNo,$invoiceId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		
		$j_narration=$customerName."From Invoice No ".$invoiceNo;
		global $con;
		$query = "INSERT INTO accountJournal 
				   (j_debit,j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES ( '', '".$totalCostValue."', '1','2394','Stock',
						   '".$invoiceNo."','".$invoiceDate."','1','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
				( '".$totalCostValue."','','18','2393','Cost',
						   '".$invoiceNo."','".$invoiceDate."','1','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function insertCuttingChargeToAccountJournelDebit($invoiceDate,$cuttingCharge,$invoiceNo,$customerName,$invoiceId)
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		$j_referenceId			=		1;
	
		$j_narration="Cutting Charge of  ".$invoiceNo."";
		
		global $con;
		  $query = "INSERT INTO accountJournal 
				   (j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$cuttingCharge."','16','3137','Cutting Charge','".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."','".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	 function getItemNameDetails($regularCustomerId,$itemName)
	{
		global $con; 
		$query = "SELECT  itemMasterId,itemName,itemCode,packing,maxretailPrice		       
				  FROM   itemMaster 
				  WHERE itemName LIKE '%".$itemName."%' AND status='1'";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function checkDiscount($invoiceId)
	{
		global $con; 
		$query = "SELECT invoiceDetailsId
				  FROM invoiceDetails
				  WHERE discountPercent>'0' AND invoiceId='".$invoiceId."'
				";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		$numRows=mysqli_num_rows($result);
		return $numRows;
	}
	function getSalesPaymentVoucherNo()
	{
		$branchId        		=   	$_COOKIE['branchId'];
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		global $con;
		  $query = "SELECT IFNULL(MAX(salesPaymentVoucherNo)+1,1) AS salesPaymentVoucherNo  
				   FROM    customerSalesPayment 
				    where privilageId='".$privilageId."' AND  branchId='".$branchId."'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
	function insertToCustomerSalesPayment($invoiceId,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$userId)
	{
		global $con;
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		
		$query = "INSERT INTO customerSalesPayment
					(invoiceId,paymentModeId,amountDate,amountPaid,salesPaymentVoucherNo,userId,privilageId,branchId,mainBranch,appStatus)
					VALUES('".$invoiceId."','1','".$invoiceDate."','".$netAmount."','".$salesPaymentVoucherNo."','".$userId."','".$privilageId."','".$branchId."','".$mainBranch."','0')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$customerSalesPaymentId	=	mysqli_insert_id($con);
		//echo "helo";
		return $customerSalesPaymentId;
	
	}
	function getExchangeRate($currencyId)
	{
		global $con;
		    $query = "SELECT exRate  
				   FROM  currency 
				   wHERE currencyId='".$currencyId."' AND status='1'
				  ";		  
		//echo "<br>".$query."<br>";
		$exRateData = mysqli_query($con,$query);
		//echo "helo";
		while($exRateRow 	= 	mysqli_fetch_array($exRateData))
		{
				$exRate		=	$exRateRow['exRate'];
		}
		return $exRate;
	}
	function checkDeliveryNoteDuplication($deliveryNoteId)
	{
		global $con; 
		  $query = "SELECT deliveryNoteId 
				  FROM  invoice 
				  WHERE deliveryNoteId='".$deliveryNoteId."'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$numRows	=	mysqli_num_rows($result);
		//echo "helo";
		return $numRows;	
	}
	
	function getDetailsOfItem($regularCustomerId,$itemMasterId){
		
		global $con; 
		  $query = "SELECT invoice.invoiceNo,invoice.invoiceDate,invoiceDetails.itemCode,invoiceDetails.quantity,invoiceDetails.unitPrice,invoiceDetails.amount,invoiceDetails.amountWithVat,unitName
					FROM invoiceDetails
					INNER JOIN invoice ON invoice.invoiceId = invoiceDetails.invoiceId
					INNER JOIN itemUnit ON itemUnit.itemUnitId = invoiceDetails.itemUnitId
					INNER JOIN unit ON unit.unitId = itemUnit.unitId
					WHERE invoice.regularCustomerId = '".$regularCustomerId."'
					AND invoiceDetails.itemMasterId = '".$itemMasterId."'
					AND invoice.status=1
					AND invoiceDetails.status=1
					ORDER BY invoice.invoiceId DESC
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		
		//echo "helo";
		return $result;	
	}
	
	function getRemainingStock($branchId,$privilageId,$stockIdRow)
	{
		$stock=0;
		global $con; 
		 $query = "SELECT 	stock_".$privilageId."_".$branchId." as stock      
				  FROM  stock 
				  WHERE stockId = '".$stockIdRow."'
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
	function getDiscountData($discountName)
	{
		
		global $con; 
		  $query = "SELECT discountId,discountPercent 
				  FROM  discount 
				  WHERE discountName='".$discountName."'
				  AND status='1'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;	
	}
	function getCurrentStockValue($stockId)
	{
		$privilageId    =   $_COOKIE['privillegeId'];
		$branchId       =   $_COOKIE['branchId'];
		global $con; 
		  $query = "SELECT stock_".$privilageId."_".$branchId." as stockValue
				  FROM  stock 
				  WHERE stockId='".$stockId."'
				  AND activeStatus='1'
				  ";	
		
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;	
	}
	function getItemCartonPrice($itemMasterId)
	{
		global $con; 
		  $query = "SELECT maxretailPrice
				  FROM  itemMaster 
				  WHERE itemMasterId='".$itemMasterId."'
				  AND status='1'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;	
	}
	function getAvgPurchasePrice($itemMasterId){
		
		global $con;
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$totalImportPurchasePrice	=	0;
		  $query = "SELECT IFNULL(SUM(importPurchaseDetails.costPerCtnRow),0) AS totalImportPurchasePrice
					FROM importPurchaseDetails				 
					WHERE itemMasterId = '".$itemMasterId."'
					AND importPurchaseDetails.status =1
					";
					
		$result = mysqli_query($con,$query);
		while($row=mysqli_fetch_array($result))
		{
			$totalImportPurchasePrice	=	$row['totalImportPurchasePrice'];
		}
		return $totalImportPurchasePrice;
	}
	function getrowCount($itemMasterId){
		
		global $con; 
		
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		
		  $query = "SELECT importPurchaseDetails.costPerCtnRow
					FROM importPurchaseDetails				 
					WHERE itemMasterId = '".$itemMasterId."'
					AND importPurchaseDetails.status =1";
		$result = mysqli_query($con,$query);
		$numOfRows	=	mysqli_num_rows($result);
		return $numOfRows;
		
	}
	function getOpeningStock($expiryDate,$itemMasterId,$privilageId,$branchId)
	{
		global $con; 
		 $query = "SELECT stock_".$privilageId."_".$branchId."  as stock     
				  FROM  stock 
				  WHERE expiryDate = '".$expiryDate."'  and activeStatus=1 and itemMasterId='".$itemMasterId."'
				  and stock_".$privilageId."_".$branchId." > 0";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$numOfRows	=	mysqli_num_rows($result);
		return $numOfRows;
		
	}
	/*function getCostPrice($itemMasterId)
	{
		$costPrices=0;
		global $con; 
		 $query = "SELECT costPrice      
				  FROM  itemMaster 
				  WHERE itemMasterId = '".$itemMasterId."'  AND status=1
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		while($row = mysqli_fetch_array($result))
			{
				$costPrices=$row['costPrice'];
			}
		//echo "helo";
		return $costPrices;	
		
	}*/
	function getmultipleOfCarton($itemMasterId)
	{
		global $con;
        $query = "SELECT multiple 
                  FROM itemUnit  
				  INNER JOIN unit ON itemUnit.unitId=unit.unitId
                  WHERE itemUnit.itemMasterId='".$itemMasterId."'
				  AND unit.unitName='CARTON'";
							
        $resultEmptyStockDisplay = mysqli_query($con, $query);
				$multiple = mysqli_fetch_array($resultEmptyStockDisplay);
        //echo "<br>".$query."<br>";
        return $multiple['multiple'];
        
		
	}
	function getBranchCode()
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		global $con;
        $query = "SELECT salesmanCode 
                  FROM branch 
                  WHERE branchId='$branchId' AND privillageId='$privilageId'";
							
        $resultBranch = mysqli_query($con, $query);
		if(mysqli_num_rows($resultBranch)>0){
			$branchCode = mysqli_fetch_array($resultBranch);
			return $branchCode['salesmanCode'];
		}
		else{
			return null;
		}
		
		
	}
	function getUserName($userId)
	{
		global $con;
      $query = "SELECT  username
				FROM  login
                WHERE loginId='$userId' AND status='1'
                  ";
						
        $result = mysqli_query($con, $query);
		while($row=(mysqli_fetch_array($result)))
		{
			$username	=	$row['username'];
		}
        return $username;
	}
	
	function getAllIncoiceForUpdation()
	{
		global $con;
        $query = "SELECT invoiceId,invoiceNo 
                  FROM invoice 
                  ";
							
        $result = mysqli_query($con, $query);
        return $result;
	}
	function updateNeumericNo($invoiceId,$invoiceNoUpdate)
	{
		global $con;
      $query = "UPDATE  invoice
					SET invoiceNumericNo='$invoiceNoUpdate'
                 WHERE invoiceId='$invoiceId'
                  ";
						
        $result = mysqli_query($con, $query);
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
				  order by multiple DESC limit 1
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result; 
		
	}
	
	function getMaterialsUnitIdAutoComplete($itemMasterId)
	{
		global $con; 
		$query = "SELECT itemUnitId,unit.unitName,multiple		       
				  FROM  itemUnit 
				  JOIN unit ON itemUnit.unitId=unit.unitId
				  WHERE itemMasterId = '".$itemMasterId."' 
				   AND itemUnit.status='1'
				  order by multiple
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result; 
		
	}
	
		function getSalesman($branchId)
	{
		
		global $con;
        $query = "SELECT salesmanName 
                  FROM branch 
                  WHERE branchId='$branchId' ";
							
        $resultBranch = mysqli_query($con, $query);
        if(mysqli_num_rows($resultBranch)>0){
		$branchCode = mysqli_fetch_array($resultBranch);
        return $branchCode['salesmanName'];
        }else
        return null;
		
	}
	
}

?>