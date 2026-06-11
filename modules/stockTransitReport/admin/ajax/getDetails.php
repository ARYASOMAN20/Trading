<?php
require_once("../../../../modules/stockTransitReport/admin/class/StockTransitReportM.php");
$StockTransitReportM = new  StockTransitReportM();

    $invoiceNo =$invoiceDate=$vendorName=$currencyName=$containerNo=$supplierInvoiceNo=$tbody=$tbody2=$tbody3=null;
	
    if(isset($_POST['importPurchaseId'])){
    $importPurchaseId	   = $_POST['importPurchaseId'];
	
	$getDetails = $StockTransitReportM->getDetails($importPurchaseId);
	if($getDetails){
		while($row = mysqli_fetch_array($getDetails)){
			$invoiceNo = $row['invoiceNo'];
			$invoiceDate = implode("-",array_reverse(explode("-",$row['invoiceDate'])));
			$vendorName = $row['vendorName'];
			$currencyName = $row['currencyName'];
			$containerNo = $row['containerNo'];
			$supplierInvoiceNo = $row['supplierInvoiceNo'];
			
			$totalQty = $row['totalQty'];
			$totalNetWeight = $row['totalNetWeight'];
			$totalAmt = $row['totalAmt'];
			$totalAmtInSr = $row['totalAmtInSR'];
			$totalExpenseCost = $row['totalExpenseCost'];
			
			$customeDuty = $row['customDuty'];
			$other = $row['other'];
			$transportation = $row['transportation'];
			$clearingCharge = $row['clearingCharge'];
			$oceanFreight = $row['oceanFreight'];
			$deliveryOrderFee = $row['deliveryOrderFee'];
			$totalExpense = $row['totalExpense'];
			$totalExpensePerKg = $row['totalExpensePerKg'];
			
			
			$lastTotalAmt = $row['lastTotalAmount'];
			$discount = $row['discount'];
			$lastTotalAmountAfterDis = $row['lastTotalAmountAfterDis'];
			$lastTotalAmountAfterDisInRiyal = $row['lastTotalAmountAfterDisInRiyal'];
			$lastVatPer = $row['lastVatPer'];
			$lastVatAmount = $row['lastVatAmount'];
			$lastTotalAmountWithVat = $row['lastTotalAmountWithVat'];
			
			
			$tbody .='<tr>
							<td>'.$row['itemCode'].'/'.$row['itemName'].'</td>
							<td align="right">'.$row['quantityRow'].'</td>
							<td>'.$row['unitName'].'</td>
							<td align="right">'.$row['netWeightRow'].'</td>
							<td align="right">'.$row['unitPriceRow'].'</td>
							<td align="right">'.$row['amountRow'].'</td>
							<td align="right">'.$row['amountInSrRow'].'</td>
							<td>'.implode("-",array_reverse(explode("-",$row['expiryDateRow']))).'</td>
							<td align="right">'.$row['expesePerKgRow'].'</td>
							<td align="right">'.$row['totalExpRow'].'</td>
							<td align="right">'.$row['costPlusExpRow'].'</td>
							<td align="right">'.$row['costPerCtnRow'].'</td>
						</tr>';
			
		}
		$tbody .='<tr>
							<td>Total</td>
							<td align="right">'.$totalQty.'</td>
							<td></td>
							<td align="right">'.$totalNetWeight.'</td>
							<td></td>
							<td align="right">'.$totalAmt.'</td>
							<td align="right">'.$totalAmtInSr.'</td>
							<td></td>
							<td></td>
							
							<td align="right">'.$totalExpenseCost.'</td>
							<td></td>
							<td></td>
					</tr>';
					
		$tbody2 ='<tr>
					<td width="30%">CUSTOM DUTY </td><td width="20%" align="CENTER">'.$customeDuty.'</td><td width="30%">OTHERS </td><td width="20%" align="CENTER"> '.$other.'</td>
				</tr>
				<tr>
					<td>TRANSPORTATION </td><td align="CENTER"> '.$transportation.'</td><td>OCEAN FREIGHT </td><td align="CENTER"> '.$oceanFreight.'</td>
				</tr>
				<tr>
					<td>CLEARING CHARGE </td><td align="CENTER"> '.$clearingCharge.'</td><td>DELIVERY ORDER FEE </td><td align="CENTER"> '.$deliveryOrderFee.'</td>
				</tr>
				<tr>
					<td>TOTAL </td><td align="CENTER"> '.$totalExpense.'</td><td>PER KG </td><td align="CENTER"> '.$totalExpensePerKg.'</td>
				</tr>';
				
		$tbody3 ='<tr>
						<td width="60%">Total Amount</td><td width="40%" align="right">'.$lastTotalAmt.'</td>
					</tr>
					<tr>
						<td >Discount</td><td align="right">'.$discount.'</td>
					</tr>
					<tr>
						<td >Amount After Dis </td><td align="right">'.$lastTotalAmountAfterDis.'</td>
					</tr>
					<tr>
						<td >Total Amount('.$currencyName.')</td><td align="right">'.$lastTotalAmountAfterDisInRiyal.'</td>
					</tr>
					<tr>
						<td>Vat('.$lastVatPer.'%)</td><td align="right">'.$lastVatAmount.'</td>
					</tr>
					<tr>
						<td >Total With Vat : </td><td align="right">'.$lastTotalAmountWithVat.'</td>
					</tr>';
				
		$j_array =array("invoiceNo"=>$invoiceNo,"invoiceDate"=>$invoiceDate,"vendorName"=>$vendorName,"currencyName"=>$currencyName,
					"containerNo"=>$containerNo,"supplierInvoiceNo"=>$supplierInvoiceNo,"tbody"=>$tbody,"tbody2"=>$tbody2,
					"tbody3"=>$tbody3);
	
	}else{
		$j_array =array("invoiceNo"=>null,"invoiceDate"=>null,"vendorName"=>null,"currencyName"=>null,
					"containerNo"=>null,"supplierInvoiceNo"=>null,"tbody"=>null,"tbody2"=>null,"tbody3"=>null);
	
	}
	
	echo json_encode($j_array);
}

?>