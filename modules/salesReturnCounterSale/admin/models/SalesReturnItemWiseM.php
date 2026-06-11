<?php
require_once("../../../../settings/connect_db.php");
//$con = mysqli_connect("localhost", "root", "", "aadil1_vansale") or die("cannot connect");


class SalesReturnItemWiseM
{
	function getlastSalesReturnNo(){
	  global $con;
	  if(isset($_COOKIE['mainBranch'])) {
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		$branchId        		=   	$_COOKIE['branchId'];
	  }
	  else{
		$mainBranch        		= 	'J';
		$branchId        		=   '5';
	  }
		
		 $query = "SELECT  MAX(numberSalesReturnNo) as numberSalesReturnNo
				  FROM  salesReturnCounterSale
				  WHERE branchId='$branchId' AND mainBranch='$mainBranch'";
	 $result  = mysqli_query($con,$query);
	  return $result;
 }
 
 
  function getSalesManCode(){
	  global $con;
	  if(isset($_COOKIE['mainBranch'])) {
		$mainBranch        		= 		$_COOKIE['mainBranch'];
		$branchId        		=   	$_COOKIE['branchId'];
	  }
	  else{
		$mainBranch        		= 	'J';
		$branchId        		=   '5';
	  }
	   $query   = "SELECT salesmanCode from branch 
					WHERE branchId='$branchId' AND mainBranch='$mainBranch'";
	  $result  = mysqli_query($con,$query);
	  if(mysqli_num_rows($result)>0)
	  {
		$data = mysqli_fetch_array( $result);
		return $data['salesmanCode'];
	  }
	  else{
		return NULL;
	  }
	 
 }
 
