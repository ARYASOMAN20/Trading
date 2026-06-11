<?php
require_once("../../../../settings/connect_db.php");
	
class invoiceEditmodel{
	// 	function getMaterialsForAutoComplete($materialsName,$regularCustomerId,$privilageId,$branchId)
	// {
	// 	global $con; 
	// 	if($privilageId==3)
	// 	{
	// 		 $query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate		       
	// 			  FROM  stock S
	// 			  JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
	// 			  WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
	// 			  AND activeStatus='1' AND stock_".$privilageId."_".$branchId.">0
	// 			  LIMIT 50
	// 			  ";
				  
	// 	}else{
	// 	  $query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate	       
	// 			  FROM  stock S
	// 			  JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
	// 			  WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
	// 			  AND activeStatus='1'
	// 			  LIMIT 50
	// 			  ";
		 		  
	// 	}
				  
	// 	//echo "<br>".$query."<br>";
	// 	$result = mysqli_query($con,$query);
	// 	//echo "helo";
	// 	return $result;
	// }

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
		$result = mysqli_query($con,$query);
		
		return $result;
	}
	



	public function invoiceNoAutocomplete($my_data){
			global $con;
			if(isset($_COOKIE['privillegeId'])) {
				$privilageId       	 	=   	$_COOKIE['privillegeId'];
				$branchId        		=   	$_COOKIE['branchId'];
				$userId					=		$_COOKIE['userId'];
			}
			else{
				$privilageId       	 	= 6; // 	$_COOKIE['privillegeId'];
				$branchId        		= 5; // 	$_COOKIE['branchId'];
				$userId					= 6; //		$_COOKIE['userId'];

			}
			
	    	if($privilageId==2||$privilageId==3)
			{
			$query   = "SELECT invoiceId,invoiceNo  
					 	FROM invoice 
						WHERE  invoiceNo LIKE '$my_data%' AND branchId='$branchId' AND privilageId='$privilageId'";
			}else{
				$query   = "SELECT invoiceId,invoiceNo  
					 	FROM invoice 
						WHERE  invoiceNo LIKE '$my_data%' AND invoice.connectedStatus=0";
			}
			$result  = mysqli_query($con,$query);
			return $result;
		}	
		function getPaymentDetails($salesInvoiceId)
	{
		global $con;
		$query = "SELECT customerSalesPaymentId 
				  FROM customerSalesPayment 
				  WHERE invoiceId = '".$salesInvoiceId."'
				    AND status='1'
				  ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$numOfRows	=	mysqli_num_rows($result);
		return $numOfRows;
	}
		

public function getInvoiceDetails($salesInvoiceId,$privilageId,$branchId){
	global $con;
	if($privilageId==3)
	{
		$query = "SELECT I.invoiceDate,I.totalAmount,I.discountAmount,I.discountPercent,I.totalAmountAfterDiscount,I.vatPercent,
              		     I.vatAmount,I.totalAmountWithVat,I.transactionType,I.invoiceId,I.regularCustomerId,I.invoiceNo,
						 I.customerName AS customerNameInvoice,I.customerPhone,RC.customerName,C.currencyName ,RC.customerNo,I.currencyId,I.exRate,I.damagedGoodsReturn,I.damagedGoodsAmount,round,roundAmount,I.invoiceRefId,I.customerVatNo
				  FROM invoice I
				  INNER JOIN regularCustomer RC on RC.regularCustomerId=I.regularCustomerId 
				  INNER JOIN currency C on C.currencyId=I.currencyId  
				  where I.invoiceId='".$salesInvoiceId."'";
	}else{
		$query = "SELECT I.invoiceDate,I.totalAmount,I.discountAmount,I.discountPercent,I.totalAmountAfterDiscount,I.vatPercent,
              		     I.vatAmount,I.totalAmountWithVat,I.transactionType,I.invoiceId,I.regularCustomerId,I.invoiceNo,
						 I.customerName AS customerNameInvoice,I.customerPhone,RC.customerName,C.currencyName ,RC.customerNo,I.currencyId,I.exRate,I.damagedGoodsReturn,I.damagedGoodsAmount,round,roundAmount,I.invoiceRefId,I.customerVatNo
				  FROM invoice I
				  left JOIN regularCustomer RC on RC.regularCustomerId=I.regularCustomerId 
				  INNER JOIN currency C on C.currencyId=I.currencyId  
				  where I.invoiceId='".$salesInvoiceId."'";		  
	}
		return mysqli_query($con,$query);
	}
	
