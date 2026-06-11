<?php
require_once("../../../../modules/salesReturnCounterSale/admin/models/SalesReturnItemWiseM.php");
// require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

class SalesReturnItemWiseC
{
	function getMaxInvoiceNo()
	{
		$objMSalesInvoice	= 	new SalesReturnItemWiseM();
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		
		$objMSalesInvoice	= 	new SalesReturnItemWiseM();
		//$objMSalesInvoice	= 	new SalesReturnItemWiseM();
		$invoiceNoData		=	$objMSalesInvoice->getMaxInvoiceNo();
		$branchCode			=	$objMSalesInvoice->getBranchCode();
		if(mysqli_num_rows($invoiceNoData)>0)
			{
			while($row=mysqli_fetch_array($invoiceNoData))
			{
				
					$lastIncoiceNo	=	$row['invoiceNo'];
					$invoiceNoArray	=	explode("/",$lastIncoiceNo);
					
					if(count($invoiceNoArray)==2)
					{
						$maxInvoiceNo	=	$invoiceNoArray[1];
						$maxInvoiceNo	=	$maxInvoiceNo+1;
					}else{
						$maxInvoiceNo	=	1;
					}
				
				
				
			}
			}else{
				$maxInvoiceNo	=	1;
			}
		
		
			 $invoiceNo	=	$branchCode.'/'.$maxInvoiceNo;
		
		
		return $invoiceNo;
	}
	public function getBranchDetailsOfInvoice($salesInvoiceId)
	{
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->getBranchDetailsOfInvoice($salesInvoiceId);
	}		
	public function getInvoiceDetails($salesInvoiceId,$privilageId,$branchId){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->getInvoiceDetails($salesInvoiceId,$privilageId,$branchId);
	}
	public function getPaymentDetails($salesInvoiceId){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->getPaymentDetails($salesInvoiceId);
	}
public function printInvoiceBody($salesInvoiceId){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->printInvoiceBody($salesInvoiceId);
	}	
	public function getAllUnits($companyItemCodeId){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->getAllUnits($companyItemCodeId);
		
	}
	function getStockValue($stockId,$privilageId,$branchId)
		{
			$stockValue	=0;
			$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
			$reault	=	$objinvoiceEditmodel->getStockValue($stockId,$privilageId,$branchId);
			while($row=mysqli_fetch_array($reault))
			{
				$stockValue	=	$row['stockValue'];
			}
			return $stockValue;
		}
		function getUnitName($itemUnitId)
		{
			$unitName				=	'';
			$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
        	$unitNameData			=	$objinvoiceEditmodel->getUnitName($itemUnitId);
			while($row=mysqli_fetch_array($unitNameData))
			{
				$unitName			=	$row['unitName'];
			}
			return $unitName;
		}
		function getPurchasePrice($itemMasterId,$importLocalStatus)
		{
			$objsalesInvoice		=	new SalesReturnItemWiseM();
			if($importLocalStatus=='IMP')	
				{	
					$purchasePrices     	= 	0;
					$costPriceInKg   		= 	0;
					$purchasePrices 		= 	$objsalesInvoice->getAvgPurchasePrice($itemMasterId);
					$count              	=  	$objsalesInvoice->getrowCount($itemMasterId);

					$resCustomerList1 		= 	$objsalesInvoice->getCostPrice($itemMasterId);
					$multiple          		=   $objsalesInvoice->getmultipleOfCarton($itemMasterId);	 
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
						$multiple          		=   $objsalesInvoice->getmultipleOfCarton($itemMasterId);	 
						/*$PurchasePriceOfItem	=	number_format($costPrices/$multiple, 2, '.', '');*/
						$PurchasePriceOfItem	=	number_format($costPrices, 2, '.', '');
					}
				}
			
			
			return  $PurchasePriceOfItem;
		}
	/* function checkIfBranch($salesInvoiceId,$branchId){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		 $count = $objinvoiceEditmodel->checkIfBranch($salesInvoiceId,$branchId);
		return $count;
	}
	 */
	public function getCurrecy(){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->getCurrecy();
		
	}
	public function getVessel(){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->getVessel();
		
	}
	function getBranchId($userId){
		$branchId        	=	'';
		$objMSalesInvoice	= 	new SalesReturnItemWiseM();
		$getBranch			=	$objMSalesInvoice->getBranchId($userId);
		while($brachData	=	mysqli_fetch_array($getBranch))
		{
			$branchId	    = $brachData['branchId'];
		}
		return $branchId;
		
	}
	
	
	
	
	
	function checkInvoiceNoExistOrNot($invoiceNo)
	{
		$objMSalesInvoice	= 	new M_salesInvoice();
		$numOfRows			=	$SalesReturnItemWiseM->checkInvoiceNoExistOrNot($invoiceNo);
		return $numOfRows;
	}
	
	function getCurrencyData()
	{
		$currencyData		=	'';
		$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
		$dropDownForCurrency  =	$SalesReturnItemWiseM->getCurrencyData();
		while ($rowDropDownForCurrency 	= 	mysqli_fetch_array($dropDownForCurrency))
		{
			if($rowDropDownForCurrency['currencyName']=='SAUDI RIYAL')
			{
				$selected="selected";
			}else{
				$selected="";
			}
			$currencyData .='<option value = "'.$rowDropDownForCurrency['currencyId'].'/'.$rowDropDownForCurrency['exRate'].'" '.$selected.'>'.$rowDropDownForCurrency['currencyName'].'</option>';
		} 
		return $currencyData;
	}
	
	function insertToSalesReturn($returnNo,$returnDate,$regularCustomerId,$currencyId,$exRate,$totalAmount,
				$discountInPercent,$discountInAmount,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,
				$netAmountWithExRate,$userId,$branchId,$privilageId,$mainBranch,$roundOff,$roundAmount,$invoiceIdToSave,$damagedGoodsAmount,$transactionType){
					
		$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
		
		$numbericReturnNo = explode("/",$returnNo);
			
		$salesReturnId = $SalesReturnItemWiseM->insertToSalesReturn($returnNo,$returnDate,$regularCustomerId,$currencyId,$exRate,$totalAmount,
							$discountInPercent,$discountInAmount,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,
							$netAmountWithExRate,$userId,$branchId,$privilageId,$mainBranch,$numbericReturnNo[2],$roundOff,$roundAmount,$invoiceIdToSave,$damagedGoodsAmount,$transactionType);
					
			return $salesReturnId;						
		}
	
	
	function insertIntoSalesReturnDetails($salesReturnId,$stockIdRow,$itemMasterId,$itemUnitId,
										$unitFraction,$quantityRow,$netWeightRow,$unitPriceRow,$rowTotal,$vatPercentage,$vatAmount,$rowTotalWithVat){
					
		$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
			
		$id=$SalesReturnItemWiseM->insertIntoSalesReturnDetails($salesReturnId,$stockIdRow,$itemMasterId,$itemUnitId,
										$unitFraction,$quantityRow,$netWeightRow,$unitPriceRow,$rowTotal,$vatPercentage,$vatAmount,$rowTotalWithVat);
				
				return $id;
					
									
		}
		
	function addStock($privilageId,$branchId,$stockIdRow,$netWeightRow){
		$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
		$SalesReturnItemWiseM->addStock($privilageId,$branchId,$stockIdRow,$netWeightRow);
		
	}
		
	function insertInvoiceToAccountJournel($netAmount,$totalAmount,
					$vatAmount,$discountInAmount,$returnNo,$regularCustomerId,
					$salesReturnId,$returnDate,$userId,$privilageId,$branchId,$mainBranch,$totalCostValue,$cuttingCharge,$transactionType){
			//new
			/*$netAmount		=	number_format($netAmount, 2, '.', '');
			$totalAmount		=	number_format($totalAmount, 2, '.', '');
			$vatAmount		=	number_format($vatAmount, 2, '.', '');
			$discountInAmount		=	number_format($discountInAmount, 2, '.', '');*/

			//new ends
			$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
			$SalesReturnItemWiseM->insertInvoiceToAccountJournel($netAmount,$totalAmount,
					$vatAmount,$discountInAmount,$returnNo,$regularCustomerId,
					$salesReturnId,$returnDate,$userId,$privilageId,$branchId,$mainBranch,$totalCostValue,$cuttingCharge,$transactionType);
						
		}
		
		
	public function getMaxSalesReturnNo(){
		$salesReturnNo=null;
		$SalesReturnItemWiseM = new SalesReturnItemWiseM();
		$res = $SalesReturnItemWiseM->getlastSalesReturnNo();
		$salesManCode = $SalesReturnItemWiseM->getSalesManCode();
		$data = mysqli_fetch_array($res);
			
			if($data['numberSalesReturnNo']!=null){
				$salesReturnNo = $salesManCode."/SRC/".($data['numberSalesReturnNo']+1);
			}else{
				$salesReturnNo=$salesManCode."/SRC/1";
			}
		
		return $salesReturnNo;
	}
	
	public function getlastSalesReturnNo(){
		$SalesReturnItemWiseM = new SalesReturnItemWiseM();
		
		$res = $SalesReturnItemWiseM->getlastSalesReturnNo();
		
		$salesManCode = $SalesReturnItemWiseM->getSalesManCode();
			$data = mysqli_fetch_array($res);
			if($data['numberSalesReturnNo']!=null){
				$salesReturnNo = $salesManCode."/SRC/".$data['numberSalesReturnNo'];
			}else{
				$salesReturnNo=null;
			}
		
		return $salesReturnNo;
	}
	
	
		public function insertItemTransferDetails($returnDate,$returnNo,$regularCustomerId,
					$itemMasterId,$stockIdRow,$quantityRow,$itemUnitId,$unitFraction,$netWeightRow,
					$salesReturnDetailsId,$privilageId,$branchId,$userId,$mainBranch,$remainingStock){
					
			$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
			
			// new
		
			$SalesReturnItemWiseM->insertItemTransferDetails($returnDate,$returnNo,$regularCustomerId,
					$itemMasterId,$stockIdRow,$quantityRow,$itemUnitId,$unitFraction,$netWeightRow,
					$salesReturnDetailsId,$privilageId,$branchId,$userId,$mainBranch,$remainingStock);
				
			}

		public function getRemainingStockFromStockTable($stockIdRow,$privilageId,$branchId)
		{
			$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
			return $SalesReturnItemWiseM->getRemainingStockFromStockTable($stockIdRow,$privilageId,$branchId);
		}
			
			
		public function localImportStatus($itemMasterId){
			$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
			return $SalesReturnItemWiseM->localImportStatus($itemMasterId);
		}
		
		public function getImportPurchasePrice($itemMasterId){
			$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
			return $SalesReturnItemWiseM->getImportPurchasePrice($itemMasterId);
		}
		
		public function getLocalPurchasePrice($itemMasterId){
			$SalesReturnItemWiseM	= 	new SalesReturnItemWiseM();
			return $SalesReturnItemWiseM->getLocalPurchasePrice($itemMasterId);
		}
	
	
	
	
	
	
