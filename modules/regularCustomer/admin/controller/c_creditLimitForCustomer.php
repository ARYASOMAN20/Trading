<?php
	require_once("../../../../modules/regularCustomer/admin/class/m_creditLimitForCustomer.php");
	$objMCreditbalance = new M_CreditLimitForCustomer();
	require_once("../../../../modules/receipt/admin/class/mReceipt.php");
	$objMReceipt	       = new MReceipt();
	require_once('../../../../modules/salesReturn/admin/class/m_salesReturn.php');
	$objForSalesReturn     = new M_salesReturn();
	class C_allCustomer{
		function creditBalalnceForAllCustomer($branchId){
			global $objMCreditbalance;
			$resCustomerId    = $objMCreditbalance->regularCustomerList();
			while($rowCustomerList = mysqli_fetch_array($resCustomerId)){
				$billTotal      	 = 0;
				$exchangeAmount    = 0;
				$paidAmount	    = 0;
				$totalReturnAmount = 0;
				$customerName 	  = $rowCustomerList['customerName'];
				$customerNo   		= $rowCustomerList['customerNo'];
				$creditLimit  	   = $rowCustomerList['creditLimit'];
				$regularCustomerId = $rowCustomerList['regularCustomerId'];
				
				$billTotalForCustomer = $objMCreditbalance->totalbillAmountForCustomer($branchId,$regularCustomerId);
				if($rowResultBillTotal= mysqli_fetch_array($billTotalForCustomer))
					$billTotal 		= $rowResultBillTotal['billAmount'];
					
				$totalPaidAmount 	     = $objMCreditbalance->exchangeAmount($regularCustomerId,$branchId); 
				if($rowExchangePaidAmount= mysqli_fetch_array($totalPaidAmount))
					$exchangeAmount      = $rowExchangePaidAmount['returnVoucherAmount'];
					
				$resCalculatePaidAmount   = $objMCreditbalance->calculatePaidAmount($regularCustomerId);
				if($rowCalculatePaidAmount= mysqli_fetch_array($resCalculatePaidAmount))
					$paidAmount           = $rowCalculatePaidAmount['paidAmount'];
					
				$resCalculateReturnAmount = $objMCreditbalance->calculateReturnAmount($regularCustomerId);
				if($rowCalculateReturnAmount= mysqli_fetch_array($resCalculateReturnAmount))
					$totalReturnAmount    = $rowCalculateReturnAmount['returnAmount'];
									
				$balance              = $billTotal-($paidAmount+$exchangeAmount+$totalReturnAmount);
				if($balance<0)
					$balance          = 0; 
				if($creditLimit>0)
					$currentCreditbalance = $creditLimit-$balance;
				else 
					$currentCreditbalance = 0;
				if($currentCreditbalance<0)
					$currentCreditbalance = 0;
				$tblCustomer 		 .= '<tr>
								  	    	<td width="105" >' . $customerNo. '</td>
					   			        	<td width="121" >' . $customerName . '</td>
											<td width="94" align="right">' .number_format($creditLimit,2,'.','') . '</td>
								 	    	<td width="120" align="right">' . number_format($currentCreditbalance,2,'.','').'</td>
									 	</tr>';
								
				
			}
			
			return $tblCustomer;
		}
		function creditBalalnceForSingleCustomer($regularCustomerId,$branchId){
			global $objMReceipt;
			global $objMCreditbalance;
			$customerDetails		  = $objMCreditbalance->customerDetails($regularCustomerId);
			if($rowCustomerDetails = mysqli_fetch_array($customerDetails)){
				$creditLimit		  = $rowCustomerDetails['creditLimit'];
				$customerName		 = $rowCustomerDetails['customerName'];
				$customerNo		  = $rowCustomerDetails['customerNo'];
			}
			
			$resCalculateBillTotal    = $objMReceipt->calculateBillTotal($regularCustomerId);
			if($rowCalculateBillTotal = mysqli_fetch_array($resCalculateBillTotal)){
				$billTotal            = $rowCalculateBillTotal['billAmount'];
			}
			$resCalculatePaidAmount   = $objMReceipt->calculatePaidAmount($regularCustomerId);
			while($rowCalculatePaidAmount= mysqli_fetch_array($resCalculatePaidAmount)){
				$receiptId            = $rowCalculatePaidAmount['branchReceiptId'];
				$returnAmtBasedNewReceiptId = $this->checkReceiptExchangeOrNot($receiptId,$branchId);
				$paidAmount           = $rowCalculatePaidAmount['paidAmount']+$returnAmtBasedNewReceiptId;
				$totalPaidAmount      = $totalPaidAmount+$paidAmount;
			}
			$resCalculateReturnAmount = $objMReceipt->calculateReturnAmount($regularCustomerId);
				while($rowCalculateReturnAmount= mysqli_fetch_array($resCalculateReturnAmount)){
				$totalReturnAmount    = $totalReturnAmount+$rowCalculateReturnAmount['returnAmount'];
			}
			$balance              = $billTotal-($totalPaidAmount+$totalReturnAmount);
			if($balance<0)
				$balance          = 0; 
			if($creditLimit>0)
					$currentCreditbalance = $creditLimit-$balance;
			else 
					$currentCreditbalance = 0;
			if($currentCreditbalance<0)
					$currentCreditbalance = 0;
			$tblCustomer .= '<tr>
							 <td width="105"  >'.$customerNo.'</td>
					   		 <td width="121"  >' .$customerName. '</td>
							 <td width="94"  align="right">' . number_format($creditLimit,2,'.',''). '</td>
							 <td width="120" align="right">' .number_format($currentCreditbalance,2,'.','').'</td>
							 </tr>';
			return $tblCustomer;
		}
		function checkReceiptExchangeOrNot($receiptId,$branchId){
			global $objForSalesReturn;	
			$resSalesReturnId         = $objForSalesReturn->returnIdFromBillExchangeBasedNewReceipt($receiptId,$branchId);
			$rowSalesReturnId  		 = mysqli_fetch_array($resSalesReturnId);
			$salesReturnId    		= $rowSalesReturnId['salesReturnId']; 
			$resReturnAmount          = $objForSalesReturn->returnAmountFromSalesReturn($salesReturnId,$branchId);
			$rowReturnAmount          = mysqli_fetch_array($resReturnAmount);
			$returnAmtBasedNewReceiptId = $rowReturnAmount['amountOfReturned'];
			if($returnAmtBasedNewReceiptId=='')
				$returnAmtBasedNewReceiptId = 0;
			return $returnAmtBasedNewReceiptId;
		}	
	}
	
	
?>