	function getCustomerForAutoComplete($customerCode)
	{
		$branchId        		=   	$_COOKIE['branchId'];
		global $con; 
		 $query = "SELECT regularCustomerId,customerName,customerNo,vatNumber      
				  FROM  regularCustomer 
				  WHERE customerNo LIKE '".$customerCode."%'
				  AND salesAreaBranchId= '".$branchId."'";
		$result = mysqli_query($con,$query);
		return $result;	
	}
	function getcountersalesInvoiceNo($my_data)
	{
		global $con;
		if(isset($_COOKIE['privillegeId'])) {

			$privilageId       	 	=   	$_COOKIE['privillegeId'];
			$branchId        		=   	$_COOKIE['branchId'];
			$userId					=		$_COOKIE['userId'];
		}
		else{
			$privilageId       	 	=   '6'	;
			$branchId        		=   '5'	;
			$userId					=	'6'	;
		}
	    	if($privilageId==2||$privilageId==3)
			{
			$query   = "SELECT invoiceId,invoiceNo  
					 	FROM invoice 
						WHERE  invoiceNo LIKE '$my_data%' AND branchId='$branchId' AND privilageId='$privilageId'";
			}else{
				$query   = "SELECT invoiceId,invoiceNo  
					 	FROM invoice 
						WHERE  invoiceNo LIKE '$my_data%'";
			}
			$result  = mysqli_query($con,$query);
			return $result;
	}
	function getBranchDetailsOfInvoice($salesInvoiceId)
		{
			global $con; 
		    $query = "SELECT userId,branchId,privilageId,mainBranch
						FROM invoice
						WHERE invoiceId='$salesInvoiceId'";
			$result = mysqli_query($con,$query);
			return $result;
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
						 I.customerName AS customerNameInvoice,I.customerPhone,RC.customerName,C.currencyName ,RC.customerNo,I.currencyId,I.exRate,I.damagedGoodsReturn,I.damagedGoodsAmount,round,roundAmount,I.invoiceRefId
				  FROM invoice I
				  INNER JOIN regularCustomer RC on RC.regularCustomerId=I.regularCustomerId 
				  INNER JOIN currency C on C.currencyId=I.currencyId  
				  where I.invoiceId='".$salesInvoiceId."'";
	}else{
		$query = "SELECT I.invoiceDate,I.totalAmount,I.discountAmount,I.discountPercent,I.totalAmountAfterDiscount,I.vatPercent,
              		     I.vatAmount,I.totalAmountWithVat,I.transactionType,I.invoiceId,I.regularCustomerId,I.invoiceNo,
						 I.customerName AS customerNameInvoice,I.customerPhone,RC.customerName,C.currencyName ,RC.customerNo,I.currencyId,I.exRate,I.damagedGoodsReturn,I.damagedGoodsAmount,round,roundAmount,I.invoiceRefId
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
						IM.itemName,IM.importLocalStatus,IM.minimumRate,IM.maxretailPrice,ID.vatPercent,ID.vatAmount,ID.amountWithVat,unit.unitName,itemUnit.multiple
					FROM invoiceDetails ID 
					INNER JOIN itemMaster IM ON ID.itemMasterId=IM.itemMasterId

					LEFT JOIN itemUnit ON itemUnit.itemUnitId=ID.itemUnitId
				  	LEFT JOIN unit ON unit.unitId=itemUnit.unitId

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
	function getLastUnit($itemMasterId,$regularCustomerId){
		global $con; 
		  $query = "SELECT * from invoice I
					INNER JOIN invoiceDetails ID ON ID.invoiceId = I.invoiceId
					WHERE ID.itemMasterId = '".$itemMasterId."' 
					AND I.regularCustomerId = '".$regularCustomerId."' 
					 ORDER BY I.invoiceId DESC  LIMIT 1";
				  
		$result = mysqli_query($con,$query);
		return $result;	
	}


function getMaterialsUnitAutoComplete($itemMasterId){
		global $con; 
		   $query = "SELECT IU.itemUnitId,U.unitName,IU.multiple
						FROM itemUnit IU
						INNER JOIN unit U ON U.unitId = IU.unitId
						WHERE IU.itemMasterId = '".$itemMasterId."' 
						AND IU.status = '1' order by IU.multiple DESC";
					
				  
		$result = mysqli_query($con,$query);
		return $result;	
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
				  
		$result = mysqli_query($con,$query);
		return $result;	
	}
	
	
		function insertToSalesReturn($returnNo,$returnDate,$regularCustomerId,$currencyId,$exRate,$totalAmount,
				$discountInPercent,$discountInAmount,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,
				$netAmountWithExRate,$userId,$branchId,$privilageId,$mainBranch,$numbericReturnNo,$roundOff,$roundAmount,$invoiceIdToSave,$damagedGoodsAmount,$transactionType)
								
	{
		global $con; 

		
		   $query = "INSERT INTO salesReturnCounterSale(salesReturnNo,salesReturnDate,regularCustomerId,currencyId,exRate,
					totalAmount,discountInPercent,discountInAmount,totalAfterDiscount,vatPercent,vatAmount,netAmount,
					netAmountWithExRate,userId,branchId,privilageId,mainBranch,numberSalesReturnNo,round,roundAmount,invoiceId,damagedGoodsAmount,transactionType)
					VALUES ('".$returnNo."', '".$returnDate."','".$regularCustomerId."','".$currencyId."','".$exRate."',
					'".$totalAmount."','".$discountInPercent."','".$discountInAmount."','".$totalAfterDiscount."',
					'".$vatPercent."','".$vatAmount."','".$netAmount."','".$netAmountWithExRate."',
					'".$userId."','".$branchId."','".$privilageId."','".$mainBranch."','".$numbericReturnNo."','".$roundOff."','".$roundAmount."','".$invoiceIdToSave."','".$damagedGoodsAmount."','".$transactionType."')";
								
		$result 	=	mysqli_query($con,$query);
		$invoiceId	=	mysqli_insert_id($con);
		return $invoiceId;	
	}
	function insertIntoSalesReturnDetails($salesReturnId,$stockIdRow,$itemMasterId,$itemUnitId,
										$unitFraction,$quantityRow,$netWeightRow,$unitPriceRow,$rowTotal,$vatPercentage,$vatAmount,$rowTotalWithVat)
	{
		global $con; 
		  $query = "INSERT INTO salesReturnCounterSaleDetails(salesReturnItemWiseId,stockId,itemMasterId,itemUnitId,
					unitFraction,quantityRow,netWeightRow,unitPriceRow,rowTotal,vatPercentage,vatAmount,rowTotalWithVat)
					VALUES ('".$salesReturnId."','".$stockIdRow."','".$itemMasterId."','".$itemUnitId."',
					'".$unitFraction."','".$quantityRow."','".$netWeightRow."','".$unitPriceRow."','".$rowTotal."','".$vatPercentage."','".$vatAmount."','".$rowTotalWithVat."')";
		
