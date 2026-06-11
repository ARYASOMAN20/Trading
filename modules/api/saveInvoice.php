<?php
	header('Content-Type: application/JSON');	
	
	//$con = mysqli_connect("localhost","alabeerc_cyan","cyan123","alabeerc_softDb");
	$con = mysqli_connect("localhost","alabeerc_ParallelProjectSoftDb","cyan123","alabeerc_parallelProjectSoftDb");
	/*
	
	$dataPOST['invoiceHead'] = array('invoiceNo'=>'RK/33','maxInvoiceNo'=>33,'invoiceDate'=>'2020-01-28','regularCustomerId'=>'492',
								'customerName'=>'CASH SALES - RK',
								'currencyId'=>'1','transactionType'=>'1','exRate'=>'19.4',
								'totalAmount'=>'2000','discountPercent'=>'5','discountAmount'=>'100',
								'totalAmountAfterDiscount'=>'1900','damagedGoodsAmount'=>'50',
								'vatPercent'=>'15','vatAmount'=>'277.50','totalAmountWithVat'=>'2127.50',
								'netAmountWithExRate'=>'41273.5','damagedGoodsReturn'=>'assad',
								'userId'=>'26','branchId'=>'8','privilageId'=>'3','mainBranch'=>'J');
								
		
	$dataPOST['invoiceBody'][]	=	array('itemMasterId'=>'2','barcode'=>'111002','stockId'=>'2','itemUnitId'=>'4',
									'quantity'=>'10','unitPrice'=>'200','netWeight'=>'110','amount'=>'2000');	
									
	ECHO $res = json_encode($dataPOST);
	
	
	$data = json_decode($res);

	//print_r($data);

	*/
	$dataPOST['invoiceHead'] = array("invoiceNo"=> "JJ/INV/1",
        "invoiceId"=> "1",
        "invoiceNumericNo"=> "1",
        "invoiceTime"=> "07:57:39 am",
        "regularCustomerId"=> "1",
        "deliveryNoteId"=> "0",
        "invoiceDate"=> "2024-07-09",
        "poNo"=> "",
        "quotationNo"=> "",
        "currencyId"=> "3",
        "totalAmount"=> "39",
        "discountId"=> "0",
        "discountAmount"=> "0",
        "discountPercent"=> "0",
        "totalAmountAfterDiscount"=> "38.61",
        "vatPercent"=> "15",
        "vatAmount"=> "5.85",
        "totalAmountWithVat"=> "44.4",
        "exRate"=> "1",
        "netAmountWithExRate"=> "44.4",
        "round"=> "0",
        "roundAmount"=> "0",
        "transactionType"=> "2",
        "damagedGoodsReturn"=> "\t\t\t\t\t",
        "damagedGoodsAmount"=> "0",
        "cuttingCharge"=> "0",
        "customerName"=> "Test Customer",
        "customerPhone"=> "",
        "customerVatNo"=> "",
        "wholesaleOrRetail"=> "0",
        "userId"=> "4",
        "branchId"=> "3",
        "mainBranch"=> "J",
        "privilageId"=> "3");
	
	ECHO $res = json_encode($dataPOST);	
	
	$data = json_decode($res);

	
	if($_POST['saveInvoiceData']){
		
		/* $saveApi = "INSERT INTO apiDetails (data) VALUES('".$_POST['saveInvoiceData']."')";
	
	 mysqli_query($con,$saveApi); */
		
	$data = json_decode($_POST['saveInvoiceData']);
	
	$invoiceNo 						= $data->invoiceHead->invoiceNo;
	$maxInvoiceNo 					= $data->invoiceHead->maxInvoiceNo;

	$invoiceDate 					= $data->invoiceHead->invoiceDate;
	$invoiceTime                    = $data->invoiceHead->invoiceTime;
	$regularCustomerId 				= $data->invoiceHead->regularCustomerId;
	$customerName 					= $data->invoiceHead->customerName;
	$currencyId 					= $data->invoiceHead->currencyId;
	$transactionType 				= $data->invoiceHead->transactionType;
	$exRate 						= $data->invoiceHead->exRate;
	$totalAmount 					= $data->invoiceHead->totalAmount;
	
	$discountPercent 				= $data->invoiceHead->discountPercent;
	$discountAmount 				= $data->invoiceHead->discountAmount;
	$totalAmountAfterDiscount 		= $data->invoiceHead->totalAmountAfterDiscount;
	$damagedGoodsAmount 			= $data->invoiceHead->damagedGoodsAmount;
	$vatPercent 					= $data->invoiceHead->vatPercent;
	$vatAmount 						= $data->invoiceHead->vatAmount;
	$totalAmountWithVat 			= $data->invoiceHead->totalAmountWithVat;
	$roundOff 			= $data->invoiceHead->roundOff;
	$roundAmount 			= $data->invoiceHead->roundAmount;
	
		if($damagedGoodsAmount=='')
	$damagedGoodsAmount=0;
	if($vatAmount=='')
	$vatAmount=0;
	if($discountAmount=='')
	$discountAmount=0;
	if($vatPercent=='')
      $vatPercent=0;
	
		$netAmountWithExRateAcc 	= 	$exRate*$totalAmountAfterDiscount;
		$totalAmountWithExRateAcc 	=	$exRate*($totalAmount-$damagedGoodsAmount);
		$vatAmountWithExRateAcc 	=	$exRate*$vatAmount;
		$discountWithExRateAcc 		=	$exRate*$discountAmount;
		$totalAmountWithVatWithExRate =  $exRate*$totalAmountWithVat;

	
	$damagedGoodsReturn 			= $data->invoiceHead->damagedGoodsReturn;
	$userId 						= $data->invoiceHead->userId;
	$branchId 						= $data->invoiceHead->branchId;
	$privilageId 					= $data->invoiceHead->privilageId;
	$mainBranch 					= $data->invoiceHead->mainBranch;
	
		date_default_timezone_set('Asia/Riyadh');
		$time = date('h:ia', time());
	
	/*
		$query = "SELECT salesmanCode FROM branch WHERE branchId='$branchId' AND privillageId='$privilageId'";
							
        $resultBranch = mysqli_query($con, $query);
		$branchCodeRes = mysqli_fetch_array($resultBranch);
		$branchCode = $branchCodeRes['salesmanCode'];
		
	
	 $query = "SELECT  MAX(invoiceNumericNo) as maxOfIncoiceNo
				  FROM  invoice
				  WHERE branchId='$branchId' AND privilageId='$privilageId'
				  AND status='1'";
	 
		$result = mysqli_query($con,$query);
	
		$res	=	mysqli_fetch_array($result);
	
	if($res['maxOfIncoiceNo']==null){
		$invoiceNo = $branchCode.'/INV/1';
	}else{
		$maxOfIncoiceNo = $res['maxOfIncoiceNo']+1;
		$invoiceNo = $branchCode.'/INV/'.$maxOfIncoiceNo;
	}
	*/
	
		
/* -----------------set Zakat Invoice Type ------------------------*/

		$query = "SELECT vatNumber FROM regularCustomer WHERE regularCustomerId='$regularCustomerId'";
							
        $resultBranch = mysqli_query($con, $query);
		$branchCodeRes = mysqli_fetch_array($resultBranch);
		$customerVat = $branchCodeRes['vatNumber'];
            	if($customerVat>0)
                   $zakatInvoiceType = '0100000';
                else
                   $zakatInvoiceType='0200000';
                   
/*   -------------------end -----------------------------------------*/   
				  

	echo  $query = "SELECT invoiceNo  FROM invoice WHERE invoiceNo = '".$invoiceNo."' 
			AND branchId='".$branchId."' AND privilageId='".$privilageId."' AND mainBranch='".$mainBranch ."'";die;
			
		 $result = mysqli_query($con,$query);
		 $numOfRows	=	mysqli_num_rows($result);
		
if($numOfRows==0){
		if($invoiceNo!='' AND $invoiceDate!=''  AND $regularCustomerId!=''  
				AND $currencyId!=''   AND $customerName!='' AND $transactionType!=''){

	 $query = "INSERT INTO invoice
				(invoiceNo,regularCustomerId,invoiceDate,invoiceTime,currencyId,totalAmount,discountAmount,
				discountPercent,totalAmountAfterDiscount,vatPercent,vatAmount,totalAmountWithVat,transactionType,exRate,
				netAmountWithExRate,userId,branchId,privilageId,mainBranch,damagedGoodsReturn,damagedGoodsAmount,customerName,
				invoiceNumericNo,round,roundAmount,time,zakatInvoiceType)
		VALUES ('".$invoiceNo."', '".$regularCustomerId."','".$invoiceDate."','".$invoiceTime."','".$currencyId."','".$totalAmount."',
		'".$discountAmount."','".$discountPercent."','".$totalAmountAfterDiscount."','".$vatPercent."',
		'".$vatAmount."','".$totalAmountWithVat."','".$transactionType."','".$exRate."','".$totalAmountWithVatWithExRate."',
		'".$userId."','".$branchId."','".$privilageId."','".$mainBranch."','".$damagedGoodsReturn."','".$damagedGoodsAmount."',
		'".$customerName."','".$maxInvoiceNo."','".$roundOff."','".$roundAmount."','".$time."','".$zakatInvoiceType."')";
	
	$result 	=	mysqli_query($con,$query);
	$invoiceId	=	mysqli_insert_id($con);
	
	
	$totalCostValue =0;
	if($invoiceId>0){
	for($i=0;$i<count($data->invoiceBody);$i++){
		
		$itemMasterId = $itemUnitId	=	$quantity	= $unitPrice = $netWeight = $amount = $barcode = $stockId = null;
		
		$itemMasterId 	= $data->invoiceBody[$i]->itemMasterId;
		$itemUnitId 	= $data->invoiceBody[$i]->itemUnitId;
		$quantity 		= $data->invoiceBody[$i]->quantity;
		$unitPrice 		= $data->invoiceBody[$i]->unitPrice;
		
		$netWeight 		= $data->invoiceBody[$i]->netWeight;
		$amount 		= $data->invoiceBody[$i]->amount;
		$barcode 		= $data->invoiceBody[$i]->barcode;
		$stockId 		= $data->invoiceBody[$i]->stockId;
		
		$vatPercent 		= $data->invoiceBody[$i]->vatPercent;
		$vatAmount 		= $data->invoiceBody[$i]->vatAmount;
		$amountWithVat 		= $data->invoiceBody[$i]->amountWithVat;
		
		if($itemMasterId!=''  AND $itemUnitId!='' AND $quantity!='' AND $unitPrice!=''
						AND $netWeight!='' AND $amount!='' AND $barcode!=''  AND $stockId!='' ){
		
		 $query = "INSERT INTO invoiceDetails (invoiceId,itemMasterId,itemUnitId,quantity,unitPrice,netWeight,amount,
										amountWithVat,itemCode,stockId,vatPercent,vatAmount)
					VALUES ('".$invoiceId."','".$itemMasterId."','".$itemUnitId."','".$quantity."',
					'".$unitPrice."','".$netWeight."','".$amount."','".$amountWithVat."','".$barcode."','".$stockId."',
					'".$vatPercent."','".$vatAmount."')";
					
		$result 			=	mysqli_query($con,$query);
		
		$invoiceDetailsId	=	mysqli_insert_id($con);
		
		
		$remainingStock = 0;
		$query = "SELECT stock_".$privilageId."_".$branchId." as stock  FROM  stock WHERE stockId = '".$stockId."'";
				  
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
		
		$remainingStock=$row['stock'];
			

		$query = "INSERT INTO itemTransferDetails(invoiceDetailsId,date,transactionNo,itemMasterId,quantity,itemUnitId,
					totalQuanity,transactionType,stockStatus,vendorOrCustomerName,branchId,remainingStock,privilageId,
					userId,mainBranch,type,stockId) 
				  VALUES('".$invoiceDetailsId."','".$invoiceDate."','".$invoiceNo."','".$itemMasterId."','".$quantity."',
				  '".$itemUnitId."','".$netWeight."','Sales','OUT','".$customerName."',
				  '".$branchId."','".$remainingStock."','".$privilageId."','".$userId."',
				  '".$mainBranch."','1','".$stockId."')";
	
		$result 	=	mysqli_query($con,$query);
		
		
		$query = "UPDATE stock 
				  SET 	stock_".$privilageId."_".$branchId." =stock_".$privilageId."_".$branchId." - '".$netWeight."'
				  WHERE stockId = '".$stockId."'";
		
		mysqli_query($con,$query);
			
			
			
		$query = "SELECT importLocalStatus FROM itemMaster where itemMasterId='$itemMasterId'";
		
		$result  = mysqli_query($con,$query);
		
		$row = mysqli_fetch_array($result);
		$importLocalStatus = $row['importLocalStatus'];
		
		$purchasePrices     	= 	0;
		$costPriceInKg   		= 	0;
			$count=0;
		if($importLocalStatus=='IMP')	
		{	
			$query = "SELECT costPerCtnRow FROM importPurchaseDetails				 
						WHERE itemMasterId = '".$itemMasterId."' AND status=1";
					
			$result = mysqli_query($con,$query);
			$count = mysqli_num_rows($result);
			
			while($row=mysqli_fetch_array($result)){
				$purchasePrices	=	$purchasePrices+$row['costPerCtnRow'];
			}
			
			
	$query = "SELECT costPrice  FROM  itemMaster 
						WHERE itemMasterId = '".$itemMasterId."'  AND status=1";
				  
			$result = mysqli_query($con,$query);
			$row=mysqli_fetch_array($result);
			
			$costPriceItemMaster = $row['costPrice'];
			
			 $query = "SELECT multiple FROM itemUnit  
						INNER JOIN unit ON itemUnit.unitId=unit.unitId
						WHERE itemUnit.itemMasterId='".$itemMasterId."'
						AND unit.unitName='CARTON'";
							
				$resultEmptyStockDisplay = mysqli_query($con, $query);
				
				$row = mysqli_fetch_array($resultEmptyStockDisplay);
				
				$multiple = $row['multiple'];
				
				$costPriceInKg	    	=   $costPriceItemMaster; 	
				
				if($costPriceInKg>0 || $count==0)
				{
					 $count=$count+1;
				}
			 $PurchasePriceOfItem =($purchasePrices+$costPriceInKg)/$count;
			 $PurchasePriceOfItem	=	number_format($PurchasePriceOfItem, 2, '.', '');	

		}else{
			
			$query = "SELECT purchasePriceWithOutDiscount/netWeight AS purchasePrice       
				  FROM  purchaseItem 
				  inner join purchaseItemBill PIB ON PIB.purchaseItemBillId=purchaseItem.purchaseItemBillId
				  WHERE materialsId = '".$itemMasterId."' 
				  AND purchaseItem.status=1
				  ORDER BY purchaseItemId DESC LIMIT 1";
				  
			$result = mysqli_query($con,$query);
			
			if(mysqli_num_rows($result)>0)
			{
				$row = mysqli_fetch_array($result);	
				$PurchasePriceOfItem	=	number_format($row['purchasePrice'], 2, '.', '');	
				
			}else{
							
				$query = "SELECT costPrice  FROM  itemMaster 
							WHERE itemMasterId = '".$itemMasterId."'  AND status=1";
				  
			$result = mysqli_query($con,$query);
			$row=mysqli_fetch_array($result);
			
			$costPriceItemMaster = $row['costPrice'];
			
			 $query = "SELECT multiple FROM itemUnit  
						INNER JOIN unit ON itemUnit.unitId=unit.unitId
						WHERE itemUnit.itemMasterId='".$itemMasterId."'
						AND unit.unitName='CARTON'";
							
				$resultEmptyStockDisplay = mysqli_query($con, $query);
				$row = mysqli_fetch_array($resultEmptyStockDisplay);
				
				$multiple = $row['multiple'];
				
				$costPriceInKg	    	=   $costPriceItemMaster; 	
				
				$PurchasePriceOfItem	=	number_format($costPriceInKg, 2, '.', '');
			}
		}
		
		$totalCostValue = $totalCostValue+$netWeight*$PurchasePriceOfItem;
		
	}

}

	$totalCostValueWithExRate = number_format($totalCostValue,2,'.','');
	
	/*--------------------------------- Accounts Starts -----------------*/
	
		$j_referenceId		=	1;
		$j_account_id		=	1;
	
	
		$j_narration="Sales Invoice of ".$customerName." By Invoice No ".$invoiceNo."";

		$j_narrationV="Sales Vat Amount  of ".$invoiceNo."";

		$j_narrationS=" Sales Account of ".$invoiceNo."";

		$query = "SELECT subAccountHeadId FROM    subAccountHead WHERE subAccountClientId='".$regularCustomerId."'";
		$getSubAccountData 	=	mysqli_query($con,$query);
		
		$getSubAccountDataRow	=	mysqli_fetch_array($getSubAccountData);
		$j_sub_account_id 		=	$getSubAccountDataRow['subAccountHeadId'];
	
	 $query = "INSERT INTO accountJournal 
			(j_debit,j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,
			j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
			
			VALUES('".$totalAmountWithVatWithExRate."','','".$j_account_id."','".$j_sub_account_id."','".$customerName."',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('','".$totalAmountWithExRateAcc."','16','20','Sales Account',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationS."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('','".$vatAmountWithExRateAcc."','6','21','Sales Vat Amount',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationV."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('".$discountWithExRateAcc."','','18','382','Discount Allowed',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			( '', '".$totalCostValueWithExRate."', '1','2394','Stock',
			 '".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			 '".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
				
			( '".$totalCostValueWithExRate."','','18','2393','Cost',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')";	
			
			mysqli_query($con,$query);
			
		
		if($transactionType==1){
			
			/*--------------- Voucher No Max ---------------------------------------*/
			 $query = "SELECT IFNULL(MAX(salesPaymentVoucherNo)+1,1) AS salesPaymentVoucherNo  
				   FROM    customerSalesPayment   where privilageId='".$privilageId."' AND  branchId='".$branchId."'
";	
				   
			$result = mysqli_query($con,$query);
			$row =  mysqli_fetch_array($result);
			
			$salesPaymentVoucherNo  = $row['salesPaymentVoucherNo'];
			
			/*--------------- Voucher No Max ----------------------------------------*/
			
			
			/*--------------- customerSalesPayment ----------------------------------------*/

			$query = "INSERT INTO customerSalesPayment
					(invoiceId,paymentModeId,amountDate,amountPaid,salesPaymentVoucherNo,
					userId,privilageId,branchId,mainBranch)
					VALUES('".$invoiceId."','1','".$invoiceDate."','".$totalAmountWithVat."','".$salesPaymentVoucherNo."',
					'".$userId."','".$privilageId."','".$branchId."','".$mainBranch."')";		  
			
			$result = mysqli_query($con,$query);
						
			/*--------------- customerSalesPayment ------------------------------------------*/

			
			
			
			$j_referenceId	=	'2';
			

			$query = "SELECT subAccountHeadId,accountHeadId,subAccountHeadName FROM subAccountHead
						WHERE subAccountSalesareaId='$branchId'";
			
			$branchAccounts 	=	mysqli_query($con,$query);
		
			$branchAccountsRow		=	mysqli_fetch_array($branchAccounts);
			$branchAccountId 		=	$branchAccountsRow['accountHeadId'];
			$branchSubAccountId 	=	$branchAccountsRow['subAccountHeadId'];
			$branchName 			=	$branchAccountsRow['subAccountHeadName'];
			

			$j_narrationC="Cash payment of Invoice No ".$invoiceNo."";
			
			
		$query = "INSERT INTO accountJournal 
			(j_debit,j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,
			j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch)
			
			VALUES('".$totalAmountWithVatWithExRate."','','".$branchAccountId."','".$branchSubAccountId."','".$branchName."',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationC."','".$invoiceId."',
			'".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('','".$totalAmountWithVatWithExRate."','1','".$j_sub_account_id."','".$customerName."',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationC."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')";
			
			mysqli_query($con,$query);
			
		}
		
		$RESPONSE = array('message'=>'Success','invoiceId'=>$invoiceId);
					
	}else{
		
		$RESPONSE = array('message'=>'FailASD'); 
	}
	}else{
		
		$RESPONSE = array('message'=>'FailASD'); 
	}
}else{
		$RESPONSE = array('message'=>'Invoice No Duplication Found');
	}

		
}else{
	$RESPONSE = array('message'=>'Fail');
}

echo json_encode($RESPONSE);
?>