function getInvoicereturnDetails($invoiceId)
	{
	$objMSalesInvoice	= 	new SalesReturnItemWiseM();
		$i				=	1;
		$tbody			=	'';
		$invoiceData	=	'';
		$thead			=	'';
		$invoiceNo					=	'';
		$invoiceDate				=	'';
		$customerName				=	'';
		$vatNumber					=	'';
		$vesselName					=	'';
		$poNo						=	'';
		$dueDate                    =   '';
		$totalAmount				=	0;
		$discountAmount				=	0;	
		$discountPercent			=	0;
		$totalAmountAfterDiscount	=	0;
		$vatPercent					=	0;
		$vatAmount					=	0;
		$totalAmountWithVat			=	0;	
		$netAmount					=	0;
		$address         			=	'';
		$damagedGoodsAmount         =	0;
		$qtyTotal         			=	0;
		$netWtTotal         		=	0;
		if(isset($_COOKIE['mainBranch'])) {
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		}
		else{
			$privilageId       	 	= '6';
		}
		
		
		$invoiceAmountDetails =	$objMSalesInvoice->getSalesReturnBasicDetails($invoiceId);
while($invoiceAmtDetailsRow	=	mysqli_fetch_array($invoiceAmountDetails))
	{
	$invoiceNo					=	$invoiceAmtDetailsRow['salesReturnNo'];
	$invoiceDate				=	$invoiceAmtDetailsRow['salesReturnDate'];
	$customerName				=	$invoiceAmtDetailsRow['customerName'];
	$vatNumber					=	$invoiceAmtDetailsRow['vatNumber'];
	$totalAmount				=	$invoiceAmtDetailsRow['totalAmount'];		
	$discountAmount				=	$invoiceAmtDetailsRow['discountInAmount'];	
	$discountPercent			=	$invoiceAmtDetailsRow['discountInPercent'];	
	$totalAmountAfterDiscount	=	$invoiceAmtDetailsRow['totalAfterDiscount'];
	$vatPercent					=	$invoiceAmtDetailsRow['vatPercent'];
	$vatAmount					=	$invoiceAmtDetailsRow['vatAmount'];
	
	$netAmount					=	$invoiceAmtDetailsRow['netAmount'];
	$netAmountWithExRate		=	$invoiceAmtDetailsRow['netAmountWithExRate'];
	$currencyName		=	$invoiceAmtDetailsRow['currencyName'];
	
}

	$invoiceDetails		=	$objMSalesInvoice->getSalesReturnDetails($invoiceId);

	$thead	='
	<table border="0" width="100%" cellpadding="10"  style="font-size: 13px;">
	<thead>
		<tr>
			<td  colspan="3" width="100%" align="center"><b><u>SALES RETURN (عائد المبيعات)</u></b></td>
		</tr>
		<tr>
			<td  width="50%"><b>TO: '.$customerName.'<br/>'.$address .'</b></td>
			<td class="tdd" width="20%"></td>
			<td class="tdd" width="30%"><b>RETURN NO: '.$invoiceNo.'</b></td>
		</tr>
		<tr>
			<td class="tdd"><b>VAT NO: '.$vatNumber.'</b></td>
			<td class="tdd"></td>
			<td><b>DATE: '.date_format(date_create($invoiceDate),"d-m-Y").'</b></td>
		</tr>
		
	</thead>
</table><br/>';

if($invoiceId>'1'){

	$tbody .='<table width="100%" border="1"  style="font-size: 12px !important;border-collapse:collapse">
				<thead>
			<tr>
				<td align="center" width="5%"><b>#</b></td>
				<td width="25%" align="center"><b>Barcode/Item(الاسم الصنف)</b></td>
				<td align="center" width="10%"><b>Qty<br/>الكمية </b></td>
				<td align="center" width="10%"><b>Unit<br/>وحدة</b></td>
				<td align="center" width="10%"><b>Weight<br/>الوزن </b></td>
				<td align="center" width="10%" ><b>Price (SR)<br/>السعر</b></td>
				<td align="center" width="10%"><b>Amount (SR)<br/>المبلغ </b></td>
					<td align="center" width="10%"><b>Vat(SR)<br>ضريبة</b></td> 
				<td align="center" width="15%"><b>Amt With Vat(SR)<br>المبلغ الإجمال</b>
			</tr>	
		</thead>
	<tbody>';

}else{
	$tbody .='<table width="100%" border="1"  style="font-size: 12px !important;border-collapse:collapse" id="salesReturn">
	<thead>
<tr>
	<td align="center" width="5%"><b>#</b></td>
	<td width="40%" align="center"><b>Barcode/Item(الاسم الصنف)</b></td>
	<td align="center" width="10%"><b>Qty<br/>الكمية </b></td>
	<td align="center" width="10%"><b>Unit<br/>وحدة</b></td>
	<td align="center" width="10%"><b>Weight<br/>الوزن </b></td>
	<td align="center" width="10%" ><b>Price (SR)<br/>السعر</b></td>
	<td align="center" width="15%"><b>Amount (SR)<br/>المبلغ </b></td>
	
	
</tr>	
</thead>
<tbody>';
}


	while($invoiceDetailsRow	=	mysqli_fetch_array($invoiceDetails))
		{
		if($invoiceId>'1'){
					$tbody.='<tr>
			<td align="center">'.$i.'</td>
			<td >'.$invoiceDetailsRow['itemCode'].'/'.$invoiceDetailsRow['itemName'].'('.$invoiceDetailsRow['itemNameArabic'].')</td>
			
			<td align="right" >'.$invoiceDetailsRow['quantityRow'].'</td>
			<td align="center" >'.$invoiceDetailsRow['unitName'].'</td>
			<td align="right">'.number_format($invoiceDetailsRow['netWeightRow'],2).'</td>
			<td align="right" >'.number_format($invoiceDetailsRow['unitPriceRow'],2).'</td>
			<td align="right">'.number_format($invoiceDetailsRow['rowTotal'],2).'</td>
			<td align="right">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="right">'.number_format($invoiceDetailsRow['rowTotalWithVat'],2).'</td>
		</tr>';
		
				$i++;
				$qtyTotal         			=	$qtyTotal +$invoiceDetailsRow['quantityRow'];
				$netWtTotal         		=	$netWtTotal +$invoiceDetailsRow['netWeightRow'];
		}else{
		    	$tbody.='<tr>
			<td align="center">'.$i.'</td>
			<td >'.$invoiceDetailsRow['itemCode'].'/'.$invoiceDetailsRow['itemName'].'('.$invoiceDetailsRow['itemNameArabic'].')</td>
			
			<td align="right" >'.$invoiceDetailsRow['quantityRow'].'</td>
			<td align="center" >'.$invoiceDetailsRow['unitName'].'</td>
			<td align="right">'.number_format($invoiceDetailsRow['netWeightRow'],2).'</td>
			<td align="right" >'.number_format($invoiceDetailsRow['unitPriceRow'],2).'</td>
			<td align="right">'.number_format($invoiceDetailsRow['rowTotal'],2).'</td>
			
		</tr>';
		
				$i++;
				$qtyTotal         			=	$qtyTotal +$invoiceDetailsRow['quantityRow'];
				$netWtTotal         		=	$netWtTotal +$invoiceDetailsRow['netWeightRow'];
		    
		}
		}
			if($invoiceId>'1'){
	$tbody.='<tr>	
		<td>&nbsp;</td>
		<td align="right"><b>Total</b></td>
		<td align="right"><b>'.$qtyTotal.'</b></td>
		<td>&nbsp;</td>
		<td align="right"><b>'.number_format($netWtTotal,2).'</b></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr><tr>
		<td colspan="8" align="right"><b>Total Excl VAT/الأجمالي بدون القيمة المضافة </b></td>
		<td   align="right" ><b>'.number_format($totalAmount,2).'</b></td>
	</tr>
	<tr>
		<td colspan="8" align="right"><b>Discount('.$discountPercent.'%)</b></td>
		<td  align="right" ><b>'.number_format($discountAmount,2).'</b></td>
	</tr>
	<tr>
		<td colspan="8" align="right"><b>Total After Discount :</b></td>
		<td  align="right" ><b>'.number_format($totalAmountAfterDiscount,2).'</b></td>
	</tr>';
	
$tbody.='<tr>
		<td colspan="8" align="right"><b>VAT TAX('.$vatPercent.'%) /القيمة المضافة :</b></td>
		<td  align="right" ><b>'.number_format($vatAmount,2).'</b></td>
	</tr>
	
	
	<tr>
		<td colspan="8" align="right"><b>Total Incl Vat /المبلغ الإجمالي  :</b></td>
		<td  align="right" ><b>'.number_format($netAmount,2).'</b></td>
	</tr></tbody>
	</table>
	<!--<table width="100%" style="font-size: 13px;">
						<tr>
						<th  colspan="12">&nbsp;</th>
						</tr>
						<tr>
						<th  colspan="12">&nbsp;</th>
						</tr>
							<tr>
							<th colspan="6" style="text-align:center">SALESMAN(مندوب مبيعات)</th>
						
							<th colspan="6" style="text-align:center">CUSTOMER(الزبون)</tk>
							</tr>
					</table>-->
				';
		}
		else{
			$tbody.='<tr>	
		<td>&nbsp;</td>
		<td align="right"><b>Total</b></td>
		<td align="right"><b>'.$qtyTotal.'</b></td>
		<td>&nbsp;</td>
		<td align="right"><b>'.number_format($netWtTotal,2).'</b></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr><tr>
		<td colspan="6" align="right"><b>Total Excl VAT/الأجمالي بدون القيمة المضافة </b></td>
		<td   align="right" ><b>'.number_format($totalAmount,2).'</b></td>
	</tr>
	<tr>
		<td colspan="6" align="right"><b>Discount('.$discountPercent.'%)</b></td>
		<td  align="right" ><b>'.number_format($discountAmount,2).'</b></td>
	</tr>
	<tr>
		<td colspan="6" align="right"><b>Total After Discount :</b></td>
		<td  align="right" ><b>'.number_format($totalAmountAfterDiscount,2).'</b></td>
	</tr>';
	
$tbody.='<tr>
		<td colspan="6" align="right"><b>VAT TAX('.$vatPercent.'%) /القيمة المضافة :</b></td>
		<td  align="right" ><b>'.number_format($vatAmount,2).'</b></td>
	</tr>
	
	
	<tr>
		<td colspan="6" align="right"><b>Total Incl Vat /المبلغ الإجمالي  :</b></td>
		<td  align="right" ><b>'.number_format($netAmount,2).'</b></td>
	</tr></tbody>
	</table>
	<!--<table width="100%" style="font-size: 13px;">
						<tr>
						<th  colspan="12">&nbsp;</th>
						</tr>
						<tr>
						<th  colspan="12">&nbsp;</th>
						</tr>
							<tr>
							<th colspan="6" style="text-align:center">SALESMAN(مندوب مبيعات)</th>
						
							<th colspan="6" style="text-align:center">CUSTOMER(الزبون)</tk>
							</tr>
					</table>-->
				';
		}
	$invoiceData	=	array('tbody'=>$tbody,'thead'=>$thead);
	return $invoiceData;

	}

	// dschange

	public function getReturnedQuantity($salesInvoiceId,$itemMasterId,$invoiceDetailsId){
		$objinvoiceEditmodel	= 	new SalesReturnItemWiseM();
		return $objinvoiceEditmodel->getReturnedQuantity($salesInvoiceId,$itemMasterId,$invoiceDetailsId);
		
	}

	
}


?>