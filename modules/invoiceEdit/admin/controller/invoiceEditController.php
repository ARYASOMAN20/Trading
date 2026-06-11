<?php
require_once('../../../../modules/invoiceEdit/admin/models/invoiceEditmodel.php');
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

class invoiceEditController
{
	public function getPaymentDetails($salesInvoiceId){
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			return $objinvoiceEditmodel->getPaymentDetails($salesInvoiceId);
		}
	public function getBranchDetailsOfIncoice($salesInvoiceId)
	{
		$objinvoiceEditmodel	= 	new invoiceEditmodel();
		return $objinvoiceEditmodel->getBranchDetailsOfIncoice($salesInvoiceId);
	}		
	
		public function getInvoiceDetails($salesInvoiceId,$privilageId,$branchId){
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			return $objinvoiceEditmodel->getInvoiceDetails($salesInvoiceId,$privilageId,$branchId);
		}
		
	public function printInvoiceBody($salesInvoiceId){
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			return $objinvoiceEditmodel->printInvoiceBody($salesInvoiceId);
		}	
		public function getAllUnits($companyItemCodeId){
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			return $objinvoiceEditmodel->getAllUnits($companyItemCodeId);
			
		}
		
		function checkIfBranch($salesInvoiceId,$branchId){
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			 $count = $objinvoiceEditmodel->checkIfBranch($salesInvoiceId,$branchId);
			return $count;
		}
		
		public function getCurrecy(){
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			return $objinvoiceEditmodel->getCurrecy();
			
		}
		public function getVessel(){
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			return $objinvoiceEditmodel->getVessel();
			
		}
		function checkInvoiceNoExistOrNot($invoiceNo,$invoiceIdUpdate)
	{
		$objinvoiceEditmodel	= 	new invoiceEditmodel();
		$numOfRows			=	$objinvoiceEditmodel->checkInvoiceNoExistOrNot($invoiceNo,$invoiceIdUpdate);
		return $numOfRows;
	}
		
		function updateInvoiceTable($invoiceDate,$currencyId,$totalAmount,$discountInPercent,$discountInAmount,
					$amountAfterDiscountTotal,$damagedGoodsAmount,$vatInPercent,$vatAmount,$netAmount,$invoiceIdUpdate,
								$exRate,$amountWithExRate,$damagedGoodsReturn,$regularCustomerId,$customerName,$customerPhone,$transactionType,$roundOff,$roundAmount,$customerVatNumber)
           
		   {
				$objinvoiceEditmodel	= 	new invoiceEditmodel();
			    $objinvoiceEditmodel->updateInvoiceTable($invoiceDate,$currencyId,$totalAmount,$discountInPercent,$discountInAmount,
									$amountAfterDiscountTotal,$damagedGoodsAmount,$vatInPercent,$vatAmount,$netAmount,$invoiceIdUpdate,
									$exRate,$amountWithExRate,$damagedGoodsReturn,$regularCustomerId,$customerName,$customerPhone,$transactionType,$roundOff,$roundAmount,$customerVatNumber);					
									
           }
		   
		function updateInvoiceDetails($invoiceId,$invoiceNo,$invoiceDate,$customerName,$stockId,$itemMasterId,$itemUnitId,$unitFraction,$quantityRow,
			                                       $unitPriceRow,$invoiceDetailsId,$amountWithOutDiscount,$netWeightRow,$netWeightOld,
												   $status,$privilageId,$branchId,$mainBranch,$userId,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,$itemCodeRow)
	{
		//var_dump($invoiceId.'-'.$stockId.'-'.$itemMasterId.'-'.$itemUnitId.'-'.$unitFraction.'-'.$quantityRow,$unitPriceRow.'-'.$invoiceDetailsId.'-'.$quantityOld.'-'.$amountWithOutDiscount.'-'.$itemUnitIdOld.'-'.$unitFractionOld.'-'.$status);die();
		
		$balQuantity   =$newStock='';
		$objinvoiceEditmodel	= 	new invoiceEditmodel();

		if($status=='1')
		{
			$objinvoiceEditmodel->updateInvoiceDetails($itemUnitId,$quantityRow,$netWeightRow,$unitPriceRow,$invoiceDetailsId,$amountWithOutDiscount,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,$itemCodeRow);
			$stockQuantity		=	$netWeightOld-$netWeightRow;
		
			$objinvoiceEditmodel->updateStockInStocktable($itemMasterId,$stockId,$stockQuantity,$privilageId,$branchId);	
			$remainingStock		=	$objinvoiceEditmodel->getRemainingStockFromStockTable($stockId,$privilageId,$branchId);
            $objinvoiceEditmodel->updateItemTransferTbl($invoiceDetailsId,$itemMasterId,$itemUnitId,$netWeightRow,$quantityRow,
								$invoiceDate,$remainingStock,$customerName);

		}	
		else if($status=='0'){
			$objinvoiceEditmodel->setStatus($invoiceDetailsId);
		    $objinvoiceEditmodel->removeStockInStockTable($stockId,$netWeightOld,$privilageId,$branchId);
			$objinvoiceEditmodel->updateStatus($invoiceDetailsId,$itemMasterId);
		}
		else{
			
			$invoiceDetailsIdNew	=	$objinvoiceEditmodel->insertToInvoiceDetails($invoiceId,$stockId,$itemMasterId,$itemUnitId,
			                                                                     $quantityRow,$netWeightRow,$unitPriceRow,$amountWithOutDiscount,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,$itemCodeRow);
		
				$objinvoiceEditmodel->decreaseStockInStocktable($itemMasterId,$stockId,$netWeightRow,$privilageId,$branchId);
				$stock         =  $objinvoiceEditmodel->getRemainingStockFromStockTable($stockId,$privilageId,$branchId);
				$objinvoiceEditmodel->insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$stockId,$quantityRow,$itemUnitId,
				$netWeightRow,$invoiceDetailsIdNew,$customerName,$stock,$privilageId,$branchId,$mainBranch,$userId);
		
		}
		