public function printInvoiceBody($salesInvoiceId){
		global $con;
		$query = "SELECT ID.invoiceDetailsId,ID.itemMasterId,ID.stockId,ID.itemUnitId,ID.quantity,ID.netWeight,ID.unitPrice,ID.amount,IM.itemCode,
						IM.itemName,IM.importLocalStatus,IM.minimumRate,IM.maxretailPrice,ID.vatPercent,ID.vatAmount,ID.amountWithVat
					FROM invoiceDetails ID 
					INNER JOIN itemMaster IM ON ID.itemMasterId=IM.itemMasterId
					where ID.invoiceId='".$salesInvoiceId."' AND  ID.status=1";
		return mysqli_query($con,$query);
	}	
	
public function getAllUnits($companyItemCodeId){
		  global $con;
		  $query ="SELECT IU.unitId,IU.multiple,U.unitName,IU.itemUnitId from itemUnit IU
			inner join unit U ON U.unitId=IU.unitId
			where IU.itemMasterId='".$companyItemCodeId."' AND IU.status=1 ORDER BY IU.multiple";
		  return mysqli_query($con,$query);
			
	}	
public function getCurrecy(){
		  global $con;
		  $query ="SELECT currencyName,currencyId,exRate from currency WHERE status=1"; 
			
			
		  return mysqli_query($con,$query);
			
	}