		$result 			=	mysqli_query($con,$query);
		$invoiceDetailsId	=	mysqli_insert_id($con);
		return $invoiceDetailsId;	
	}
	
	function addStock($privilageId,$branchId,$stockIdRow,$netWeightRow){
		global $con;
		 $query ="UPDATE stock SET stock_".$privilageId."_".$branchId."= stock_".$privilageId."_".$branchId."+".$netWeightRow."
				where stockId='".$stockIdRow."'";
				
		mysqli_query($con,$query);
	}
	
	
/* Accounts starts------------------------*/
	
function getSubAccountHeadId($regularCustomerId){
	global $con;
	$query  = "select accountHeadId,subAccountHeadId,subAccountHeadName from subAccountHead where subAccountClientId='$regularCustomerId'";
	$result = mysqli_query($con, $query);
	return $result;
}


function getWareHouse($branchId){
	global $con;
	$query  = "select accountHeadId,subAccountHeadId,subAccountHeadName from subAccountHead where subAccountSalesareaId='$branchId'";
	$result = mysqli_query($con, $query);
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

	
function insertInvoiceToAccountJournel($netAmount,$totalAmount,
					$vatAmount,$discountInAmount,$returnNo,$regularCustomerId,
					$salesReturnId,$returnDate,$userId,$privilageId,$branchId,$mainBranch,$totalCostValue,$cuttingCharge,$transactionType)
	{
	    global $con;
		$j_referenceId=11;
		if($privilageId==2 || $privilageId==6){
			if($regularCustomerId==null OR $regularCustomerId==0){
				$customer = $this->getWareHouse($branchId);
			}else{
				$customer = $this->getSubAccountHeadId($regularCustomerId);
			}
			$resCustomer = mysqli_fetch_array($customer);
			$subAccountHeadName = $resCustomer['subAccountHeadName'];
			$customerAccountHeadId = $resCustomer['accountHeadId'];
			$customerSubAccountHeadId = $resCustomer['subAccountHeadId'];
		}else{
			$customer = $this->getSubAccountHeadId($regularCustomerId);
			$resCustomer = mysqli_fetch_array($customer);
			$subAccountHeadName = $resCustomer['subAccountHeadName'];
			$customerAccountHeadId = $resCustomer['accountHeadId'];
			$customerSubAccountHeadId = $resCustomer['subAccountHeadId'];
		}
		
			$j_narration="Sales Return of ".$subAccountHeadName." By  Return No ".$returnNo."";

		/* ('".$cuttingCharge."','','16','3137','Cutting Charge','".$returnNo."',
				   '".$returnDate."','".$j_referenceId."','".$j_narration."','".$salesReturnId."',
				   '" .$userId. "','".$privilageId."','".$branchId."','".$mainBranch."'),*/
				   
		 $query  = "INSERT INTO accountJournal(j_debit,j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,
					j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_userId,j_privillageId,j_branchId,j_mainBranch) 
		           
				   VALUES('','" .$netAmount. "','" .$customerAccountHeadId. "','" .$customerSubAccountHeadId. "',
				   '" .$subAccountHeadName. "','" .$returnNo. "','" .$returnDate. "','".$j_referenceId."','".$j_narration."',
				   '".$salesReturnId."','" .$userId. "','".$privilageId."','".$branchId."','".$mainBranch."'),
							
				('" .$totalAmount. "','','16','20','Sales A/C',
								'" .$returnNo. "','" .$returnDate. "','".$j_referenceId."','".$j_narration."','".$salesReturnId."',
								'" .$userId. "','".$privilageId."','".$branchId."','".$mainBranch."'),
								
				('" .$vatAmount. "','','6','21','Sales Vat Account',
							'" .$returnNo. "','" .$returnDate. "','".$j_referenceId."','".$j_narration."','".$salesReturnId."',
							'" .$userId. "','".$privilageId."','".$branchId."','".$mainBranch."'),
							
				('','".$discountInAmount."','18','382','Discount Allowed','".$returnNo."',
				   '".$returnDate."','".$j_referenceId."','".$j_narration."','".$salesReturnId."',
				   '" .$userId. "','".$privilageId."','".$branchId."','".$mainBranch."'),

				    ( '', '".$totalCostValue."', '18','2393','Cost','".$returnNo."',
				  '".$returnDate."','".$j_referenceId."','".$j_narration."','".$salesReturnId."',
						   '".$userId."','".$privilageId."','".$branchId."','".$mainBranch."'),
					
					( '".$totalCostValue."','','1','2394','Stock','".$returnNo."',
					'".$returnDate."','".$j_referenceId."','".$j_narration."','".$salesReturnId."',
						   '".$userId."','".$privilageId."','".$branchId."','".$mainBranch."')
							
							
							"; 
		$result = mysqli_query($con, $query);

		if($transactionType==1)
		{
			$j_referenceId=36;
			$j_narration="Sales Return Payment of ".$subAccountHeadName." By  Return No ".$returnNo."";
			$subaccountData			=		$this->getSubAccountDetails($branchId);
			while($row	=	mysqli_fetch_array($subaccountData))
			{
				$j_account_id		=	$row['accountHeadId'];
				$j_sub_account_id	=	$row['subAccountHeadId'];
				$SalesAccount		=	$row['subAccountHeadName'];
			}
			$query = "INSERT INTO accountJournal 
				   (j_debit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
				   VALUES('".$netAmount."','".$customerAccountHeadId."','".$customerSubAccountHeadId."','".$subAccountHeadName."','".$returnNo."','".$returnDate."','".$j_referenceId."','".$j_narration."','".$salesReturnId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
				  ";		  
			//echo "<br>".$query."<br>";
			$result = mysqli_query($con,$query);
			$query = "INSERT INTO accountJournal 
					(j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
					VALUES('".$netAmount."','".$j_account_id."','".$j_sub_account_id."','".$SalesAccount."','".$returnNo."','".$returnDate."','".$j_referenceId."','".$j_narration."','".$salesReturnId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')
					";		  
			//echo "<br>".$query."<br>";
			$result = mysqli_query($con,$query);
		}
	    
		return $result;
	}
 /* Accounts END */
 
	
	function checkInvoiceNoExistOrNot($invoiceNo)
	{
		global $con;
		$branchId        		=   	$_COOKIE['branchId'];
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$query = "SELECT invoiceNo 
				  FROM invoice 
				  WHERE invoiceNo = '".$invoiceNo."'
				  AND branchId='$branchId' AND privilageId='$privilageId'";
				  
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
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
	}
	
	function getCurrencyData()
	{
		global $con; 
		  $query = "SELECT currencyId,currencyName,exRate 
				  FROM  currency 
				  WHERE status=1 ";		  
		$result = mysqli_query($con,$query);
		return $result;	
		
	}
	function getMaterialsForAutoComplete($materialsName,$regularCustomerId,$privilageId,$branchId)
	{
		global $con; 
		
		if($privilageId==3 || $privilageId==2 || $privilageId==6){
			 $query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate		       
				  FROM  stock S
				  JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
				  JOIN invoiceDetails ID ON ID.stockId=S.stockId
				  JOIN invoice I ON I.invoiceId=ID.invoiceId
					WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
				  AND activeStatus='1' 
				  AND I.branchId='$branchId' AND privilageId='$privilageId'
				  
				  GROUP BY ID.stockId LIMIT 50";
		}else{
			
			$query = "SELECT S.itemMasterId,S.stockId,S.expiryDate,IM.importLocalStatus,IM.itemName,IM.itemCode,IM.packing,IM.maxretailPrice,vat,stock_".$privilageId."_".$branchId." as stockValue,minimumRate		       
				  FROM  stock S
				  JOIN itemMaster IM ON S.itemMasterId=IM.itemMasterId
				WHERE (IM.itemName LIKE '".$materialsName."%' OR IM.itemCode LIKE '".$materialsName."%')
				  AND activeStatus='1' 
				   LIMIT 50";
		}
// echo $query;
				  
		$result = mysqli_query($con,$query);
		return $result;
	}
	


	function getExchangeRate($currencyId)
	{
		global $con;
		    $query = "SELECT exRate  
				   FROM  currency 
				   wHERE currencyId='".$currencyId."' AND status='1'
				  ";		  
		$exRateData = mysqli_query($con,$query);
		while($exRateRow 	= 	mysqli_fetch_array($exRateData))
		{
				$exRate		=	$exRateRow['exRate'];
		}
		return $exRate;
	}

	
	function getmultipleOfCarton($itemMasterId)
	{
		global $con;
        $query = "SELECT multiple 
                            FROM itemUnit 
							
                            WHERE itemUnit.itemMasterId='".$itemMasterId."' AND itemUnit.unitId='2'";
							
        $resultEmptyStockDisplay = mysqli_query($con, $query);
		if(mysqli_num_rows($resultEmptyStockDisplay)>0){
			$multiple = mysqli_fetch_array($resultEmptyStockDisplay);
			//echo "<br>".$query."<br>";
			return $multiple['multiple'];
		}
		else{
			return NULL;
		}
				
        
		
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
	function getPurchasePriceForLocalPurchase($itemMasterId)	
	{
		if(isset($_COOKIE['privillegeId'])) {
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		}
		else{
			$privilageId       	 	=   	'';
			$branchId        		=   	'';
		}
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
	function getBranchCode()
	{
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		global $con;
        $query = "SELECT salesmanCode 
                  FROM branch 
                  WHERE branchId='$branchId' AND privillageId='$privilageId'";
							
        $resultBranch = mysqli_query($con, $query);
		$branchCode = mysqli_fetch_array($resultBranch);
        return $branchCode['salesmanCode'];
		
	}
	
	
	function insertItemTransferDetails($returnDate,$returnNo,$regularCustomerId,
					$itemMasterId,$stockIdRow,$quantityRow,$itemUnitId,$unitFraction,$netWeightRow,
					$salesReturnDetailsId,$privilageId,$branchId,$userId,$mainBranch,$remainingStock){
						
		$transactionType = 'SALES RETURN';
		$stockStatus = 'IN';
		$customerName=null;
		global $con;
		
		if($privilageId==2 || $privilageId==6){
			$customer = $this->getWareHouse($branchId);
			$resCustomer = mysqli_fetch_array($customer);
			$customerName = $resCustomer['subAccountHeadName'];
		}else{
			$customer = $this->getSubAccountHeadId($regularCustomerId);
			$resCustomer = mysqli_fetch_array($customer);
			$customerName = $resCustomer['subAccountHeadName'];
		}
		
		$query = "INSERT INTO itemTransferDetails(invoiceDetailsId,date,transactionNo,itemMasterId,quantity,
					itemUnitId,totalQuanity,transactionType,stockStatus,
					vendorOrCustomerName,privilageId,branchId,userId,mainBranch,type,stockId,remainingStock) 
				  VALUES('".$salesReturnDetailsId."','".$returnDate."','".$returnNo."','".$itemMasterId."','".$quantityRow."',
				  '".$itemUnitId."','".$netWeightRow."','".$transactionType."','".$stockStatus."','".$customerName."',
				  '".$privilageId."','".$branchId."','".$userId."','".$mainBranch."','11','".$stockIdRow."','".$remainingStock."')";
		
		$result = mysqli_query($con,$query);
						
	}
	
	
	function localImportStatus($itemMasterId){
		global $con;
		$query = "SELECT importLocalStatus from itemMaster where itemMasterId='$itemMasterId'";
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
		return $row['importLocalStatus'];
	}
	
	function getImportPurchasePrice($itemMasterId){
		global $con; 
		$sum=$costPerKg=0;
		$query = "SELECT costPerCtnRow from  importPurchaseDetails where itemMasterId='$itemMasterId' AND status=1";
		
		$result = mysqli_query($con,$query);
		 
		 $noOfRows = mysqli_num_rows($result);
		 
		while($row = mysqli_fetch_array($result))
			{
				$sum=$sum+$row['costPerCtnRow'];
			}
			
		$costPricefromItemMaster =	$this->getCostPrice($itemMasterId);
		//$mutiple				 =	$this->getmultipleOfCartonForPrice($itemMasterId);
		$costPerKgFromItemMaster = $costPricefromItemMaster;
		
		if($costPerKgFromItemMaster>0){
			$costPerKg = ($sum+$costPerKgFromItemMaster)/($noOfRows+1);
		}else{
			$costPerKg = $sum/$noOfRows;
		}
		return number_format($costPerKg,2,'.','');
	}
	
	
	function getCostPrice($itemMasterId)
	{
		$costPrices=0;
		global $con; 
		 $query = "SELECT costPrice      
				  FROM  itemMaster 
				  WHERE itemMasterId = '".$itemMasterId."'  AND status=1";
				  
		$result = mysqli_query($con,$query);
		while($row = mysqli_fetch_array($result))
			{
				$costPrices=$row['costPrice'];
			}
			
		return $costPrices;	
		
	} 


function getmultipleOfCartonForPrice($itemMasterId)
	{
		global $con;
        $query = "SELECT multiple 
                  FROM itemUnit  
				  INNER JOIN unit ON itemUnit.unitId=unit.unitId
                  WHERE itemUnit.itemMasterId='".$itemMasterId."'
				  AND unit.unitName='CARTON' AND unit.status=1";
							
        $resultEmptyStockDisplay = mysqli_query($con, $query);
		$multiple = mysqli_fetch_array($resultEmptyStockDisplay);
        return $multiple['multiple'];
        
		
	}
	
	
	
	function getLocalPurchasePrice($itemMasterId)	
	{
		global $con; 
		 $query = "SELECT PI.purchasePriceWithOutDiscount/netWeight AS purchasePrice       
				  FROM  purchaseItem PI
				  inner join purchaseItemBill PIB ON PIB.purchaseItemBillId=PI.purchaseItemBillId
				  WHERE PI.materialsId = '".$itemMasterId."' 
				  AND PI.status=1
				  ORDER BY PI.purchaseItemId DESC LIMIT 1";
				  
		$result = mysqli_query($con,$query);
		
		$row = mysqli_fetch_array($result);
		if($row['purchasePrice']>0){
			$purchasePrice = $row['purchasePrice'];
		}else{
			
			$purchasePrice =$this->getCostPrice($itemMasterId);
		}
		
		//$costPricefromItemMaster =	$this->getCostPrice($itemMasterId);
		//$mutiple				 =	$this->getmultipleOfCarton($itemMasterId);
		
		//$costPerKgFromItemMaster = $costPricefromItemMaster;
		
		$costPerKg =$purchasePrice;
		return number_format($costPerKg,2,'.','');
	}
	
	
	
	
	function getSalesReturnBasicDetails($invoiceId)
	{
		global $con; 
		   $query = "SELECT I.salesReturnNo,I.salesReturnDate,
							I.totalAmount,I.discountInPercent,I.discountInAmount,I.totalAfterDiscount,I.vatPercent,I.vatAmount,
							I.netAmount,
							I.netAmountWithExRate,
							RC.customerName,RC.vatNumber,RC.dueDate,RC.address,C.currencyName
							FROM    salesReturnCounterSale I
							LEFT JOIN regularCustomer RC ON I.regularCustomerId=RC.regularCustomerId
							LEFT JOIN currency C ON C.currencyId=I.currencyId
							WHERE salesReturnItemWiseId='".$invoiceId."'
				  ";	
						  
	//	echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function getSalesReturnDetails($invoiceId)
	{
		global $con; 
		  $query = "SELECT *
				  FROM    salesReturnCounterSaleDetails  SRIWD
				  LEFT JOIN itemMaster ON itemMaster.itemMasterId=SRIWD.itemMasterId
				  LEFT JOIN itemUnit ON itemUnit.itemUnitId=SRIWD.itemUnitId
				  LEFT JOIN unit ON unit.unitId=itemUnit.unitId
				  WHERE SRIWD.salesReturnItemWiseId='".$invoiceId."'
				  AND SRIWD.status=1";		  
				
	//	echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}

	// ds change

	function getReturnedQuantity($invoiceId,$itemMasterId,$invoiceDetailsId)
		{
			global $con;

			$query ="SELECT SUM(quantityRow) as returnedQuantity,SUM(netWeightRow) as returnedWeight 
					FROM salesReturnCounterSaleDetails 
					INNER JOIN salesReturnCounterSale 
					ON salesReturnCounterSale.salesReturnItemWiseId= salesReturnCounterSaleDetails.salesReturnItemWiseId 
					WHERE itemMasterId='$itemMasterId' 
					AND salesReturnCounterSale.invoiceId='$invoiceId'";


			$result = mysqli_query($con,$query);
			//echo '<br>'.$query.'<br>';
			if(mysqli_num_rows($result)>0){
				$data=mysqli_fetch_array($result);
				return $data;
			}else{
				return 0;
			}
		}
	
	// new 
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
	
}

?>