		return $invoiceDetailsId;
	}	
	
	 function getSubAccountId($regularCustomerId)
		 {
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
        	$getSubAccountData			=	$objinvoiceEditmodel->getSubAccountId($regularCustomerId);
			while($getSubAccountDataRow	=	mysqli_fetch_array($getSubAccountData))
				{
					$subAccountHeadId	=	$getSubAccountDataRow['subAccountHeadId'];
				}
				return $subAccountHeadId;
         }
	function getSubAccountIdByBranchId($branchId)
	{
		$objinvoiceEditmodel	= 	new invoiceEditmodel();
        $getSubAccountData		=	$objinvoiceEditmodel-> getSubAccountIdByBranchId($branchId);
		while($row	=	mysqli_fetch_array($getSubAccountData))
		{
			$subAccountHeadId		=	$row['subAccountHeadId'];
		}
		return $subAccountHeadId;
	}
    function updateAccountJournel($invoiceDate,$netAmount,$subAccountHeadId,$subAccountHeadIdOld,$invoiceNo,$customerName,$invoiceIdUpdate,$discountInAmount,
			$totalAmount,$vatAmount,$totalCostValue,$transactionType,$transactionTypeOld,$privilageId,$branchId,$salesPaymentVoucherNo,$regularCustomerId,$userId,$mainBranch)
		{
			$debitAmount            ='';
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
				$objsalesInvoice		=	new M_salesInvoice();
			$debitAmount		    =	$netAmount;
			
        	$updateAccountJournelDebit			            =	$objinvoiceEditmodel->updateAccountJournelDebit($invoiceDate,$debitAmount,$subAccountHeadId,$subAccountHeadIdOld,$invoiceNo,$customerName,$invoiceIdUpdate,$privilageId);
			$updateDiscountToAccountJournelDebit			=	$objinvoiceEditmodel->updateDiscountToAccountJournelDebit($invoiceDate,$discountInAmount,$invoiceNo,$customerName,$invoiceIdUpdate);
			$updateWuthoutVatTotalToAccountJournelCredit	=	$objinvoiceEditmodel->updateWuthoutVatTotalToAccountJournelCredit($invoiceDate,$totalAmount,$invoiceNo,$invoiceIdUpdate);
			$updateVatAmountToAccountJournelCredit			=	$objinvoiceEditmodel->updateVatAmountToAccountJournelCredit($invoiceDate,$vatAmount,$invoiceNo,$invoiceIdUpdate);
			$updateCostAndStockValue                        =   $objinvoiceEditmodel->updateCostAndStockValue($invoiceDate,$customerName,$totalCostValue,$invoiceNo,$invoiceIdUpdate);
			// $privilageId==6 is added newly in three of the below 12-09-24
			if($transactionType==2&&$transactionTypeOld	==1 && ($privilageId==3 || $privilageId==2 || $privilageId==6))
			{
				$subAccountHeadIdBranch 	  = $this->getSubAccountIdByBranchId($branchId);
				$objinvoiceEditmodel-> updateSalesPaymentToAccountJurnalWithStatusZero($subAccountHeadIdOld,$subAccountHeadIdBranch,$invoiceIdUpdate,$branchId);
			}
			if($transactionType==1 && $transactionTypeOld	==1 && ($privilageId==3 || $privilageId==2 || $privilageId==6))
			{
				$subAccountHeadIdBranch 	  = $this->getSubAccountIdByBranchId($branchId);
				$objinvoiceEditmodel-> updateSalesPaymentToAccountJurnal($invoiceDate,$debitAmount,$subAccountHeadIdBranch,$subAccountHeadId,$subAccountHeadIdOld,$invoiceNo,$customerName,$invoiceIdUpdate,$branchId);
			}
			
			 if($transactionType==1 && $transactionTypeOld	==2 && ($privilageId==3 || $privilageId==2 || $privilageId==6)){
			     	if($regularCustomerId>0)
			{
				
				$insertSalesPaymentToAccountJurnalCredit		=	$objinvoiceEditmodel->insertSalesPaymentToAccountJurnalCredit($subAccountHeadId,$customerName,$netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceIdUpdate,$branchId,$privilageId,$userId,$mainBranch);
				$insertSalesPaymentToAccountJurnalDebit			=	$objinvoiceEditmodel->insertSalesPaymentToAccountJurnalDebit($netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceIdUpdate,$branchId,$privilageId,$userId,$mainBranch);	
			
			}
			 }
			
			return $updateAccountJournelDebit;
		}	
		function getUnitName($itemUnitId)
		{
			$unitName				=	'';
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
        	$unitNameData			=	$objinvoiceEditmodel->getUnitName($itemUnitId);
			while($row=mysqli_fetch_array($unitNameData))
			{
				$unitName			=	$row['unitName'];
			}
			return $unitName;
		}
		function getPurchasePrice($itemMasterId,$importLocalStatus)
		{
			$objsalesInvoice		=	new M_salesInvoice();
			if($importLocalStatus=='IMP')	
				{	
					$purchasePrices     	= 	0;
					$costPriceInKg   		= 	0;
					$purchasePrices 		= 	$objsalesInvoice->getAvgPurchasePrice($itemMasterId);
					$count              	=  	$objsalesInvoice->getrowCount($itemMasterId);

					$resCustomerList1 		= 	$objsalesInvoice->getCostPrice($itemMasterId);
					//$multiple          		=   $objsalesInvoice->getmultipleOfCarton($itemMasterId);	 
					/*$costPriceInKg	    	=   $resCustomerList1/$multiple; 	*/
					$costPriceInKg	    	=   $resCustomerList1;
						
						if($resCustomerList1>0 || $count==0)
						{
							 $count=$count+1;
						}
					 $PurchasePriceOfItem =($purchasePrices+$costPriceInKg)/$count;
					 $PurchasePriceOfItem	=	number_format($PurchasePriceOfItem, 2, '.', '');	
				}else	
				{		
					$locPurchaseData 	= 	$objsalesInvoice->getPurchasePriceForLocalPurchase($itemMasterId);	
					$numRows			=	mysqli_num_rows($locPurchaseData);
					if($numRows>0)
					{
					while($row = mysqli_fetch_array($locPurchaseData))		
						{			
							$PurchasePriceOfItem	=	number_format($row['purchasePrice'], 2, '.', '');	
						}	
					}else{
						$costPrices				=	$objsalesInvoice->getCostPrice($itemMasterId);
						//$multiple          		=   $objsalesInvoice->getmultipleOfCarton($itemMasterId);	 
						/*$PurchasePriceOfItem	=	number_format($costPrices/$multiple, 2, '.', '');*/
						$PurchasePriceOfItem	=	number_format($costPrices, 2, '.', '');
					}
				}
			
			
			return  $PurchasePriceOfItem;
		}
		function updateCustomerSalesPaymentTable($invoiceIdUpdate,$invoiceDate,$netAmount)
		{
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			$reault	=	$objinvoiceEditmodel->updateCustomerSalesPaymentTable($invoiceIdUpdate,$invoiceDate,$netAmount);
			return $reault;
		}
		function updateCustomerSalesPaymentTableWithStatusZero($invoiceIdUpdate,$invoiceDate,$updateZeroAmount)
		{
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			$reault	=	$objinvoiceEditmodel->updateCustomerSalesPaymentTableWithStatusZero($invoiceIdUpdate,$invoiceDate,$updateZeroAmount);
			return $reault;
		}
		function getStockValue($stockId,$privilageId,$branchId)
		{
			$stockValue	=0;
			$objinvoiceEditmodel	= 	new invoiceEditmodel();
			$reault	=	$objinvoiceEditmodel->getStockValue($stockId,$privilageId,$branchId);
			while($row=mysqli_fetch_array($reault))
			{
				$stockValue	=	$row['stockValue'];
			}
			return $stockValue;
		}
		
		function getSalesPaymentVoucherNo($branchId){
		    
		    $objinvoiceEditmodel	= 	new invoiceEditmodel();
			$reault	=	$objinvoiceEditmodel->getSalesPaymentVoucherNo($branchId);
		while($salesPaymentVoucherNoRow	=	mysqli_fetch_array($reault))
				{
					$salesPaymentVoucherNo	=	$salesPaymentVoucherNoRow['salesPaymentVoucherNo'];
				}
	return 	$salesPaymentVoucherNo;
		}
		
	function insertToCustomerSalesPayment($invoiceIdUpdate,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$branchId,$privilageId,$userId,$mainBranch){
		    
		 
	$objinvoiceEditmodel			= 	new invoiceEditmodel();
	//$netAmount					=	number_format(($netAmount*$exRate),2,'.','');
    $customerSalesPaymentId		=	$objinvoiceEditmodel->insertToCustomerSalesPayment($invoiceIdUpdate,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$branchId,$privilageId,$userId,$mainBranch);
	return $customerSalesPaymentId;

		}
		
	}

?>