public function getVessel(){
		  global $con;
		  $query ="SELECT vesselId,vesselName from vessel";
			
		  return mysqli_query($con,$query);
			
	}	
	function checkInvoiceNoExistOrNot($invoiceNo,$invoiceIdUpdate)
	{
		global $con;
		$query = "SELECT invoiceNo 
				  FROM invoice 
				  WHERE invoiceNo = '".$invoiceNo."' AND invoiceId!='".$invoiceIdUpdate."'";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$numOfRows	=	mysqli_num_rows($result);
		return $numOfRows;
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
	
	function checkIfBranch($salesInvoiceId,$branchId)
	{
			global $con;
		$query = "SELECT invoiceNo 
				  FROM invoice 
				  WHERE invoiceId = '".$salesInvoiceId."' AND branchId='".$branchId."'";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$numOfRows	=	mysqli_num_rows($result);
		return $numOfRows;
		
	}
	
	function setStatus($invoiceDetailsId){
		
		global $con; 
		 $query = "UPDATE invoiceDetails SET status=0
				   WHERE invoiceDetailsId = '".$invoiceDetailsId."' ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		
	}  
	
	function updateInvoiceTable($invoiceDate,$currencyId,$totalAmount,$discountInPercent,$discountInAmount,
					$amountAfterDiscountTotal,$damagedGoodsAmount,$vatInPercent,$vatAmount,$netAmount,$invoiceIdUpdate,
								$exRate,$amountWithExRate,$damagedGoodsReturn,$regularCustomerId,$customerName,$customerPhone,$transactionType,$roundOff,$roundAmount,$customerVatNumber)
		
		{
			global $con; 
		 $query = "UPDATE invoice SET invoiceDate='".$invoiceDate."',currencyId='".$currencyId."',totalAmount='".$totalAmount."',
									  discountPercent='".$discountInPercent."',discountAmount='".$discountInAmount."',
									  totalAmountAfterDiscount='".$amountAfterDiscountTotal."',vatPercent='".$vatInPercent."',
									  vatAmount='".$vatAmount."',totalAmountWithVat='".$netAmount."',
									  exRate='".$exRate."', netAmountWithExRate='".$amountWithExRate."',
									  damagedGoodsReturn='".$damagedGoodsReturn."',damagedGoodsAmount='".$damagedGoodsAmount."',
									  regularCustomerId='".$regularCustomerId."',customerName='".$customerName."',
									  customerPhone='".$customerPhone."',transactionType='".$transactionType."',updateStatus='1',round='".$roundOff."',roundAmount='".$roundAmount."',customerVatNo='".$customerVatNumber."'	 	 
				   WHERE invoiceId = '".$invoiceIdUpdate."' ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
			
		}
	function insertToInvoiceDetails($invoiceId,$stockId,$itemMasterId,$itemUnitId,
			                        $quantityRow,$netWeightRow,$unitPriceRow,$amountWithOutDiscount,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,$itemCodeRow)
	{
		global $con; 
		$query = "INSERT INTO invoiceDetails
					(invoiceId,stockId,itemMasterId,itemUnitId,quantity,netWeight,unitPrice,amount,vatPercent,vatAmount,amountWithVat,itemCode)
					VALUES ('".$invoiceId."','".$stockId."','".$itemMasterId."','".$itemUnitId."','".$quantityRow."',
					'".$netWeightRow."','".$unitPriceRow."','".$amountWithOutDiscount."','".$vatPercentRow."','".$vatAmountRow."','".$amountWithWithVatRow."','".$itemCodeRow."')";
	
		$result 			=	mysqli_query($con,$query);
		$invoiceDetailsId	=	mysqli_insert_id($con);
		//echo "helo";
		return $invoiceDetailsId;	
	}	
		
	function updateInvoiceDetails($itemUnitId,$quantityRow,$netWeightRow,$unitPriceRow,$invoiceDetailsId,$amountWithOutDiscount,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,$itemCodeRow)
		
		{
			global $con; 
		$query = "UPDATE invoiceDetails 
					SET itemUnitId='".$itemUnitId."',quantity='".$quantityRow."',netWeight='".$netWeightRow."',unitPrice='".$unitPriceRow."',
						amount='".$amountWithOutDiscount."',vatPercent='".$vatPercentRow."',vatAmount='".$vatAmountRow."',amountWithVat='".$amountWithWithVatRow."',itemCode='".$itemCodeRow."'
						WHERE invoiceDetailsId = '".$invoiceDetailsId."' ";
				 
		$result = mysqli_query($con,$query);
		
		return $result;	
			
		}	
		
		function updateStockInStocktable($itemMasterId,$stockId,$stockQuantity,$privilageId,$branchId)
	{
		global $con;
		
		 $query = "UPDATE stock 
				  SET stock_".$privilageId."_".$branchId." = stock_".$privilageId."_".$branchId." + '". $stockQuantity ."'
				  WHERE stockId = '".$stockId."' ";
	  
				// echo "<br>".$query."<br>";	exit;	  
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
	}
	function decreaseStockInStocktable($itemMasterId,$stockId,$stockQuantity,$privilageId,$branchId)
	{
		global $con;
		
		 $query = "UPDATE stock 
				  SET stock_".$privilageId."_".$branchId." = stock_".$privilageId."_".$branchId." -'". $stockQuantity ."'
				  WHERE stockId = '".$stockId."' ";
	  
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
	}
	function removeStockInStockTable($stockId,$balQuantity,$privilageId,$branchId)
	{
		global $con;
		
		 $query = "UPDATE stock 
				  SET stock_".$privilageId."_".$branchId." = stock_".$privilageId."_".$branchId." + '".$balQuantity."'
				  WHERE stockId = '".$stockId."' ";
	  
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
	}
	function getRemainingStockFromStockTable($stockId,$privilageId,$branchId)
	{
		global $con;
		$remainingStock	=	0;
		 $query = "SELECT stock_".$privilageId."_".$branchId."   as remainingStock
					FROM stock
					WHERE stockId = '".$stockId."' ";
	  
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		while($row=mysqli_fetch_array($result))
		{
			$remainingStock	=	$row['remainingStock'];
		}
		return $remainingStock;
	}
	function updateStockInItemMasterBranch($itemMasterId,$stockQuantity,$branchId)
	{
		global $con;
		$query = "UPDATE itemMaster 
				  SET ".$branchId."_B_stock = ".$branchId."_B_stock  + '". $stockQuantity ."'
				  WHERE itemMasterId = '".$itemMasterId."' ";
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
		
	}
	
	function getRemainingStock($branchId,$itemMasterId){
		$stock=0;
		global $con; 
		 $query = "SELECT ".$branchId."_B_stock as stock      
				  FROM  itemMaster 
				  WHERE itemMasterId = '".$itemMasterId."'
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
	function getRemainingStock1($itemMasterId){
		$stock=0;
		global $con; 
		 $query = "SELECT stock as stock      
				  FROM  itemMaster 
				  WHERE itemMasterId = '".$itemMasterId."'
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
	
	function insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$stockId,$quantityRow,$itemUnitId,$netWeightRow,
	$invoiceDetailsId,$customerName,$stock,$privilageId,$branchId,$mainBranch,$userId)
	{
		$transactionType = 'Sales';
		$stockStatus = 'OUT';
		global $con;
		$query = "INSERT INTO itemTransferDetails(invoiceDetailsId,date,transactionNo,itemMasterId,quantity,itemUnitId,totalQuanity,
		transactionType,stockStatus,vendorOrCustomerName,remainingStock,stockId,type,privilageId,branchId,mainBranch,userId) 
				  VALUES('".$invoiceDetailsId."','".$invoiceDate."','".$invoiceNo."','".$itemMasterId."','".$quantityRow."','".$itemUnitId."',
				  '".$netWeightRow."','".$transactionType."','".$stockStatus."','".$customerName."','".$stock."','".$stockId."','1',
				  '".$privilageId."','".$branchId."','".$mainBranch."','".$userId."')";
		$result = mysqli_query($con,$query);
		//return mysqli_insert_id($con);
		
	}
		
		function updateStatus($invoiceDetailsId,$itemMasterId){
	global $con; 
		 $query = "UPDATE itemTransferDetails SET status=0 
				   WHERE invoiceDetailsId = '".$invoiceDetailsId."' AND  itemMasterId='".$itemMasterId."' AND type='1'";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
	
}
function updateItemTransferTbl($invoiceDetailsId,$itemMasterId,$itemUnitId,$newStock,$quantityRow,$invoiceDate,$stock,$customerName	)
	{
		global $con;
			 $query = "UPDATE itemTransferDetails
					  SET date='".$invoiceDate."',quantity='".$quantityRow."',itemUnitId='".$itemUnitId."',totalQuanity='".$newStock."',
					      remainingStock='".$stock."',vendorOrCustomerName='".$customerName."'
					  WHERE invoiceDetailsId='".$invoiceDetailsId."' AND itemMasterId='".$itemMasterId."' AND type='1' 
					";
				
		//print_r($query);
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
		
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
	function getSubAccountIdByBranchId($branchId)
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
		function updateAccountJournelDebit($invoiceDate,$netAmount,$subAccountHeadId,$subAccountHeadIdOld,$invoiceNo,$customerName,$invoiceIdUpdate,$privilageId)
		{
			global $con; 
			$j_narration="Sales Invoice of ".$customerName." By ".$invoiceNo."";
		/*	if($privilageId==3)
			{*/
				 $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_debit='".$netAmount."',
				 j_sub_account_id='".$subAccountHeadId."',j_particulars='".$customerName."',j_narration='".$j_narration."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='".$subAccountHeadIdOld."' ";
		/*	}else{
		    $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_debit='".$netAmount."',
					j_particulars='".$customerName."',j_narration='".$j_narration."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='".$subAccountHeadId."' ";
				  
		    }*/
		    $result = mysqli_query($con,$query);
		   
		    return $result;
			
		}
		
		function updateDiscountToAccountJournelDebit($invoiceDate,$discountInAmount,$invoiceNo,$customerName,$invoiceIdUpdate)
		{
			global $con; 
			$j_narration="Sales Invoice of ".$customerName." By ".$invoiceNo."";
		    $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_debit='".$discountInAmount."',j_narration='".$j_narration."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='382' ";
				  
		    
		    $result = mysqli_query($con,$query);
		    
		    return $result;
			
		}
		
		function updateWuthoutVatTotalToAccountJournelCredit($invoiceDate,$totalAmount,$invoiceNo,$invoiceIdUpdate)
		{
			global $con; 
			$j_narration="Sales Account of ".$invoiceNo."";
		    $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_credit='".$totalAmount."',j_remarks='".$invoiceNo."',j_narration='".$j_narration."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='20' ";
				  
		   
		    $result = mysqli_query($con,$query);
		   
		    return $result;
			
		}
		
		function updateVatAmountToAccountJournelCredit($invoiceDate,$vatAmount,$invoiceNo,$invoiceIdUpdate)
		{
			global $con; 
			$j_narration="Sales Vat Amount of ".$invoiceNo."";
		    $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_credit='".$vatAmount."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='21' ";
				  
		    
		    $result = mysqli_query($con,$query);
		   
		    return $result;
			
		}
		function updateCostAndStockValue($invoiceDate,$customerName,$totalCostValue,$invoiceNo,$invoiceIdUpdate)
		{
			global $con; 
			$j_narration=$customerName." From Invoice No ".$invoiceNo."";
		    $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_credit='".$totalCostValue."',j_narration='".$j_narration."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='2394' ";
				  
		    $result = mysqli_query($con,$query);
		    $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_debit='".$totalCostValue."',j_narration='".$j_narration."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='2393' ";
				  
		    $result = mysqli_query($con,$query);
		    return $result;
			
		}
		function updateSalesPaymentToAccountJurnal($invoiceDate,$debitAmount,$subAccountHeadIdBranch,$subAccountHeadId,$subAccountHeadIdOld,$invoiceNo,$customerName,$invoiceIdUpdate,$branchId)
		{
			global $con; 
			$j_narration=$customerName." From Invoice No ".$invoiceNo;
		     $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_credit='".$debitAmount."',
				j_sub_account_id='".$subAccountHeadId."',j_particulars='".$customerName."',j_narration='".$j_narration."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='2' AND j_sub_account_id='$subAccountHeadIdOld' 
					  AND j_voucherNo IS NULL AND j_branchId='$branchId'";
				  
		    $result = mysqli_query($con,$query);
		     $query = "UPDATE accountJournal SET j_dateOfPayment='".$invoiceDate."',j_debit='".$debitAmount."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='2' AND j_sub_account_id='$subAccountHeadIdBranch' 
					  AND j_voucherNo IS NULL AND j_branchId='$branchId'";
				  
		    $result = mysqli_query($con,$query);
		    return $result;
		}
		function updateSalesPaymentToAccountJurnalWithStatusZero($subAccountHeadIdOld,$subAccountHeadIdBranch,$invoiceIdUpdate,$branchId)
		{
			global $con; 
		     $query = "UPDATE accountJournal SET j_status='0'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='2' AND j_sub_account_id='$subAccountHeadIdOld' 
					  AND j_voucherNo IS NULL AND j_branchId='$branchId'";
				  
		    $result = mysqli_query($con,$query);
		     $query = "UPDATE accountJournal SET j_status='0'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='2' AND j_sub_account_id='$subAccountHeadIdBranch' 
					  AND j_voucherNo IS NULL AND j_branchId='$branchId'";
				  
		    $result = mysqli_query($con,$query);
		    return $result;
		}
		
		function updateInvoiceTbl($invoiceIdUpdate,$discountInAmount,$amountAfterDiscountTotal,$totalAmount,$vatAmount,$netAmount)
		{
		
		global $con; 
		 $query = "UPDATE invoice SET totalAmount='".$totalAmount."',
									  discountAmount='".$discountInAmount."',
									  vatAmount='".$vatAmount."',totalAmountWithVat='".$netAmount."',
									  updateStatus='1',totalAmountAfterDiscount='".$amountAfterDiscountTotal."'
				   WHERE invoiceId = '".$invoiceIdUpdate."' ";
				  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
		}
		function updateAccountsTbl($invoiceIdUpdate,$discountInAmount,$totalAmount,$vatAmount,$netAmount,$subAccountHeadId)
		{
			global $con; 
		    $query = "UPDATE accountJournal SET j_debit='".$netAmount."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='".$subAccountHeadId."' ";
				  
		    
		    $result = mysqli_query($con,$query);
			
			 $query = "UPDATE accountJournal SET j_debit='".$discountInAmount."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='382' ";
				  
		    
		    $result = mysqli_query($con,$query);
			
			 $query = "UPDATE accountJournal SET j_credit='".$totalAmount."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='20' ";
				  
		   
		    $result = mysqli_query($con,$query);
			
			 $query = "UPDATE accountJournal SET j_credit='".$vatAmount."'
				      WHERE j_invoiceId = '".$invoiceIdUpdate."' AND j_referenceId='1' AND j_sub_account_id='21' ";
				  
		    
		    $result = mysqli_query($con,$query);
			
			
		}
		function getUnitName($itemUnitId)
		{
			global $con; 
		    $query = "SELECT unit.unitName
						FROM itemUnit
						INNER JOIN unit ON itemUnit.unitId=unit.unitId
						WHERE itemUnit.itemUnitId='$itemUnitId'";
			$result = mysqli_query($con,$query);
			return $result;
		}
		function getBranchDetailsOfIncoice($salesInvoiceId)
		{
			global $con; 
		    $query = "SELECT userId,branchId,privilageId,mainBranch
						FROM invoice
						WHERE invoiceId='$salesInvoiceId'";
			$result = mysqli_query($con,$query);
			return $result;
		}
		function updateCustomerSalesPaymentTable($invoiceIdUpdate,$invoiceDate,$netAmount)
		{
			global $con; 
		     $query = "UPDATE customerSalesPayment
						SET amountDate='$invoiceDate',amountPaid='$netAmount'
						WHERE invoiceId='$invoiceIdUpdate'";
					
			$result = mysqli_query($con,$query);
			return $result;
		}
		function updateCustomerSalesPaymentTableWithStatusZero($invoiceIdUpdate,$invoiceDate,$updateZeroAmount)
		{
			global $con; 
		     $query = "UPDATE customerSalesPayment
						SET amountDate='$invoiceDate',amountPaid='$updateZeroAmount',status='0'
						WHERE invoiceId='$invoiceIdUpdate'";	
			$result = mysqli_query($con,$query);
			return $result;
		}
		
function getDeletedItems()
		{
			global $con; 
		     $query = "SELECT ID.stockId,ID.netWeight,I.branchId,I.privilageId
						FROM invoiceDetails ID 
						INNER JOIN invoice I ON ID.invoiceId=I.invoiceId
						WHERE I.updateStatus='1' AND I.privilageId='3'";
					
			$result = mysqli_query($con,$query);
			return $result;
		}
		function updateStockInStoctTable($stockId,$totalStockValue,$branchId,$privilageId)
		{
			global $con;
		
		  $query = "UPDATE stock 
				  SET stock_".$privilageId."_".$branchId." = '".$totalStockValue."'
				  WHERE stockId = '".$stockId."' ";
		
				//echo "<br>".$query."<br>";		  
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
		}
		function getTotalInstockFromItemTransferDetailsTable($stockId,$branchId,$privilageId)
		{
			global $con;
			  $query = "SELECT  IFNULL(SUM(totalQuanity),0)  as totalInStock
						FROM  itemTransferDetails 
						WHERE branchId='$branchId'  AND privilageId='$privilageId'
						AND stockId= '$stockId'
						AND stockStatus='IN'
						AND  status='1'
					  ";	
					  

			$result = mysqli_query($con,$query);
			while($row=mysqli_fetch_array($result))
			{
				$totalInStock	=	$row['totalInStock'];
			}
			return $totalInStock;
		}
		function getTotalOutstockFromItemTransferDetailsTable($stockId,$branchId,$privilageId)
		{
			global $con;
			  $query = "SELECT  IFNULL(SUM(totalQuanity),0)  as totalOutStock
						FROM  itemTransferDetails 
						WHERE branchId='$branchId'  AND privilageId='$privilageId'
						AND stockId= '$stockId' 
						AND stockStatus='OUT'
						AND  status='1'
					  ";	

			$result = mysqli_query($con,$query);
			while($row=mysqli_fetch_array($result))
			{
				$totalOutStock	=	$row['totalOutStock'];
			}
			return $totalOutStock;
		}
			function getCustomerForAutoComplete($customerCode,$branchId)
	{
		global $con; 
		 $query = "SELECT regularCustomerId,customerName,customerNo,vatNumber      
				  FROM  regularCustomer 
				  WHERE (customerNo LIKE '".$customerCode."%' OR customerName LIKE '".$customerCode."%')
				  AND salesAreaBranchId= '".$branchId."'
				  ";
				
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;	
	}
	function getStockValue($stockId,$privilageId,$branchId)
	{
		global $con; 
		$query = "SELECT stock_".$privilageId."_".$branchId."  as stockValue 
				  FROM  stock 
				  WHERE stockId='$stockId'
				  ";
		
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
		function insertSalesPaymentToAccountJurnalDebit($netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceId,$branchId,$privilageId,$userId,$mainBranch)
	{
	
		
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
		function insertSalesPaymentToAccountJurnalCredit($subAccountHeadId,$customerName,$netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceId,$branchId,$privilageId,$userId,$mainBranch)
	{
	
		
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
	
	function getSalesPaymentVoucherNo($branchId)
	{
	
		global $con;
		  $query = "SELECT IFNULL(MAX(salesPaymentVoucherNo)+1,1) AS salesPaymentVoucherNo  
				   FROM    customerSalesPayment 
				    where   branchId='".$branchId."'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
		function insertToCustomerSalesPayment($invoiceIdUpdate,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$branchId,$privilageId,$userId,$mainBranch)
	{
		global $con;
	
		$query = "INSERT INTO customerSalesPayment
					(invoiceId,paymentModeId,amountDate,amountPaid,salesPaymentVoucherNo,userId,privilageId,branchId,mainBranch,appStatus)
					VALUES('".$invoiceIdUpdate."','1','".$invoiceDate."','".$netAmount."','".$salesPaymentVoucherNo."','".$userId."','".$privilageId."','".$branchId."','".$mainBranch."','0')
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$customerSalesPaymentId	=	mysqli_insert_id($con);
		//echo "helo";
		return $customerSalesPaymentId;
	
	}
	
}
?>